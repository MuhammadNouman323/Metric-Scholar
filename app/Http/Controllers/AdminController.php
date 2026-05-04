<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard()
    {
        $studentCount = User::whereRaw('LOWER(role) = ?', ['student'])->count();
        $facultyCount = User::whereRaw('LOWER(role) = ?', ['faculty'])->count();

        return view('users.admin.dashboard', compact('studentCount', 'facultyCount'));
    }

    public function users()
    {
        $recentUsers = User::latest()->take(4)->get();

        return view('users.admin.admin-user', compact('recentUsers'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:student,faculty'],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['role'] = strtolower($validated['role']);
        $validated['password'] = Hash::make($validated['password']);
        $validated['admin_id'] = null;
        $validated['access_level'] = null;

        User::create($validated);

        return back()->with('success', ucfirst($validated['role']).' account created successfully.');
    }

    public function students()
    {
        return view('users.admin.students');
    }

    public function faculty()
    {
        return view('users.admin.faculty');
    }

    public function courses()
    {
        return view('users.admin.courses');
    }

    public function departments()
    {
        $departments = User::query()
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->select('department')
            ->distinct()
            ->get()
            ->map(function (User $user): array {
                $departmentName = trim((string) $user->department);

                return [
                    'slug' => Str::slug($departmentName),
                    'name' => $departmentName,
                    'facultyCount' => User::query()
                        ->whereRaw('LOWER(role) = ?', ['faculty'])
                        ->where('department', $departmentName)
                        ->count(),
                    'studentCount' => User::query()
                        ->whereRaw('LOWER(role) = ?', ['student'])
                        ->where('department', $departmentName)
                        ->count(),
                ];
            })
            ->sortBy('name')
            ->values();

        return view('users.admin.departments', compact('departments'));
    }

    public function department(string $department)
    {
        $section = request()->string('section')->toString() ?: 'overview';

        $departmentName = User::query()
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);

        $departmentUsers = User::query()
            ->whereIn('role', ['student', 'faculty'])
            ->where('department', $departmentName)
            ->latest()
            ->get();

        $students = $departmentUsers
            ->where('role', 'student')
            ->values();

        $faculty = $departmentUsers
            ->where('role', 'faculty')
            ->values();

        $departmentPayload = $this->buildDepartmentPayload(
            departmentName: $departmentName,
            departmentSlug: $department,
            students: $students,
            faculty: $faculty,
            users: $departmentUsers,
        );

        return view('users.admin.department-detail', [
            'department' => $departmentPayload,
            'section' => in_array($section, ['overview', 'faculty', 'enrollment'], true) ? $section : 'overview',
        ]);
    }

    /**
     * @param  Collection<int, User>  $students
     * @param  Collection<int, User>  $faculty
     * @param  Collection<int, User>  $users
     * @return array<string, mixed>
     */
    private function buildDepartmentPayload(
        string $departmentName,
        string $departmentSlug,
        Collection $students,
        Collection $faculty,
        Collection $users,
    ): array {
        $departmentCode = Str::upper(Str::substr(Str::slug($departmentName, ''), 0, 4));

        return [
            'slug' => $departmentSlug,
            'name' => $departmentName,
            'departmentCode' => $departmentCode !== '' ? $departmentCode : 'DEPT',
            'established' => 'Live Department Data',
            'description' => 'This department overview is generated from student and faculty accounts created through admin management.',
            'pulse' => [
                'facultyCount' => (string) $faculty->count(),
                'studentCount' => (string) $students->count(),
                'recentAdditions' => (string) $users->where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'enrollment' => [
                ['label' => 'Total Students', 'value' => number_format($students->count())],
                ['label' => 'Total Faculty', 'value' => number_format($faculty->count())],
                ['label' => 'Total Members', 'value' => number_format($users->count())],
            ],
            'students' => $students
                ->map(fn (User $user): array => [
                    'initials' => Str::of($user->name)->explode(' ')->filter()->take(2)->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))->implode(''),
                    'name' => $user->name,
                    'email' => $user->email,
                    'program' => $departmentName,
                    'status' => 'Active',
                ])
                ->values()
                ->all(),
            'faculty' => $faculty
                ->map(fn (User $user): array => [
                    'initials' => Str::of($user->name)->explode(' ')->filter()->take(2)->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))->implode(''),
                    'name' => $user->name,
                    'role' => 'Faculty Member',
                    'email' => $user->email,
                    'office' => $departmentName,
                    'status' => 'Active',
                ])
                ->values()
                ->all(),
            'activity' => $users
                ->take(5)
                ->map(fn (User $user): array => [
                    'title' => ucfirst($user->role).' account added',
                    'detail' => $user->name.' was added to '.$departmentName.'.',
                    'time' => $user->created_at->diffForHumans(),
                ])
                ->values()
                ->all(),
        ];
    }

    public function reports()
    {
        return view('users.admin.reports');
    }

    public function newCourse(): View
    {
        return view('users.admin.new-course');
    }
}
