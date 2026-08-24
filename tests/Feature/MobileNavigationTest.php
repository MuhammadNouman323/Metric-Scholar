<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dashboard renders mobile sidebar drawer markup', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertOk();
    $response->assertSee('data-sidebar-toggle', false);
    $response->assertSee('id="sidebar-drawer"', false);
    $response->assertSee('sidebar-backdrop', false);
    $response->assertSee('data-sidebar-close', false);
});

test('faculty dashboard renders mobile sidebar drawer markup', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);

    $response = $this->actingAs($faculty)->get('/faculty/dashboard');

    $response->assertOk();
    $response->assertSee('data-sidebar-toggle', false);
    $response->assertSee('id="sidebar-drawer"', false);
    $response->assertSee('sidebar-backdrop', false);
    $response->assertSee('data-sidebar-close', false);
});

test('student dashboard renders mobile sidebar drawer markup', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)->get('/student/dashboard');

    $response->assertOk();
    $response->assertSee('data-sidebar-toggle', false);
    $response->assertSee('id="sidebar-drawer"', false);
    $response->assertSee('sidebar-backdrop', false);
    $response->assertSee('data-sidebar-close', false);
});
