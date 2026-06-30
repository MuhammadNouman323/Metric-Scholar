<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can register and is redirected to admin dashboard', function () {
    $response = $this->post('/register', [
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'department' => 'Computer Science',
        'admin_id' => 'ADM-9999',
        'access_level' => 'Full Access',
        'terms' => '1',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'admin@example.com',
        'role' => 'admin',
    ]);
});

test('register requires accepted terms', function () {
    $response = $this->from('/register')->post('/register', [
        'name' => 'Admin User',
        'email' => 'admin2@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('terms');
    expect(User::where('email', 'admin2@example.com')->exists())->toBeFalse();
});
