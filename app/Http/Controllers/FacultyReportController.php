<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;
use App\Services\FacultyDashboardService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FacultyReportController extends Controller
{
    public function __construct(
        protected FacultyDashboardService $dashboardService
    ) {}

    public function dashboardReport(): Response
    {
        $faculty = Auth::user();

        $avgRating = $this->dashboardService->getAverageRating($faculty);
        $totalResponses = $this->dashboardService->getTotalResponses($faculty);
        $coursesCount = $this->dashboardService->getCoursesCount($faculty);
        $completionRate = $this->dashboardService->getCompletionRate($faculty);
        $criteriaStats = $this->dashboardService->getCriteriaStats($faculty);
        $historicalTrend = $this->dashboardService->getHistoricalTrend($faculty);
        $recentComments = $this->dashboardService->getRecentComments($faculty);

        $pdf = Pdf::loadView('users.faculty.reports-pdf', [
            'type' => 'dashboard',
            'faculty' => $faculty,
            'avgRating' => $avgRating,
            'totalResponses' => $totalResponses,
            'coursesCount' => $coursesCount,
            'completionRate' => $completionRate,
            'criteriaStats' => $criteriaStats,
            'historicalTrend' => $historicalTrend,
            'recentComments' => $recentComments,
            'currentTerm' => currentTerm(),
        ]);

        $safeName = str_replace(' ', '_', strtolower($faculty->name));

        return $pdf->download("faculty_dashboard_report_{$safeName}_".date('Y-m-d').'.pdf');
    }

    public function feedbackExport(Request $request): StreamedResponse
    {
        $faculty = Auth::user();

        $feedbackQuery = Feedback::with(['course', 'answers'])
            ->where('faculty_id', $faculty->id)
            ->select('feedbacks.*');

        $courseFilter = $request->query('course_id');
        if ($courseFilter) {
            $feedbackQuery->where('course_id', $courseFilter);
        }

        $feedbackQuery->addSelect([
            'overall_rating' => FeedbackAnswer::select('rating')
                ->whereColumn('feedback_id', 'feedbacks.id')
                ->where('question_id', 'overall_rating')
                ->limit(1),
        ]);

        $sort = $request->query('sort', 'recent');
        if ($sort === 'highest') {
            $feedbackQuery->orderByDesc('overall_rating');
        } elseif ($sort === 'lowest') {
            $feedbackQuery->orderBy('overall_rating');
        } else {
            $feedbackQuery->latest();
        }

        $feedbacks = $feedbackQuery->get();

        $headers = ['Course Code', 'Course Title', 'Overall Rating', 'Clarity', 'Materials', 'Responsiveness', 'Fairness', 'Practical', 'Organization', 'Comments', 'What Worked Well', 'Could Improve', 'Date Submitted'];

        $filename = 'faculty_feedback_'.date('Ymd_His');

        $callback = function () use ($feedbacks, $headers) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $headers);

            foreach ($feedbacks as $fb) {
                $answers = $fb->answers->pluck('rating', 'question_id');

                fputcsv($file, [
                    $fb->course?->code ?? 'N/A',
                    $fb->course?->title ?? 'N/A',
                    $answers->get('overall_rating', ''),
                    $answers->get('clarity', ''),
                    $answers->get('materials', ''),
                    $answers->get('responsiveness', ''),
                    $answers->get('fairness', ''),
                    $answers->get('practical', ''),
                    $answers->get('organization', ''),
                    $fb->answers->firstWhere('question_id', 'comments')?->text_answer ?? '',
                    $fb->answers->firstWhere('question_id', 'what_worked_well')?->text_answer ?? '',
                    $fb->answers->firstWhere('question_id', 'what_could_improve')?->text_answer ?? '',
                    $fb->created_at ? $fb->created_at->format('Y-m-d H:i') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    public function analyticsReport(): Response
    {
        $faculty = Auth::user();

        $avgRating = $this->dashboardService->getAverageRating($faculty);
        $totalResponses = $this->dashboardService->getTotalResponses($faculty);
        $coursesCount = $this->dashboardService->getCoursesCount($faculty);
        $completionRate = $this->dashboardService->getCompletionRate($faculty);
        $criteriaStats = $this->dashboardService->getCriteriaStats($faculty);
        $historicalTrend = $this->dashboardService->getHistoricalTrend($faculty);
        $recentComments = $this->dashboardService->getRecentComments($faculty);

        $studentsPolled = FeedbackToken::where('faculty_id', $faculty->id)
            ->where('is_used', true)
            ->distinct('student_id')
            ->count('student_id');

        $totalTokens = FeedbackToken::where('faculty_id', $faculty->id)->count();

        $positiveReception = $totalTokens > 0 ? round(($studentsPolled / $totalTokens) * 100) : 0;

        $lowestCriterion = ! empty($criteriaStats)
            ? array_keys($criteriaStats, min($criteriaStats))[0]
            : null;

        $criterionLabels = [
            'clarity' => 'Lectures (Clarity)',
            'responsiveness' => 'Grading (Responsiveness)',
            'materials' => 'Labs (Materials)',
            'organization' => 'Speed (Organization)',
        ];

        $pdf = Pdf::loadView('users.faculty.reports-pdf', [
            'type' => 'analytics',
            'faculty' => $faculty,
            'avgRating' => $avgRating,
            'totalResponses' => $totalResponses,
            'coursesCount' => $coursesCount,
            'completionRate' => $completionRate,
            'criteriaStats' => $criteriaStats,
            'historicalTrend' => $historicalTrend,
            'recentComments' => $recentComments,
            'currentTerm' => currentTerm(),
            'studentsPolled' => $studentsPolled,
            'totalTokens' => $totalTokens,
            'positiveReception' => $positiveReception,
            'lowestCriterion' => $lowestCriterion,
            'criterionLabels' => $criterionLabels,
        ]);

        $safeName = str_replace(' ', '_', strtolower($faculty->name));

        return $pdf->download("faculty_full_dossier_{$safeName}_".date('Y-m-d').'.pdf');
    }
}
