<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('123456789');
        $currentTerm = currentTerm();
        $closedTerm = $this->previousTerm($currentTerm);

        // ─── 1. University ───────────────────────────────────────────────
        $university = University::create([
            'name' => 'Virtual University of Pakistan',
            'domain' => 'vu.edu.pk',
        ]);

        // ─── 2. Admin ────────────────────────────────────────────────────
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@vu.edu.pk',
            'password' => $password,
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
            'university_id' => $university->id,
        ]);

        // ─── 3. Faculty ─────────────────────────────────────────────────
        $facultyData = [
            ['name' => 'Dr. Ahmed Khan',   'email' => 'ahmed.khan@vu.edu.pk',  'department' => 'Computer Science'],
            ['name' => 'Prof. Sara Ali',    'email' => 'sara.ali@vu.edu.pk',    'department' => 'Computer Science'],
            ['name' => 'Dr. Usman Malik',   'email' => 'usman.malik@vu.edu.pk', 'department' => 'Applied Physics'],
            ['name' => 'Prof. Zara Tariq',  'email' => 'zara.tariq@vu.edu.pk',  'department' => 'Applied Physics'],
        ];

        $faculty = [];
        foreach ($facultyData as $f) {
            $faculty[] = User::create([
                'name' => $f['name'],
                'email' => $f['email'],
                'password' => $password,
                'role' => 'faculty',
                'department' => $f['department'],
                'email_verified_at' => now(),
                'is_active' => true,
                'university_id' => $university->id,
                'created_by' => $admin->id,
            ]);
        }

        [$ahmed, $sara, $usman, $zara] = $faculty;

        // ─── 4. Students ────────────────────────────────────────────────
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => fake()->name(),
                'email' => 'student'.str_pad($i, 2, '0', STR_PAD_LEFT).'@vu.edu.pk',
                'password' => $password,
                'role' => 'student',
                'department' => $i <= 10 ? 'Computer Science' : 'Applied Physics',
                'email_verified_at' => now(),
                'is_active' => true,
                'university_id' => $university->id,
                'created_by' => $admin->id,
            ]);
        }

        $csStudents = User::where('role', 'student')->where('department', 'Computer Science')->get();
        $apStudents = User::where('role', 'student')->where('department', 'Applied Physics')->get();

        // ─── 5. Courses ─────────────────────────────────────────────────
        $csCoursesData = [
            ['title' => 'Introduction to Programming', 'code' => 'CS101', 'credit_hours' => 3],
            ['title' => 'Data Structures',              'code' => 'CS201', 'credit_hours' => 3],
            ['title' => 'Database Systems',             'code' => 'CS202', 'credit_hours' => 3],
            ['title' => 'Software Engineering',         'code' => 'CS301', 'credit_hours' => 3],
            ['title' => 'Operating Systems',            'code' => 'CS302', 'credit_hours' => 3],
            ['title' => 'Computer Networks',            'code' => 'CS401', 'credit_hours' => 3],
            ['title' => 'Artificial Intelligence',      'code' => 'CS402', 'credit_hours' => 3],
            ['title' => 'Machine Learning',             'code' => 'CS403', 'credit_hours' => 4],
        ];

        $apCoursesData = [
            ['title' => 'Mechanics',          'code' => 'PHY101', 'credit_hours' => 3],
            ['title' => 'Electromagnetism',   'code' => 'PHY102', 'credit_hours' => 3],
            ['title' => 'Thermodynamics',     'code' => 'PHY201', 'credit_hours' => 3],
            ['title' => 'Quantum Physics',    'code' => 'PHY202', 'credit_hours' => 3],
            ['title' => 'Optics',             'code' => 'PHY301', 'credit_hours' => 3],
            ['title' => 'Nuclear Physics',    'code' => 'PHY302', 'credit_hours' => 3],
            ['title' => 'Solid State Physics', 'code' => 'PHY401', 'credit_hours' => 4],
            ['title' => 'Astrophysics',       'code' => 'PHY402', 'credit_hours' => 3],
        ];

        $csCourses = [];
        foreach ($csCoursesData as $c) {
            $csCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'department' => 'Computer Science',
            ]);
        }

        $apCourses = [];
        foreach ($apCoursesData as $c) {
            $apCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'department' => 'Applied Physics',
            ]);
        }

        // ─── 6. Assign courses to faculty ───────────────────────────────
        $facultyCourseMap = [
            [$ahmed, array_slice($csCourses, 0, 4)],
            [$sara,  array_slice($csCourses, 4, 4)],
            [$usman, array_slice($apCourses, 0, 4)],
            [$zara,  array_slice($apCourses, 4, 4)],
        ];

        foreach ($facultyCourseMap as [$f, $courses]) {
            $f->courses()->attach(
                collect($courses)->pluck('id')->all(),
                ['term' => $currentTerm]
            );
        }

        // ─── 7. Enroll students in courses ──────────────────────────────
        foreach ($csStudents as $student) {
            $student->courses()->attach(
                collect($csCourses)->random(rand(4, 6))->pluck('id')->all(),
                ['term' => $currentTerm]
            );
        }

        foreach ($apStudents as $student) {
            $student->courses()->attach(
                collect($apCourses)->random(rand(4, 6))->pluck('id')->all(),
                ['term' => $currentTerm]
            );
        }

        // ─── 8. Evaluations ─────────────────────────────────────────────
        $closedEval = Evaluation::create([
            'title' => 'Fall 2025 Evaluation',
            'semester' => 'Fall 2025',
            'evaluation_type' => 'final',
            'start_date' => now()->subMonths(4)->subDays(7),
            'end_date' => now()->subMonths(4)->addDays(7),
            'status' => 'closed',
            'is_anonymous' => true,
            'closed_at' => now()->subMonths(3),
            'created_by' => $admin->id,
        ]);

        $activeEval = Evaluation::create([
            'title' => "Mid-Term Evaluation - $currentTerm",
            'semester' => $currentTerm,
            'evaluation_type' => 'mid-term',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(10),
            'status' => 'active',
            'is_anonymous' => true,
            'activated_at' => now()->subDays(5),
            'created_by' => $admin->id,
        ]);

        $scheduledEval = Evaluation::create([
            'title' => "Final Evaluation - $currentTerm",
            'semester' => $currentTerm,
            'evaluation_type' => 'final',
            'start_date' => now()->addDays(30),
            'end_date' => now()->addDays(44),
            'status' => 'scheduled',
            'is_anonymous' => true,
            'created_by' => $admin->id,
        ]);

        // ─── 9. Link evaluations to faculty + courses ───────────────────
        $evalConfigs = [
            ['eval' => $closedEval,    'completion' => 0.75, 'avgCs' => 4.2, 'avgAp' => 3.5],
            ['eval' => $activeEval,    'completion' => 0.30, 'avgCs' => 4.2, 'avgAp' => 3.5],
            ['eval' => $scheduledEval, 'completion' => 0.00, 'avgCs' => 0,   'avgAp' => 0],
        ];

        foreach ($evalConfigs as $cfg) {
            $evaluation = $cfg['eval'];

            $evaluation->faculty()->attach(collect($faculty)->pluck('id')->all());

            foreach ($facultyCourseMap as [$f, $courses]) {
                foreach ($courses as $course) {
                    DB::table('evaluation_courses')->insert([
                        'evaluation_id' => $evaluation->id,
                        'course_id' => $course->id,
                        'faculty_id' => $f->id,
                    ]);
                }
            }
        }

        // ─── 10. Feedback tokens + feedbacks + answers ──────────────────
        $commentPool = [
            'Great teaching style, very engaging.',
            'The course material was well organized.',
            'Could use more practical examples.',
            'Excellent explanations of complex topics.',
            'Very helpful and responsive to questions.',
            'The pace was sometimes too fast.',
            'Good course overall, learned a lot.',
            'Would recommend to other students.',
            'Clear and concise lectures.',
            'Assignments were relevant and challenging.',
            'The instructor is very approachable.',
            'More office hours would be helpful.',
        ];

        foreach ($evalConfigs as $cfg) {
            $evaluation = $cfg['eval'];
            if ($cfg['completion'] <= 0) {
                continue;
            }

            $evalCourseFacultyPairs = DB::table('evaluation_courses')
                ->where('evaluation_id', $evaluation->id)
                ->get();

            foreach ($evalCourseFacultyPairs as $pair) {
                $dept = Course::find($pair->course_id)->department;
                $students = $dept === 'Computer Science' ? $csStudents : $apStudents;

                foreach ($students as $student) {
                    $token = FeedbackToken::create([
                        'evaluation_id' => $evaluation->id,
                        'student_id' => $student->id,
                        'faculty_id' => $pair->faculty_id,
                        'course_id' => $pair->course_id,
                        'token' => Str::uuid(),
                        'is_used' => false,
                    ]);

                    if (! fake()->boolean($cfg['completion'] * 100)) {
                        continue;
                    }

                    $token->update(['is_used' => true, 'used_at' => now()]);

                    $feedback = Feedback::create([
                        'evaluation_id' => $evaluation->id,
                        'faculty_id' => $pair->faculty_id,
                        'course_id' => $pair->course_id,
                    ]);

                    $baseRating = $dept === 'Computer Science' ? $cfg['avgCs'] : $cfg['avgAp'];

                    foreach (['overall_rating', 'clarity', 'materials', 'responsiveness', 'organization'] as $qid) {
                        $r = $qid === 'overall_rating'
                            ? max(1, min(5, (int) round($baseRating + fake()->randomFloat(1, -0.8, 0.8))))
                            : max(1, min(5, (int) round($baseRating + fake()->randomFloat(1, -1.2, 1.2))));

                        FeedbackAnswer::create([
                            'feedback_id' => $feedback->id,
                            'question_id' => $qid,
                            'rating' => $r,
                        ]);
                    }

                    if (fake()->boolean(60)) {
                        FeedbackAnswer::create([
                            'feedback_id' => $feedback->id,
                            'question_id' => 'comments',
                            'text_answer' => fake()->randomElement($commentPool),
                        ]);
                    }
                }
            }
        }
    }

    private function previousTerm(string $current): string
    {
        $parts = explode(' ', $current);
        $season = $parts[0];
        $year = (int) ($parts[1] ?? date('Y'));

        if ($season === 'Spring') {
            return 'Fall '.($year - 1);
        }

        return 'Spring '.$year;
    }
}
