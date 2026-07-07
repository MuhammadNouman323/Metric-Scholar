<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    public function dashboard()
    {
        return view('users.faculty.dashboard');
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
