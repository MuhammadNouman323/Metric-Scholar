<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can view own profile', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/profile');

    $response->assertOk();
    $response->assertSee($admin->name);
    $response->assertSee($admin->email);
});

test('faculty can view own profile', function () {
    $faculty = User::factory()->create(['role' => 'faculty']);

    $response = $this->actingAs($faculty)->get('/faculty/profile');

    $response->assertOk();
    $response->assertSee($faculty->name);
    $response->assertSee($faculty->email);
});

test('student can view own profile', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)->get('/student/profile');

    $response->assertOk();
    $response->assertSee($student->name);
    $response->assertSee($student->email);
});

test('user cannot view another user profile URL', function () {
    $student1 = User::factory()->create(['role' => 'student']);
    $student2 = User::factory()->create(['role' => 'student']);

    // Accessing student2 profile as student1 should redirect to student1's dashboard
    $response = $this->actingAs($student1)->get("/student/profile/{$student2->id}");

    $response->assertRedirect('/student/dashboard');
    $response->assertSessionHas('error', 'You are not authorized to access this page.');
});

test('user can update personal info', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'name' => 'Original Name',
        // 'email' => 'original@student.edu',
        'phone' => '1234567890',
    ]);

    $response = $this->actingAs($student)->put('/student/profile', [
        'name' => 'Updated Name',
        'phone' => '0987654321',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Profile information updated successfully.');

    $this->assertDatabaseHas('users', [
        'id' => $student->id,
        'name' => 'Updated Name',
        'phone' => '0987654321',
    ]);
});

test('user can change password with correct current password', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'password' => Hash::make('old_password'),
    ]);

    $response = $this->actingAs($student)->put('/student/profile/password', [
        'current_password' => 'old_password',
        'password' => 'new_password123',
        'password_confirmation' => 'new_password123',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Password updated successfully.');

    $this->assertTrue(Hash::check('new_password123', $student->fresh()->password));
});

test('password change fails with incorrect current password', function () {
    $student = User::factory()->create([
        'role' => 'student',
        'password' => Hash::make('old_password'),
    ]);

    $response = $this->actingAs($student)->put('/student/profile/password', [
        'current_password' => 'wrong_password',
        'password' => 'new_password123',
        'password_confirmation' => 'new_password123',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors(['current_password']);
    $this->assertTrue(Hash::check('old_password', $student->fresh()->password));
});

test('user can upload and replace profile picture', function () {
    Storage::fake('public');

    $student = User::factory()->create([
        'role' => 'student',
        'avatar' => null,
    ]);

    // 1. Upload first image
    $file = UploadedFile::fake()->image('avatar.jpg');

    $response = $this->actingAs($student)->put('/student/profile', [
        'name' => $student->name,
        'avatar' => $file,
    ]);

    $response->assertRedirect();
    $student = $student->fresh();
    $this->assertNotNull($student->avatar);
    Storage::disk('public')->assertExists($student->avatar);

    $oldAvatarPath = $student->avatar;

    // 2. Upload second image (should replace and delete the first one)
    $newFile = UploadedFile::fake()->image('new_avatar.png');

    $response = $this->actingAs($student)->put('/student/profile', [
        'name' => $student->name,
        'avatar' => $newFile,
    ]);

    $student = $student->fresh();
    Storage::disk('public')->assertExists($student->avatar);
    Storage::disk('public')->assertMissing($oldAvatarPath);
});

test('user can remove profile picture', function () {
    Storage::fake('public');

    $student = User::factory()->create([
        'role' => 'student',
        'avatar' => 'profile-images/fake.jpg',
    ]);

    Storage::disk('public')->put('profile-images/fake.jpg', 'fake content');

    $response = $this->actingAs($student)->post('/student/profile/avatar/remove');

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Profile picture removed successfully.');

    $this->assertNull($student->fresh()->avatar);
    Storage::disk('public')->assertMissing('profile-images/fake.jpg');
});
