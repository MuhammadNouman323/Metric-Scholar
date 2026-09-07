<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function adminForStoreUser(): User
{
    return User::factory()->create([
        'role' => 'admin',
        'email' => 'admin@scholarmetric.edu',
    ]);
}

function storeUserPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Jane Doe',
        'email' => 'jane.doe@scholarmetric.edu',
        'role' => 'student',
        'department' => 'Computer Science',
        'password' => 'StrongPass123!',
        'password_confirmation' => 'StrongPass123!',
    ], $overrides);
}

test('admin can create a student account', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->post('/admin/user', storeUserPayload());

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'email' => 'jane.doe@scholarmetric.edu',
        'role' => 'student',
        'created_by' => $admin->id,
    ]);
});

test('admin can create a faculty account', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->post('/admin/user', storeUserPayload([
        'role' => 'faculty',
    ]));

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'email' => 'jane.doe@scholarmetric.edu',
        'role' => 'faculty',
        'created_by' => $admin->id,
    ]);
});

test('registration rejects missing required fields', function (string $field) {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([$field => '']));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors($field);
})->with(['name', 'email', 'role', 'department', 'password']);

test('registration rejects an invalid role', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'role' => 'admin',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('role');
});

test('registration rejects an invalid email format', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'email' => 'not-an-email',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('email');
});

test('registration rejects emails outside the admin institutional domain', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'email' => 'jane.doe@other.edu',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('email');
    expect(User::query()->where('email', 'jane.doe@other.edu')->exists())->toBeFalse();
});

test('registration rejects duplicate emails', function () {
    $admin = adminForStoreUser();

    User::factory()->create(['email' => 'jane.doe@scholarmetric.edu']);

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload());

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('email');
});

test('registration rejects passwords shorter than 8 characters', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'password' => 'Sh0rt!1',
        'password_confirmation' => 'Sh0rt!1',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('password');
});

test('registration rejects passwords without complexity', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('password');
});

test('registration rejects mismatched password confirmation', function () {
    $admin = adminForStoreUser();

    $response = $this->actingAs($admin)->from('/admin/user')->post('/admin/user', storeUserPayload([
        'password_confirmation' => 'DifferentPass123!',
    ]));

    $response->assertRedirect('/admin/user');
    $response->assertSessionHasErrors('password');
});

test('registration does not allow forging an admin_id', function () {
    $admin = adminForStoreUser();

    $this->actingAs($admin)->post('/admin/user', storeUserPayload([
        'admin_id' => 'HACKED-ID',
    ]));

    $created = User::query()->where('email', 'jane.doe@scholarmetric.edu')->firstOrFail();

    expect($created->admin_id)->not->toBe('HACKED-ID');
});
