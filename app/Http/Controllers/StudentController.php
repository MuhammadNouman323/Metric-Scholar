<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Course;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Repositories\FeedbackRepository;
use App\Services\GeminiModerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(): View
    {
        $student = auth()->user();

        $enrolledCourses = $student->courses()->with('faculty')->get();
        $activeCourses = $enrolledCourses->count();

        // Get tokens for the student but ONLY for active evaluations
        $allTokens = $student->feedbackTokens()
            ->whereHas('evaluation', function ($query) {
                $query->active();
            })
            ->with(['evaluation', 'course', 'faculty'])
            ->get();

        $submittedFeedbackCount = $allTokens->where('is_used', true)->count();
        $pendingFeedback = $allTokens->where('is_used', false)->count();

        $totalEvaluations = $allTokens->count();
        $feedbackRate = $totalEvaluations > 0 ? round(($submittedFeedbackCount / $totalEvaluations) * 100) : 0;

        $pendingEvaluations = $allTokens->where('is_used', false)->take(5);

        $recentSubmission = $allTokens->where('is_used', true)->sortByDesc('used_at')->first();

        $notifications = $student->notifications()->take(5)->get();

        return view('users.student.dashboard', [
            'student' => $student,
            'activeCourses' => $activeCourses,
            'submittedFeedbackCount' => $submittedFeedbackCount,
            'pendingFeedback' => $pendingFeedback,
            'totalEvaluations' => $totalEvaluations,
            'feedbackRate' => $feedbackRate,
            'pendingEvaluations' => $pendingEvaluations,
            'recentSubmission' => $recentSubmission,
            'notifications' => $notifications,
        ]);
    }

    public function courses(): View
    {
        $student = auth()->user();
        $courses = $student->courses()->with('faculty')->paginate(10);
        $activeCourses = $courses->total();
        $totalCredits = $student->courses()->sum('credit_hours') ?? 0;

        $pendingFeedback = $student->feedbackTokens()->where('is_used', false)->count();

        return view('users.student.courses', [
            'student' => $student,
            'courses' => $courses,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'pendingFeedback' => $pendingFeedback,
        ]);
    }

    public function feedback(Request $request, ?Course $course = null): View
    {
        $student = auth()->user();

        // All unused tokens regardless of date (needed for sidebar counts)
        $allPendingTokens = $student->feedbackTokens()
            ->with(['evaluation', 'course', 'faculty'])
            ->where('is_used', false)
            ->get();

        // Only tokens whose evaluation has started (start_date <= today)
        $pendingTokens = $allPendingTokens->filter(function ($token) {
            $startDate = $token->evaluation?->start_date;

            return $startDate === null || $startDate->lte(now()->startOfDay());
        })->values();

        // Tokens whose evaluation hasn't started yet
        $notYetAvailableTokens = $allPendingTokens->filter(function ($token) {
            $startDate = $token->evaluation?->start_date;

            return $startDate !== null && $startDate->gt(now()->startOfDay());
        })->values();

        // Find the specific token to use (only from date-valid tokens)
        $activeToken = null;
        if ($request->has('token')) {
            $activeToken = $pendingTokens->firstWhere('token', $request->query('token'));
        } elseif ($course) {
            $activeToken = $pendingTokens->firstWhere('course_id', $course->id);
        } else {
            $activeToken = $pendingTokens->first();
        }

        $courseModel = $activeToken ? $activeToken->course : $course;
        $instructor = $activeToken ? $activeToken->faculty : ($courseModel ? $courseModel->faculty->first() : null);

        $hasSubmitted = false;
        if ($courseModel && ! $activeToken) {
            // Check if they used a token for this course
            $hasSubmitted = $student->feedbackTokens()->where('course_id', $courseModel->id)->where('is_used', true)->exists();
        }

        $avgRating = null;
        if ($instructor) {
            $avgRating = FeedbackAnswer::whereHas('feedback', function ($q) use ($instructor) {
                $q->where('faculty_id', $instructor->id);
            })->where('question_id', 'overall_rating')->avg('rating');
            $avgRating = round($avgRating, 1);
        }

        return view('users.student.feedback', [
            'course' => $courseModel,
            'instructor' => $instructor,
            'pendingTokens' => $pendingTokens,
            'notYetAvailableTokens' => $notYetAvailableTokens,
            'activeToken' => $activeToken,
            'hasSubmitted' => $hasSubmitted,
            'avgRating' => $avgRating,
        ]);
    }

    public function storeFeedback(StoreFeedbackRequest $request, FeedbackRepository $feedbackRepository): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $tokenModel = $feedbackRepository->findToken($validated['token']);

        if (! $tokenModel || $tokenModel->is_used) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or already used evaluation token.',
                ], 422);
            }

            return back()->withErrors(['token' => 'Invalid or already used evaluation token.']);
        }

        // Guard: reject submission if evaluation hasn't started yet
        $evaluation = $tokenModel->evaluation;
        if ($evaluation && $evaluation->start_date && $evaluation->start_date->gt(now()->startOfDay())) {
            $opensOn = $evaluation->start_date->format('F j, Y');
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "This evaluation is not open yet. It opens on {$opensOn}.",
                ], 403);
            }

            return back()->withErrors(['token' => "This evaluation is not open yet. It opens on {$opensOn}."]);
        }

        // Moderate written comments before persisting
        $moderationService = app(GeminiModerationService::class);
        $textFields = ['comments', 'what_worked_well', 'what_could_improve'];
        $moderatedAnswers = [];
        $isRejected = false;

        foreach ($textFields as $field) {
            if (! empty($validated[$field])) {
                $result = $moderationService->moderate($validated[$field]);
                if (($result['status'] ?? 'approved') === 'rejected') {
                    $isRejected = true;
                }
                $moderatedAnswers[$field] = $result;
            }
        }

        if ($isRejected) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your written feedback contains offensive or inappropriate language. Please revise your comments and submit again.',
                ], 422);
            }

            return back()->withInput()->withErrors([
                'comments' => 'Your written feedback contains offensive or inappropriate language. Please revise your comments and submit again.',
            ]);
        }

        // Save anonymous feedback inside a transaction with row locking
        $feedback = DB::transaction(function () use ($tokenModel, $validated, $textFields, $moderatedAnswers, $feedbackRepository) {
            $freshToken = FeedbackToken::where('id', $tokenModel->id)
                ->lockForUpdate()
                ->first();

            if (! $freshToken || $freshToken->is_used) {
                return null;
            }

            $feedbackData = [
                'evaluation_id' => $freshToken->evaluation_id,
                'faculty_id' => $freshToken->faculty_id,
                'course_id' => $freshToken->course_id,
            ];

            $answersData = [
                'clarity' => ['rating' => $validated['clarity']],
                'materials' => ['rating' => $validated['materials']],
                'responsiveness' => ['rating' => $validated['responsiveness']],
                'fairness' => ['rating' => $validated['fairness']],
                'practical' => ['rating' => $validated['practical']],
                'organization' => ['rating' => $validated['organization']],
                'overall_rating' => ['rating' => $validated['overall_rating']],
                'recommendation' => ['text_answer' => $validated['recommendation'] ?? null],
            ];

            foreach ($textFields as $field) {
                if (! empty($validated[$field])) {
                    $mod = $moderatedAnswers[$field];
                    $answersData[$field] = [
                        'text_answer' => $mod['cleaned_comment'] ?? $validated[$field],
                        'moderation_status' => $mod['status'] ?? 'approved',
                        'toxicity_score' => $mod['toxicity_score'] ?? 0,
                        'moderation_reason' => $mod['reason'] ?? null,
                        'moderation_categories' => $mod['categories'] ?? [],
                        'original_comment' => $validated[$field],
                        'cleaned_comment' => $mod['cleaned_comment'] ?? $validated[$field],
                        'moderated_at' => now(),
                    ];
                } else {
                    $answersData[$field] = [
                        'text_answer' => null,
                    ];
                }
            }

            $feedbackRepository->markTokenAsUsed($freshToken);

            return $feedbackRepository->saveFeedback($feedbackData, $answersData);
        });

        if ($feedback === null) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or already used evaluation token.',
                ], 422);
            }

            return back()->withErrors(['token' => 'Invalid or already used evaluation token.']);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your feedback has been submitted successfully and completely anonymously.',
                'redirect' => route('student.feedback.history'),
            ]);
        }

        return redirect()->route('student.feedback.history')->with('success', 'Thank you! Your feedback has been submitted successfully and anonymously.');
    }

    public function getCourseDetails(Course $course): JsonResponse
    {
        $student = auth()->user();

        // Check if student has an active token for this course
        $activeToken = $student->feedbackTokens()->with(['faculty'])->where('course_id', $course->id)->where('is_used', false)->first();

        if (! $activeToken) {
            return response()->json(['error' => 'No pending evaluation for this course'], 403);
        }

        $instructor = $activeToken->faculty;

        $avgRating = null;
        if ($instructor) {
            $avgRating = FeedbackAnswer::whereHas('feedback', function ($q) use ($instructor) {
                $q->where('faculty_id', $instructor->id);
            })->where('question_id', 'overall_rating')->avg('rating');
            $avgRating = round($avgRating, 1);
        }

        return response()->json([
            'course' => [
                'id' => $course->id,
                'code' => $course->code,
                'title' => $course->title,
                'department' => $course->department,
                'semester' => $course->semester,
            ],
            'instructor' => $instructor ? [
                'name' => $instructor->name,
                'designation' => $instructor->designation,
                'department' => $instructor->department,
            ] : null,
            'hasSubmitted' => false,
            'feedbackToken' => $activeToken->token,
            'avgRating' => $avgRating,
        ]);
    }

    public function feedbackHistory(): View
    {
        $student = auth()->user();
        $submissions = $student->feedbackTokens()->with(['evaluation', 'course', 'faculty'])->where('is_used', true)->latest('used_at')->paginate(25);
        $pendingTokens = $student->feedbackTokens()->with(['evaluation', 'course'])->where('is_used', false)->get();

        return view('users.student.feedback.history', [
            'submissions' => $submissions,
            'pendingFeedback' => $pendingTokens->count(),
            'pendingCourses' => $pendingTokens->pluck('course'),
        ]);
    }

    public function profile(): View
    {
        $student = auth()->user();

        $activeCourses = $student->courses()->count();
        $totalCredits = $student->courses()->sum('credit_hours') ?? 0;

        $allTokens = $student->feedbackTokens()->get();
        $submittedFeedbackCount = $allTokens->where('is_used', true)->count();
        $feedbackRate = $allTokens->count() > 0 ? round(($submittedFeedbackCount / $allTokens->count()) * 100) : 0;

        $submissions = $student->feedbackTokens()->with(['evaluation', 'course'])->where('is_used', true)->latest('used_at')->take(5)->get();

        return view('users.student.profile', [
            'student' => $student,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'feedbackRate' => $feedbackRate,
            'submissions' => $submissions,
        ]);
    }

    public function teachers(): View
    {
        $student = auth()->user();

        $courses = $student->courses()->with(['faculty' => fn ($q) => $q->where('role', 'faculty')])->get();

        $teachersMap = [];
        $departments = collect();

        foreach ($courses as $course) {
            foreach ($course->faculty as $teacher) {
                if (! isset($teachersMap[$teacher->id])) {
                    $teacher->teaching_courses = collect([$course]);
                    $teachersMap[$teacher->id] = $teacher;
                } else {
                    $teachersMap[$teacher->id]->teaching_courses->push($course);
                }
                if ($teacher->department) {
                    $departments->push($teacher->department);
                } elseif ($course->department) {
                    $departments->push($course->department);
                }
            }
        }

        $teachers = collect(array_values($teachersMap));
        $uniqueDepartmentsCount = $departments->unique()->count();
        $totalTeachersCount = $teachers->count();

        return view('users.student.teachers', [
            'teachers' => $teachers,
            'uniqueDepartmentsCount' => $uniqueDepartmentsCount,
            'totalTeachersCount' => $totalTeachersCount,
        ]);
    }
}
