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

test('non-faculty users cannot access faculty report routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($admin)->get('/faculty/reports/dashboard-pdf')->assertRedirect();
    $this->actingAs($admin)->get('/faculty/reports/feedback-export')->assertRedirect();
    $this->actingAs($admin)->get('/faculty/reports/analytics-pdf')->assertRedirect();

    $this->actingAs($student)->get('/faculty/reports/dashboard-pdf')->assertRedirect();
    $this->actingAs($student)->get('/faculty/reports/feedback-export')->assertRedirect();
    $this->actingAs($student)->get('/faculty/reports/analytics-pdf')->assertRedirect();
});

test('faculty can download dashboard PDF report', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Software Engineering',
        'code' => 'CS-301',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $faculty->courses()->attach($course->id);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Evaluation',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid(),
        'is_used' => true,
    ]);

    $feedback = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'overall_rating',
        'rating' => 4,
    ]);

    $response = $this->actingAs($faculty)->get('/faculty/reports/dashboard-pdf');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('faculty can download analytics PDF dossier', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Data Structures',
        'code' => 'CS-201',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $faculty->courses()->attach($course->id);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'final',
        'start_date' => now()->subDays(3),
        'end_date' => now()->addDays(3),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid(),
        'is_used' => true,
    ]);

    $feedback = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'overall_rating',
        'rating' => 5,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'clarity',
        'rating' => 5,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'comments',
        'text_answer' => 'Amazing lecturer!',
    ]);

    $response = $this->actingAs($faculty)->get('/faculty/reports/analytics-pdf');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('faculty can export feedback CSV', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $course = Course::create([
        'title' => 'Algorithms',
        'code' => 'CS-302',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'final',
        'start_date' => now(),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid(),
        'is_used' => true,
    ]);

    $feedback = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'overall_rating',
        'rating' => 4,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'comments',
        'text_answer' => 'Good course overall.',
    ]);

    $response = $this->actingAs($faculty)->get('/faculty/reports/feedback-export');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

    $content = $response->streamedContent();
    expect($content)->toContain('Course Code');
    expect($content)->toContain('CS-302');
    expect($content)->toContain('Good course overall.');
});

test('feedback CSV export respects course filter', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);

    $course1 = Course::create([
        'title' => 'Algorithms',
        'code' => 'CS-302',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $course2 = Course::create([
        'title' => 'Networks',
        'code' => 'CS-405',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Eval',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'final',
        'start_date' => now(),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    $fb1 = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course1->id,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $fb1->id,
        'question_id' => 'overall_rating',
        'rating' => 5,
    ]);

    $fb2 = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course2->id,
    ]);
    FeedbackAnswer::create([
        'feedback_id' => $fb2->id,
        'question_id' => 'overall_rating',
        'rating' => 3,
    ]);

    $response = $this->actingAs($faculty)->get("/faculty/reports/feedback-export?course_id={$course1->id}");

    $response->assertStatus(200);

    $content = $response->streamedContent();
    expect($content)->toContain('CS-302');
    expect($content)->not->toContain('CS-405');
});

test('faculty dashboard page links to report routes', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);

    $response = $this->actingAs($faculty)->get('/faculty/dashboard');

    $response->assertStatus(200);
    $response->assertSee(route('faculty.reports.dashboard-pdf'));
    $response->assertSee(route('faculty.reports.analytics-pdf'));
});
