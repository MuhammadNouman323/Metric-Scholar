<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\FeedbackToken;
use App\Repositories\EvaluationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EvaluationService
{
    public function __construct(
        protected EvaluationRepository $evaluationRepository
    ) {}

    public function publishEvaluation(array $data, array $facultyIds, array $courseFacultyMapping): Evaluation
    {
        return DB::transaction(function () use ($data, $facultyIds, $courseFacultyMapping) {
            $data['status'] = 'active'; // or 'published' based on flow

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
    }

    protected function generateTokensForEvaluation(Evaluation $evaluation, array $courseFacultyMapping): void
    {
        // For each course, find enrolled students, and generate a token
        $tokensToInsert = [];
        $now = now();

        foreach ($courseFacultyMapping as $courseId => $facultyId) {
            if (is_array($facultyId)) {
                $facultyId = $facultyId['faculty_id'] ?? null;
            }
            $course = Course::with('users')->find($courseId);

            if (! $course) {
                continue;
            }

            $students = $course->users->where('role', 'student');

            foreach ($students as $student) {
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
