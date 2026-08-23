<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\University;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        $request->session()->regenerate();

        // track last activity for session expiration
        $request->session()->put('last_activity', now()->timestamp);

        /** @var User $user */
        $user = $request->user();

        if ($user->role->value !== $credentials['role']) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'role' => 'Selected role does not match this account.',
            ]);
        }

        return redirect()->intended($user->role->dashboardRoute());
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        unset($validated['terms']);
        $validated['role'] = Role::Admin->value;
        $validated['admin_id'] ??= 'ADM-'.strtoupper((string) str()->random(6));
        $validated['access_level'] ??= 'Full Access';
        $validated['password'] = Hash::make($validated['password']);

        $domain = explode('@', $validated['email'])[1];
        $university = University::firstOrCreate(
            ['domain' => $domain],
            ['name' => ucfirst(explode('.', $domain)[0]).' University']
        );

        $validated['university_id'] = $university->id;

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('last_activity', now()->timestamp);

        return redirect('/admin/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPassword(): View
    {
        $resetChannelToken = Str::random(32);
        session()->put('reset_channel_token', $resetChannelToken);

        return view('auth.forgot-password', compact('resetChannelToken'));
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (! $user || $user->role !== Role::Admin) {
            throw ValidationException::withMessages([
                'email' => 'No admin account found with that email address.',
            ]);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }

    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', ['token' => $token, 'email' => request('email')]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->password = Hash::make($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
