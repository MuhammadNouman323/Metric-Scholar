<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:admin,student,faculty'],
        ]);

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = $request->user();

        if (strtolower($user->role) !== $credentials['role']) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'role' => 'Selected role does not match this account.',
            ]);
        }

        return redirect()->intended($this->redirectPathForRole($user->role));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['nullable', 'string', 'max:255'],
            'admin_id' => ['nullable', 'string', 'max:255', 'unique:users,admin_id'],
            'access_level' => ['nullable', 'string', 'max:255'],
            'terms' => ['accepted'],
        ]);

        unset($validated['terms']);
        $validated['role'] = 'admin';
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
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if (! $user || strtolower($user->role) !== 'admin') {
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

    private function redirectPathForRole(string $role): string
    {
        return match (strtolower($role)) {
            'admin' => '/admin/dashboard',
            'faculty' => '/faculty/dashboard',
            default => '/student/dashboard',
        };
    }
}
