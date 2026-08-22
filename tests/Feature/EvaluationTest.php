<?php

use App\Http\Middleware\UpdateEvaluationStatuses;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\FeedbackToken;
use App\Models\User;
use App\Repositories\EvaluationRepository;
use App\Repositories\FeedbackRepository;
use App\Services\EvaluationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('admin can create an evaluation and tokens are generated', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Software Engineering',
        'code' => 'CS-301',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    // Attach faculty and student to course
    $course->faculty()->attach($faculty->id);
    $course->users()->attach($student->id);

    // Call service to publish evaluation
    $service = new EvaluationService(
        new EvaluationRepository,
        new FeedbackRepository
    );

    $evaluationData = [
        'title' => 'Fall 2024 Evaluation',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'is_anonymous' => true,
    ];

    $evaluation = $service->publishEvaluation(
        $evaluationData,
        [$course->id],
        [$faculty->id]
    );

    // Assert evaluation is created
    expect($evaluation->title)->toBe('Fall 2024 Evaluation');
    expect($evaluation->courses->contains($course->id))->toBeTrue();
    expect($evaluation->faculty->contains($faculty->id))->toBeTrue();

    // Assert token is generated for the student
    $this->assertDatabaseHas('feedback_tokens', [
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'course_id' => $course->id,
        'faculty_id' => $faculty->id,
        'is_used' => false,
    ]);
});

test('student can submit anonymous feedback using token', function () {
    $student = User::factory()->create(['role' => 'student']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $course = Course::create([
        'title' => 'Database Systems',
        'code' => 'CS-402',
        'semester' => 'Spring 2025',
        'credit_hours' => 4,
        'department' => 'Computer Science',
    ]);
    $evaluation = Evaluation::create([
        'title' => 'Test Eval',
        'semester' => 'Fall',
        'evaluation_type' => 'mid-term',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    $token = FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid(),
        'is_used' => false,
    ]);

    $response = $this->actingAs($student)->postJson(route('student.feedback.store'), [
        'token' => $token->token,
        'clarity' => 5,
        'materials' => 4,
        'responsiveness' => 5,
        'fairness' => 5,
        'practical' => 4,
        'organization' => 5,
        'overall_rating' => 5,
        'comments' => 'Great class!',
        'what_worked_well' => 'Everything',
        'what_could_improve' => 'Nothing',
        'recommendation' => 'yes_definitely',
    ]);

    $response->assertJson(['success' => true]);

    // Assert token is used
    $this->assertDatabaseHas('feedback_tokens', [
        'id' => $token->id,
        'is_used' => true,
    ]);

    // Assert feedback is created
    $this->assertDatabaseHas('feedbacks', [
        'evaluation_id' => $evaluation->id,
        'course_id' => $course->id,
        'faculty_id' => $faculty->id,
    ]);

    // Assert answers are created
    $this->assertDatabaseHas('feedback_answers', [
        'question_id' => 'overall_rating',
        'rating' => 5,
    ]);
});

test('admin can view edit form for scheduled evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Spring 2025 Eval',
        'semester' => 'Spring 2025',
        'evaluation_type' => 'Final',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertOk();
    $response->assertSee('Spring 2025 Eval');
    $response->assertSee('Edit Scheduled Evaluation');
});

test('admin cannot edit non-scheduled evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Active Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'Mid-Term',
        'start_date' => now(),
        'end_date' => now()->addDays(7),
        'status' => 'active',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertNotFound();
});

test('admin cannot edit draft evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Draft Eval',
        'semester' => 'Spring 2025',
        'evaluation_type' => 'Annual',
        'start_date' => now()->addDays(30),
        'end_date' => now()->addDays(37),
        'status' => 'draft',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertNotFound();
});

test('admin cannot edit closed evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Closed Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'Final',
        'start_date' => now()->subDays(14),
        'end_date' => now()->subDays(7),
        'status' => 'closed',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertNotFound();
});

test('admin can update scheduled evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Original Title',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'Mid-Term',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'is_anonymous' => true,
        'send_reminder' => true,
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.evaluations.update', $evaluation), [
        'title' => 'Updated Title',
        'semester' => 'Spring 2025',
        'evaluation_type' => 'Final',
        'start_date' => now()->addDays(20)->toDateString(),
        'end_date' => now()->addDays(27)->toDateString(),
        'is_anonymous' => '1',
        'allow_faculty_response' => '1',
        'send_reminder' => '0',
    ]);

    $response->assertRedirect(route('admin.evaluations'));
    $response->assertSessionHas('success', 'Scheduled evaluation updated successfully.');

    $evaluation->refresh();

    expect($evaluation->title)->toBe('Updated Title');
    expect($evaluation->semester)->toBe('Spring 2025');
    expect($evaluation->evaluation_type)->toBe('Final');
    expect($evaluation->is_anonymous)->toBeTrue();
    expect($evaluation->allow_faculty_response)->toBeTrue();
    expect($evaluation->send_reminder)->toBeFalse();
});

test('admin cannot update scheduled evaluation with invalid data', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Existing Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'Mid-Term',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.evaluations.update', $evaluation), [
        'title' => '',
        'semester' => '',
        'evaluation_type' => '',
        'start_date' => '',
        'end_date' => '',
    ]);

    $response->assertSessionHasErrors(['title', 'semester', 'evaluation_type', 'start_date', 'end_date']);
});

test('non-admin user cannot edit scheduled evaluation', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Scheduled Eval',
        'semester' => 'Spring 2025',
        'evaluation_type' => 'Final',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $faculty = User::factory()->create(['role' => 'faculty']);

    $response = $this->actingAs($faculty)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertRedirect();
    $this->assertDatabaseMissing('evaluations', [
        'id' => $evaluation->id,
        'status' => 'draft',
    ]);
});

test('admin cannot update scheduled evaluation to invalid date range', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $evaluation = Evaluation::create([
        'title' => 'Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'Mid-Term',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.evaluations.update', $evaluation), [
        'title' => 'Updated',
        'semester' => 'Spring 2025',
        'evaluation_type' => 'Final',
        'start_date' => now()->addDays(27)->toDateString(),
        'end_date' => now()->addDays(20)->toDateString(),
    ]);

    $response->assertSessionHasErrors(['end_date']);
});

test('middleware activates scheduled evaluations when start_date is today', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Today Start Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'Mid-Term',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $this->get(route('admin.evaluations'));

    $evaluation->refresh();
    expect($evaluation->status)->toBe('active');
});

test('date fields are disabled on edit form when start_date has arrived', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Started Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'Final',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDays(6)->toDateString(),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)
        ->withoutMiddleware(UpdateEvaluationStatuses::class)
        ->get(route('admin.evaluations.edit', $evaluation));

    $response->assertOk();
    $response->assertSee('Dates cannot be changed');
    $response->assertSeeInOrder(['input', 'id="start_date"', 'disabled']);
});

test('admin cannot change dates via update when start_date has arrived', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Started Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'Final',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDays(6)->toDateString(),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $originalEndDate = $evaluation->end_date->copy();

    $this->actingAs($admin)
        ->withoutMiddleware(UpdateEvaluationStatuses::class)
        ->put(route('admin.evaluations.update', $evaluation), [
            'title' => 'Updated Title',
            'semester' => 'Spring 2027',
            'evaluation_type' => 'Annual',
            'start_date' => now()->addDays(30)->toDateString(),
            'end_date' => now()->addDays(60)->toDateString(),
        ]);

    $evaluation->refresh();
    expect($evaluation->title)->toBe('Updated Title');
    expect($evaluation->start_date->startOfDay())->not->toEqual(now()->addDays(30)->startOfDay());
    expect($evaluation->end_date->startOfDay())->toEqual($originalEndDate->startOfDay());
});

test('date fields remain editable when start_date is in the future', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Future Eval',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'Final',
        'start_date' => now()->addDays(14),
        'end_date' => now()->addDays(21),
        'status' => 'scheduled',
        'created_by' => $admin->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.evaluations.edit', $evaluation));

    $response->assertOk();
    $response->assertDontSee('Dates cannot be changed');
    $response->assertSee('start_date');
});
