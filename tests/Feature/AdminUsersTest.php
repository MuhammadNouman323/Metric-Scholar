<?php

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('/admin/users renders the admin user page', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    $response = $this->get('/admin/user');

    $response->assertOk();
    $response->assertSee('Create New User');
});

test('/admin/dashboard shows dynamic student and faculty counts', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    User::factory()->count(3)->create([
        'role' => 'student',
    ]);

    User::factory()->count(2)->create([
        'role' => 'faculty',
    ]);

    $this->actingAs($admin);

    $response = $this->get('/admin/dashboard');

    $response->assertOk();
    $response->assertViewHas('studentCount', 3);
    $response->assertViewHas('facultyCount', 2);
});

test('/admin/dashboard shows dynamic recent activity feed', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $faculty = User::factory()->create([
        'name' => 'Dr. Robert Smith',
        'email' => 'robert.smith@example.com',
        'role' => 'faculty',
        'department' => 'Engineering',
    ]);

    $course = Course::create([
        'title' => 'Adv. Algorithms',
        'code' => 'CS-505',
        'semester' => 'Fall 2026',
        'credit_hours' => 3,
        'department' => 'Engineering',
    ]);

    $evaluation = Evaluation::create([
        'title' => 'Mid-term Evaluation',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    Feedback::create([
        'evaluation_id' => $evaluation->id,
        'faculty_id' => $faculty->id,
        'course_id' => $course->id,
        'submitted_at' => now()->subMinutes(2),
    ])->answers()->create([
        'question_id' => 'comments',
        'text_answer' => 'Excellent delivery of complex topics.',
        'moderation_status' => 'approved',
    ]);

    User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'role' => 'student',
        'created_at' => now()->subMinutes(45),
    ]);

    $this->actingAs($admin);

    $response = $this->get('/admin/dashboard');

    $response->assertOk();

    $activity = $response->viewData('recentActivity');

    expect($activity)->toHaveCount(3);
    expect($activity->first()['type'])->toBe('user');
    expect($activity->first()['name'])->toBe('Dr. Robert Smith');
    expect($activity->first()['role'])->toBe('Faculty');
    expect($activity->first()['department'])->toBe('Engineering');
    expect($activity->get(1)['type'])->toBe('feedback');
    expect($activity->get(1)['course'])->toBe('Adv. Algorithms');
    expect($activity->get(1)['quote'])->toBe('Excellent delivery of complex topics.');
    expect($activity->last()['type'])->toBe('user');
    expect($activity->last()['name'])->toBe('Jane Doe');
    expect($activity->last()['role'])->toBe('Student');

    $response->assertSee('Anonymous Student');
    $response->assertSee('Adv. Algorithms');
    $response->assertSee('Excellent delivery of complex topics.');
    $response->assertSee('Jane Doe');
    $response->assertSee('Engineering');
});

test('/admin/dashboard recent activity feed is limited to five newest events', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $faculty = User::factory()->create([
        'role' => 'faculty',
    ]);

    $course = Course::create([
        'title' => 'Database Systems',
        'code' => 'CS-402',
        'semester' => 'Fall 2026',
        'credit_hours' => 4,
        'department' => 'Computer Science',
    ]);

    $evaluation = Evaluation::create([
        'title' => 'Fall Evaluation',
        'semester' => 'Fall 2026',
        'evaluation_type' => 'mid-term',
        'start_date' => now()->subDays(5),
        'end_date' => now()->addDays(5),
        'status' => 'active',
        'is_anonymous' => true,
    ]);

    foreach (range(1, 7) as $i) {
        Feedback::create([
            'evaluation_id' => $evaluation->id,
            'faculty_id' => $faculty->id,
            'course_id' => $course->id,
            'submitted_at' => now()->subMinutes($i),
        ]);
    }

    $this->actingAs($admin);

    $response = $this->get('/admin/dashboard');

    $response->assertOk();

    $activity = $response->viewData('recentActivity');

    expect($activity)->toHaveCount(5);
    expect($activity->pluck('timestamp'))->toEqual($activity->pluck('timestamp')->sort()->reverse()->values());
});

test('/admin/dashboard shows empty state when no recent activity exists', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    $response = $this->get('/admin/dashboard');

    $response->assertOk();
    $response->assertViewHas('recentActivity', fn ($activity) => $activity->isEmpty());
    $response->assertSee('No recent activity yet.');
});

test('/admin/departments and detail page show dynamic users created by admin', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    User::factory()->create([
        'name' => 'Faculty Member',
        'email' => 'faculty.member@example.com',
        'role' => 'faculty',
        'department' => 'Computer Science',
    ]);

    User::factory()->create([
        'name' => 'Student Member',
        'email' => 'student.member@example.com',
        'role' => 'student',
        'department' => 'Computer Science',
    ]);

    $this->actingAs($admin);

    $departmentsResponse = $this->get('/admin/departments');
    $departmentsResponse->assertOk();
    $departmentsResponse->assertSee('Computer Science');

    $detailResponse = $this->get('/admin/departments/computer-science?section=overview');
    $detailResponse->assertOk();
    $detailResponse->assertSee('Faculty Member');

    $enrollmentResponse = $this->get('/admin/departments/computer-science?section=enrollment');
    $enrollmentResponse->assertOk();
    $enrollmentResponse->assertSee('Student Member');
});

test('/admin/user creation does not reuse the admin primary key as admin_id', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@example.com',
    ]);

    User::factory()->create([
        'admin_id' => (string) $admin->id,
    ]);

    $this->actingAs($admin);

    $response = $this->post('/admin/user', [
        'name' => 'New Student',
        'email' => 'new.student@example.com',
        'role' => 'student',
        'department' => 'Computer Science',
        'password' => 'password123',
    ]);

    $response->assertRedirect();

    $createdUser = User::where('email', 'new.student@example.com')->firstOrFail();

    expect($createdUser->created_by)->toBe($admin->id);
    expect($createdUser->admin_id)->not->toBe((string) $admin->id);
});

test('admin can access edit user page', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
        'department' => 'Computer Science',
    ]);

    $this->actingAs($admin);

    $response = $this->get("/admin/user/{$student->id}/edit");

    $response->assertOk();
    $response->assertSee($student->name);
    $response->assertSee('Edit User Profile');
});

test('admin can update user profile', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
        'department' => 'Computer Science',
    ]);

    $this->actingAs($admin);

    $response = $this->put("/admin/user/{$student->id}", [
        'name' => 'Updated Student Name',
        'email' => 'updated.student@example.com',
        'role' => 'student',
        'department' => 'Mathematics',
    ]);

    $response->assertRedirect('/admin/students');

    $student->refresh();
    expect($student->name)->toBe('Updated Student Name');
    expect($student->email)->toBe('updated.student@example.com');
    expect($student->department)->toBe('Mathematics');
});

test('admin can toggle user status immediately', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
        'is_active' => true,
    ]);

    $this->actingAs($admin);

    $response = $this->postJson("/admin/user/{$student->id}/toggle-status", [
        'is_active' => false,
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
        'is_active' => false,
    ]);

    $student->refresh();
    expect($student->is_active)->toBeFalse();
});

test('admin can access user recovery page', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
    ]);

    $this->actingAs($admin);

    $response = $this->get("/admin/user/{$student->id}/recovery");

    $response->assertOk();
    $response->assertSee('Account Recovery');
});

test('admin can simulate sending password recovery email', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
    ]);

    $this->actingAs($admin);

    $response = $this->post("/admin/user/{$student->id}/recovery/email");

    $response->assertRedirect();
    $response->assertSessionHas('success', 'A secure password recovery link has been sent to '.$student->email);
});

test('admin can set temporary password and force change requirement', function () {
    $university = University::create([
        'name' => 'Scholar Metric University',
        'domain' => 'scholarmetric.edu',
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $student = User::factory()->create([
        'role' => 'student',
        'university_id' => $university->id,
    ]);

    $this->actingAs($admin);

    $response = $this->post("/admin/user/{$student->id}/recovery/password", [
        'password' => 'StrongPass1234!!_ComplianceCheck',
        'password_confirmation' => 'StrongPass1234!!_ComplianceCheck',
        'force_change' => '1',
    ]);

    $response->assertRedirect(route('admin.users.edit', $student));

    $student->refresh();
    expect(Hash::check('StrongPass1234!!_ComplianceCheck', $student->password))->toBeTrue();
    expect($student->password_change_required)->toBeTrue();
});
