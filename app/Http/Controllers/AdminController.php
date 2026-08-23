<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\User;
use App\Services\EvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $tenantId = auth()->user()->university_id;

        $counts = User::where('university_id', $tenantId)
            ->selectRaw("
                SUM(CASE WHEN role = 'student' THEN 1 ELSE 0 END) as student_count,
                SUM(CASE WHEN role = 'faculty' THEN 1 ELSE 0 END) as faculty_count
            ")
            ->first();

        $studentCount = $counts->student_count ?? 0;
        $facultyCount = $counts->faculty_count ?? 0;
        $courseCount = Course::count();

        $feedbackCount = Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))->count();

        $ratingQuery = FeedbackAnswer::where('question_id', 'overall_rating')
            ->whereHas('feedback.faculty', fn ($q) => $q->where('university_id', $tenantId));

        $totalRatings = $ratingQuery->count();

        if ($totalRatings > 0) {
            $avgRating = round($ratingQuery->avg('rating'), 1);
            $excellent = (clone $ratingQuery)->where('rating', '>=', 4.5)->count();
            $good = (clone $ratingQuery)->whereBetween('rating', [3.5, 4.49])->count();
            $others = (clone $ratingQuery)->where('rating', '<', 3.5)->count();

            $excellentPct = round(($excellent / $totalRatings) * 100);
            $goodPct = round(($good / $totalRatings) * 100);
            $othersPct = 100 - $excellentPct - $goodPct;
        } else {
            $avgRating = 0;
            $excellentPct = 0;
            $goodPct = 0;
            $othersPct = 100;
        }

        $ratingChart = [
            'avgRating' => $avgRating,
            'excellentPct' => $excellentPct,
            'goodPct' => $goodPct,
            'othersPct' => $othersPct,
            'circumference' => 238.7,
            'excellentOffset' => 238.7 * (1 - $excellentPct / 100),
            'goodOffset' => 238.7 * (1 - $goodPct / 100),
            'goodRotation' => $excellentPct * 3.6,
        ];

        $departments = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $departmentPerformance = [];
        $colors = [
            ['bar' => '#0e48c1', 'shadow' => 'shadow-blue-500/20'],
            ['bar' => '#2563eb', 'shadow' => 'shadow-blue-400/20'],
            ['bar' => '#6366f1', 'shadow' => 'shadow-indigo-400/20'],
            ['bar' => '#10b981', 'shadow' => 'shadow-emerald-400/20'],
            ['bar' => '#f59e0b', 'shadow' => 'shadow-amber-400/20'],
            ['bar' => '#ef4444', 'shadow' => 'shadow-red-400/20'],
        ];

        foreach ($departments as $i => $dept) {
            $avg = Feedback::whereHas('faculty', function ($q) use ($dept, $tenantId) {
                $q->where('department', $dept)->where('university_id', $tenantId);
            })
                ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
                ->where('feedback_answers.question_id', 'overall_rating')
                ->avg('feedback_answers.rating');

            $score = $avg ? round(($avg / 5) * 100) : 0;

            $departmentPerformance[] = [
                'name' => $dept,
                'score' => $score,
                'avg_rating' => $avg ? round($avg, 1) : 0,
                'color' => $colors[$i % count($colors)],
            ];
        }

        usort($departmentPerformance, fn ($a, $b) => $b['score'] <=> $a['score']);

        return view('users.admin.dashboard', compact(
            'studentCount',
            'facultyCount',
            'courseCount',
            'feedbackCount',
            'departmentPerformance',
            'ratingChart',
        ));
    }

    public function users(): View
    {
        $recentUsers = User::where('university_id', auth()->user()->university_id)
            ->latest()->take(4)->get();

        return view('users.admin.admin-user', compact('recentUsers'));
    }

    public function storeUser(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['role'] = strtolower($validated['role']);
        $validated['password'] = Hash::make($validated['password']);
        $validated['admin_id'] = $this->generateAdminId();
        $validated['created_by'] = auth()->id();
        $validated['university_id'] = auth()->user()->university_id;
        $validated['access_level'] = null;

        User::create($validated);

        return back()->with('success', ucfirst($validated['role']).' account created successfully.');
    }

    public function students(): View
    {
        $tenantId = auth()->user()->university_id;
        $students = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->with('courses')
            ->withCount('courses')
            ->paginate(10);

        $departments = User::where('university_id', $tenantId)
            ->distinct()
            ->pluck('department');

        $totalStudents = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->count();

        return view('users.admin.students', [
            'students' => $students,
            'departments' => $departments,
            'totalStudents' => $totalStudents,
        ]);
    }

    public function faculty(): View
    {
        $tenantId = auth()->user()->university_id;

        $faculties = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->with('courses')
            ->withCount('courses')
            ->latest()
            ->paginate(10);

        $totalFaculty = User::where('university_id', $tenantId)->where('role', Role::Faculty)->count();
        $activeCourses = Course::withCount('users')->count();
        $pendingReviews = 0; // Can be configured based on your logic
        $tenuredPercentage = 65; // Can be calculated from data

        $departments = User::where('university_id', $tenantId)
            ->whereIn('role', [Role::Student, Role::Faculty])
            ->whereNotNull('department')
            ->select('department')
            ->distinct()
            ->get()
            ->map(fn ($user) => trim((string) $user->department))
            ->values();

        return view('users.admin.faculty', compact('faculties', 'totalFaculty', 'activeCourses', 'departments', 'pendingReviews', 'tenuredPercentage'));
    }

    public function assignCourses(User $faculty): View
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);

        $departmentSlug = Str::slug($faculty->department ?? '');

        $term = request()->query('term', currentTerm());

        $availableCourses = Course::where('department', $faculty->department)
            ->whereDoesntHave('faculty', fn ($q) => $q->where('course_user.term', $term))
            ->paginate(50);

        $assignedCourses = $faculty->courses()->wherePivot('term', $term)->get();

        return view('users.admin.faculty-assign-courses', compact('faculty', 'availableCourses', 'assignedCourses', 'departmentSlug', 'term'));
    }

    public function storeCourseAssignments(Request $request, User $faculty): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);

        $validated = $request->validate([
            'assigned_courses' => ['nullable', 'array'],
            'assigned_courses.*' => ['exists:courses,id'],
            'term' => ['nullable', 'string', 'max:255'],
        ]);

        $courseIds = $validated['assigned_courses'] ?? [];
        $term = $validated['term'] ?? currentTerm();

        $syncData = [];
        foreach ($courseIds as $courseId) {
            $syncData[$courseId] = ['term' => $term];
        }

        DB::transaction(function () use ($faculty, $term, $syncData) {
            $faculty->courses()->wherePivot('term', $term)->detach();
            $faculty->courses()->attach($syncData);
        });

        return redirect()->back()->with('success', 'Course assignments updated successfully.');
    }

    public function courses(): View
    {
        $tenantId = auth()->user()->university_id;

        $departments = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', [Role::Student, Role::Faculty])
            ->whereNotNull('department')
            ->select('department')
            ->distinct()
            ->get()
            ->map(fn ($user) => trim((string) $user->department))
            ->values();

        $courses = Course::query()
            ->withCount('users')
            ->latest()
            ->paginate(50);

        $totalEnrollment = $courses->sum('users_count');
        $activeCourses = $courses->count();
        $pendingEvaluations = $courses->where('status', 'pending')->count();

        return view('users.admin.courses', [
            'departments' => $departments,
            'courses' => $courses,
            'totalEnrollment' => $totalEnrollment,
            'activeCourses' => $activeCourses,
            'pendingEvaluations' => $pendingEvaluations,
        ]);
    }

    public function departments(): View
    {
        $tenantId = auth()->user()->university_id;

        $roleCounts = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', [Role::Student, Role::Faculty])
            ->whereNotNull('department')
            ->selectRaw('department, role, COUNT(*) as count')
            ->groupBy('department', 'role')
            ->get();

        $departments = $roleCounts->pluck('department')->unique()->map(function (?string $department) use ($roleCounts): array {
            $departmentName = trim((string) $department);

            return [
                'slug' => Str::slug($departmentName),
                'name' => $departmentName,
                'facultyCount' => $roleCounts->where('department', $department)->where('role', Role::Faculty)->sum('count'),
                'studentCount' => $roleCounts->where('department', $department)->where('role', Role::Student)->sum('count'),
            ];
        })->sortBy('name')->values();

        return view('users.admin.departments', compact('departments'));
    }

    public function department(string $department): View
    {
        $section = request()->string('section')->toString() ?: 'overview';
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $departmentUsers = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', [Role::Student, Role::Faculty])
            ->where('department', $departmentName)
            ->latest()
            ->paginate(50);

        $students = $departmentUsers
            ->where('role', Role::Student)
            ->values();

        $faculty = $departmentUsers
            ->where('role', Role::Faculty)
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
     * @param  Collection<int, User>|LengthAwarePaginator<int, User>  $users
     * @return array<string, mixed>
     */
    private function buildDepartmentPayload(
        string $departmentName,
        string $departmentSlug,
        Collection $students,
        Collection $faculty,
        Collection|LengthAwarePaginator $users,
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
                    'title' => ucfirst($user->role->value).' account added',
                    'detail' => $user->name.' was added to '.$departmentName.'.',
                    'time' => $user->created_at->diffForHumans(),
                ])
                ->values()
                ->all(),
        ];
    }

    public function assignDepartmentCourses(string $department, User $faculty): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);
        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);
        abort_unless($faculty->department === $departmentName, 404);

        $term = request()->query('term', currentTerm());

        $availableCourses = Course::where('department', $departmentName)
            ->whereDoesntHave('faculty', fn ($q) => $q->where('course_user.term', $term))
            ->paginate(50);

        $assignedCourses = $faculty->courses()->wherePivot('term', $term)->get();

        return view('users.admin.department-assign-courses', [
            'departmentName' => $departmentName,
            'department' => $department,
            'faculty' => $faculty,
            'availableCourses' => $availableCourses,
            'assignedCourses' => $assignedCourses,
        ]);
    }

    public function storeDepartmentCourseAssignments(Request $request, string $department, User $faculty): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);
        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);
        abort_unless($faculty->department === $departmentName, 404);

        $validated = $request->validate([
            'assigned_courses' => ['nullable', 'array'],
            'assigned_courses.*' => ['exists:courses,id'],
            'term' => ['nullable', 'string', 'max:255'],
        ]);

        $courseIds = $validated['assigned_courses'] ?? [];
        $term = $validated['term'] ?? currentTerm();

        $syncData = [];
        foreach ($courseIds as $courseId) {
            $syncData[$courseId] = ['term' => $term];
        }

        DB::transaction(function () use ($faculty, $term, $syncData) {
            $faculty->courses()->wherePivot('term', $term)->detach();
            $faculty->courses()->attach($syncData);
        });

        return redirect()
            ->route('admin.departments.manage', ['department' => $department, 'section' => 'faculty'])
            ->with('success', 'Course assignments updated successfully.');
    }

    public function assignEnrollmentCourses(string $department): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $students = User::where('university_id', $tenantId)
            ->where('department', $departmentName)
            ->where('role', Role::Student)
            ->with('courses')
            ->paginate(50);

        $availableCourses = Course::where('department', $departmentName)->paginate(50);

        return view('users.admin.department-assign-enrollment', [
            'departmentName' => $departmentName,
            'department' => $department,
            'students' => $students,
            'availableCourses' => $availableCourses,
        ]);
    }

    public function storeEnrollmentCourseAssignments(Request $request, string $department): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'assigned_courses' => ['nullable', 'array'],
            'assigned_courses.*' => ['exists:courses,id'],
        ]);

        $student = User::findOrFail($validated['student_id']);
        abort_unless($student->university_id === $tenantId && $student->role === Role::Student, 404);
        abort_unless($student->department === $departmentName, 404);

        $courseIds = $validated['assigned_courses'] ?? [];

        DB::transaction(function () use ($student, $courseIds) {
            $student->courses()->sync($courseIds);
        });

        return redirect()
            ->route('admin.departments.manage', ['department' => $department, 'section' => 'enrollment'])
            ->with('success', 'Course enrollment updated successfully.');
    }

    public function evaluations(): View
    {
        $tenantId = auth()->user()->university_id;

        $evaluations = Evaluation::whereHas('creator', function ($query) use ($tenantId) {
            $query->where('university_id', $tenantId);
        })
            ->withCount(['tokens', 'tokens as used_tokens_count' => function ($q) {
                $q->where('is_used', true);
            }])
            ->latest()
            ->paginate(50);

        $activeEvaluations = $evaluations->where('status', 'active');
        $scheduledEvaluations = $evaluations->where('status', 'scheduled');
        $closedEvaluations = $evaluations->where('status', 'closed');
        $draftEvaluations = $evaluations->where('status', 'draft');

        $activeEvaluationsProgress = $activeEvaluations->mapWithKeys(function ($eval) {
            $eligible = $eval->tokens_count;
            $submitted = $eval->used_tokens_count;

            return [$eval->id => [
                'eligible' => $eligible,
                'submitted' => $submitted,
                'pending' => $eligible - $submitted,
                'completion_percentage' => $eligible > 0
                    ? round(($submitted / $eligible) * 100)
                    : 0,
            ]];
        });

        return view('users.admin.evaluations.index', compact(
            'evaluations',
            'activeEvaluations',
            'scheduledEvaluations',
            'closedEvaluations',
            'draftEvaluations',
            'activeEvaluationsProgress'
        ));
    }

    public function newEvaluationStep1(Request $request): View
    {
        $evaluationData = $request->session()->get('evaluation_wizard_step1', []);

        return view('users.admin.evaluations.step1', compact('evaluationData'));
    }

    public function storeEvaluationStep1(StoreEvaluationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->session()->put('evaluation_wizard_step1', $validated);

        return redirect()->route('admin.evaluations.new.step2');
    }

    public function newEvaluationStep2(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('evaluation_wizard_step1')) {
            return redirect()->route('admin.evaluations.new.step1');
        }

        $tenantId = auth()->user()->university_id;

        $departments = User::where('university_id', $tenantId)
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $selectionData = $request->session()->get('evaluation_wizard_step2', []);

        return view('users.admin.evaluations.step2', compact('departments', 'selectionData'));
    }

    public function getFacultyCoursesForEvaluation(Request $request): JsonResponse
    {
        $tenantId = auth()->user()->university_id;
        $department = $request->query('department');

        $faculty = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->where('department', $department)
            ->with(['courses' => function ($query) {
                $query->withCount(['users as students_count' => function ($q) {
                    $q->where('role', Role::Student);
                }]);
            }])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'department' => trim((string) $user->department),
                    'courses' => $user->courses->map(function ($course) {
                        return [
                            'id' => $course->id,
                            'code' => $course->code,
                            'title' => $course->title,
                            'credit_hours' => $course->credit_hours,
                            'students_count' => $course->students_count,
                        ];
                    }),
                ];
            });

        return response()->json(['faculty' => $faculty]);
    }

    public function storeEvaluationStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department' => 'required|string',
            'selected_faculty' => 'required|array',
            'selected_courses' => 'required|array',
        ]);

        $request->session()->put('evaluation_wizard_step2', $validated);

        return redirect()->route('admin.evaluations.new.step3');
    }

    public function newEvaluationStep3(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('evaluation_wizard_step1') || ! $request->session()->has('evaluation_wizard_step2')) {
            return redirect()->route('admin.evaluations.new.step1');
        }

        $step1 = $request->session()->get('evaluation_wizard_step1');
        $step2 = $request->session()->get('evaluation_wizard_step2');

        $faculty = User::whereIn('id', $step2['selected_faculty'])->get();
        $courses = Course::withCount(['users as students_count' => function ($q) {
            $q->where('role', Role::Student);
        }])->whereIn('id', $step2['selected_courses'])->get();

        $totalEligibleStudents = $courses->sum('students_count');

        return view('users.admin.evaluations.step3', compact('step1', 'step2', 'faculty', 'courses', 'totalEligibleStudents'));
    }

    public function publishEvaluation(Request $request, EvaluationService $evaluationService): RedirectResponse
    {
        if (! $request->session()->has('evaluation_wizard_step1') || ! $request->session()->has('evaluation_wizard_step2')) {
            return redirect()->route('admin.evaluations.new.step1');
        }

        $step1 = $request->session()->get('evaluation_wizard_step1');
        $step2 = $request->session()->get('evaluation_wizard_step2');

        $step1['created_by'] = auth()->id();

        // Build course to faculty mapping based on selected courses
        $courseFacultyMapping = [];
        $tenantId = auth()->user()->university_id;

        // We need to map each selected course to its faculty
        $facultyCourses = User::where('university_id', $tenantId)
            ->whereIn('id', $step2['selected_faculty'])
            ->with('courses')
            ->get();

        foreach ($facultyCourses as $faculty) {
            foreach ($faculty->courses as $course) {
                if (in_array($course->id, $step2['selected_courses'])) {
                    $courseFacultyMapping[$course->id] = $faculty->id;
                }
            }
        }

        $evaluationService->publishEvaluation($step1, $step2['selected_faculty'], $courseFacultyMapping);

        $request->session()->forget(['evaluation_wizard_step1', 'evaluation_wizard_step2']);

        return redirect()->route('admin.evaluations')->with('success', 'Evaluation cycle published successfully. Tokens have been generated for eligible students.');
    }

    public function editEvaluation(Evaluation $evaluation): View
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($evaluation->creator->university_id === $tenantId, 403);
        abort_unless($evaluation->status === 'scheduled', 404);

        return view('users.admin.evaluations.edit', compact('evaluation'));
    }

    public function updateEvaluation(Request $request, Evaluation $evaluation): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($evaluation->creator->university_id === $tenantId, 403);
        abort_unless($evaluation->status === 'scheduled', 404);

        $datesLocked = $evaluation->start_date->lte(now());

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
            'evaluation_type' => ['required', 'string', 'max:255'],
            'start_date' => $datesLocked ? ['sometimes'] : ['required', 'date'],
            'end_date' => $datesLocked ? ['sometimes'] : ['required', 'date', 'after:start_date'],
            'is_anonymous' => ['boolean'],
            'allow_faculty_response' => ['boolean'],
            'send_reminder' => ['boolean'],
        ]);

        $validated['is_anonymous'] = $request->boolean('is_anonymous');
        $validated['allow_faculty_response'] = $request->boolean('allow_faculty_response');
        $validated['send_reminder'] = $request->boolean('send_reminder');

        if ($datesLocked) {
            unset($validated['start_date'], $validated['end_date']);
        }

        $evaluation->update($validated);

        return redirect()->route('admin.evaluations')->with('success', 'Scheduled evaluation updated successfully.');
    }

    public function eval(): View
    {
        return view('admin.evaluations.index');
    }

    public function newCourse(): View
    {
        $tenantId = auth()->user()->university_id;

        $departments = User::query()
            ->where('university_id', $tenantId)
            ->whereIn('role', [Role::Student, Role::Faculty])
            ->whereNotNull('department')
            ->select('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('users.admin.new-course', compact('departments'));
    }

    public function storeCourse(StoreCourseRequest $request): RedirectResponse
    {
        Course::create($request->validated());

        return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
    }

    public function manageDepartment(string $department): View
    {
        $section = request()->string('section')->toString() ?: 'courses';
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $courses = Course::where('department', $departmentName)->latest()->paginate(50);
        $facultyMembers = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->where('department', $departmentName)
            ->with('courses')
            ->latest()
            ->paginate(50);
        $students = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->where('department', $departmentName)
            ->with('courses')
            ->latest()
            ->paginate(50);

        return view('users.admin.department-manage', [
            'departmentName' => $departmentName,
            'department' => $department,
            'section' => in_array($section, ['courses', 'faculty', 'enrollment'], true) ? $section : 'courses',
            'courses' => $courses,
            'facultyMembers' => $facultyMembers,
            'students' => $students,
        ]);
    }

    public function newDepartmentCourse(string $department): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        return view('users.admin.department-new-course', [
            'departmentName' => $departmentName,
            'department' => $department,
        ]);
    }

    public function storeDepartmentCourse(Request $request, string $department): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

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

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);
        abort_unless($course->department === $departmentName, 404);

        return view('users.admin.department-edit-course', [
            'departmentName' => $departmentName,
            'department' => $department,
            'course' => $course,
        ]);
    }

    public function updateDepartmentCourse(Request $request, string $department, Course $course): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

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

    public function destroyDepartmentCourse(string $department, Course $course): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

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

    public function assignFacultyToCourses(?string $department = null): View
    {
        $tenantId = auth()->user()->university_id;

        $query = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->with('courses');

        if ($department) {
            $query->where('department', $department);
        }

        $faculty = $query->latest()->paginate(50);

        $term = request()->query('term', currentTerm());

        $courses = Course::whereDoesntHave('faculty', fn ($q) => $q->where('course_user.term', $term))
            ->latest()
            ->paginate(50);

        return view('users.admin.courses-assign-faculty', [
            'faculty' => $faculty,
            'courses' => $courses,
            'selectedDepartment' => $department,
            'term' => $term,
        ]);
    }

    public function storeFacultyAssignments(Request $request): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $validated = $request->validate([
            'faculty_id' => ['required', 'exists:users,id'],
            'assigned_courses' => ['nullable', 'array'],
            'assigned_courses.*' => ['exists:courses,id'],
            'term' => ['nullable', 'string', 'max:255'],
        ]);

        $faculty = User::findOrFail($validated['faculty_id']);
        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);

        $courseIds = $validated['assigned_courses'] ?? [];
        $term = $validated['term'] ?? currentTerm();

        $syncData = [];
        foreach ($courseIds as $courseId) {
            $syncData[$courseId] = ['term' => $term];
        }

        DB::transaction(function () use ($faculty, $term, $syncData) {
            $faculty->courses()->wherePivot('term', $term)->detach();
            $faculty->courses()->attach($syncData);
        });

        return redirect()->route('admin.courses')
            ->with('success', 'Faculty course assignment updated successfully.');
    }

    public function assignStudentsToCourses(?string $department = null): View
    {
        $tenantId = auth()->user()->university_id;

        $query = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->with('courses');

        if ($department) {
            $query->where('department', $department);
        }

        $students = $query->latest()->paginate(50);

        $courses = Course::latest()->paginate(50);

        return view('users.admin.courses-assign-students', [
            'students' => $students,
            'courses' => $courses,
            'selectedDepartment' => $department,
        ]);
    }

    public function storeStudentAssignments(Request $request): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'assigned_courses' => ['nullable', 'array'],
            'assigned_courses.*' => ['exists:courses,id'],
        ]);

        $student = User::findOrFail($validated['student_id']);
        abort_unless($student->university_id === $tenantId && $student->role === Role::Student, 404);

        $courseIds = $validated['assigned_courses'] ?? [];

        DB::transaction(function () use ($student, $courseIds) {
            $student->courses()->sync($courseIds);
        });

        return redirect()->route('admin.courses')
            ->with('success', 'Student course assignment updated successfully.');
    }

    public function editUser(User $user): View
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        $departments = User::where('university_id', $tenantId)
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        return view('users.admin.edit', compact('user', 'departments'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:student,faculty,admin'],
            'department' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['role'] = strtolower($validated['role']);
        $validated['is_active'] = $request->boolean('is_active', true);

        DB::transaction(function () use ($user, $validated) {
            $user->update($validated);
        });

        $redirectRoute = $user->role === Role::Faculty ? '/admin/faculty' : '/admin/students';

        return redirect($redirectRoute)->with('success', 'User profile updated successfully.');
    }

    public function toggleStatus(Request $request, User $user): JsonResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        $user->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
        ]);
    }

    public function recoveryUser(User $user): View
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        return view('users.admin.recovery', compact('user'));
    }

    public function sendRecoveryEmail(User $user): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        return back()->with('success', 'A secure password recovery link has been sent to '.$user->email);
    }

    public function updateTemporaryPassword(Request $request, User $user): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:14'],
            'force_change' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($user, $validated, $request) {
            $user->update([
                'password' => Hash::make($validated['password']),
                'password_change_required' => $request->boolean('force_change'),
            ]);
        });

        return redirect()->route('admin.users.edit', $user)->with('success', 'Temporary password updated successfully. Make sure to communicate it to the user.');
    }

    private function resolveDepartmentNameBySlug(string $slug, ?string $tenantId): ?string
    {
        return User::query()
            ->where('university_id', $tenantId)
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->map(fn (?string $value): string => trim((string) $value))
            ->filter()
            ->first(fn (string $value): bool => Str::slug($value) === $slug);
    }

    public function moderation(Request $request): View
    {
        $tenantId = auth()->user()->university_id;

        $query = FeedbackAnswer::whereNotNull('moderation_status')
            ->with(['feedback.course', 'feedback.faculty'])
            ->whereHas('feedback', function ($q) use ($tenantId) {
                $q->whereHas('faculty', function ($q2) use ($tenantId) {
                    $q2->where('university_id', $tenantId);
                });
            });

        if ($request->has('status') && in_array($request->status, ['approved', 'flagged', 'rejected'])) {
            $query->where('moderation_status', $request->status);
        }

        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('original_comment', 'like', "%{$search}%")
                    ->orWhere('cleaned_comment', 'like', "%{$search}%")
                    ->orWhere('moderation_reason', 'like', "%{$search}%");
            });
        }

        $answers = $query->latest('moderated_at')->paginate(15);

        $statsQuery = FeedbackAnswer::whereNotNull('moderation_status')
            ->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });

        $moderationStats = (clone $statsQuery)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN moderation_status = 'approved' THEN 1 ELSE 0 END) as approved_count,
                SUM(CASE WHEN moderation_status = 'flagged' THEN 1 ELSE 0 END) as flagged_count,
                SUM(CASE WHEN moderation_status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
                AVG(toxicity_score) as avg_toxicity
            ")
            ->first();

        $totalModerated = $moderationStats->total ?? 0;
        $totalApproved = $moderationStats->approved_count ?? 0;
        $totalFlagged = $moderationStats->flagged_count ?? 0;
        $totalRejected = $moderationStats->rejected_count ?? 0;
        $avgToxicity = round($moderationStats->avg_toxicity ?? 0, 2);

        return view('users.admin.moderation', compact(
            'answers', 'totalModerated', 'totalApproved', 'totalFlagged', 'totalRejected', 'avgToxicity'
        ));
    }
}
