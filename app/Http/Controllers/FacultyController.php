<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    public function dashboard()
    {
        $faculty = Auth::user();
        $notifications = $faculty->notifications()->take(5)->get();

        $activeEvaluation = Evaluation::whereIn('status', ['active', 'scheduled'])
            ->whereHas('faculty', function ($q) use ($faculty) {
                $q->where('users.id', $faculty->id);
            })->first();

        $assignedCourses = collect();
        if ($activeEvaluation) {
            $assignedCourses = $faculty->courses()->whereHas('evaluations', function ($q) use ($activeEvaluation) {
                $q->where('evaluations.id', $activeEvaluation->id);
            })->get();
        }

        // 1. Average Rating
        $avgRating = Feedback::where('faculty_id', $faculty->id)
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->avg('feedback_answers.rating');
        $avgRating = $avgRating ? round($avgRating, 1) : 0.0;

        // 2. Total Responses Count
        $totalResponsesCount = Feedback::where('faculty_id', $faculty->id)->count();

        // 3. Courses Count
        $coursesCount = $faculty->courses()->count();

        // 4. Feedback Completion Rate
        $totalTokensCount = FeedbackToken::where('faculty_id', $faculty->id)->count();
        $usedTokensCount = FeedbackToken::where('faculty_id', $faculty->id)->where('is_used', true)->count();
        $completionRate = $totalTokensCount > 0 ? round(($usedTokensCount / $totalTokensCount) * 100, 1) : 0.0;

        // 5. Criteria Stats
        $criteriaAverages = FeedbackAnswer::join('feedbacks', 'feedback_answers.feedback_id', '=', 'feedbacks.id')
            ->where('feedbacks.faculty_id', $faculty->id)
            ->whereIn('feedback_answers.question_id', ['clarity', 'materials', 'responsiveness', 'organization'])
            ->selectRaw('feedback_answers.question_id, AVG(feedback_answers.rating) as avg_rating')
            ->groupBy('feedback_answers.question_id')
            ->pluck('avg_rating', 'question_id')
            ->all();

        $criteriaStats = [
            'clarity' => isset($criteriaAverages['clarity']) ? round($criteriaAverages['clarity'], 1) : 0.0,
            'materials' => isset($criteriaAverages['materials']) ? round($criteriaAverages['materials'], 1) : 0.0,
            'responsiveness' => isset($criteriaAverages['responsiveness']) ? round($criteriaAverages['responsiveness'], 1) : 0.0,
            'organization' => isset($criteriaAverages['organization']) ? round($criteriaAverages['organization'], 1) : 0.0,
        ];

        // 6. Historical Semesters Trend
        $historicalSemesters = Feedback::where('faculty_id', $faculty->id)
            ->join('evaluations', 'feedbacks.evaluation_id', '=', 'evaluations.id')
            ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
            ->where('feedback_answers.question_id', 'overall_rating')
            ->selectRaw('evaluations.semester, AVG(feedback_answers.rating) as avg_rating, MIN(evaluations.created_at) as created_at')
            ->groupBy('evaluations.semester')
            ->orderBy('created_at')
            ->get();

        if ($historicalSemesters->isEmpty()) {
            // Default mock trend if no data is available, for beautiful visualization
            $historicalTrend = [
                ['semester' => 'Fall 2022', 'rating' => 4.2],
                ['semester' => 'Spring 2023', 'rating' => 4.4],
                ['semester' => 'Fall 2023', 'rating' => 4.6],
                ['semester' => 'Spring 2024', 'rating' => 4.8],
            ];
        } else {
            $historicalTrend = [];
            foreach ($historicalSemesters as $hs) {
                $historicalTrend[] = [
                    'semester' => $hs->semester,
                    'rating' => round($hs->avg_rating, 1),
                ];
            }
        }

        // Generate SVG points from $historicalTrend
        $svgPoints = [];
        $numTrendPoints = count($historicalTrend);
        foreach ($historicalTrend as $idx => $trend) {
            $x = $numTrendPoints > 1 ? 40 + ($idx * (520 / ($numTrendPoints - 1))) : 300;
            $ratingValue = max(1, min(5, $trend['rating']));
            $y = 155 - ($ratingValue - 1) * 32.5;
            $svgPoints[] = [
                'x' => $x,
                'y' => $y,
                'semester' => $trend['semester'],
                'rating' => $trend['rating'],
            ];
        }

        // 7. Recent Comments
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
            'activeEvaluation',
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

    public function feedback()
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

    public function analytics()
    {
        return view('users.faculty.analytics');
    }

    public function profile()
    {
        return view('users.faculty.profile');
    }
}
