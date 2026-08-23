<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Models\User;

class ReportService
{
    /**
     * Get statistics summary based on filters.
     */
    public function getSummaryStats(array $filters): array
    {
        $tenantId = auth()->user()->university_id ?? null;

        // Base queries
        $evalQuery = Evaluation::query();
        $facultyQuery = User::where('role', Role::Faculty);
        $studentQuery = User::where('role', Role::Student);
        $courseQuery = Course::query();
        $feedbackQuery = Feedback::query();
        $tokenQuery = FeedbackToken::query();

        if ($tenantId) {
            $evalQuery->whereHas('creator', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
            $facultyQuery->where('university_id', $tenantId);
            $studentQuery->where('university_id', $tenantId);
            $feedbackQuery->whereHas('faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
            $tokenQuery->whereHas('faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }

        // Apply filters where applicable
        if (! empty($filters['evaluation_id'])) {
            $evalQuery->where('id', $filters['evaluation_id']);
            $feedbackQuery->where('evaluation_id', $filters['evaluation_id']);
            $tokenQuery->where('evaluation_id', $filters['evaluation_id']);

            $facultyQuery->whereHas('evaluations', function ($q) use ($filters) {
                $q->where('evaluations.id', $filters['evaluation_id']);
            });
            $courseQuery->whereHas('evaluations', function ($q) use ($filters) {
                $q->where('evaluations.id', $filters['evaluation_id']);
            });
        }

        if (! empty($filters['semester'])) {
            $sem = $filters['semester'];
            $evalQuery->where('semester', $sem);
            $feedbackQuery->whereHas('evaluation', function ($q) use ($sem) {
                $q->where('semester', $sem);
            });
            $tokenQuery->whereHas('evaluation', function ($q) use ($sem) {
                $q->where('semester', $sem);
            });
            $courseQuery->where('semester', $sem);
        }

        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $facultyQuery->where('department', $dept);
            $courseQuery->where('department', $dept);

            $feedbackQuery->where(function ($q) use ($dept) {
                $q->whereHas('faculty', function ($qf) use ($dept) {
                    $qf->where('department', $dept);
                })->orWhereHas('course', function ($qc) use ($dept) {
                    $qc->where('department', $dept);
                });
            });
            $tokenQuery->where(function ($q) use ($dept) {
                $q->whereHas('faculty', function ($qf) use ($dept) {
                    $qf->where('department', $dept);
                })->orWhereHas('course', function ($qc) use ($dept) {
                    $qc->where('department', $dept);
                });
            });
        }

        if (! empty($filters['faculty_id'])) {
            $fid = $filters['faculty_id'];
            $feedbackQuery->where('faculty_id', $fid);
            $tokenQuery->where('faculty_id', $fid);
            $facultyQuery->where('id', $fid);
            $courseQuery->whereHas('faculty', function ($q) use ($fid) {
                $q->where('users.id', $fid);
            });
        }

        if (! empty($filters['course_id'])) {
            $cid = $filters['course_id'];
            $feedbackQuery->where('course_id', $cid);
            $tokenQuery->where('course_id', $cid);
            $courseQuery->where('id', $cid);
        }

        if (! empty($filters['start_date'])) {
            $feedbackQuery->whereDate('submitted_at', '>=', $filters['start_date']);
            $tokenQuery->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (! empty($filters['end_date'])) {
            $feedbackQuery->whereDate('submitted_at', '<=', $filters['end_date']);
            $tokenQuery->whereDate('created_at', '<=', $filters['end_date']);
        }

        if (! empty($filters['status'])) {
            $status = $filters['status'];
            $evalQuery->where('status', $status);
            $feedbackQuery->whereHas('evaluation', function ($q) use ($status) {
                $q->where('status', $status);
            });
            $tokenQuery->whereHas('evaluation', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        // Calculations
        $totalEvaluations = (clone $evalQuery)->count();
        $activeEvaluations = (clone $evalQuery)->where('status', 'active')->count();
        $closedEvaluations = (clone $evalQuery)->where('status', 'closed')->count();
        $totalFaculty = (clone $facultyQuery)->count();
        $totalStudents = (clone $studentQuery)->count();
        $totalCourses = (clone $courseQuery)->count();

        $totalFeedback = (clone $feedbackQuery)->count();
        $pendingFeedback = (clone $tokenQuery)->where('is_used', false)->count();

        // Calculate Overall Average Rating
        $avgQuery = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->where('feedback_answers.question_id', 'overall_rating');

        // Scope average by the same feedback filters
        if ($tenantId) {
            $avgQuery->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }
        if (! empty($filters['evaluation_id'])) {
            $avgQuery->where('feedbacks.evaluation_id', $filters['evaluation_id']);
        }
        if (! empty($filters['semester'])) {
            $avgQuery->whereHas('feedback.evaluation', function ($q) use ($filters) {
                $q->where('semester', $filters['semester']);
            });
        }
        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $avgQuery->where(function ($q) use ($dept) {
                $q->whereHas('feedback.faculty', function ($qf) use ($dept) {
                    $qf->where('department', $dept);
                })->orWhereHas('feedback.course', function ($qc) use ($dept) {
                    $qc->where('department', $dept);
                });
            });
        }
        if (! empty($filters['faculty_id'])) {
            $avgQuery->where('feedbacks.faculty_id', $filters['faculty_id']);
        }
        if (! empty($filters['course_id'])) {
            $avgQuery->where('feedbacks.course_id', $filters['course_id']);
        }
        if (! empty($filters['start_date'])) {
            $avgQuery->whereDate('feedbacks.submitted_at', '>=', $filters['start_date']);
        }
        if (! empty($filters['end_date'])) {
            $avgQuery->whereDate('feedbacks.submitted_at', '<=', $filters['end_date']);
        }
        if (! empty($filters['status'])) {
            $avgQuery->whereHas('feedback.evaluation', function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        $overallAverage = $avgQuery->avg('feedback_answers.rating');
        $overallAverage = $overallAverage ? round($overallAverage, 2) : 0.00;

        $completionRate = 0.0;
        $totalTokens = $totalFeedback + $pendingFeedback;
        if ($totalTokens > 0) {
            $completionRate = round(($totalFeedback / $totalTokens) * 100, 1);
        }

        return [
            'total_evaluations' => $totalEvaluations,
            'active_evaluations' => $activeEvaluations,
            'closed_evaluations' => $closedEvaluations,
            'total_faculty' => $totalFaculty,
            'total_students' => $totalStudents,
            'total_courses' => $totalCourses,
            'total_feedback' => $totalFeedback,
            'pending_feedback' => $pendingFeedback,
            'overall_average' => $overallAverage,
            'completion_rate' => $completionRate,
        ];
    }

    /**
     * Report 1: Faculty Performance Report.
     */
    public function getFacultyPerformanceReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        $query = User::where('role', Role::Faculty);

        if ($tenantId) {
            $query->where('university_id', $tenantId);
        }

        if (! empty($filters['department'])) {
            $query->where('department', $filters['department']);
        }

        if (! empty($filters['faculty_id'])) {
            $query->where('id', $filters['faculty_id']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', '%'.$search.'%');
        }

        $facultyIds = $query->pluck('id');

        $feedbackQuery = Feedback::whereIn('faculty_id', $facultyIds);

        if (! empty($filters['evaluation_id'])) {
            $feedbackQuery->where('evaluation_id', $filters['evaluation_id']);
        }
        if (! empty($filters['semester'])) {
            $feedbackQuery->whereHas('evaluation', function ($q) use ($filters) {
                $q->where('semester', $filters['semester']);
            });
        }
        if (! empty($filters['course_id'])) {
            $feedbackQuery->where('course_id', $filters['course_id']);
        }
        if (! empty($filters['start_date'])) {
            $feedbackQuery->whereDate('submitted_at', '>=', $filters['start_date']);
        }
        if (! empty($filters['end_date'])) {
            $feedbackQuery->whereDate('submitted_at', '<=', $filters['end_date']);
        }
        if (! empty($filters['status'])) {
            $feedbackQuery->whereHas('evaluation', function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        }

        $feedbackCounts = (clone $feedbackQuery)
            ->selectRaw('faculty_id, COUNT(*) as total')
            ->groupBy('faculty_id')
            ->pluck('total', 'faculty_id');

        $avgRatings = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->whereIn('feedbacks.faculty_id', $facultyIds)
            ->where('feedback_answers.question_id', 'overall_rating')
            ->selectRaw('feedbacks.faculty_id, AVG(feedback_answers.rating) as avg_rating')
            ->groupBy('feedbacks.faculty_id')
            ->pluck('avg_rating', 'faculty_id');

        $facultyData = $query->get()->map(function ($faculty) use ($feedbackCounts, $avgRatings) {
            $totalFeedback = $feedbackCounts[$faculty->id] ?? 0;
            $avgRating = isset($avgRatings[$faculty->id]) ? round($avgRatings[$faculty->id], 2) : 0.00;
            $performanceScore = round($avgRating * 20, 1);

            $grade = $avgRating >= 4.5 ? 'Excellent'
                : ($avgRating >= 4.0 ? 'Very Good'
                : ($avgRating >= 3.0 ? 'Good'
                : ($avgRating >= 2.0 ? 'Fair' : 'Poor')));

            return [
                'faculty_id' => $faculty->id,
                'name' => $faculty->name,
                'department' => $faculty->department ?? 'N/A',
                'avatar' => $faculty->avatar_url,
                'avg_rating' => $avgRating,
                'total_feedback' => $totalFeedback,
                'performance_score' => $performanceScore,
                'grade' => $grade,
            ];
        });

        // Apply Sorting
        $sort = $filters['sort'] ?? 'highest';
        if ($sort === 'highest') {
            return $facultyData->sortByDesc('avg_rating')->values();
        } else {
            return $facultyData->sortBy('avg_rating')->values();
        }
    }

    /**
     * Report 2: Course Report.
     */
    public function getCourseReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        $query = Course::query();

        if (! empty($filters['department'])) {
            $query->where('department', $filters['department']);
        }

        if (! empty($filters['course_id'])) {
            $query->where('id', $filters['course_id']);
        }

        if (! empty($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('code', 'like', '%'.$search.'%');
            });
        }

        // We fetch courses and project details
        return $query->get()->flatMap(function ($course) use ($filters, $tenantId) {
            // Find all faculty assigned to this course via pivot evaluation_courses or course_user
            // Let's get faculty connected to feedbacks, tokens or evaluations
            $facultyQuery = User::where('role', Role::Faculty)
                ->whereHas('courses', function ($q) use ($course) {
                    $q->where('courses.id', $course->id);
                });

            if ($tenantId) {
                $facultyQuery->where('university_id', $tenantId);
            }

            if (! empty($filters['faculty_id'])) {
                $facultyQuery->where('id', $filters['faculty_id']);
            }

            $faculties = $facultyQuery->get();

            // If no faculty mapped yet, return a generic placeholder row
            if ($faculties->isEmpty()) {
                return [[
                    'course_id' => $course->id,
                    'code' => $course->code,
                    'title' => $course->title,
                    'faculty_name' => 'Not Assigned',
                    'total_students' => 0,
                    'feedback_submitted' => 0,
                    'avg_rating' => 0.00,
                    'completion_percentage' => 0.0,
                ]];
            }

            return $faculties->map(function ($faculty) use ($course, $filters) {
                // Tokens for this combination
                $tokenQuery = FeedbackToken::where('course_id', $course->id)
                    ->where('faculty_id', $faculty->id);

                if (! empty($filters['evaluation_id'])) {
                    $tokenQuery->where('evaluation_id', $filters['evaluation_id']);
                }

                $totalStudents = $tokenQuery->count();
                $feedbackSubmitted = (clone $tokenQuery)->where('is_used', true)->count();

                // Compute Average Rating
                $avgRating = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
                    ->where('feedbacks.course_id', $course->id)
                    ->where('feedbacks.faculty_id', $faculty->id)
                    ->where('feedback_answers.question_id', 'overall_rating');

                if (! empty($filters['evaluation_id'])) {
                    $avgRating->where('feedbacks.evaluation_id', $filters['evaluation_id']);
                }
                if (! empty($filters['start_date'])) {
                    $avgRating->whereDate('feedbacks.submitted_at', '>=', $filters['start_date']);
                }
                if (! empty($filters['end_date'])) {
                    $avgRating->whereDate('feedbacks.submitted_at', '<=', $filters['end_date']);
                }

                $avg = $avgRating->avg('rating');
                $avg = $avg ? round($avg, 2) : 0.00;

                $completionRate = $totalStudents > 0 ? round(($feedbackSubmitted / $totalStudents) * 100, 1) : 0.0;

                return [
                    'course_id' => $course->id,
                    'code' => $course->code,
                    'title' => $course->title,
                    'faculty_name' => $faculty->name,
                    'total_students' => $totalStudents,
                    'feedback_submitted' => $feedbackSubmitted,
                    'avg_rating' => $avg,
                    'completion_percentage' => $completionRate,
                ];
            });
        })->values();
    }

    /**
     * Report 3: Department Report.
     */
    public function getDepartmentReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        // Distinct departments from User (faculty) and Course
        $deptQuery = User::query();
        if ($tenantId) {
            $deptQuery->where('university_id', $tenantId);
        }
        $departments = $deptQuery->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->pluck('department');

        if (! empty($filters['department'])) {
            $departments = $departments->filter(function ($d) use ($filters) {
                return strtolower($d) === strtolower($filters['department']);
            });
        }

        if (! empty($filters['search'])) {
            $search = strtolower($filters['search']);
            $departments = $departments->filter(function ($d) use ($search) {
                return str_contains(strtolower($d), $search);
            });
        }

        return $departments->map(function ($deptName) use ($filters, $tenantId) {
            // Count Faculty
            $facQuery = User::where('role', Role::Faculty)->where('department', $deptName);
            if ($tenantId) {
                $facQuery->where('university_id', $tenantId);
            }
            $facultyCount = $facQuery->count();

            // Average Rating for the department
            $avgQuery = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
                ->where('feedback_answers.question_id', 'overall_rating')
                ->where(function ($q) use ($deptName) {
                    $q->whereHas('feedback.faculty', function ($qf) use ($deptName) {
                        $qf->where('department', $deptName);
                    })->orWhereHas('feedback.course', function ($qc) use ($deptName) {
                        $qc->where('department', $deptName);
                    });
                });

            if (! empty($filters['evaluation_id'])) {
                $avgQuery->where('feedbacks.evaluation_id', $filters['evaluation_id']);
            }
            if (! empty($filters['semester'])) {
                $avgQuery->whereHas('feedback.evaluation', function ($q) use ($filters) {
                    $q->where('semester', $filters['semester']);
                });
            }

            $avg = $avgQuery->avg('rating');
            $avg = $avg ? round($avg, 2) : 0.00;

            // Locate Best & Lowest Performing Faculty
            $allFaculty = User::where('role', Role::Faculty)->where('department', $deptName);
            if ($tenantId) {
                $allFaculty->where('university_id', $tenantId);
            }

            $facultyPerformers = $allFaculty->get()->map(function ($fac) use ($filters) {
                $fbIds = Feedback::where('faculty_id', $fac->id);
                if (! empty($filters['evaluation_id'])) {
                    $fbIds->where('evaluation_id', $filters['evaluation_id']);
                }
                $fbIds = $fbIds->pluck('id');

                $facAvg = 0.00;
                if ($fbIds->isNotEmpty()) {
                    $facAvg = FeedbackAnswer::whereIn('feedback_id', $fbIds)
                        ->where('question_id', 'overall_rating')
                        ->avg('rating');
                }

                return [
                    'name' => $fac->name,
                    'rating' => $facAvg ? round($facAvg, 2) : 0.00,
                    'has_feedback' => $fbIds->isNotEmpty(),
                ];
            });

            $ratedPerformers = $facultyPerformers->filter(fn ($fp) => $fp['has_feedback']);

            $bestFaculty = $ratedPerformers->sortByDesc('rating')->first()['name'] ?? 'N/A';
            $worstFaculty = $ratedPerformers->sortBy('rating')->first()['name'] ?? 'N/A';

            return [
                'department_name' => $deptName,
                'number_of_faculty' => $facultyCount,
                'avg_rating' => $avg,
                'best_faculty' => $bestFaculty,
                'worst_faculty' => $worstFaculty,
            ];
        })->values();
    }

    /**
     * Report 4: Evaluation Report.
     */
    public function getEvaluationReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        $query = Evaluation::query();

        if ($tenantId) {
            $query->whereHas('creator', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }

        if (! empty($filters['evaluation_id'])) {
            $query->where('id', $filters['evaluation_id']);
        }

        if (! empty($filters['semester'])) {
            $query->where('semester', $filters['semester']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('title', 'like', '%'.$search.'%');
        }

        return $query->get()->map(function ($evaluation) {
            $totalEligible = FeedbackToken::where('evaluation_id', $evaluation->id)->count();
            $submitted = FeedbackToken::where('evaluation_id', $evaluation->id)->where('is_used', true)->count();
            $pending = FeedbackToken::where('evaluation_id', $evaluation->id)->where('is_used', false)->count();

            $completion = $totalEligible > 0 ? round(($submitted / $totalEligible) * 100, 1) : 0.0;

            return [
                'evaluation_id' => $evaluation->id,
                'title' => $evaluation->title,
                'semester' => $evaluation->semester,
                'start_date' => $evaluation->start_date ? $evaluation->start_date->format('Y-m-d') : 'N/A',
                'end_date' => $evaluation->end_date ? $evaluation->end_date->format('Y-m-d') : 'N/A',
                'status' => ucfirst($evaluation->status),
                'total_eligible_students' => $totalEligible,
                'submitted_feedback' => $submitted,
                'pending_feedback' => $pending,
                'completion_percentage' => $completion,
            ];
        })->values();
    }

    /**
     * Report 5: Question Analysis Report.
     */
    public function getQuestionAnalysisReport(array $filters): array
    {
        $tenantId = auth()->user()->university_id ?? null;

        $questionKeys = [
            'clarity' => 'Clarity of Instruction',
            'materials' => 'Quality of Materials',
            'responsiveness' => 'Responsiveness and Availability',
            'fairness' => 'Fairness of Grading',
            'practical' => 'Practical/Application Focus',
            'organization' => 'Course Organization',
            'overall_rating' => 'Overall Rating',
        ];

        // Base Feedback query to filter feedback IDs
        $feedbackQuery = Feedback::query();
        if ($tenantId) {
            $feedbackQuery->whereHas('faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }
        if (! empty($filters['evaluation_id'])) {
            $feedbackQuery->where('evaluation_id', $filters['evaluation_id']);
        }
        if (! empty($filters['semester'])) {
            $feedbackQuery->whereHas('evaluation', function ($q) use ($filters) {
                $q->where('semester', $filters['semester']);
            });
        }
        if (! empty($filters['faculty_id'])) {
            $feedbackQuery->where('faculty_id', $filters['faculty_id']);
        }
        if (! empty($filters['course_id'])) {
            $feedbackQuery->where('course_id', $filters['course_id']);
        }
        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $feedbackQuery->where(function ($q) use ($dept) {
                $q->whereHas('faculty', function ($qf) use ($dept) {
                    $qf->where('department', $dept);
                })->orWhereHas('course', function ($qc) use ($dept) {
                    $qc->where('department', $dept);
                });
            });
        }

        $feedbackIds = $feedbackQuery->pluck('id');
        $report = [];

        foreach ($questionKeys as $key => $label) {
            $answers = FeedbackAnswer::whereIn('feedback_id', $feedbackIds)
                ->where('question_id', $key)
                ->whereNotNull('rating')
                ->pluck('rating');

            $count = $answers->count();
            $avg = $count > 0 ? round($answers->average(), 2) : 0.00;

            $excellentCount = $answers->filter(fn ($r) => $r == 5)->count();
            $veryGoodCount = $answers->filter(fn ($r) => $r == 4)->count();
            $goodCount = $answers->filter(fn ($r) => $r == 3)->count();
            $fairCount = $answers->filter(fn ($r) => $r == 2)->count();
            $poorCount = $answers->filter(fn ($r) => $r == 1)->count();

            $report[] = [
                'question_id' => $key,
                'question' => $label,
                'avg_rating' => $avg,
                'excellent_pct' => $count > 0 ? round(($excellentCount / $count) * 100, 1) : 0.0,
                'very_good_pct' => $count > 0 ? round(($veryGoodCount / $count) * 100, 1) : 0.0,
                'good_pct' => $count > 0 ? round(($goodCount / $count) * 100, 1) : 0.0,
                'fair_pct' => $count > 0 ? round(($fairCount / $count) * 100, 1) : 0.0,
                'poor_pct' => $count > 0 ? round(($poorCount / $count) * 100, 1) : 0.0,
            ];
        }

        return $report;
    }

    /**
     * Report 6: Anonymous Comments Report.
     */
    public function getAnonymousCommentsReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        // Fetch comments where question_id is 'comments' or 'what_worked_well' or 'what_could_improve'
        // moderation_status must be 'approved'
        // Student columns should NEVER be joined.
        $query = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->whereIn('feedback_answers.question_id', ['comments', 'what_worked_well', 'what_could_improve'])
            ->whereNotNull('feedback_answers.text_answer')
            ->where('feedback_answers.text_answer', '!=', '')
            ->where('feedback_answers.moderation_status', 'approved');

        if ($tenantId) {
            $query->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }

        if (! empty($filters['evaluation_id'])) {
            $query->where('feedbacks.evaluation_id', $filters['evaluation_id']);
        }
        if (! empty($filters['semester'])) {
            $query->whereHas('feedback.evaluation', function ($q) use ($filters) {
                $q->where('semester', $filters['semester']);
            });
        }
        if (! empty($filters['faculty_id'])) {
            $query->where('feedbacks.faculty_id', $filters['faculty_id']);
        }
        if (! empty($filters['course_id'])) {
            $query->where('feedbacks.course_id', $filters['course_id']);
        }
        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $query->where(function ($q) use ($dept) {
                $q->whereHas('feedback.faculty', function ($qf) use ($dept) {
                    $qf->where('department', $dept);
                })->orWhereHas('feedback.course', function ($qc) use ($dept) {
                    $qc->where('department', $dept);
                });
            });
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('feedback_answers.text_answer', 'like', '%'.$search.'%');
        }

        return $query->select(
            'feedback_answers.id',
            'feedback_answers.question_id',
            'feedback_answers.text_answer',
            'feedback_answers.created_at',
            'feedbacks.faculty_id',
            'feedbacks.course_id',
            'feedbacks.evaluation_id'
        )
            ->with(['feedback.faculty', 'feedback.course', 'feedback.evaluation'])
            ->latest('feedback_answers.created_at')
            ->paginate(15);
    }

    /**
     * Report 7: AI Moderation Report.
     */
    public function getAIModerationReport(array $filters)
    {
        $tenantId = auth()->user()->university_id ?? null;

        $query = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->whereIn('feedback_answers.question_id', ['comments', 'what_worked_well', 'what_could_improve'])
            ->whereNotNull('feedback_answers.original_comment');

        if ($tenantId) {
            $query->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }

        if (! empty($filters['evaluation_id'])) {
            $query->where('feedbacks.evaluation_id', $filters['evaluation_id']);
        }
        if (! empty($filters['status'])) {
            // This filters comments by status: approved/flagged/rejected
            $query->where('feedback_answers.moderation_status', $filters['status']);
        }
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('feedback_answers.original_comment', 'like', '%'.$search.'%')
                    ->orWhere('feedback_answers.moderation_reason', 'like', '%'.$search.'%');
            });
        }

        return $query->select(
            'feedback_answers.id',
            'feedback_answers.question_id',
            'feedback_answers.original_comment',
            'feedback_answers.cleaned_comment',
            'feedback_answers.moderation_status',
            'feedback_answers.toxicity_score',
            'feedback_answers.moderation_reason',
            'feedback_answers.moderation_categories',
            'feedback_answers.moderated_at',
            'feedbacks.faculty_id',
            'feedbacks.course_id',
            'feedbacks.evaluation_id'
        )
            ->with(['feedback.faculty', 'feedback.course', 'feedback.evaluation'])
            ->latest('feedback_answers.moderated_at')
            ->paginate(15);
    }

    /**
     * Get chart statistics.
     */
    public function getChartData(array $filters): array
    {
        $tenantId = auth()->user()->university_id ?? null;

        // 1. Faculty Average Ratings (Bar Chart)
        $facQuery = User::where('role', Role::Faculty);
        if ($tenantId) {
            $facQuery->where('university_id', $tenantId);
        }
        if (! empty($filters['department'])) {
            $facQuery->where('department', $filters['department']);
        }
        $facultyList = $facQuery->take(15)->get();

        $facNames = [];
        $facRatings = [];
        foreach ($facultyList as $fac) {
            $avg = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
                ->where('feedbacks.faculty_id', $fac->id)
                ->where('feedback_answers.question_id', 'overall_rating')
                ->avg('rating');
            $facNames[] = $fac->name;
            $facRatings[] = $avg ? round($avg, 2) : 0.00;
        }

        // 2. Overall Rating Distribution (Pie Chart) Excellent (5), Very Good (4), Good (3), Fair (2), Poor (1)
        $distQuery = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->whereNotNull('feedback_answers.rating');

        if ($tenantId) {
            $distQuery->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }
        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $distQuery->whereHas('feedback.faculty', function ($q) use ($dept) {
                $q->where('department', $dept);
            });
        }
        if (! empty($filters['evaluation_id'])) {
            $distQuery->where('feedbacks.evaluation_id', $filters['evaluation_id']);
        }

        $allRatings = $distQuery->pluck('rating');
        $ratingDistribution = [
            'Excellent' => $allRatings->filter(fn ($r) => $r == 5)->count(),
            'Very Good' => $allRatings->filter(fn ($r) => $r == 4)->count(),
            'Good' => $allRatings->filter(fn ($r) => $r == 3)->count(),
            'Fair' => $allRatings->filter(fn ($r) => $r == 2)->count(),
            'Poor' => $allRatings->filter(fn ($r) => $r == 1)->count(),
        ];

        // 3. Faculty Performance Trend by Semester (Line Chart)
        $trendQuery = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->join('evaluations', 'feedbacks.evaluation_id', '=', 'evaluations.id')
            ->where('feedback_answers.question_id', 'overall_rating');

        if ($tenantId) {
            $trendQuery->whereHas('feedback.faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }
        if (! empty($filters['department'])) {
            $dept = $filters['department'];
            $trendQuery->whereHas('feedback.faculty', function ($q) use ($dept) {
                $q->where('department', $dept);
            });
        }
        if (! empty($filters['faculty_id'])) {
            $trendQuery->where('feedbacks.faculty_id', $filters['faculty_id']);
        }

        $semesterTrends = $trendQuery->selectRaw('evaluations.semester, AVG(feedback_answers.rating) as avg_rating')
            ->groupBy('evaluations.semester')
            ->orderBy('evaluations.semester')
            ->pluck('avg_rating', 'semester');

        // 4. Evaluation Completion Rate (Doughnut Chart)
        $tknQuery = FeedbackToken::query();
        if ($tenantId) {
            $tknQuery->whereHas('faculty', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
        }
        if (! empty($filters['evaluation_id'])) {
            $tknQuery->where('evaluation_id', $filters['evaluation_id']);
        }
        $totalTokens = $tknQuery->count();
        $submittedTokens = (clone $tknQuery)->where('is_used', true)->count();
        $pendingTokens = $totalTokens - $submittedTokens;

        $completionRateData = [
            'Submitted' => $submittedTokens,
            'Pending' => $pendingTokens,
        ];

        // 5. Top 10 Highest Rated Faculty (Horizontal Bar Chart)
        $topFaculty = [];
        $topRatings = [];

        $allFacultyToRate = User::where('role', Role::Faculty);
        if ($tenantId) {
            $allFacultyToRate->where('university_id', $tenantId);
        }
        if (! empty($filters['department'])) {
            $allFacultyToRate->where('department', $filters['department']);
        }

        $facultyAvgRatings = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->whereIn('feedbacks.faculty_id', $allFacultyToRate->pluck('id'))
            ->selectRaw('feedbacks.faculty_id, AVG(feedback_answers.rating) as avg_rating')
            ->groupBy('feedbacks.faculty_id')
            ->pluck('avg_rating', 'faculty_id');

        if ($facultyAvgRatings->isNotEmpty()) {
            $facultyNames = $allFacultyToRate->pluck('name', 'id');
            $sorted = $facultyAvgRatings->sortDesc()->take(10);
            foreach ($sorted as $facId => $avg) {
                $topFaculty[] = $facultyNames[$facId] ?? 'Unknown';
                $topRatings[] = round($avg, 2);
            }
        }

        return [
            'faculty_bar' => [
                'labels' => $facNames,
                'data' => $facRatings,
            ],
            'rating_pie' => [
                'labels' => array_keys($ratingDistribution),
                'data' => array_values($ratingDistribution),
            ],
            'semester_line' => [
                'labels' => $semesterTrends->keys()->all(),
                'data' => $semesterTrends->values()->map(fn ($v) => round($v, 2))->all(),
            ],
            'completion_doughnut' => [
                'labels' => array_keys($completionRateData),
                'data' => array_values($completionRateData),
            ],
            'top_faculty_horizontal' => [
                'labels' => $topFaculty,
                'data' => $topRatings,
            ],
        ];
    }
}
