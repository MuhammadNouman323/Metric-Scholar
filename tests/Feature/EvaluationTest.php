<?php

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
