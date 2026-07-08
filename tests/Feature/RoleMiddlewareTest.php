<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected to login when accessing protected route', function () {
    $response = $this->get('/admin/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users are redirected away from login page by role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $faculty = User::factory()->create(['role' => 'faculty']);
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($admin)->get('/login')->assertRedirect('/admin/dashboard');
    $this->actingAs($faculty)->get('/login')->assertRedirect('/faculty/dashboard');
    $this->actingAs($student)->get('/login')->assertRedirect('/student/dashboard');
});

test('student cannot access admin routes', function () {
    $student = User::factory()->create(['role' => 'student']);
    $response = $this->actingAs($student)->get('/admin/dashboard');
    $response->assertRedirect('/student/dashboard');
    $response->assertSessionHas('error', 'You are not authorized to access that page.');
});

test('admin can access admin routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $response = $this->actingAs($admin)->get('/admin/dashboard');
    $response->assertStatus(200);
});

test('student can access student routes and not faculty routes', function () {
    $student = User::factory()->create(['role' => 'student']);
    $this->actingAs($student)->get('/student/dashboard')->assertStatus(200);
    $this->actingAs($student)->get('/faculty/dashboard')->assertRedirect('/student/dashboard');
});

test('faculty can access faculty routes', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);
    $this->actingAs($faculty)->get('/faculty/dashboard')->assertStatus(200);
});
