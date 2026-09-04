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
        $university = University::query()->firstOrCreate(
            ['domain' => 'vu.edu.pk'],
            ['name' => 'Virtual University of Pakistan']
        );

        // ─── 2. Admin ────────────────────────────────────────────────────
        $admin = User::create([
            'name' => 'Muhammad Nouman',
            'email' => 'bc220410458mno@vu.edu.pk',
            'password' => $password,
            'role' => 'admin',
            'admin_id' => 'ADM-DEMO01',
            'access_level' => 'Full Access',
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
            ['name' => 'Dr. Imran Qureshi', 'email' => 'imran.qureshi@vu.edu.pk', 'department' => 'Mathematics'],
            ['name' => 'Prof. Nadia Jamil', 'email' => 'nadia.jamil@vu.edu.pk',   'department' => 'Mathematics'],
            ['name' => 'Dr. Farhan Raza',   'email' => 'farhan.raza@vu.edu.pk',   'department' => 'Bio-Chemistry'],
            ['name' => 'Prof. Sana Munir',  'email' => 'sana.munir@vu.edu.pk',    'department' => 'Bio-Chemistry'],
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

        [$ahmed, $sara, $usman, $zara, $imran, $nadia, $farhan, $sana] = $faculty;

        // ─── 4. Students ────────────────────────────────────────────────
        $studentNames = [
            'Ali Raza', 'Hamza Tariq', 'Bilal Ahmed', 'Usman Ghani', 'Hassan Javed',
            'Umar Farooq', 'Abdullah Nasir', 'Salman Haider', 'Fahad Mehmood', 'Zeeshan Ali',
            'Ayesha Khan', 'Fatima Zahra', 'Zainab Riaz', 'Hira Shahid', 'Mahnoor Asif',
            'Amna Bibi', 'Rabia Anwar', 'Maryam Tariq', 'Iqra Naz', 'Laiba Yousaf',
        ];

        foreach ($studentNames as $index => $name) {
            $dept = match (true) {
                $index < 5              => 'Computer Science',
                $index < 10             => 'Applied Physics',
                $index < 15             => 'Mathematics',
                default                 => 'Bio-Chemistry',
            };

            User::create([
                'name' => $name,
                'email' => str_replace(' ', '.', strtolower($name)).'@vu.edu.pk',
                'password' => $password,
                'role' => 'student',
                'department' => $dept,
                'email_verified_at' => now(),
                'is_active' => true,
                'university_id' => $university->id,
                'created_by' => $admin->id,
            ]);
        }

        $csStudents = User::where('role', 'student')->where('department', 'Computer Science')->get();
        $apStudents = User::where('role', 'student')->where('department', 'Applied Physics')->get();
        $mathStudents = User::where('role', 'student')->where('department', 'Mathematics')->get();
        $bcStudents = User::where('role', 'student')->where('department', 'Bio-Chemistry')->get();

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

        $mathCoursesData = [
            ['title' => 'Calculus I',            'code' => 'MATH101', 'credit_hours' => 3],
            ['title' => 'Calculus II',           'code' => 'MATH102', 'credit_hours' => 3],
            ['title' => 'Linear Algebra',        'code' => 'MATH201', 'credit_hours' => 3],
            ['title' => 'Differential Equations', 'code' => 'MATH202', 'credit_hours' => 3],
            ['title' => 'Discrete Mathematics',  'code' => 'MATH301', 'credit_hours' => 3],
            ['title' => 'Probability Theory',    'code' => 'MATH302', 'credit_hours' => 3],
            ['title' => 'Numerical Analysis',    'code' => 'MATH401', 'credit_hours' => 4],
            ['title' => 'Abstract Algebra',      'code' => 'MATH402', 'credit_hours' => 3],
        ];

        $bcCoursesData = [
            ['title' => 'General Chemistry',     'code' => 'BCH101', 'credit_hours' => 3],
            ['title' => 'Organic Chemistry',     'code' => 'BCH102', 'credit_hours' => 3],
            ['title' => 'Biochemistry',          'code' => 'BCH201', 'credit_hours' => 3],
            ['title' => 'Cell Biology',          'code' => 'BCH202', 'credit_hours' => 3],
            ['title' => 'Microbiology',          'code' => 'BCH301', 'credit_hours' => 3],
            ['title' => 'Genetics',              'code' => 'BCH302', 'credit_hours' => 3],
            ['title' => 'Molecular Biology',     'code' => 'BCH401', 'credit_hours' => 4],
            ['title' => 'Analytical Chemistry',  'code' => 'BCH402', 'credit_hours' => 3],
        ];

        $csCourses = [];
        foreach ($csCoursesData as $c) {
            $csCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'semester' => $currentTerm,
                'department' => 'Computer Science',
                'university_id' => $university->id,
            ]);
        }

        $apCourses = [];
        foreach ($apCoursesData as $c) {
            $apCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'semester' => $currentTerm,
                'department' => 'Applied Physics',
                'university_id' => $university->id,
            ]);
        }

        $mathCourses = [];
        foreach ($mathCoursesData as $c) {
            $mathCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'semester' => $currentTerm,
                'department' => 'Mathematics',
                'university_id' => $university->id,
            ]);
        }

        $bcCourses = [];
        foreach ($bcCoursesData as $c) {
            $bcCourses[] = Course::create([
                'title' => $c['title'],
                'code' => $c['code'],
                'credit_hours' => $c['credit_hours'],
                'semester' => $currentTerm,
                'department' => 'Bio-Chemistry',
                'university_id' => $university->id,
            ]);
        }

        // ─── 6. Assign courses to faculty ───────────────────────────────
        $facultyCourseMap = [
            [$ahmed, array_slice($csCourses, 0, 4)],
            [$sara,  array_slice($csCourses, 4, 4)],
            [$usman, array_slice($apCourses, 0, 4)],
            [$zara,  array_slice($apCourses, 4, 4)],
            [$imran, array_slice($mathCourses, 0, 4)],
            [$nadia, array_slice($mathCourses, 4, 4)],
            [$farhan, array_slice($bcCourses, 0, 4)],
            [$sana,  array_slice($bcCourses, 4, 4)],
        ];

        foreach ($facultyCourseMap as [$f, $courses]) {
            // Current term
            $f->courses()->attach(
                collect($courses)->pluck('id')->all(),
                ['term' => $currentTerm]
            );

            // Previous term (for trend/comparison data)
            $f->courses()->attach(
                collect($courses)->pluck('id')->all(),
                ['term' => $closedTerm]
            );
        }

        // ─── 7. Enroll students in courses ──────────────────────────────
        foreach ($csStudents as $student) {
            $courseIds = collect($csCourses)->random(rand(4, 6))->pluck('id')->all();
            $student->courses()->attach($courseIds, ['term' => $currentTerm]);
            $student->courses()->attach($courseIds, ['term' => $closedTerm]);
        }

        foreach ($apStudents as $student) {
            $courseIds = collect($apCourses)->random(rand(4, 6))->pluck('id')->all();
            $student->courses()->attach($courseIds, ['term' => $currentTerm]);
            $student->courses()->attach($courseIds, ['term' => $closedTerm]);
        }

        foreach ($mathStudents as $student) {
            $courseIds = collect($mathCourses)->random(rand(4, 6))->pluck('id')->all();
            $student->courses()->attach($courseIds, ['term' => $currentTerm]);
            $student->courses()->attach($courseIds, ['term' => $closedTerm]);
        }

        foreach ($bcStudents as $student) {
            $courseIds = collect($bcCourses)->random(rand(4, 6))->pluck('id')->all();
            $student->courses()->attach($courseIds, ['term' => $currentTerm]);
            $student->courses()->attach($courseIds, ['term' => $closedTerm]);
        }

        // ─── 8. Evaluations ─────────────────────────────────────────────
        // Previous semester (closed) - drives the "previous semester" trend line
        $prevEval = Evaluation::create([
            'title' => "Final Evaluation - $closedTerm",
            'semester' => $closedTerm,
            'evaluation_type' => 'final',
            'start_date' => $this->termStartDate($closedTerm),
            'end_date' => $this->termEndDate($closedTerm),
            'status' => 'closed',
            'is_anonymous' => true,
            'closed_at' => $this->termEndDate($closedTerm)->addDays(3),
            'created_by' => $admin->id,
        ]);

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
        // Each config includes a date range so feedback is spread across the semester.
        $evalConfigs = [
            ['eval' => $prevEval,     'completion' => 0.85, 'avgCs' => 4.0, 'avgAp' => 3.4, 'avgMath' => 3.7, 'avgBc' => 3.6, 'from' => $this->termStartDate($closedTerm), 'to' => $this->termEndDate($closedTerm)],
            ['eval' => $closedEval,   'completion' => 0.75, 'avgCs' => 4.2, 'avgAp' => 3.5, 'avgMath' => 3.8, 'avgBc' => 3.7, 'from' => now()->subMonths(4)->subDays(14), 'to' => now()->subMonths(4)->addDays(14)],
            ['eval' => $activeEval,   'completion' => 0.30, 'avgCs' => 4.2, 'avgAp' => 3.5, 'avgMath' => 3.8, 'avgBc' => 3.7, 'from' => now()->startOfMonth(), 'to' => now()],
            ['eval' => $scheduledEval, 'completion' => 0.00, 'avgCs' => 0,   'avgAp' => 0,   'avgMath' => 0,   'avgBc' => 0,   'from' => now(), 'to' => now()],
        ];

        $deptStudents = [
            'Computer Science' => $csStudents,
            'Applied Physics'  => $apStudents,
            'Mathematics'      => $mathStudents,
            'Bio-Chemistry'    => $bcStudents,
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
            'The exam questions were fair and covered the syllabus.',
            'I would love more real-world applications.',
            'Great use of technology in the classroom.',
        ];

        $moderationPool = [
            ['status' => 'approved', 'toxicity' => 0.02, 'reason' => null, 'categories' => []],
            ['status' => 'approved', 'toxicity' => 0.05, 'reason' => null, 'categories' => []],
            ['status' => 'flagged',  'toxicity' => 0.55, 'reason' => 'Possible mild frustration detected.', 'categories' => ['negative']],
            ['status' => 'approved', 'toxicity' => 0.10, 'reason' => null, 'categories' => []],
            ['status' => 'approved', 'toxicity' => 0.01, 'reason' => null, 'categories' => []],
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
                $students = $deptStudents[$dept];

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

                    // Spread feedback across the evaluation window so charts have data per month
                    $usedAt = fake()->dateTimeBetween($cfg['from'], $cfg['to']);

                    $token->update(['is_used' => true, 'used_at' => $usedAt]);

                    $feedback = Feedback::create([
                        'evaluation_id' => $evaluation->id,
                        'faculty_id' => $pair->faculty_id,
                        'course_id' => $pair->course_id,
                        'submitted_at' => $usedAt,
                    ]);

                    $avgKey = match ($dept) {
                        'Computer Science' => 'avgCs',
                        'Applied Physics'  => 'avgAp',
                        'Mathematics'      => 'avgMath',
                        'Bio-Chemistry'    => 'avgBc',
                    };
                    $baseRating = $cfg[$avgKey];

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
                        $mod = fake()->randomElement($moderationPool);
                        FeedbackAnswer::create([
                            'feedback_id' => $feedback->id,
                            'question_id' => 'comments',
                            'text_answer' => fake()->randomElement($commentPool),
                            'moderation_status' => $mod['status'],
                            'toxicity_score' => $mod['toxicity'],
                            'moderation_reason' => $mod['reason'],
                            'moderation_categories' => $mod['categories'],
                            'moderated_at' => now(),
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

    private function termStartDate(string $term): \Illuminate\Support\Carbon
    {
        $parts = explode(' ', $term);
        $season = $parts[0];
        $year = (int) ($parts[1] ?? date('Y'));

        return match ($season) {
            'Spring' => \Illuminate\Support\Carbon::create($year, 1, 1),
            'Summer' => \Illuminate\Support\Carbon::create($year, 5, 1),
            default  => \Illuminate\Support\Carbon::create($year, 8, 1),
        };
    }

    private function termEndDate(string $term): \Illuminate\Support\Carbon
    {
        $parts = explode(' ', $term);
        $season = $parts[0];
        $year = (int) ($parts[1] ?? date('Y'));

        return match ($season) {
            'Spring' => \Illuminate\Support\Carbon::create($year, 6, 30),
            'Summer' => \Illuminate\Support\Carbon::create($year, 7, 31),
            default  => \Illuminate\Support\Carbon::create($year, 12, 31),
        };
    }
}
