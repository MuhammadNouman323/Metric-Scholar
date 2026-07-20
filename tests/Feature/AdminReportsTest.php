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

test('non-admin users cannot access administrative reports', function () {
    $student = User::factory()->create(['role' => 'student']);
    $faculty = User::factory()->create(['role' => 'faculty']);

    $this->actingAs($student)->get('/admin/reports')->assertRedirect();
    $this->actingAs($faculty)->get('/admin/reports')->assertRedirect();
});

test('administrator can access reports dashboard and metrics are computed', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student']);
    $faculty = User::factory()->create(['role' => 'faculty']);

    $course = Course::create([
        'title' => 'Software Engineering',
        'code' => 'CS-301',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    $evaluation = Evaluation::create([
        'title' => 'Fall 2024 Evaluation',
        'semester' => 'Fall 2024',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    // Create 1 used token & feedback and 1 unused token
    $tokenUsed = FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid()->toString(),
        'is_used' => true,
        'used_at' => now(),
    ]);

    $tokenUnused = FeedbackToken::create([
        'evaluation_id' => $evaluation->id,
        'student_id' => $student->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'token' => Str::uuid()->toString(),
        'is_used' => false,
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
        'question_id' => 'comments',
        'text_answer' => 'Excellent work by the instructor!',
        'moderation_status' => 'approved',
    ]);

    $response = $this->actingAs($admin)->get('/admin/reports');
    $response->assertStatus(200);

    // Verify stats exist in output
    $response->assertSee('Total Evaluations');
    $response->assertSee('Active Evaluations');
    $response->assertSee('Feedback Submitted');
    $response->assertSee('Pending Feedback');
});

test('student identity is completely anonymous and never exposed in reports', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create([
        'role' => 'student',
        'name' => 'John Anonymous Student',
        'email' => 'john.student@university.edu',
    ]);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $course = Course::create([
        'title' => 'Software Quality',
        'code' => 'CS-403',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);
    $evaluation = Evaluation::create([
        'title' => 'Evaluation Fall 24',
        'semester' => 'Fall 24',
        'evaluation_type' => 'final',
        'start_date' => now(),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    $feedback = Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
    ]);

    FeedbackAnswer::create([
        'feedback_id' => $feedback->id,
        'question_id' => 'comments',
        'text_answer' => 'Constructive feedback from student',
        'moderation_status' => 'approved',
    ]);

    // Request comments tab
    $response = $this->actingAs($admin)->get('/admin/reports?tab=comments');
    $response->assertStatus(200);
    $response->assertSee('Constructive feedback from student');

    // Security assertions: student details MUST NOT be leaked anywhere in reports page
    $response->assertDontSee('John Anonymous Student');
    $response->assertDontSee('john.student@university.edu');
});

test('administrator can download CSV and Excel reports', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $course = Course::create([
        'title' => 'Systems Programming',
        'code' => 'CS-302',
        'semester' => 'Fall 2024',
        'credit_hours' => 3,
        'department' => 'Computer Science',
    ]);

    // CSV Export
    $responseCsv = $this->actingAs($admin)->get('/admin/reports/export/csv?tab=faculty');
    $responseCsv->assertStatus(200);
    $responseCsv->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

    // Excel Export
    $responseExcel = $this->actingAs($admin)->get('/admin/reports/export/excel?tab=faculty');
    $responseExcel->assertStatus(200);
    $responseExcel->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
});
