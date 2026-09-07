<?php

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

function resetPasswordUser(): User
{
    return User::factory()->create([
        'email' => 'reset@scholarmetric.edu',
    ]);
}

function validResetPayload(array $overrides = []): array
{
    return array_merge([
        'token' => 'invalid-token',
        'email' => 'reset@scholarmetric.edu',
        'password' => 'NewStrongPass123!',
        'password_confirmation' => 'NewStrongPass123!',
    ], $overrides);
}

test('forgot password page renders', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('Forgot your password?');
});

test('sending a reset link for a valid email returns a status and sends the notification', function () {
    $user = resetPasswordUser();

    Notification::fake();

    $response = $this->from(route('password.request'))->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('password.request'));
    $response->assertSessionHas('status');
    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

test('sending a reset link requires a valid email', function (string $email) {
    $this->from(route('password.request'))
        ->post(route('password.email'), ['email' => $email])
        ->assertRedirect(route('password.request'))
        ->assertSessionHasErrors('email');
})->with(['', 'not-an-email']);

test('a valid reset link shows the reset password form', function () {
    $user = resetPasswordUser();

    $token = Password::broker()->createToken($user);

    $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->assertOk()
        ->assertViewIs('auth.reset-password');
});

test('an invalid reset link shows the expired page', function () {
    $user = resetPasswordUser();

    $this->get(route('password.reset', ['token' => 'bogus-token', 'email' => $user->email]))
        ->assertOk()
        ->assertViewIs('auth.reset-link-expired')
        ->assertSee('This link is invalid');
});

test('an expired reset link shows the expired page', function () {
    $user = resetPasswordUser();

    $token = 'expired-token';
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now()->subMinutes(61),
    ]);

    $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->assertOk()
        ->assertViewIs('auth.reset-link-expired')
        ->assertSee('This link has expired');
});

test('password reset rejects passwords without required complexity', function () {
    $user = resetPasswordUser();

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->post(route('password.update'), validResetPayload([
            'token' => $token,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]))
        ->assertRedirect(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->assertSessionHasErrors('password');
});

test('password reset rejects passwords shorter than 8 characters', function () {
    $user = resetPasswordUser();

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->post(route('password.update'), validResetPayload([
            'token' => $token,
            'password' => 'Sh0rt!1',
            'password_confirmation' => 'Sh0rt!1',
        ]))
        ->assertRedirect(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->assertSessionHasErrors('password');
});

test('password reset rejects mismatched password confirmation', function () {
    $user = resetPasswordUser();

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->post(route('password.update'), validResetPayload([
            'token' => $token,
            'password_confirmation' => 'DifferentPass123!',
        ]))
        ->assertRedirect(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->assertSessionHasErrors('password');
});

test('password reset rejects an invalid or mismatched token', function () {
    $user = resetPasswordUser();

    $this->from(route('password.reset', ['token' => 'bogus', 'email' => $user->email]))
        ->post(route('password.update'), validResetPayload())
        ->assertRedirect(route('password.reset', ['token' => 'bogus', 'email' => $user->email]))
        ->assertSessionHasErrors('email');
});

test('a valid reset resets the user password and redirects to login', function () {
    $user = resetPasswordUser();

    $token = Password::broker()->createToken($user);

    $response = $this->from(route('password.reset', ['token' => $token, 'email' => $user->email]))
        ->post(route('password.update'), validResetPayload(['token' => $token]));

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('status');

    $user->refresh();
    expect(Hash::check('NewStrongPass123!', $user->password))->toBeTrue();
});
