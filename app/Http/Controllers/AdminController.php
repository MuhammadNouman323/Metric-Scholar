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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:student,faculty'],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['role'] = strtolower($validated['role']);
        $validated['password'] = Hash::make($validated['password']);
        $validated['admin_id'] = null;
        $validated['access_level'] = null;

        User::create($validated);

        return back()->with('success', ucfirst($validated['role']).' account created successfully.');
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

    public function departments()
    {
        return view('users.admin.departments');
    }

    public function department(string $department)
    {
        $section = request()->string('section')->toString() ?: 'overview';

        $departmentPages = [
            'computer-science' => [
                'slug' => 'computer-science',
                'name' => 'Computer Science',
                'departmentCode' => 'ENGINEERING',
                'established' => 'Est. 1968',
                'description' => 'Advancing the frontiers of computing through innovative research, rigorous academic programs, and interdisciplinary collaboration to solve complex global challenges.',
                'facultyCount' => 42,
                'overview' => 'The Computer Science department combines theory, systems, and applied computing across AI, software engineering, cybersecurity, and data science.',
                'pulse' => [
                    'avgGpa' => '3.72',
                    'feedbackRate' => '88%',
                    'pendingReviews' => '14',
                ],
                'enrollment' => [
                    ['label' => 'Undergraduate', 'value' => '1,245'],
                    ['label' => 'Graduate (MS)', 'value' => '320'],
                    ['label' => 'Doctoral (PhD)', 'value' => '85'],
                ],
                'students' => [
                    ['initials' => 'MU', 'name' => 'Muhammad Umer', 'email' => 'umer@vu.edu.pk', 'program' => 'Computer Science', 'status' => 'Evaluation Pending'],
                    ['initials' => 'MU', 'name' => 'Muhammad Uzair', 'email' => 'uzair@vu.edu.pk', 'program' => 'Computer Science', 'status' => 'Evaluation Pending'],
                    ['initials' => 'ZA', 'name' => 'Zaeem', 'email' => 'zaeem@vu.edu.pk', 'program' => 'Computer Science', 'status' => 'Reviewed'],
                ],
                'faculty' => [
                    ['initials' => 'GH', 'name' => 'Dr. Grace Hopper', 'role' => 'Professor, Systems Architecture', 'email' => 'g.hopper@cs.edu', 'office' => 'Turing Hall, Room 402', 'status' => 'Tenured'],
                    ['initials' => 'AT', 'name' => 'Dr. Alan Turing', 'role' => 'Assoc. Professor, Cryptography', 'email' => 'a.turing@cs.edu', 'office' => 'Lovelace Bldg, Room 210', 'status' => 'Under Review'],
                ],
                'activity' => [
                    ['title' => 'Curriculum updated', 'detail' => 'CS401 added to Spring roster.', 'time' => '2h ago'],
                    ['title' => 'Review completed', 'detail' => 'Faculty evaluations finalized.', 'time' => '1d ago'],
                ],
            ],
            'bio-chemistry' => [
                'slug' => 'bio-chemistry',
                'name' => 'Bio-Chemistry',
                'departmentCode' => 'SCIENCES',
                'established' => 'Est. 1974',
                'description' => 'Leading investigative studies in metabolic pathways, structural biology, and molecular genetics with a strong clinical research focus.',
                'facultyCount' => 35,
                'overview' => 'The Bio-Chemistry department supports research in enzymes, molecular medicine, biotechnology, and advanced laboratory diagnostics.',
                'pulse' => [
                    'avgGpa' => '3.61',
                    'feedbackRate' => '84%',
                    'pendingReviews' => '9',
                ],
                'enrollment' => [
                    ['label' => 'Undergraduate', 'value' => '1,018'],
                    ['label' => 'Graduate (MS)', 'value' => '214'],
                    ['label' => 'Doctoral (PhD)', 'value' => '61'],
                ],
                'students' => [
                    ['initials' => 'SA', 'name' => 'Sarah Ahmad', 'email' => 'sarah@vu.edu.pk', 'program' => 'Bio-Chemistry', 'status' => 'Reviewed'],
                    ['initials' => 'AY', 'name' => 'Ayan Yusuf', 'email' => 'ayan@vu.edu.pk', 'program' => 'Bio-Chemistry', 'status' => 'Evaluation Pending'],
                    ['initials' => 'NR', 'name' => 'Noor Rahman', 'email' => 'noor@vu.edu.pk', 'program' => 'Bio-Chemistry', 'status' => 'Reviewed'],
                ],
                'faculty' => [
                    ['initials' => 'MC', 'name' => 'Dr. Marie Curie', 'role' => 'Professor, Biophysics', 'email' => 'm.curie@bc.edu', 'office' => 'Helix Tower, Room 308', 'status' => 'Tenured'],
                    ['initials' => 'RZ', 'name' => 'Dr. Rosalind Z.', 'role' => 'Assoc. Professor, Genomics', 'email' => 'r.z@bc.edu', 'office' => 'Genome Lab, Room 114', 'status' => 'Under Review'],
                ],
                'activity' => [
                    ['title' => 'Lab audit passed', 'detail' => 'All molecular suites cleared.', 'time' => '5h ago'],
                    ['title' => 'Grant submitted', 'detail' => 'Genetics research funding packet sent.', 'time' => '2d ago'],
                ],
            ],
            'applied-physics' => [
                'slug' => 'applied-physics',
                'name' => 'Applied Physics',
                'departmentCode' => 'SCIENCES',
                'established' => 'Est. 1959',
                'description' => 'Exploring quantum materials, condensed matter physics, photonics, and computational modeling for emerging technologies.',
                'facultyCount' => 28,
                'overview' => 'Applied Physics emphasizes experimental design, instrumentation, and mathematical modeling across modern materials science.',
                'pulse' => [
                    'avgGpa' => '3.54',
                    'feedbackRate' => '81%',
                    'pendingReviews' => '11',
                ],
                'enrollment' => [
                    ['label' => 'Undergraduate', 'value' => '864'],
                    ['label' => 'Graduate (MS)', 'value' => '176'],
                    ['label' => 'Doctoral (PhD)', 'value' => '42'],
                ],
                'students' => [
                    ['initials' => 'AI', 'name' => 'Areeb Iqbal', 'email' => 'areeb@vu.edu.pk', 'program' => 'Applied Physics', 'status' => 'Reviewed'],
                    ['initials' => 'FK', 'name' => 'Fatima Khan', 'email' => 'fatima@vu.edu.pk', 'program' => 'Applied Physics', 'status' => 'Evaluation Pending'],
                    ['initials' => 'HM', 'name' => 'Hassan Malik', 'email' => 'hassan@vu.edu.pk', 'program' => 'Applied Physics', 'status' => 'Reviewed'],
                ],
                'faculty' => [
                    ['initials' => 'MJ', 'name' => 'Dr. Maxwell J.', 'role' => 'Professor, Photonics', 'email' => 'm.j@ap.edu', 'office' => 'Photon Hall, Room 120', 'status' => 'Reviewed'],
                    ['initials' => 'NK', 'name' => 'Dr. N. K.', 'role' => 'Assoc. Professor, Quantum Systems', 'email' => 'n.k@ap.edu', 'office' => 'Quantum Wing, Room 215', 'status' => 'Under Review'],
                ],
                'activity' => [
                    ['title' => 'Instrument check', 'detail' => 'Spectroscopy lab calibration completed.', 'time' => '3h ago'],
                    ['title' => 'New seminar', 'detail' => 'Quantum devices workshop announced.', 'time' => '1d ago'],
                ],
            ],
        ];

        abort_unless(array_key_exists($department, $departmentPages), 404);

        return view('users.admin.department-detail', [
            'department' => $departmentPages[$department],
            'section' => in_array($section, ['overview', 'faculty', 'enrollment'], true) ? $section : 'overview',
        ]);
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
