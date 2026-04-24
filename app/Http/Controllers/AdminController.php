<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('users.admin.dashboard');
    }

    public function users()
    {
        $recentUsers = User::latest()->take(4)->get();

        return view('users.admin.admin-user', compact('recentUsers'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'department' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($validated['role'] === 'Admin') {
            $validated['admin_id'] = 'ADM-'.rand(1000, 9999);
            $validated['access_level'] = 'Full Access';
        }

        User::create($validated);

        return back()->with('success', 'User created successfully.');
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

    public function newCourse(): View
    {
        return view('users.admin.new-course');
    }
}
