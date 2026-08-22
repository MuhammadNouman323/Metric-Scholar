<?php

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\User;
use App\Repositories\EvaluationRepository;
use App\Repositories\FeedbackRepository;
use App\Services\EvaluationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createCourse(string $code): Course
{
    return Course::create([
        'title' => "Course $code",
        'code' => $code,
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);
}

function createEvaluation(User $admin, string $title, string $status): Evaluation
{
    return Evaluation::create([
        'title' => $title,
        'semester' => 'Fall 2026',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDays(7),
        'status' => $status,
        'created_by' => $admin->id,
    ]);
}

test('active evaluations beyond the first page still appear in the active section', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    // Oldest evaluation is active; 55 newer closed ones push it onto page 2.
    $oldActive = createEvaluation($admin, 'Old Active Eval', 'active');

    foreach (range(1, 55) as $i) {
        createEvaluation($admin, "Closed Eval $i", 'closed');
    }

    $response = $this->actingAs($admin)->get(route('admin.evaluations'));

    $response->assertOk();

    $activeEvaluations = $response->viewData('activeEvaluations');
    expect($activeEvaluations->contains('id', $oldActive->id))->toBeTrue();
    expect($activeEvaluationsProgress = $response->viewData('activeEvaluationsProgress'))
        ->toHaveKey($oldActive->id);
});

test('eligible students reflect current enrollment instead of stale tokens', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $studentA = User::factory()->create(['role' => 'student']);
    $studentB = User::factory()->create(['role' => 'student']);
    $lateStudent = User::factory()->create(['role' => 'student']);

    $course = createCourse('CS-101');
    $course->users()->attach([$studentA->id, $studentB->id]);

    $service = new EvaluationService(
        new EvaluationRepository,
        new FeedbackRepository
    );

    $evaluation = $service->publishEvaluation(
        [
            'title' => 'Mid-Term Evaluation',
            'semester' => 'Fall 2026',
            'evaluation_type' => 'mid-term',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'is_anonymous' => true,
        ],
        [$course->id],
        [$faculty->id]
    );

    // Two tokens were generated at publish time.
    expect($evaluation->tokens()->count())->toBe(2);

    // Enrollment changes after publish: one student drops, another joins.
    $course->users()->detach($studentA->id);
    $course->users()->attach($lateStudent->id);

    $response = $this->actingAs($admin)->get(route('admin.evaluations'));

    $response->assertOk();

    $progress = $response->viewData('activeEvaluationsProgress')[$evaluation->id];

    expect($progress['eligible'])->toBe(2)
        ->and($progress['pending'])->toBe(2)
        ->and($progress['completion_percentage'])->toBe(0);
});

test('eligible students count is distinct across shared courses', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);
    $otherStudent = User::factory()->create(['role' => 'student']);

    $courseA = createCourse('CS-201');
    $courseB = createCourse('CS-202');

    $courseA->users()->attach([$student->id, $otherStudent->id]);
    $courseB->users()->attach($student->id);

    $evaluation = createEvaluation($admin, 'Shared Courses Eval', 'active');
    $evaluation->courses()->attach([
        $courseA->id => ['faculty_id' => $faculty->id],
        $courseB->id => ['faculty_id' => $faculty->id],
    ]);

    expect($evaluation->eligibleStudentsCount())->toBe(2);
});

test('pending and completion never go negative when eligible students drop below submissions', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course = createCourse('CS-301');
    $course->users()->attach($student->id);

    $service = new EvaluationService(
        new EvaluationRepository,
        new FeedbackRepository
    );

    $evaluation = $service->publishEvaluation(
        [
            'title' => 'Dropping Eval',
            'semester' => 'Fall 2026',
            'evaluation_type' => 'mid-term',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
            'is_anonymous' => true,
        ],
        [$course->id],
        [$faculty->id]
    );

    $token = $evaluation->tokens()->firstOrFail();
    $token->update(['is_used' => true]);

    // The student drops the course after submitting feedback.
    $course->users()->detach($student->id);

    $response = $this->actingAs($admin)->get(route('admin.evaluations'));

    $response->assertOk();

    $progress = $response->viewData('activeEvaluationsProgress')[$evaluation->id];

    expect($progress['eligible'])->toBe(0)
        ->and($progress['submitted'])->toBe(1)
        ->and($progress['pending'])->toBe(0)
        ->and($progress['completion_percentage'])->toBe(0);
});
