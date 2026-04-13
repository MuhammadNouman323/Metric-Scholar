<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('users.admin.dashboard');
    }

    public function users()
    {
        return view('users.admin.users');
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

    public function reports()
    {
        return view('users.admin.reports');
    }
}
