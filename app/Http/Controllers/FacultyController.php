<?php

namespace App\Http\Controllers;

class FacultyController extends Controller
{
    public function dashboard()
    {
        return view('users.faculty.dashboard');
    }

    public function feedback()
    {
        return view('users.faculty.feedback');
    }

    public function analytics()
    {
        return view('users.faculty.analytics');
    }

    public function profile()
    {
        return view('users.faculty.profile');
    }
}
