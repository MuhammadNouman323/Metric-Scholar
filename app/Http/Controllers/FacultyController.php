<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Services\FacultyDashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function dashboard(FacultyDashboardService $dashboardService): View
    {
        $faculty = Auth::user();
        $notifications = $faculty->notifications()->take(5)->get();

        $activeEvaluations = $dashboardService->getActiveEvaluations($faculty);

        $assignedCourses = collect();
        if ($activeEvaluations->isNotEmpty()) {
            $evaluationIds = $activeEvaluations->pluck('id');
            $assignedCourses = $faculty->courses()->whereHas('evaluations', function ($q) use ($evaluationIds) {
                $q->whereIn('evaluations.id', $evaluationIds);
            })->get();
        }

        $avgRating = $dashboardService->getAverageRating($faculty);
        $totalResponsesCount = $dashboardService->getTotalResponses($faculty);
        $coursesCount = $dashboardService->getCoursesCount($faculty);
        $completionRate = $dashboardService->getCompletionRate($faculty);
        $criteriaStats = $dashboardService->getCriteriaStats($faculty);
        $svgPoints = $dashboardService->generateSvgPoints($faculty);

        $recentComments = FeedbackAnswer::where('question_id', 'comments')
            ->whereNotNull('text_answer')
            ->where('text_answer', '!=', '')
            ->whereHas('feedback', function ($q) use ($faculty) {
                $q->where('faculty_id', $faculty->id);
            })
            ->with(['feedback.course', 'feedback.answers' => function ($q) {
                $q->where('question_id', 'overall_rating');
            }])
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($answer) {
                $overallRatingAnswer = $answer->feedback->answers->first();

                return [
                    'text' => $answer->text_answer,
                    'rating' => $overallRatingAnswer ? $overallRatingAnswer->rating : 5,
                    'date' => $answer->created_at ? $answer->created_at->diffForHumans() : 'Recently',
                    'course' => $answer->feedback->course->code ?? 'N/A',
                ];
            })
            ->all();

        return view('users.faculty.dashboard', compact(
            'faculty',
            'notifications',
            'activeEvaluations',
            'assignedCourses',
            'avgRating',
            'totalResponsesCount',
            'coursesCount',
            'completionRate',
            'criteriaStats',
            'svgPoints',
            'recentComments'
        ));
    }

    public function feedback(): View
    {
        $faculty = Auth::user();

        // All courses this faculty is assigned to (for the filter dropdown)
        $courses = $faculty->courses()->get(['courses.id', 'courses.title', 'courses.code']);

        // Base query: all feedbacks for this faculty
        $feedbackQuery = Feedback::with(['course', 'answers'])
            ->where('faculty_id', $faculty->id)
            ->select('feedbacks.*');

        // Apply course filter
        $courseFilter = request('course_id');
        if ($courseFilter) {
            $feedbackQuery->where('course_id', $courseFilter);
        }

        // Subquery for overall_rating
        $feedbackQuery->addSelect([
            'overall_rating' => FeedbackAnswer::select('rating')
                ->whereColumn('feedback_id', 'feedbacks.id')
                ->where('question_id', 'overall_rating')
                ->limit(1),
        ]);

        // Apply sort
        $sort = request('sort', 'recent');
        if ($sort === 'highest') {
            $feedbackQuery->orderByDesc('overall_rating');
        } elseif ($sort === 'lowest') {
            $feedbackQuery->orderBy('overall_rating');
        } else {
            $feedbackQuery->latest();
        }

        $feedbacks = $feedbackQuery->paginate(9)->withQueryString();

        // Map answers directly to the feedback object to support existing views
        $feedbacks->getCollection()->transform(function ($fb) {
            foreach ($fb->answers as $answer) {
                if (in_array($answer->question_id, ['comments', 'what_worked_well', 'what_could_improve'])) {
                    $fb->{$answer->question_id} = $answer->text_answer;
                } else {
                    $fb->{$answer->question_id} = $answer->rating;
                }
            }

            return $fb;
        });

        // Aggregate stats across ALL feedbacks (unfiltered)
        $totalCount = Feedback::where('faculty_id', $faculty->id)->count();
        $avgRating = Feedback::where('faculty_id', $faculty->id)
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->avg('feedback_answers.rating');

        $avgRating = $avgRating ? round($avgRating, 1) : 0;

        $newCount = Feedback::where('faculty_id', $faculty->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Rating distribution for progress bar (out of 5)
        $excellentCount = Feedback::where('faculty_id', $faculty->id)
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->where('feedback_answers.rating', '>=', 4.5)
            ->count();

        $goodCount = Feedback::where('faculty_id', $faculty->id)
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->whereBetween('feedback_answers.rating', [3.5, 4.49])
            ->count();

        $distribution = [
            'excellent' => $totalCount > 0 ? round(($excellentCount / $totalCount) * 100) : 0,
            'good' => $totalCount > 0 ? round(($goodCount / $totalCount) * 100) : 0,
        ];

        return view('users.faculty.feedback', compact(
            'feedbacks',
            'courses',
            'totalCount',
            'avgRating',
            'newCount',
            'distribution',
            'courseFilter',
            'sort'
        ));
    }

    public function analytics(FacultyDashboardService $dashboardService): View
    {
        $faculty = Auth::user();

        $avgRating = $dashboardService->getAverageRating($faculty);
        $completionRate = $dashboardService->getCompletionRate($faculty);
        $totalResponses = $dashboardService->getTotalResponses($faculty);
        $coursesCount = $dashboardService->getCoursesCount($faculty);
        $criteriaStats = $dashboardService->getCriteriaStats($faculty);
        $historicalTrend = $dashboardService->getHistoricalTrend($faculty);
        $recentComments = $dashboardService->getRecentComments($faculty);

        $studentsPolled = FeedbackToken::where('faculty_id', $faculty->id)
            ->where('is_used', true)
            ->distinct('student_id')
            ->count('student_id');

        $lowestCriterion = ! empty($criteriaStats)
            ? array_keys($criteriaStats, min($criteriaStats))[0]
            : null;

        $trendPoints = $this->buildTrendPoints($historicalTrend);

        $radarPolygon = $this->buildRadarPolygon($criteriaStats);

        $trendAreaPath = '';
        $trendLinePath = '';
        if (! empty($trendPoints)) {
            $first = $trendPoints[0];
            $last = $trendPoints[count($trendPoints) - 1];
            $dArea = "M {$first['x']} {$first['y']}";
            $dLine = "M {$first['x']} {$first['y']}";
            foreach (array_slice($trendPoints, 1) as $p) {
                $dArea .= " L {$p['x']} {$p['y']}";
                $dLine .= " L {$p['x']} {$p['y']}";
            }
            $dArea .= " L {$last['x']} 220 L {$first['x']} 220 Z";
            $trendAreaPath = $dArea;
            $trendLinePath = $dLine;
        }

        $trendingUp = count($historicalTrend) >= 2
            && end($historicalTrend)['rating'] > $historicalTrend[count($historicalTrend) - 2]['rating'];

        $criterionLabels = [
            'clarity' => 'Lectures',
            'responsiveness' => 'Grading',
            'materials' => 'Labs',
            'organization' => 'Speed',
        ];

        return view('users.faculty.analytics', compact(
            'avgRating',
            'completionRate',
            'totalResponses',
            'studentsPolled',
            'coursesCount',
            'criteriaStats',
            'historicalTrend',
            'recentComments',
            'lowestCriterion',
            'trendPoints',
            'radarPolygon',
            'trendAreaPath',
            'trendLinePath',
            'trendingUp',
            'criterionLabels',
        ));
    }

    private function buildTrendPoints(array $trend): array
    {
        $numPoints = count($trend);
        $points = [];
        foreach ($trend as $idx => $t) {
            $x = $numPoints > 1 ? round(($idx / ($numPoints - 1)) * 760) : 380;
            $ratingValue = max(1, min(5, $t['rating']));
            $y = round(200 - (($ratingValue - 1) / 4) * 160);

            $points[] = [
                'x' => $x,
                'y' => $y,
                'semester' => $t['semester'],
                'rating' => $t['rating'],
            ];
        }

        return $points;
    }

    private function buildRadarPolygon(array $criteriaStats): string
    {
        if (empty($criteriaStats)) {
            return '';
        }

        $vertices = [
            ['x' => 150, 'y' => 30],
            ['x' => 258, 'y' => 108],
            ['x' => 216, 'y' => 234],
            ['x' => 84, 'y' => 234],
            ['x' => 42, 'y' => 108],
        ];

        $values = [
            $criteriaStats['clarity'] ?? 0,
            $criteriaStats['responsiveness'] ?? 0,
            $criteriaStats['materials'] ?? 0,
            $criteriaStats['organization'] ?? 0,
            array_sum($criteriaStats) / count($criteriaStats),
        ];

        $polygonPoints = '';
        foreach ($vertices as $i => $v) {
            $pct = $values[$i] / 5;
            $px = round(150 + ($v['x'] - 150) * $pct);
            $py = round(150 + ($v['y'] - 150) * $pct);
            $polygonPoints .= "$px,$py ";
        }

        return trim($polygonPoints);
    }

    public function profile(): View
    {
        return view('users.faculty.profile');
    }
}
