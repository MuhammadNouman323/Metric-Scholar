<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        $plainPassword = '123456789';
        $password = Hash::make($plainPassword);

        // Matches the admin dashboard engagement chart window (Spring 2025 -> Fall 2026)
        // after the chart was narrowed in AdminController.
        $demoSemesters = [
            'Spring 2025', 'Fall 2025',
            'Spring 2026', 'Fall 2026',
        ];
        $currentTerm = end($demoSemesters);

        // ─── Guard: never double-seed silently ───────────────────────────
        if (User::where('email', 'nouman@pu.edu.pk')->exists()) {
            $this->command->warn('Demo data already exists. Run `php artisan migrate:fresh --seed` to reset the demo before repeating.');

            return;
        }

        DB::transaction(function () use ($password, $plainPassword, $demoSemesters, $currentTerm) {
            // ─── 1. University ───────────────────────────────────────────
            $university = University::query()->firstOrCreate(
                ['domain' => 'pu.edu.pk'],
                ['name' => 'Punjab University']
            );

            // ─── 2. Admin ────────────────────────────────────────────────
            $admin = User::create([
                'name' => 'Muhammad Nouman',
                'email' => 'nouman@pu.edu.pk',
                'password' => $password,
                'role' => Role::Admin,
                'admin_id' => 'ADM-DEMO01',
                'access_level' => 'Full Access',
                'email_verified_at' => now(),
                'is_active' => true,
                'university_id' => $university->id,
            ]);

            // ─── 3. Faculty ─────────────────────────────────────────────
            $facultyData = [
                ['name' => 'Dr. Ahmed Khan',   'email' => 'ahmed.khan@pu.edu.pk',  'department' => 'Computer Science'],
                ['name' => 'Prof. Sara Ali',    'email' => 'sara.ali@pu.edu.pk',    'department' => 'Computer Science'],
                ['name' => 'Dr. Usman Malik',   'email' => 'usman.malik@pu.edu.pk', 'department' => 'Applied Physics'],
                ['name' => 'Prof. Zara Tariq',  'email' => 'zara.tariq@pu.edu.pk',  'department' => 'Applied Physics'],
                ['name' => 'Dr. Imran Qureshi', 'email' => 'imran.qureshi@pu.edu.pk', 'department' => 'Mathematics'],
                ['name' => 'Prof. Nadia Jamil', 'email' => 'nadia.jamil@pu.edu.pk',   'department' => 'Mathematics'],
                ['name' => 'Dr. Farhan Raza',   'email' => 'farhan.raza@pu.edu.pk',   'department' => 'Bio-Chemistry'],
                ['name' => 'Prof. Sana Munir',  'email' => 'sana.munir@pu.edu.pk',    'department' => 'Bio-Chemistry'],
            ];

            $faculty = [];
            foreach ($facultyData as $f) {
                $faculty[] = User::create([
                    'name' => $f['name'],
                    'email' => $f['email'],
                    'password' => $password,
                    'role' => Role::Faculty,
                    'department' => $f['department'],
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'university_id' => $university->id,
                    'created_by' => $admin->id,
                ]);
            }

            [$ahmed, $sara, $usman, $zara, $imran, $nadia, $farhan, $sana] = $faculty;

            // ─── 4. Students (8 per department = 32) ─────────────────────
            $studentNames = [
                // Computer Science
                'Ali Raza', 'Hamza Tariq', 'Bilal Ahmed', 'Usman Ghani',
                'Hassan Javed', 'Umar Farooq', 'Abdullah Nasir', 'Salman Haider',
                // Applied Physics
                'Fahad Mehmood', 'Zeeshan Ali', 'Ayesha Khan', 'Fatima Zahra',
                'Zainab Riaz', 'Hira Shahid', 'Mahnoor Asif', 'Amna Bibi',
                // Mathematics
                'Rabia Anwar', 'Maryam Tariq', 'Iqra Naz', 'Laiba Yousaf',
                'Areeba Noor', 'Mubeen Akhtar', 'Sana Javed', 'Dania Saleem',
                // Bio-Chemistry
                'Taimoor Shah', 'Saad Anwar', 'Kashif Raza', 'Noman Ali',
                'Farhan Aslam', 'Adnan Baig', 'Waqas Ahmed', 'Zubair Khan',
            ];

            foreach ($studentNames as $index => $name) {
                $dept = match (true) {
                    $index < 8              => 'Computer Science',
                    $index < 16             => 'Applied Physics',
                    $index < 24             => 'Mathematics',
                    default                 => 'Bio-Chemistry',
                };

                User::create([
                    'name' => $name,
                    'email' => str_replace(' ', '.', strtolower($name)).'@pu.edu.pk',
                    'password' => $password,
                    'role' => Role::Student,
                    'department' => $dept,
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'university_id' => $university->id,
                    'created_by' => $admin->id,
                ]);
            }

            $deptStudents = [
                'Computer Science' => User::where('role', Role::Student)->where('department', 'Computer Science')->get(),
                'Applied Physics'  => User::where('role', Role::Student)->where('department', 'Applied Physics')->get(),
                'Mathematics'      => User::where('role', Role::Student)->where('department', 'Mathematics')->get(),
                'Bio-Chemistry'    => User::where('role', Role::Student)->where('department', 'Bio-Chemistry')->get(),
            ];

            // ─── 5. Courses ─────────────────────────────────────────────
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

            $courseData = [
                'Computer Science' => $csCoursesData,
                'Applied Physics'  => $apCoursesData,
                'Mathematics'      => $mathCoursesData,
                'Bio-Chemistry'    => $bcCoursesData,
            ];

            $coursesByDept = [];
            foreach ($courseData as $dept => $rows) {
                foreach ($rows as $c) {
                    $coursesByDept[$dept][] = Course::create([
                        'title' => $c['title'],
                        'code' => $c['code'],
                        'credit_hours' => $c['credit_hours'],
                        'semester' => $currentTerm,
                        'department' => $dept,
                        'university_id' => $university->id,
                    ]);
                }
            }

            // ─── 6. Assign courses to faculty ───────────────────────────
            $facultyCourseMap = [
                [$ahmed,  array_slice($coursesByDept['Computer Science'], 0, 4)],
                [$sara,   array_slice($coursesByDept['Computer Science'], 4, 4)],
                [$usman,  array_slice($coursesByDept['Applied Physics'], 0, 4)],
                [$zara,   array_slice($coursesByDept['Applied Physics'], 4, 4)],
                [$imran,  array_slice($coursesByDept['Mathematics'], 0, 4)],
                [$nadia,  array_slice($coursesByDept['Mathematics'], 4, 4)],
                [$farhan, array_slice($coursesByDept['Bio-Chemistry'], 0, 4)],
                [$sana,   array_slice($coursesByDept['Bio-Chemistry'], 4, 4)],
            ];

            foreach ($facultyCourseMap as [$f, $courses]) {
                $courseIds = collect($courses)->pluck('id')->all();

                // Same courses assigned across every demo semester (2025 -> 2026)
                foreach ($demoSemesters as $term) {
                    $f->courses()->attach($courseIds, ['term' => $term]);
                }
            }

            // ─── 7. Enroll students in courses ──────────────────────────
            foreach ($deptStudents as $dept => $students) {
                foreach ($students as $student) {
                    $courseIds = collect($coursesByDept[$dept])->random(4)->pluck('id')->all();

                    foreach ($demoSemesters as $term) {
                        $student->courses()->attach($courseIds, ['term' => $term]);
                    }
                }
            }

            // ─── 8. Evaluations ─────────────────────────────────────────
            // One final evaluation per semester + an active mid-term for the current
            // term. Config drives the "improvement over time" story the chart shows.
            $semesterConfig = [
                'Spring 2025' => ['band' => 'medium', 'completion' => 0.72, 'avgCs' => 3.4, 'avgAp' => 3.0, 'avgMath' => 3.2, 'avgBc' => 3.1],
                'Fall 2025'   => ['band' => 'medium', 'completion' => 0.78, 'avgCs' => 3.9, 'avgAp' => 3.4, 'avgMath' => 3.7, 'avgBc' => 3.5],
                'Spring 2026' => ['band' => 'high',   'completion' => 0.82, 'avgCs' => 4.2, 'avgAp' => 3.9, 'avgMath' => 4.1, 'avgBc' => 4.0],
                'Fall 2026'   => ['band' => 'high',   'completion' => 0.55, 'avgCs' => 4.6, 'avgAp' => 4.2, 'avgMath' => 4.4, 'avgBc' => 4.3],
            ];

            $evalConfigs = [];

            foreach ($demoSemesters as $semester) {
                $isCurrent = $semester === $currentTerm;
                $status = $isCurrent ? 'scheduled' : 'closed';

                $evaluation = Evaluation::create([
                    'title' => "Final Evaluation - $semester",
                    'semester' => $semester,
                    'evaluation_type' => 'final',
                    'start_date' => $this->termStartDate($semester),
                    'end_date' => $this->termEndDate($semester),
                    'status' => $status,
                    'is_anonymous' => true,
                    'closed_at' => $status === 'closed' ? $this->termEndDate($semester)->addDays(3) : null,
                    'created_by' => $admin->id,
                ]);

                $cfg = $semesterConfig[$semester];

                $evalConfigs[] = [
                    'eval' => $evaluation,
                    'band' => $cfg['band'],
                    // Current term's final hasn't opened yet -> no feedback yet.
                    'completion' => $isCurrent ? 0.00 : $cfg['completion'],
                    'avgCs' => $cfg['avgCs'],
                    'avgAp' => $cfg['avgAp'],
                    'avgMath' => $cfg['avgMath'],
                    'avgBc' => $cfg['avgBc'],
                    'from' => $this->termStartDate($semester),
                    'to' => $this->termEndDate($semester),
                ];
            }

            // Active mid-term evaluation for the current term (drives current-semester data).
            // Completion is deliberately high so student/faculty dashboards look populated.
            $activeEval = Evaluation::create([
                'title' => "Mid-Term Evaluation - $currentTerm",
                'semester' => $currentTerm,
                'evaluation_type' => 'mid-term',
                'start_date' => $this->termStartDate($currentTerm),
                'end_date' => $this->termEndDate($currentTerm),
                'status' => 'active',
                'is_anonymous' => true,
                'activated_at' => $this->termStartDate($currentTerm),
                'created_by' => $admin->id,
            ]);

            $evalConfigs[] = [
                'eval' => $activeEval,
                'band' => 'high',
                'completion' => 0.55,
                'avgCs' => 4.6, 'avgAp' => 4.2, 'avgMath' => 4.4, 'avgBc' => 4.3,
                'from' => now()->subDays(21),
                'to' => now(),
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

            // ─── 9. Feedback tokens + feedbacks + answers ────────────────
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
                'The exam questions were fair and covered the whole syllabus.',
                'I would love more real-world applications.',
                'Great use of technology in the classroom.',
            ];

            // A few deliberately toxic comments so the AI-moderation pipeline
            // (approved/flagged/rejected + cleaned_comment) can be demoed.
            $moderationPool = [
                ['status' => 'approved', 'toxicity' => 5,  'reason' => null, 'categories' => []],
                ['status' => 'approved', 'toxicity' => 18, 'reason' => null, 'categories' => []],
                ['status' => 'flagged',  'toxicity' => 48, 'reason' => 'Mild frustration detected, no explicit abuse.', 'categories' => ['negative']],
                ['status' => 'flagged',  'toxicity' => 55, 'reason' => 'Negative tone detected, review recommended.', 'categories' => ['negative']],
                ['status' => 'rejected', 'toxicity' => 82, 'reason' => 'Abusive language detected and cleaned.', 'categories' => ['abusive', 'negative']],
                ['status' => 'rejected', 'toxicity' => 90, 'reason' => 'Strongly abusive language detected and cleaned.', 'categories' => ['abusive', 'negative']],
            ];

            $rawComments = [
                'this department is a complete joke, the faculty are all clueless',
                'this professor is an absolute failure as a teacher',
                'I hate this class and everything about it, total waste of time',
                'pathetic teaching, zero effort from the instructor',
                'do not take this course, you will regret it',
            ];

            $cleanedComments = [
                'this department is a complete joke, the faculty are all [moderated]',
                'this professor is an absolute [moderated] as a teacher',
                'I [moderated] this class and everything about it, total waste of time',
                '[moderated] teaching, zero effort from the instructor',
                'do not take this course, you will regret it',
            ];

            $commentIndex = 0;

            $qualitativeFeedback = [
                'high' => [
                    'worked' => 'Clear explanations and useful examples made the lessons easy to follow.',
                    'improve' => 'Keep the current pace and continue adding practical exercises.',
                    'score' => 92,
                ],
                'medium' => [
                    'worked' => 'The main concepts were covered well and the course materials were available.',
                    'improve' => 'More worked examples and additional office hours would improve the experience.',
                    'score' => 65,
                ],
                'low' => [
                    'worked' => 'The instructor was approachable when questions were raised.',
                    'improve' => 'The pace, organization, and practical support need significant improvement.',
                    'score' => 32,
                ],
            ];

            foreach ($evalConfigs as $cfg) {
                $evaluation = $cfg['eval'];
                if ($cfg['completion'] <= 0) {
                    // Still issue tokens so the feedback-entry flow can be demoed later.
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

                        $feedbackBand = $cfg['band'];
                        $feedbackStatus = $feedbackBand === 'high' ? 'approved' : ($feedbackBand === 'medium' ? 'flagged' : 'rejected');

                        $feedback = Feedback::create([
                            'evaluation_id' => $evaluation->id,
                            'faculty_id' => $pair->faculty_id,
                            'course_id' => $pair->course_id,
                            'submitted_at' => $usedAt,
                            'worked_well' => $qualitativeFeedback[$feedbackBand]['worked'],
                            'improve' => $qualitativeFeedback[$feedbackBand]['improve'],
                            'worked_status' => $feedbackStatus,
                            'improve_status' => $feedbackStatus,
                            'worked_score' => $qualitativeFeedback[$feedbackBand]['score'],
                            'improve_score' => $qualitativeFeedback[$feedbackBand]['score'],
                            'worked_reason' => $feedbackStatus === 'approved' ? null : 'Demo fixture for '.$feedbackBand.' quality feedback.',
                            'improve_reason' => $feedbackStatus === 'approved' ? null : 'Demo fixture for '.$feedbackBand.' quality feedback.',
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
                            $mod = $moderationPool[$commentIndex++ % count($moderationPool)];
                            $isToxic = in_array($mod['status'], ['rejected']) || $mod['toxicity'] > 60;
                            $raw = $isToxic
                                ? $rawComments[$commentIndex % count($rawComments)]
                                : fake()->randomElement($commentPool);

                            FeedbackAnswer::create([
                                'feedback_id' => $feedback->id,
                                'question_id' => 'comments',
                                'text_answer' => $raw,
                                'moderation_status' => $mod['status'],
                                'toxicity_score' => $mod['toxicity'],
                                'moderation_reason' => $mod['reason'],
                                'moderation_categories' => $mod['categories'],
                                'original_comment' => $raw,
                                'cleaned_comment' => $isToxic
                                    ? $cleanedComments[$commentIndex % count($cleanedComments)]
                                    : $raw,
                                'moderated_at' => now(),
                            ]);
                        }
                    }
                }
            }

            $this->printDemoSummary($plainPassword, $currentTerm);
        });
    }

    private function printDemoSummary(string $password, string $currentTerm): void
    {
        $admin = User::where('email', 'nouman@pu.edu.pk')->first();
        $faculty = User::where('email', 'ahmed.khan@pu.edu.pk')->first();
        $student = User::where('email', 'ali.raza@pu.edu.pk')->first();

        $this->command->newLine();
        $this->command->info('==================================================');
        $this->command->info('  Demo seeded successfully (current term: '.$currentTerm.')');
        $this->command->info('==================================================');
        $this->command->line('  Admin   -> nouman@pu.edu.pk     ('.$password.')');
        $this->command->line('  Faculty -> ahmed.khan@pu.edu.pk ('.$password.')');
        $this->command->line('  Student -> ali.raza@pu.edu.pk   ('.$password.')');
        $this->command->newLine();
        $this->command->info('  Unused feedback tokens exist for the active eval.');
        $this->command->info('  Try the student feedback flow with ali.raza@pu.edu.pk.');
        $this->command->info('--------------------------------------------------');
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