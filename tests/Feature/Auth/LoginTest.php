<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can login and is redirected to dashboard based on selected role', function () {
    $user = User::factory()->create([
        'role' => 'faculty',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role' => 'faculty',
    ]);

    $response->assertRedirect('/faculty/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('login fails when selected role does not match account role', function () {
    $user = User::factory()->create([
        'role' => 'student',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'role' => 'admin',
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors('role');
    $this->assertGuest();
});
