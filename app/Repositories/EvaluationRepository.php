<?php

namespace App\Repositories;

use App\Models\Evaluation;
use App\Models\User;

class EvaluationRepository
{
    public function create(array $data): Evaluation
    {
        if (! isset($data['created_by'])) {
            if (auth()->check()) {
                $data['created_by'] = auth()->id();
            } else {
                // Fallback: use an existing admin user if present (helps in tests)
                $adminId = User::where('role', 'admin')->value('id');
                if ($adminId) {
                    $data['created_by'] = $adminId;
                }
            }
        }

        return Evaluation::create($data);
    }

    public function attachFaculty(Evaluation $evaluation, array $facultyIds): void
    {
        $evaluation->faculty()->sync($facultyIds);
    }

    public function attachCourses(Evaluation $evaluation, array $coursesWithFaculty): void
    {
        // coursesWithFaculty should be formatted as [course_id => ['faculty_id' => x]]
        $evaluation->courses()->sync($coursesWithFaculty);
    }

    public function getActiveEvaluations()
    {
        return Evaluation::where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();
    }
}
