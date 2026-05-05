<?php

namespace App\Http\Controllers;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('users.student.dashboard');
    }

    public function courses()
    {
        return view('users.student.courses');
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
        return view('users.student.profile');
    }
}
