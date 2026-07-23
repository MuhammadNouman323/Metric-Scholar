<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Enforce access control for editing another user's profile.
     */
    protected function validateProfileAccess(?User $user): ?RedirectResponse
    {
        if ($user && $user->id !== auth()->id()) {
            $role = strtolower(auth()->user()->role);

            return redirect()->to("/{$role}/dashboard")->with('error', 'You are not authorized to access this page.');
        }

        return null;
    }

    /**
     * Show the Admin Profile view.
     */
    public function showAdminProfile(?User $user = null): View|RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $admin = auth()->user();

        return view('users.admin.profile', compact('admin'));
    }

    /**
     * Show the Faculty Profile view.
     */
    public function showFacultyProfile(?User $user = null): View|RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $faculty = auth()->user();

        return view('users.faculty.profile', compact('faculty'));
    }

    /**
     * Show the Student Profile view.
     */
    public function showStudentProfile(?User $user = null): View|RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $student = auth()->user();

        // Calculate student statistics
        $activeCourses = $student->courses()->count();
        $totalCredits = $student->courses()->sum('credit_hours') ?? 0;

        $allTokens = $student->feedbackTokens()->get();
        $submittedFeedbackCount = $allTokens->where('is_used', true)->count();
        $feedbackRate = $allTokens->count() > 0 ? round(($submittedFeedbackCount / $allTokens->count()) * 100) : 0;

        $submissions = $student->feedbackTokens()
            ->with(['evaluation', 'course'])
            ->where('is_used', true)
            ->latest('used_at')
            ->take(5)
            ->get();

        return view('users.student.profile', compact(
            'student',
            'activeCourses',
            'totalCredits',
            'feedbackRate',
            'submissions'
        ));
    }

    /**
     * Update the authenticated user's profile details.
     */
    public function updateProfile(UpdateProfileRequest $request, ?User $user = null): RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $currentUser = auth()->user();
        $data = $request->validated();

        DB::transaction(function () use ($currentUser, $request, $data) {
            if ($request->hasFile('avatar')) {
                if ($currentUser->avatar) {
                    Storage::disk('public')->delete($currentUser->avatar);
                }

                $path = $request->file('avatar')->store('profile-images', 'public');
                $currentUser->avatar = $path;
            }

            $currentUser->name = $data['name'];
            $currentUser->email = $data['email'];
            $currentUser->phone = $data['phone'] ?? null;
            $currentUser->save();
        });

        return back()->with('success', 'Profile information updated successfully.');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(UpdatePasswordRequest $request, ?User $user = null): RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $currentUser = auth()->user();
        $currentUser->password = Hash::make($request->password);
        $currentUser->save();

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the authenticated user's profile picture.
     */
    public function removeAvatar(?User $user = null): RedirectResponse
    {
        if ($redirect = $this->validateProfileAccess($user)) {
            return $redirect;
        }

        $currentUser = auth()->user();

        if ($currentUser->avatar) {
            Storage::disk('public')->delete($currentUser->avatar);
            $currentUser->avatar = null;
            $currentUser->save();
        }

        return back()->with('success', 'Profile picture removed successfully.');
    }
}
