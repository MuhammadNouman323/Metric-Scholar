<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        $student->loadCount('feedbacks');

        $enrolledCourses = $student->courses()->with('faculty')->get();
        $activeCourses = $enrolledCourses->count();

        $submittedFeedbackCount = $student->feedbacks_count;
        $pendingFeedback = max(0, $activeCourses - $submittedFeedbackCount);

        $feedbackRate = $activeCourses > 0 ? round(($submittedFeedbackCount / $activeCourses) * 100) : 0;

        // Find courses without feedback
        $submittedCourseIds = $student->feedbacks()->pluck('course_id')->toArray();
        $pendingEvaluations = $enrolledCourses->whereNotIn('id', $submittedCourseIds)->take(5);

        $recentSubmission = $student->feedbacks()->with('course')->latest()->first();

        return view('users.student.dashboard', [
            'student' => $student,
            'activeCourses' => $activeCourses,
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

        $student->loadCount('feedbacks');
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
        $enrolledCourses = $student->courses()->with('faculty')->get();
        $submittedCourseIds = $student->feedbacks()->pluck('course_id')->toArray();

        $pendingCourses = $enrolledCourses->whereNotIn('id', $submittedCourseIds);

        // If no course specified, pick the first pending one if available
        if (! $course && $pendingCourses->count() > 0) {
            $course = $pendingCourses->first();
        }

        $hasSubmitted = false;
        if ($course) {
            $hasSubmitted = in_array($course->id, $submittedCourseIds);
        }

        return view('users.student.feedback', [
            'course' => $course,
            'enrolledCourses' => $enrolledCourses,
            'pendingCourses' => $pendingCourses,
            'hasSubmitted' => $hasSubmitted,
        ]);
    }

    public function storeFeedback(Request $request)
    {
        $student = auth()->user();

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'clarity' => 'required|integer|min:1|max:5',
            'materials' => 'required|integer|min:1|max:5',
            'responsiveness' => 'required|integer|min:1|max:5',
            'fairness' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:2000',
        ]);

        // Ensure student is enrolled in this course
        if (! $student->courses()->where('courses.id', $validated['course_id'])->exists()) {
            return back()->withErrors(['course_id' => 'You are not enrolled in this course.']);
        }

        // Ensure student hasn't already submitted feedback for this course
        if ($student->feedbacks()->where('course_id', $validated['course_id'])->exists()) {
            return back()->withErrors(['course_id' => 'You have already submitted feedback for this course.']);
        }

        $student->feedbacks()->create($validated);

        return redirect()->route('student.feedback.history')->with('success', 'Thank you! Your feedback has been submitted successfully.');
    }

    public function feedbackHistory()
    {
        $student = auth()->user();
        $submissions = $student->feedbacks()->with('course')->latest()->get();

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
        $student->loadCount('feedbacks');

        $activeCourses = $student->courses()->count();
        $totalCredits = $student->courses()->sum('credit_hours') ?? 0;

        $submittedFeedbackCount = $student->feedbacks_count;
        $feedbackRate = $activeCourses > 0 ? round(($submittedFeedbackCount / $activeCourses) * 100) : 0;

        $submissions = $student->feedbacks()->with('course')->latest()->take(5)->get();

        return view('users.student.profile', [
            'student' => $student,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'feedbackRate' => $feedbackRate,
            'submissions' => $submissions,
        ]);
    }
}
