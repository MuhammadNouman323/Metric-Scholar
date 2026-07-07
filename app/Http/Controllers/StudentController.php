<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Repositories\FeedbackRepository;
use App\Services\GeminiModerationService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();

        $enrolledCourses = $student->courses()->with('faculty')->get();
        $activeCourses = $enrolledCourses->count();

        // Get tokens for the student
        $allTokens = $student->feedbackTokens()->with(['evaluation', 'course', 'faculty'])->get();

        $submittedFeedbackCount = $allTokens->where('is_used', true)->count();
        $pendingFeedback = $allTokens->where('is_used', false)->count();

        $totalEvaluations = $allTokens->count();
        $feedbackRate = $totalEvaluations > 0 ? round(($submittedFeedbackCount / $totalEvaluations) * 100) : 0;

        $pendingEvaluations = $allTokens->where('is_used', false)->take(5);

        $recentSubmission = $allTokens->where('is_used', true)->sortByDesc('used_at')->first();

        return view('users.student.dashboard', [
            'student' => $student,
            'activeCourses' => $activeCourses,
            'submittedFeedbackCount' => $submittedFeedbackCount,
            'pendingFeedback' => $pendingFeedback,
            'feedbackRate' => $feedbackRate,
            'pendingEvaluations' => $pendingEvaluations,
            'recentSubmission' => $recentSubmission,
        ]);
    }

    public function courses()
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

    public function feedback(Request $request, ?Course $course = null)
    {
        $student = auth()->user();
        $pendingTokens = $student->feedbackTokens()->with(['evaluation', 'course', 'faculty'])->where('is_used', false)->get();

        // Find the specific token to use
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
            'activeToken' => $activeToken,
            'hasSubmitted' => $hasSubmitted,
            'avgRating' => $avgRating,
        ]);
    }

    public function storeFeedback(Request $request, FeedbackRepository $feedbackRepository)
    {
        $validated = $request->validate([
            'token' => 'required|string|exists:feedback_tokens,token',
            'clarity' => 'required|integer|min:1|max:5',
            'materials' => 'required|integer|min:1|max:5',
            'responsiveness' => 'required|integer|min:1|max:5',
            'fairness' => 'required|integer|min:1|max:5',
            'practical' => 'required|integer|min:1|max:5',
            'organization' => 'required|integer|min:1|max:5',
            'overall_rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:2000',
            'what_worked_well' => 'nullable|string|max:2000',
            'what_could_improve' => 'nullable|string|max:2000',
            'recommendation' => 'nullable|in:yes_definitely,neutral,not_really',
        ]);

        $tokenModel = $feedbackRepository->findToken($validated['token']);

        if (! $tokenModel || $tokenModel->is_used) {
            return back()->withErrors(['token' => 'Invalid or already used evaluation token.']);
        }

        // Save anonymous feedback
        $feedbackData = [
            'evaluation_id' => $tokenModel->evaluation_id,
            'faculty_id' => $tokenModel->faculty_id,
            'course_id' => $tokenModel->course_id,
        ];

        $answersData = [
            'clarity' => ['rating' => $validated['clarity']],
            'materials' => ['rating' => $validated['materials']],
            'responsiveness' => ['rating' => $validated['responsiveness']],
            'fairness' => ['rating' => $validated['fairness']],
            'practical' => ['rating' => $validated['practical']],
            'organization' => ['rating' => $validated['organization']],
            'overall_rating' => ['rating' => $validated['overall_rating']],
            'comments' => ['text_answer' => $validated['comments'] ?? null],
            'what_worked_well' => ['text_answer' => $validated['what_worked_well'] ?? null],
            'what_could_improve' => ['text_answer' => $validated['what_could_improve'] ?? null],
            'recommendation' => ['text_answer' => $validated['recommendation'] ?? null],
        ];

        // Mark token as used BEFORE dispatching or saving to prevent race conditions
        $feedbackRepository->markTokenAsUsed($tokenModel);

        $feedbackRepository->saveFeedback($feedbackData, $answersData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your feedback has been submitted successfully and completely anonymously.',
                'redirect' => route('student.feedback.history'),
            ]);
        }

        return redirect()->route('student.feedback.history')->with('success', 'Thank you! Your feedback has been submitted successfully and anonymously.');
    }

    public function getCourseDetails(Course $course)
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

    public function feedbackHistory()
    {
        $student = auth()->user();
        $submissions = $student->feedbackTokens()->with(['evaluation', 'course', 'faculty'])->where('is_used', true)->latest('used_at')->get();
        $pendingTokens = $student->feedbackTokens()->with(['evaluation', 'course'])->where('is_used', false)->get();

        return view('users.student.feedback.history', [
            'submissions' => $submissions,
            'pendingFeedback' => $pendingTokens->count(),
            'pendingCourses' => $pendingTokens->pluck('course'),
        ]);
    }

    public function profile()
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

    public function teachers()
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

    public function store(
        Request $request,
        GeminiModerationService $gemini
    ) {
        $result = $gemini->moderate($request->worked_well);

        dd($result);
    }
}
class FeedbackController extends Controller
{
    public function store(
        Request $request,
        GeminiModerationService $gemini
    ) {
        $request->validate([
            'worked_well' => 'required|min:80',
            'improve' => 'required|min:80',
        ]);

        $worked = $gemini->moderate(
            $request->worked_well
        );

        $improve = $gemini->moderate(
            $request->improve
        );

        if (
            $worked['status'] == 'rejected' ||
            $improve['status'] == 'rejected'
        ) {
            return back()
                ->withErrors([
                    'comment' => 'Your feedback contains inappropriate language.',
                ]);
        }

        Feedback::create([

            'worked_well' => $worked['cleaned_comment'],

            'improve' => $improve['cleaned_comment'],

            'worked_status' => $worked['status'],

            'worked_score' => $worked['toxicity_score'],

            'worked_reason' => $worked['reason'],

            'improve_status' => $improve['status'],

            'improve_score' => $improve['toxicity_score'],

            'improve_reason' => $improve['reason'],

        ]);

        return redirect()
            ->route('student.dashboard')
            ->with('success', 'Feedback submitted successfully.');
    }
}
