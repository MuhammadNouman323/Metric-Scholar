<?php

use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function registerPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Admin User',
        'email' => 'admin@vu.edu.pk',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'department' => 'Computer Science',
        'terms' => '1',
    ], $overrides);
}

test('admin can register for a pre-registered university and is redirected to admin dashboard', function () {
    University::factory()->create(['domain' => 'vu.edu.pk']);

    $response = $this->post('/register', registerPayload());

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'admin@vu.edu.pk',
        'role' => 'admin',
        'access_level' => 'Full Access',
        'university_id' => University::query()->where('domain', 'vu.edu.pk')->value('id'),
    ]);
});

test('registration requires the email domain to match a registered university', function () {
    $response = $this->from('/register')->post('/register', registerPayload([
        'email' => 'admin@unknown-university.edu',
    ]));

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('email');
    expect(User::query()->where('email', 'admin@unknown-university.edu')->exists())->toBeFalse();
});

test('email domain matching is case-insensitive', function () {
    University::factory()->create(['domain' => 'vu.edu.pk']);

    $response = $this->post('/register', registerPayload([
        'email' => 'Admin@VU.EDU.PK',
    ]));

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticated();
});

test('registration rejects a second administrator for the same university', function () {
    $university = University::factory()->create(['domain' => 'vu.edu.pk']);

    User::factory()->create([
        'role' => 'admin',
        'university_id' => $university->id,
    ]);

    $response = $this->from('/register')->post('/register', registerPayload([
        'email' => 'second.admin@vu.edu.pk',
    ]));

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('email');
    expect(User::query()->where('email', 'second.admin@vu.edu.pk')->exists())->toBeFalse();
});

test('a deactivated administrator still blocks new registrations for their university', function () {
    $university = University::factory()->create(['domain' => 'vu.edu.pk']);

    User::factory()->create([
        'role' => 'admin',
        'is_active' => false,
        'university_id' => $university->id,
    ]);

    $response = $this->from('/register')->post('/register', registerPayload([
        'email' => 'new.admin@vu.edu.pk',
    ]));

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('email');
});

test('admins of different universities do not block each other', function () {
    $universityA = University::factory()->create(['domain' => 'uni-a.edu']);
    $universityB = University::factory()->create(['domain' => 'uni-b.edu']);

    User::factory()->create([
        'role' => 'admin',
        'university_id' => $universityA->id,
    ]);

    $response = $this->post('/register', registerPayload([
        'email' => 'admin@uni-b.edu',
    ]));

    $response->assertRedirect('/admin/dashboard');
    expect(User::query()->where('university_id', $universityB->id)->where('role', 'admin')->count())->toBe(1);
});

test('register requires accepted terms', function () {
    University::factory()->create(['domain' => 'vu.edu.pk']);

    $response = $this->from('/register')->post('/register', registerPayload([
        'terms' => null,
    ]));

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('terms');
    expect(User::query()->where('email', 'admin@vu.edu.pk')->exists())->toBeFalse();
});
