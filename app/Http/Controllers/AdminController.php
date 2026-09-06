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
use App\Notifications\EvaluationRescheduledNotification;
use App\Services\EvaluationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $courseCount = Course::where('university_id', $tenantId)->count();

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

        $recentFeedbacks = Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))
            ->with(['course', 'answers'])
            ->orderByDesc('submitted_at')
            ->limit(5)
            ->get()
            ->map(function (Feedback $feedback): array {
                $quoteAnswer = $feedback->answers->first(
                    fn (FeedbackAnswer $answer): bool => filled($answer->text_answer)
                        && in_array($answer->moderation_status, ['approved', null], true)
                );

                return [
                    'type' => 'feedback',
                    'actor' => 'Anonymous Student',
                    'course' => $feedback->course?->title ?? $feedback->course?->code ?? 'a course',
                    'quote' => $quoteAnswer !== null ? Str::limit($quoteAnswer->text_answer, 110) : null,
                    'time' => $feedback->submitted_at->diffForHumans(),
                    'timestamp' => $feedback->submitted_at->getTimestamp(),
                ];
            })
            ->toBase();

        $recentUsers = User::where('university_id', $tenantId)
            ->whereKeyNot(auth()->id())
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn (User $user): array => [
                'type' => 'user',
                'name' => $user->name,
                'role' => ucfirst($user->role->value),
                'department' => $user->department,
                'avatar_url' => $user->avatar_url,
                'time' => $user->created_at->diffForHumans(),
                'timestamp' => $user->created_at->getTimestamp(),
            ])
            ->toBase();

        $recentActivity = $recentFeedbacks
            ->merge($recentUsers)
            ->sortByDesc('timestamp')
            ->take(2)
            ->values();

        // Engagement Trends: year-by-year with Spring (1st sem) and Fall (2nd sem)
        $currentYear = (int) date('Y');
        $years = range($currentYear - 1, $currentYear);

        $semesterDefs = [];
        $labels = [];
        foreach ($years as $year) {
            $semesterDefs[] = [
                'start' => "{$year}-01-01",
                'end'   => "{$year}-06-30",
                'label' => "Spring {$year}",
            ];
            $semesterDefs[] = [
                'start' => "{$year}-08-01",
                'end'   => "{$year}-12-31",
                'label' => "Fall {$year}",
            ];
            $labels[] = "Spring {$year}";
            $labels[] = "Fall {$year}";
        }

        $semesterData = [];
        foreach ($semesterDefs as $def) {
            $monthly = $this->getMonthlyRatingsByDepartment($tenantId, $def['start'], $def['end']);
            $semesterData[$def['label']] = $monthly->map(function ($months) {
                $values = $months->filter()->values();

                return $values->isEmpty() ? null : round($values->average(), 2);
            });
        }

        $allDepts = collect();
        foreach ($semesterData as $deptRatings) {
            $allDepts = $allDepts->merge($deptRatings->keys());
        }
        $allDepts = $allDepts->unique()->values();

        $deptAverages = $allDepts->mapWithKeys(function (string $dept) use ($semesterData) {
            $ratings = collect();
            foreach ($semesterData as $deptRatings) {
                $ratings->push($deptRatings->get($dept));
            }
            $average = $ratings->filter()->average();

            return [$dept => $average ? round($average, 2) : null];
        });

        $deptsWithRatings = $deptAverages->filter()->sortByDesc(fn ($avg) => $avg);

        $chartColors = [
            '#0e48c1', '#2563eb', '#6366f1', '#8b5cf6',
            '#10b981', '#14b8a6', '#f59e0b', '#ef4444',
            '#ec4899', '#0ea5e9',
        ];

        $chartDepartments = [];
        foreach ($deptsWithRatings->keys() as $index => $dept) {
            $series = [];
            foreach ($labels as $label) {
                $series[] = $semesterData[$label][$dept] ?? null;
            }
            $chartDepartments[] = [
                'name'    => $dept,
                'current' => $series,
                'color'   => $chartColors[$index % count($chartColors)],
            ];
        }

        $highestDept = $deptsWithRatings->keys()->first();
        $lowestDept = $deptsWithRatings->keys()->last();

        $engagementData = [
            'labels'      => $labels,
            'departments' => $chartDepartments,
            'summary'     => [
                'highest' => $highestDept,
                'lowest'  => $lowestDept,
            ],
        ];

        return view('users.admin.dashboard', compact(
            'studentCount',
            'facultyCount',
            'courseCount',
            'feedbackCount',
            'departmentPerformance',
            'ratingChart',
            'recentActivity',
            'engagementData',
        ));
    }

    public function users(): View
    {
        $recentUsers = User::where('university_id', auth()->user()->university_id)
            ->latest()->take(4)->get();

        return view('users.admin.admin-user', compact('recentUsers'));
    }

    public function registrations(): View
    {
        $tenantId = auth()->user()->university_id;

        $registrations = User::where('university_id', $tenantId)
            ->whereKeyNot(auth()->id())
            ->latest()
            ->paginate(12);

        $totalRegistrations = User::where('university_id', $tenantId)
            ->whereKeyNot(auth()->id())
            ->count();

        return view('users.admin.registrations', compact('registrations', 'totalRegistrations'));
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

    public function students(Request $request): View
    {
        $tenantId = auth()->user()->university_id;
        $students = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->with('courses')
            ->withCount('courses')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('department', $request->string('department')->toString());
            })
            ->paginate(10)->withQueryString();

        $departments = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->select('department')
            ->distinct()
            ->get()
            ->map(fn ($user) => trim((string) $user->department))
            ->filter()
            ->unique()
            ->values();

        $totalStudents = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->count();

        return view('users.admin.students', [
            'students' => $students,
            'departments' => $departments,
            'totalStudents' => $totalStudents,
        ]);
    }

    public function exportStudents(Request $request): StreamedResponse
    {
        $tenantId = auth()->user()->university_id;

        $students = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->withCount('courses')
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('department', $request->string('department')->toString());
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Student ID', 'Name', 'Email', 'Department', 'Enrolled Courses', 'Status']);

            foreach ($students as $student) {
                fputcsv($file, [
                    '#SC-'.$student->id,
                    $student->name,
                    $student->email,
                    $student->department ?? 'General',
                    $student->courses_count,
                    $student->is_active ? 'Active' : 'Inactive',
                ]);
            }

            fclose($file);
        };

        $filename = 'students_list_'.date('Ymd_His');

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    public function faculty(Request $request): View
    {
        $tenantId = auth()->user()->university_id;

        $faculties = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->with('courses')
            ->withCount('courses')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('department', $request->string('department')->toString());
            })
            ->latest()
            ->paginate(10)->withQueryString();

        $totalFaculty = User::where('university_id', $tenantId)->where('role', Role::Faculty)->count();
        $activeCourses = Course::where('university_id', $tenantId)->withCount('users')->count();
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

    public function exportFaculty(Request $request): StreamedResponse
    {
        $tenantId = auth()->user()->university_id;

        $faculties = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->withCount('courses')
            ->when($request->filled('department'), function ($query) use ($request) {
                $query->where('department', $request->string('department')->toString());
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();

        $callback = function () use ($faculties) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Faculty ID', 'Name', 'Email', 'Department', 'Course Load', 'Status']);

            foreach ($faculties as $faculty) {
                fputcsv($file, [
                    'FAC-'.$faculty->id,
                    $faculty->name,
                    $faculty->email,
                    $faculty->department ?? 'General',
                    $faculty->courses_count,
                    $faculty->is_active ? 'Active' : 'Inactive',
                ]);
            }

            fclose($file);
        };

        $filename = 'faculty_list_'.date('Ymd_His');

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    public function assignCourses(User $faculty): View
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($faculty->university_id === $tenantId && $faculty->role === Role::Faculty, 404);

        $departmentSlug = Str::slug($faculty->department ?? '');

        $term = request()->query('term', currentTerm());

        $availableCourses = Course::where('university_id', $tenantId)
            ->where('department', $faculty->department)
            ->whereDoesntHave('faculty', fn ($q) => $q->where('course_user.term', $term)->where('role', Role::Faculty->value))
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

    public function courses(Request $request): View
    {
        $tenantId = auth()->user()->university_id;
        $selectedSemester = trim((string) $request->query('semester', ''));
        $selectedDepartment = trim((string) $request->query('department', ''));

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
            ->where('university_id', $tenantId)
            ->when($selectedSemester !== '', function ($query) use ($selectedSemester) {
                $query->where('semester', $selectedSemester);
            })
            ->when($selectedDepartment !== '', function ($query) use ($selectedDepartment) {
                $query->where('department', $selectedDepartment);
            })
            ->withCount(['users as students_count' => function ($q) {
                $q->where('role', Role::Student);
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Tenant-wide stats are computed with aggregate queries so they are
        // not limited to the current page of the paginated course list.
        // Faculty share the course_user pivot with students, so enrollment
        // counts must always be filtered by the student role.
        $totalEnrollment = DB::table('course_user')
            ->join('courses', 'courses.id', '=', 'course_user.course_id')
            ->join('users', 'users.id', '=', 'course_user.user_id')
            ->where('courses.university_id', $tenantId)
            ->where('users.role', Role::Student->value)
            ->count();

        $activeCourses = Course::where('university_id', $tenantId)->count();
        $pendingEvaluations = Evaluation::whereHas('creator', function ($query) use ($tenantId) {
            $query->where('university_id', $tenantId);
        })
            ->scheduled()
            ->count();

        $semesters = Course::where('university_id', $tenantId)
            ->whereNotNull('semester')
            ->where('semester', '!=', '')
            ->distinct()
            ->orderBy('semester')
            ->pluck('semester');

        return view('users.admin.courses', [
            'departments' => $departments,
            'courses' => $courses,
            'totalEnrollment' => $totalEnrollment,
            'activeCourses' => $activeCourses,
            'pendingEvaluations' => $pendingEvaluations,
            'semesters' => $semesters,
            'selectedSemester' => $selectedSemester,
            'selectedDepartment' => $selectedDepartment,
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
                    'id' => $user->id,
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
                    'id' => $user->id,
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
->take(4)
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

        $availableCourses = Course::where('university_id', $tenantId)
            ->where('department', $departmentName)
            ->whereDoesntHave('faculty', fn ($q) => $q->where('course_user.term', $term)->where('role', Role::Faculty->value))
            ->paginate(50)->withQueryString();

        $assignedCourses = $faculty->courses()->wherePivot('term', $term)->get();

        return view('users.admin.department-assign-courses', [
            'departmentName' => $departmentName,
            'department' => $department,
            'faculty' => $faculty,
            'term' => $term,
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

        $availableCourses = Course::where('university_id', $tenantId)
            ->where('department', $departmentName)
            ->paginate(50);

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
            $student->courses()->syncWithPivotValues($courseIds, ['term' => currentTerm()]);
        });

        return redirect()
            ->route('admin.departments.manage', ['department' => $department, 'section' => 'enrollment'])
            ->with('success', 'Course enrollment updated successfully.');
    }

    public function evaluations(): View
    {
        $tenantId = auth()->user()->university_id;

        $tenantEvaluations = fn () => Evaluation::whereHas('creator', function ($query) use ($tenantId) {
            $query->where('university_id', $tenantId);
        });

        $withUsedTokensCount = function ($query) {
            $query->where('is_used', true);
        };

        $evaluations = $tenantEvaluations()
            ->withCount(['tokens', 'tokens as used_tokens_count' => $withUsedTokensCount])
            ->latest()
            ->paginate(50);

        // Status groups are queried separately: filtering the paginator would
        // only see the current page and silently drop evaluations from the
        // Active/Scheduled/Closed/Draft sections.
        $activeEvaluations = $tenantEvaluations()
            ->active()
            ->withCount(['tokens as used_tokens_count' => $withUsedTokensCount])
            ->latest()
            ->get();
        $scheduledEvaluations = $tenantEvaluations()->scheduled()->latest()->get();
        $closedEvaluations = $tenantEvaluations()->closed()->latest()->get();
        $draftEvaluations = $tenantEvaluations()->draft()->latest()->get();

        $eligibleCounts = Evaluation::eligibleStudentsCounts($activeEvaluations->modelKeys());

        $activeEvaluationsProgress = $activeEvaluations->mapWithKeys(function ($eval) use ($eligibleCounts) {
            // Eligible students come from current course enrollment, not the
            // tokens generated at publish time, so enrollment changes during
            // an active evaluation are reflected.
            $eligible = (int) ($eligibleCounts[$eval->id] ?? 0);
            $submitted = (int) $eval->used_tokens_count;

            return [$eval->id => [
                'eligible' => $eligible,
                'submitted' => $submitted,
                'pending' => max($eligible - $submitted, 0),
                'completion_percentage' => $eligible > 0
                    ? (int) min(round(($submitted / $eligible) * 100), 100)
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

        $tenantId = auth()->user()->university_id;
        $step1 = $request->session()->get('evaluation_wizard_step1');
        $step2 = $request->session()->get('evaluation_wizard_step2');

        $faculty = User::whereIn('id', $step2['selected_faculty'])->get();
        $courses = Course::where('university_id', $tenantId)
            ->withCount(['users as students_count' => function ($q) {
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

        $oldStartDate = $evaluation->start_date->format('Y-m-d');
        $oldEndDate = $evaluation->end_date->format('Y-m-d');

        $evaluation->update($validated);

        if ($evaluation->start_date->format('Y-m-d') !== $oldStartDate || $evaluation->end_date->format('Y-m-d') !== $oldEndDate) {
            $this->notifyEvaluationReschedule($evaluation, $oldStartDate, $oldEndDate);
        }

        return redirect()->route('admin.evaluations')->with('success', 'Scheduled evaluation updated successfully.');
    }

    private function notifyEvaluationReschedule(Evaluation $evaluation, string $oldStartDate, string $oldEndDate): void
    {
        $tenantId = auth()->user()->university_id;

        $studentIds = DB::table('evaluation_courses')
            ->join('course_user', 'course_user.course_id', '=', 'evaluation_courses.course_id')
            ->join('users', 'users.id', '=', 'course_user.user_id')
            ->where('evaluation_courses.evaluation_id', $evaluation->id)
            ->where('users.university_id', $tenantId)
            ->where('users.role', Role::Student->value)
            ->pluck('course_user.user_id');

        $recipientIds = $studentIds
            ->merge($evaluation->faculty()->where('users.university_id', $tenantId)->pluck('users.id'))
            ->unique()
            ->values();

        User::whereIn('id', $recipientIds)->get()->each(function (User $user) use ($evaluation, $oldStartDate, $oldEndDate) {
            $role = $user->role === Role::Faculty ? 'faculty' : 'student';

            try {
                $user->notify(new EvaluationRescheduledNotification($evaluation, $oldStartDate, $oldEndDate, $role));
            } catch (\Throwable $e) {
                Log::warning('Failed to notify user '.$user->id.' about rescheduled evaluation '.$evaluation->id.': '.$e->getMessage());
            }
        });
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
        $validated = $request->validated();
        $validated['university_id'] = auth()->user()->university_id;
        $validated['semester'] = $validated['semester'] ?? currentTerm();

        Course::create($validated);

        return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
    }

    public function editCourse(Course $course): View
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($course->university_id === $tenantId, 404);

        return view('users.admin.edit-course', ['course' => $course]);
    }

    public function updateCourse(Request $request, Course $course): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($course->university_id === $tenantId, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code,'.$course->id.',id,university_id,'.$tenantId],
            'semester' => ['nullable', 'string', 'max:255'],
            'credit_hours' => ['nullable', 'integer', 'min:1', 'max:8'],
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    public function destroyCourse(Course $course): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        abort_unless($course->university_id === $tenantId, 404);

        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }

    public function manageDepartment(string $department): View
    {
        $section = request()->string('section')->toString() ?: 'courses';
        $tenantId = auth()->user()->university_id;
        $term = currentTerm();

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $search = request()->string('search')->toString();
        $termFilter = request()->string('semester')->toString();

        $courses = Course::where('university_id', $tenantId)
            ->where('department', $departmentName)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->when($termFilter !== '', function ($query) use ($termFilter) {
                $query->where('semester', $termFilter);
            })
            ->latest()
            ->paginate(50)
            ->withQueryString();
        $facultyMembers = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->where('department', $departmentName)
            ->with(['courses' => fn ($q) => $q->wherePivot('term', $term)])
            ->latest()
            ->paginate(50);
        $students = User::query()
            ->where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->where('department', $departmentName)
            ->with('courses')
            ->latest()
            ->paginate(50);

        $deptMetrics = $this->buildDepartmentMetrics($tenantId, $departmentName);

        return view('users.admin.department-manage', [
            'departmentName' => $departmentName,
            'department' => $department,
            'section' => in_array($section, ['courses', 'faculty', 'enrollment'], true) ? $section : 'courses',
            'courses' => $courses,
            'facultyMembers' => $facultyMembers,
            'students' => $students,
            'deptMetrics' => $deptMetrics,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildDepartmentMetrics(int $tenantId, string $departmentName): array
    {
        $feedbackBase = fn ($query) => $query
            ->where('users.university_id', $tenantId)
            ->where('users.department', $departmentName);

        $avgRatingRow = DB::table('feedbacks')
            ->join('users', 'feedbacks.faculty_id', '=', 'users.id')
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where(fn ($q) => $feedbackBase($q))
            ->where('feedback_answers.question_id', 'overall_rating')
            ->avg('feedback_answers.rating');

        $trendRows = DB::table('feedbacks')
            ->join('users', 'feedbacks.faculty_id', '=', 'users.id')
            ->join('evaluations', 'feedbacks.evaluation_id', '=', 'evaluations.id')
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where(fn ($q) => $feedbackBase($q))
            ->where('feedback_answers.question_id', 'overall_rating')
            ->select('evaluations.semester', DB::raw('ROUND(AVG(feedback_answers.rating), 2) as avg'))
            ->groupBy('evaluations.semester')
            ->get();

        $seasonOrder = ['Spring' => 0, 'Summer' => 1, 'Fall' => 2];

        $semesterTrend = $trendRows
            ->mapWithKeys(fn ($row): array => [(string) $row->semester => (float) $row->avg])
            ->sortBy(function (float $avg, string $semester) use ($seasonOrder): int {
                $parts = explode(' ', $semester);

                return ((int) ($parts[1] ?? 0) * 10) + ($seasonOrder[$parts[0]] ?? 9);
            })
            ->take(5);

        return [
            'courseCount' => Course::where('university_id', $tenantId)
                ->where('department', $departmentName)
                ->count(),
            'facultyCount' => User::where('university_id', $tenantId)
                ->where('role', Role::Faculty)
                ->where('department', $departmentName)
                ->count(),
            'studentCount' => User::where('university_id', $tenantId)
                ->where('role', Role::Student)
                ->where('department', $departmentName)
                ->count(),
            'feedbackCount' => Feedback::whereHas('faculty', fn ($q) => $q
                ->where('university_id', $tenantId)
                ->where('department', $departmentName))->count(),
            'avgRating' => $avgRatingRow ? round((float) $avgRatingRow, 2) : 0.0,
            'semesterTrend' => $semesterTrend,
            'courseCodes' => Course::where('university_id', $tenantId)
                ->where('department', $departmentName)
                ->orderBy('code')
                ->limit(4)
                ->pluck('code')
                ->all(),
        ];
    }

    public function suggestDepartmentCourses(string $department): JsonResponse
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);

        $search = request()->string('q')->toString();

        $courses = Course::where('university_id', $tenantId)
            ->where('department', $departmentName)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->limit(10)
            ->get(['id', 'code', 'title', 'semester', 'credit_hours']);

        return response()->json(['courses' => $courses]);
    }

    public function suggestStudents(): JsonResponse
    {
        $tenantId = auth()->user()->university_id;

        $search = request()->string('q')->toString();

        $students = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->limit(10)
            ->get(['id', 'name', 'email', 'department', 'avatar'])
            ->append('avatar_url');

        return response()->json(['students' => $students]);
    }

    public function suggestFaculty(): JsonResponse
    {
        $tenantId = auth()->user()->university_id;

        $search = request()->string('q')->toString();

        $faculty = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->limit(10)
            ->get(['id', 'name', 'email', 'department', 'avatar'])
            ->append('avatar_url');

        return response()->json(['faculty' => $faculty]);
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
            'code' => ['required', 'string', 'max:255', 'unique:courses,code,NULL,id,university_id,'.$tenantId],
            'semester' => ['nullable', 'string', 'max:255'],
            'credit_hours' => ['nullable', 'integer', 'min:1', 'max:8'],
        ]);

        $validated['department'] = $departmentName;
        $validated['university_id'] = $tenantId;
        $validated['semester'] = $validated['semester'] ?? currentTerm();

        Course::create($validated);

        return redirect()->route('admin.departments.manage', ['department' => $department, 'section' => 'courses'])
            ->with('success', 'Course created successfully.');
    }

    public function editDepartmentCourse(string $department, Course $course): View
    {
        $tenantId = auth()->user()->university_id;

        $departmentName = $this->resolveDepartmentNameBySlug($department, $tenantId);

        abort_unless($departmentName !== null, 404);
        abort_unless($course->university_id === $tenantId && $course->department === $departmentName, 404);

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
        abort_unless($course->university_id === $tenantId && $course->department === $departmentName, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code,'.$course->id.',id,university_id,'.$tenantId],
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
        abort_unless($course->university_id === $tenantId && $course->department === $departmentName, 404);

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

        $term = request()->query('term', currentTerm());

        $query = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->with(['courses' => fn ($q) => $q->wherePivot('term', $term)]);

        if ($department) {
            $query->where('department', $department);
        }

        $faculty = $query->latest()->paginate(50);

        $courses = Course::where('university_id', $tenantId)
            ->when($department, fn ($q) => $q->where('department', $department))
            ->latest()
            ->paginate(50);

        $courseIds = $courses->pluck('id');

        $courseAssignments = DB::table('course_user')
            ->join('users', 'users.id', '=', 'course_user.user_id')
            ->where('users.role', Role::Faculty->value)
            ->where('users.university_id', $tenantId)
            ->where('course_user.term', $term)
            ->whereIn('course_user.course_id', $courseIds)
            ->select('course_user.course_id', 'users.id as faculty_id', 'users.name as faculty_name')
            ->get();

        $courseFacultyMap = $courseAssignments->keyBy('course_id')
            ->map(fn ($row) => ['id' => $row->faculty_id, 'name' => $row->faculty_name]);

        $facultyCourseMap = collect($faculty->items())->mapWithKeys(
            fn ($member) => [$member->id => $member->courses->pluck('id')->map(fn ($id) => (string) $id)->all()]
        );

        return view('users.admin.courses-assign-faculty', [
            'faculty' => $faculty,
            'courses' => $courses,
            'selectedDepartment' => $department,
            'term' => $term,
            'courseFacultyMap' => $courseFacultyMap,
            'facultyCourseMap' => $facultyCourseMap,
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

    public function assignStudentsToCourses(?string $department = null): View|RedirectResponse
    {
        $tenantId = auth()->user()->university_id;

        if ($department) {
            $departmentName = $this->resolveDepartmentNameBySlug(Str::slug($department), $tenantId);

            abort_unless($departmentName !== null, 404);

            return redirect()->route('admin.departments.enrollment.assign-courses', Str::slug($departmentName));
        }

        $students = User::where('university_id', $tenantId)
            ->where('role', Role::Student)
            ->with('courses')
            ->latest()
            ->paginate(50);

        $courses = Course::where('university_id', $tenantId)
            ->latest()
            ->paginate(50);

        return view('users.admin.courses-assign-students', [
            'students' => $students,
            'courses' => $courses,
            'selectedDepartment' => null,
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
            $student->courses()->syncWithPivotValues($courseIds, ['term' => currentTerm()]);
        });

        return redirect()->route('admin.courses')
            ->with('success', 'Student course assignment updated successfully.');
    }

    public function showUser(User $user): View
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);

        $courses = $user->courses()->withPivot('term')->latest('course_user.created_at')->get();

        return view('users.admin.show', compact('user', 'courses'));
    }

    public function destroyUser(User $user): RedirectResponse
    {
        $tenantId = auth()->user()->university_id;
        abort_unless($user->university_id === $tenantId, 403);
        abort_unless($user->role === Role::Student, 404);
        abort_if($user->id === auth()->id(), 403);

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.students')->with('success', "Student {$name} deleted successfully.");
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

        if ($user->is_active === false) {
            return back()->with('error', 'Cannot send a recovery link to a deactivated account.');
        }

        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'A secure password reset email has been sent to '.$user->email);
        }

        return back()->with('error', 'Unable to send the reset email. Please try again later.');
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

    private function getMonthlyRatingsByDepartment(?string $tenantId, string $startDate, string $endDate): Collection
    {
        $isSqlite = DB::getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "strftime('%m', feedbacks.submitted_at)" : 'MONTH(feedbacks.submitted_at)';

        return Feedback::query()
            ->when($tenantId, fn ($q) => $q->whereHas('faculty', fn ($qq) => $qq->where('university_id', $tenantId)))
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->join('users', 'feedbacks.faculty_id', '=', 'users.id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->where('feedbacks.submitted_at', '>=', $startDate)
            ->where('feedbacks.submitted_at', '<=', $endDate)
            ->selectRaw("users.department, {$monthExpr} as month_num, AVG(feedback_answers.rating) as avg_rating")
            ->groupBy('users.department', 'month_num')
            ->get()
            ->groupBy('department')
            ->map(fn ($rows) => $rows->pluck('avg_rating', 'month_num'));
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

    public function activityLog(Request $request): View
    {
        $tenantId = auth()->user()->university_id;
        $filter = $request->get('filter', 'all');
        $perPage = 15;

        $feedbackQuery = Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))
            ->with(['course', 'answers'])
            ->orderByDesc('submitted_at');

        $userQuery = User::where('university_id', $tenantId)
            ->whereKeyNot(auth()->id())
            ->orderByDesc('created_at');

        $feedbacks = $filter === 'all' || $filter === 'feedback'
            ? $feedbackQuery->get()->map(function (Feedback $feedback): array {
                $quoteAnswer = $feedback->answers->first(
                    fn (FeedbackAnswer $answer): bool => filled($answer->text_answer)
                        && in_array($answer->moderation_status, ['approved', null], true)
                );

                return [
                    'type' => 'feedback',
                    'actor' => 'Anonymous Student',
                    'course' => $feedback->course?->title ?? $feedback->course?->code ?? 'a course',
                    'quote' => $quoteAnswer !== null ? Str::limit($quoteAnswer->text_answer, 140) : null,
                    'time' => $feedback->submitted_at->diffForHumans(),
                    'timestamp' => $feedback->submitted_at->getTimestamp(),
                ];
            })
            : collect();

        $users = $filter === 'all' || $filter === 'user'
            ? $userQuery->get()->map(fn (User $user): array => [
                'type' => 'user',
                'name' => $user->name,
                'role' => ucfirst($user->role->value),
                'department' => $user->department,
                'avatar_url' => $user->avatar_url,
                'time' => $user->created_at->diffForHumans(),
                'timestamp' => $user->created_at->getTimestamp(),
            ])
            : collect();

        $activity = $feedbacks->merge($users)
            ->sortByDesc('timestamp')
            ->values();

        $paginated = new LengthAwarePaginator(
            $activity->forPage($request->get('page', 1), $perPage),
            $activity->count(),
            $perPage,
            $request->get('page', 1),
            ['path' => route('admin.activity-log'), 'query' => ['filter' => $filter]]
        );

        $counts = [
            'all' => Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))->count()
                + User::where('university_id', $tenantId)->whereKeyNot(auth()->id())->count(),
            'feedback' => Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))->count(),
            'user' => User::where('university_id', $tenantId)->whereKeyNot(auth()->id())->count(),
        ];

        return view('users.admin.activity-log', compact('activity', 'paginated', 'counts', 'filter'));
    }
}
