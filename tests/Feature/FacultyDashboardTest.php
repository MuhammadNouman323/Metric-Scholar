<?php

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('faculty dashboard displays dynamic metrics and calculations', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course1 = Course::create([
        'title' => 'Software Engineering',
        'code' => 'CS-301',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);
    $course2 = Course::create([
        'title' => 'Database Systems',
        'code' => 'CS-402',
        'semester' => 'Fall 2024',
        'credit_hours' => 4,
        'department' => 'Computer Science',
    ]);

    $faculty->courses()->attach([$course1->id, $course2->id]);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Evaluation',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    // Create tokens (2 total)
    $token1 = FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course1->id,
        'token' => Str::uuid(),
        'is_used' => true,
    ]);

    $token2 = FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course2->id,
        'token' => Str::uuid(),
        'is_used' => false,
    ]);

    // Create feedback matching token1
    $feedback = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course1->id,
    ]);

    // Create feedback answers
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'overall_rating',
        'rating' => 4,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'clarity',
        'rating' => 5,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'materials',
        'rating' => 4,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'responsiveness',
        'rating' => 3,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'organization',
        'rating' => 5,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'comments',
        'text_answer' => 'Great teacher!',
    ]);

    $response = $this->actingAs($faculty)->get('/faculty/dashboard');

    $response->assertStatus(200);

    // Verify values passed to view
    $response->assertViewHas('avgRating', 4.0);
    $response->assertViewHas('totalResponsesCount', 1);
    $response->assertViewHas('coursesCount', 2);
    $response->assertViewHas('completionRate', 50.0);

    $criteriaStats = $response->viewData('criteriaStats');
    expect($criteriaStats['clarity'])->toBe(5.0);
    expect($criteriaStats['materials'])->toBe(4.0);
    expect($criteriaStats['responsiveness'])->toBe(3.0);
    expect($criteriaStats['organization'])->toBe(5.0);

    $recentComments = $response->viewData('recentComments');
    expect($recentComments)->toHaveCount(1);
    expect($recentComments[0]['text'])->toBe('Great teacher!');
    expect($recentComments[0]['rating'])->toBe(4);
});

test('expired evaluations are closed by the lifecycle command', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $evaluation = Evaluation::create([
        'title' => 'Expired Evaluation',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDays(10),
        'end_date' => now()->subDays(2), // expired 2 days ago
        'status' => 'active',
        'is_anonymous' => true,
        'created_by' => $admin->id,
    ]);

    $this->artisan('evaluation:process-lifecycle')
        ->expectsOutput('Closed evaluation ID: '.$evaluation->id)
        ->assertExitCode(0);

    $evaluation->refresh();
    expect($evaluation->status)->toBe('closed');
    expect($evaluation->closed_at)->not->toBeNull();
});
