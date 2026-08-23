<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\FeedbackToken;
use App\Models\User;
use App\Notifications\NewEvaluationScheduledNotification;
use App\Repositories\EvaluationRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EvaluationService
{
    public function __construct(
        protected EvaluationRepository $evaluationRepository
    ) {}

    public function publishEvaluation(array $data, array $facultyIds, array $courseFacultyMapping): Evaluation
    {
        $evaluation = DB::transaction(function () use ($data, $facultyIds, $courseFacultyMapping) {
            $data['status'] = 'scheduled'; // Scheduler handles transition to active

            $evaluation = $this->evaluationRepository->create($data);

            // Support both associative mapping [course_id => faculty_id]
            // and paired numeric arrays: publishEvaluation($data, [$courseId], [$facultyId])
            $coursePivot = [];
            $isList = array_values($courseFacultyMapping) === $courseFacultyMapping;
            if ($isList) {
                // assume $facultyIds holds course ids and $courseFacultyMapping holds faculty ids
                $courseIds = $facultyIds;
                $facultyList = $courseFacultyMapping;
                foreach ($courseIds as $i => $courseId) {
                    if (isset($facultyList[$i])) {
                        $coursePivot[$courseId] = ['faculty_id' => $facultyList[$i]];
                    }
                }
            } else {
                $facultyList = $facultyIds;
                foreach ($courseFacultyMapping as $courseId => $facultyId) {
                    $coursePivot[$courseId] = ['faculty_id' => $facultyId];
                }
            }

            $this->evaluationRepository->attachFaculty($evaluation, $facultyList);
            $this->evaluationRepository->attachCourses($evaluation, $coursePivot);

            $this->generateTokensForEvaluation($evaluation, $coursePivot);

            return $evaluation;
        });

        Artisan::call('evaluation:process-lifecycle');

        return $evaluation;
    }

    protected function generateTokensForEvaluation(Evaluation $evaluation, array $courseFacultyMapping): void
    {
        // For each course, find enrolled students, and generate a token
        $tokensToInsert = [];
        $now = now();
        $notifiedStudents = [];
        $notifiedFaculty = [];

        foreach ($courseFacultyMapping as $courseId => $facultyId) {
            if (is_array($facultyId)) {
                $facultyId = $facultyId['faculty_id'] ?? null;
            }
            $course = Course::with('users')->find($courseId);

            if (! $course) {
                continue;
            }

            // Notify Faculty
            if ($facultyId && ! in_array($facultyId, $notifiedFaculty)) {
                $facultyUser = User::find($facultyId);
                if ($facultyUser) {
                    $facultyUser->notify(new NewEvaluationScheduledNotification($evaluation, 'faculty'));
                    $notifiedFaculty[] = $facultyId;
                }
            }

            $students = $course->users->where('role', Role::Student);

            foreach ($students as $student) {
                if (! in_array($student->id, $notifiedStudents)) {
                    $student->notify(new NewEvaluationScheduledNotification($evaluation, 'student'));
                    $notifiedStudents[] = $student->id;
                }

                $tokensToInsert[] = [
                    'evaluation_id' => $evaluation->id,
                    'student_id' => $student->id,
                    'faculty_id' => $facultyId,
                    'course_id' => $course->id,
                    'token' => Str::uuid()->toString(),
                    'is_used' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Chunk insertions for scalability
        foreach (array_chunk($tokensToInsert, 500) as $chunk) {
            FeedbackToken::insert($chunk);
        }
    }
}
