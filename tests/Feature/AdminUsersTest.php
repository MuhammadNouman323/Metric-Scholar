<?php

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
