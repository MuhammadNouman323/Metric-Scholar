<?php

namespace App\Http\Controllers;
use App\Models\Course;
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
        $tenantId = auth()->user()->university_id;
        $studentCount = User::where('university_id', $tenantId)->whereRaw('LOWER(role) = ?', ['student'])->count();
        $facultyCount = User::where('university_id', $tenantId)->whereRaw('LOWER(role) = ?', ['faculty'])->count();
        $courseCount = Course::all()->count();

        return view('users.admin.dashboard', compact('studentCount', 'facultyCount', 'courseCount'));
    }

    public function users()
    {
        $recentUsers = User::where('university_id', auth()->user()->university_id)
            ->latest()->take(4)->get();

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
        $validated['admin_id'] = $this->generateAdminId();
        $validated['created_by'] = auth()->id();
        $validated['university_id'] = auth()->user()->university_id;
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
        $tenantId = auth()->user()->university_id;

        $departments = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->select('department')
            ->distinct()
            ->get()
            ->map(function (User $user) use ($tenantId): array {
                $departmentName = trim((string) $user->department);

                return [
                    'slug' => Str::slug($departmentName),
                    'name' => $departmentName,
                    'facultyCount' => User::query()
                        ->where('university_id', $tenantId)
                        ->whereRaw('LOWER(role) = ?', ['faculty'])
                        ->where('department', $departmentName)
                        ->count(),
                    'studentCount' => User::query()
                        ->where('university_id', $tenantId)
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
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);

        $departmentUsers = User::query()
            ->where('university_id', $tenantId)
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

    public function manageDepartment(string $department)
    {
        $section = request()->string('section')->toString() ?: 'courses';
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);

        $courses = Course::where('department', $departmentName)->latest()->get();

        return view('users.admin.department-manage', [
            'departmentName' => $departmentName,
            'department' => $department,
            'section' => in_array($section, ['courses', 'faculty', 'enrollment'], true) ? $section : 'courses',
            'courses' => $courses,
        ]);
    }

    public function newDepartmentCourse(string $department): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);

        return view('users.admin.department-new-course', [
            'departmentName' => $departmentName,
            'department' => $department,
        ]);
    }

    public function storeDepartmentCourse(Request $request, string $department)
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code'],
            'semester' => ['nullable', 'string', 'max:255'],
            'credit_hours' => ['nullable', 'integer', 'min:1', 'max:8'],
        ]);

        $validated['department'] = $departmentName;

        Course::create($validated);

        return redirect()->route('admin.departments.manage', ['department' => $department, 'section' => 'courses'])
            ->with('success', 'Course created successfully.');
    }

    public function editDepartmentCourse(string $department, Course $course): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);
        abort_unless($course->department === $departmentName, 404);

        return view('users.admin.department-edit-course', [
            'departmentName' => $departmentName,
            'department' => $department,
            'course' => $course,
        ]);
    }

    public function updateDepartmentCourse(Request $request, string $department, Course $course)
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);
        abort_unless($course->department === $departmentName, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code,'.$course->id],
            'semester' => ['nullable', 'string', 'max:255'],
            'credit_hours' => ['nullable', 'integer', 'min:1', 'max:8'],
        ]);

        $course->update($validated);

        return redirect()->route('admin.departments.manage', ['department' => $department, 'section' => 'courses'])
            ->with('success', 'Course updated successfully.');
    }

    public function destroyDepartmentCourse(string $department, Course $course)
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', ['student', 'faculty'])
            ->whereNotNull('department')
            ->get(['department'])
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $department);

        abort_unless($departmentName !== null, 404);
        abort_unless($course->department === $departmentName, 404);

        $course->delete();

        return redirect()->route('admin.departments.manage', ['department' => $department, 'section' => 'courses'])
            ->with('success', 'Course deleted successfully.');
    }

    private function generateAdminId(): string
    {
        do {
            $adminId = 'ADM-'.strtoupper((string) Str::random(6));
        } while (User::where('admin_id', $adminId)->exists());

        return $adminId;
    }
}
