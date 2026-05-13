<?php

namespace App\Http\Controllers;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();

        return view('users.student.dashboard', [
            'student' => $student,
            'activeCourses' => $student->courses()->count(),
        ]);
    }

    public function courses()
    {
        $student = auth()->user();
        $courses = $student->courses()->with('faculty')->paginate(10);
        $activeCourses = $student->courses()->count();
        $totalCredits = $student->courses()->sum('credits') ?? 0;

        return view('users.student.courses', [
            'student' => $student,
            'courses' => $courses,
            'activeCourses' => $activeCourses,
            'totalCredits' => $totalCredits,
            'currentGPA' => 3.82,
            'pendingFeedback' => 2,
        ]);
    }

    public function feedback()
    {
        return view('users.student.feedback');
    }

    public function feedbackHistory()
    {
        return view('users.student.feedback.history');
    }

    public function profile()
    {
        $student = auth()->user();

        return view('users.student.profile', [
            'student' => $student,
        ]);
    }
}
