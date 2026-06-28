<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        $student->loadCount(['feedbackAccess as feedbacks_count' => function ($query) {
            $query->where('submitted', true);
        }]);

        $enrolledCourses = $student->courses()->with('faculty')->get();
        $activeCourses = $enrolledCourses->count();

        $submittedFeedbackCount = $student->feedbacks_count;
        $pendingFeedback = max(0, $activeCourses - $submittedFeedbackCount);

        $feedbackRate = $activeCourses > 0 ? round(($submittedFeedbackCount / $activeCourses) * 100) : 0;

        // Find courses without feedback
        $submittedCourseIds = $student->feedbackAccess()->where('submitted', true)->pluck('course_id')->toArray();
        $pendingEvaluations = $enrolledCourses->whereNotIn('id', $submittedCourseIds)->take(5);

        $recentSubmission = $student->feedbackAccess()->with('course')->where('submitted', true)->latest('updated_at')->first();

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

        $student->loadCount(['feedbackAccess as feedbacks_count' => function ($query) {
            $query->where('submitted', true);
        }]);
        $submittedFeedbackCount = $student->feedbacks_count;
        $pendingFeedback = max(0, $activeCourses - $submittedFeedbackCount);

        return view('users.student.courses', [
            'student' => $student,
            'courses' => $courses,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'pendingFeedback' => $pendingFeedback,
        ]);
    }

    public function feedback(?Course $course = null)
    {
        $student = auth()->user();
        $enrolledCourses = $student->courses()->with(['faculty' => fn ($q) => $q->where('role', 'faculty')])->get();
        $submittedCourseIds = $student->feedbackAccess()->where('submitted', true)->pluck('course_id')->toArray();

        $pendingCourses = $enrolledCourses->whereNotIn('id', $submittedCourseIds);

        // If no course specified, pick the first pending one if available
        if (! $course && $pendingCourses->count() > 0) {
            $course = $pendingCourses->first();
            // Ensure faculty is loaded with role filter on the resolved course
            $course->load(['faculty' => fn ($q) => $q->where('role', 'faculty')]);
        } elseif ($course) {
            $course->load(['faculty' => fn ($q) => $q->where('role', 'faculty')]);
        }

        $hasSubmitted = false;
        if ($course) {
            $hasSubmitted = in_array($course->id, $submittedCourseIds);
        }

        $instructor = $course?->faculty->first();

        $feedbackToken = null;
        if ($course && ! $hasSubmitted) {
            $feedbackToken = Crypt::encryptString(json_encode([
                'user_id' => $student->id,
                'course_id' => $course->id,
                'faculty_id' => $instructor?->id,
            ]));
        }

        $avgRating = null;
        if ($instructor) {
            $avgRating = Feedback::where('faculty_id', $instructor->id)
                ->selectRaw('ROUND(AVG((clarity + materials + responsiveness + fairness) / 4.0), 1) as avg')
                ->value('avg');
        }

        return view('users.student.feedback', [
            'course' => $course,
            'instructor' => $instructor,
            'enrolledCourses' => $enrolledCourses,
            'pendingCourses' => $pendingCourses,
            'hasSubmitted' => $hasSubmitted,
            'feedbackToken' => $feedbackToken,
            'avgRating' => $avgRating,
        ]);
    }

    public function storeFeedback(Request $request)
    {
        $student = auth()->user();

        $validated = $request->validate([
            'token' => 'required|string',
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

        try {
            $payload = json_decode(Crypt::decryptString($validated['token']), true);
        } catch (\Exception $e) {
            return back()->withErrors(['token' => 'Invalid or expired evaluation session.']);
        }

        if ($payload['user_id'] !== $student->id) {
            return back()->withErrors(['token' => 'Unauthorized evaluation attempt.']);
        }

        $courseId = $payload['course_id'];

        $access = $student->feedbackAccess()->firstOrCreate(
            ['course_id' => $courseId],
            ['submitted' => false]
        );

        if ($access->submitted) {
            return back()->withErrors(['course_id' => 'You have already submitted feedback for this course.']);
        }

        // Mark as submitted
        $access->update(['submitted' => true]);

        // Insert anonymous feedback
        Feedback::create([
            'anonymous_token' => Str::uuid()->toString(),
            'course_id' => $courseId,
            'faculty_id' => $payload['faculty_id'] ?? null,
            'clarity' => $validated['clarity'],
            'materials' => $validated['materials'],
            'responsiveness' => $validated['responsiveness'],
            'fairness' => $validated['fairness'],
            'practical' => $validated['practical'],
            'organization' => $validated['organization'],
            'overall_rating' => $validated['overall_rating'],
            'comments' => $validated['comments'],
            'what_worked_well' => $validated['what_worked_well'],
            'what_could_improve' => $validated['what_could_improve'],
            'recommendation' => $validated['recommendation'],
        ]);

        return redirect()->route('student.feedback.history')->with('success', 'Thank you! Your feedback has been submitted successfully and anonymously.');
    }

    public function feedbackHistory()
    {
        $student = auth()->user();
        $submissions = $student->feedbackAccess()->with('course')->where('submitted', true)->latest('updated_at')->get();

        $enrolledCourses = $student->courses;
        $activeCourses = $enrolledCourses->count();
        $pendingFeedback = max(0, $activeCourses - $submissions->count());
        $pendingCourses = $enrolledCourses->whereNotIn('id', $submissions->pluck('course_id'));

        return view('users.student.feedback.history', [
            'submissions' => $submissions,
            'pendingFeedback' => $pendingFeedback,
            'pendingCourses' => $pendingCourses,
        ]);
    }

    public function profile()
    {
        $student = auth()->user();
        $student->loadCount(['feedbackAccess as feedbacks_count' => function ($query) {
            $query->where('submitted', true);
        }]);

        $activeCourses = $student->courses()->count();
        $totalCredits = $student->courses()->sum('credit_hours') ?? 0;

        $submittedFeedbackCount = $student->feedbacks_count;
        $feedbackRate = $activeCourses > 0 ? round(($submittedFeedbackCount / $activeCourses) * 100) : 0;

        $submissions = $student->feedbackAccess()->with('course')->where('submitted', true)->latest('updated_at')->take(5)->get();

        return view('users.student.profile', [
            'student' => $student,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'feedbackRate' => $feedbackRate,
            'submissions' => $submissions,
        ]);
    }
}
