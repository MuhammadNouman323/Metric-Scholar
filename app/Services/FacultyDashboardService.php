<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Models\User;

class FacultyDashboardService
{
    public function getAverageRating(User $faculty): float
    {
        $avg = Feedback::where('faculty_id', $faculty->id)
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->avg('feedback_answers.rating');

        return $avg ? round($avg, 1) : 0.0;
    }

    public function getTotalResponses(User $faculty): int
    {
        return Feedback::where('faculty_id', $faculty->id)->count();
    }

    public function getCoursesCount(User $faculty): int
    {
        return $faculty->courses()->count();
    }

    public function getCompletionRate(User $faculty): float
    {
        $total = FeedbackToken::where('faculty_id', $faculty->id)->count();
        $used = FeedbackToken::where('faculty_id', $faculty->id)->where('is_used', true)->count();

        return $total > 0 ? round(($used / $total) * 100, 1) : 0.0;
    }

    public function getCriteriaStats(User $faculty): array
    {
        $averages = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->where('feedbacks.faculty_id', $faculty->id)
            ->whereIn('feedback_answers.question_id', ['clarity', 'materials', 'responsiveness', 'organization'])
            ->selectRaw('feedback_answers.question_id, AVG(feedback_answers.rating) as avg_rating')
            ->groupBy('feedback_answers.question_id')
            ->pluck('avg_rating', 'question_id')
            ->all();

        $criteria = ['clarity', 'materials', 'responsiveness', 'organization'];
        $stats = [];
        foreach ($criteria as $criterion) {
            $stats[$criterion] = isset($averages[$criterion]) ? round($averages[$criterion], 1) : 0.0;
        }

        return $stats;
    }

    public function getActiveEvaluations(User $faculty)
    {
        return Evaluation::whereIn('status', ['active', 'scheduled'])
            ->whereHas('faculty', function ($q) use ($faculty) {
                $q->where('users.id', $faculty->id);
            })->get();
    }

    public function getHistoricalTrend(User $faculty): array
    {
        $semesters = Feedback::where('faculty_id', $faculty->id)
            ->join('evaluations', 'feedbacks.evaluation_id', '=', 'evaluations.id')
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->selectRaw('evaluations.semester, AVG(feedback_answers.rating) as avg_rating, MIN(evaluations.created_at) as created_at')
            ->groupBy('evaluations.semester')
            ->orderBy('created_at')
            ->get();

        $trend = [];
        foreach ($semesters as $hs) {
            $trend[] = [
                'semester' => $hs->semester,
                'rating' => round($hs->avg_rating, 1),
            ];
        }

        return $trend;
    }

    public function getRecentComments(User $faculty, int $limit = 5): array
    {
        $comments = Feedback::where('faculty_id', $faculty->id)
            ->with(['course:id,title,code', 'answers' => function ($q) {
                $q->where('question_id', 'comments');
            }])
            ->whereHas('answers', function ($q) {
                $q->where('question_id', 'comments');
            })
            ->latest()
            ->take($limit)
            ->get();

        return $comments->map(fn ($f) => [
            'course' => $f->course?->title,
            'comment' => $f->answers->first()?->text_answer,
            'submitted_at' => $f->created_at,
        ])->toArray();
    }

    public function generateSvgPoints(User $faculty): array
    {
        $trend = $this->getHistoricalTrend($faculty);
        $points = [];
        $numPoints = count($trend);

        foreach ($trend as $idx => $t) {
            $x = $numPoints > 1 ? 40 + ($idx * (520 / ($numPoints - 1))) : 300;
            $ratingValue = max(1, min(5, $t['rating']));
            $y = 155 - ($ratingValue - 1) * 32.5;
            $points[] = [
                'x' => $x,
                'y' => $y,
                'semester' => $t['semester'],
                'rating' => $t['rating'],
            ];
        }

        return $points;
    }
}
