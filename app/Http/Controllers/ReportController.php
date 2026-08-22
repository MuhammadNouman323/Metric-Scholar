<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\User;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    protected array $validFilters = [
        'evaluation_id', 'semester', 'department', 'faculty_id',
        'course_id', 'start_date', 'end_date', 'status', 'search', 'sort',
    ];

    public function __construct(
        protected ReportService $reportService
    ) {}

    public function index(Request $request): View
    {
        $filters = $this->extractFilters($request);
        $tab = $request->query('tab', 'summary');

        $stats = $this->reportService->getSummaryStats($filters);
        $chartData = $this->reportService->getChartData($filters);
        $reportData = $this->resolveReport($tab, $filters);

        $dropdowns = $this->loadDropdownOptions();

        return view('users.admin.reports', array_merge(
            compact('stats', 'chartData', 'reportData', 'tab', 'filters'),
            $dropdowns
        ));
    }

    public function print(Request $request): View
    {
        $filters = $this->extractFilters($request);
        $tab = $request->query('tab', 'summary');

        $result = $this->resolveReportForPrint($tab, $filters);

        return view('users.admin.reports-print', [
            'reportData' => $result['data'],
            'tab' => $tab,
            'title' => $result['title'],
            'filters' => $filters,
        ]);
    }

    public function generatePdf(): Response
    {
        $tenantId = auth()->user()->university_id;

        $studentCount = User::where('university_id', $tenantId)->where('role', Role::Student)->count();
        $facultyCount = User::where('university_id', $tenantId)->where('role', Role::Faculty)->count();
        $courseCount = Course::where('university_id', $tenantId)->count();
        $feedbackCount = Feedback::whereHas('faculty', fn ($q) => $q->where('university_id', $tenantId))->count();

        $ratingQuery = FeedbackAnswer::where('question_id', 'overall_rating')
            ->whereHas('feedback.faculty', fn ($q) => $q->where('university_id', $tenantId));

        $totalRatings = $ratingQuery->count();

        if ($totalRatings > 0) {
            $avgRating = round($ratingQuery->avg('rating'), 1);
            $excellent = (clone $ratingQuery)->where('rating', '>=', 4.5)->count();
            $good = (clone $ratingQuery)->whereBetween('rating', [3.5, 4.49])->count();
            $others = (clone $ratingQuery)->where('rating', '<', 3.5)->count();
            $excellentPct = round(($excellent / $totalRatings) * 100);
            $goodPct = round(($good / $totalRatings) * 100);
            $othersPct = 100 - $excellentPct - $goodPct;
        } else {
            $avgRating = 0;
            $excellentPct = 0;
            $goodPct = 0;
            $othersPct = 100;
        }

        $ratingChart = [
            'avgRating' => $avgRating,
            'excellentPct' => $excellentPct,
            'goodPct' => $goodPct,
            'othersPct' => $othersPct,
        ];

        $departments = User::where('university_id', $tenantId)
            ->where('role', Role::Faculty)
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $departmentPerformance = collect();
        foreach ($departments as $dept) {
            $avg = Feedback::whereHas('faculty', fn ($q) => $q->where('department', $dept)->where('university_id', $tenantId))
                ->join('feedback_answers', 'feedbacks.id', '=', 'feedback_answers.feedback_id')
                ->where('feedback_answers.question_id', 'overall_rating')
                ->avg('feedback_answers.rating');

            $score = $avg ? round(($avg / 5) * 100) : 0;

            $departmentPerformance->push([
                'name' => $dept,
                'score' => $score,
                'avg_rating' => $avg ? round($avg, 1) : 0,
            ]);
        }

        $departmentPerformance = $departmentPerformance->sortByDesc('score')->values();

        $pdf = Pdf::loadView('users.admin.reports-pdf', [
            'studentCount' => $studentCount,
            'facultyCount' => $facultyCount,
            'courseCount' => $courseCount,
            'feedbackCount' => $feedbackCount,
            'ratingChart' => $ratingChart,
            'departmentPerformance' => $departmentPerformance,
            'currentTerm' => currentTerm(),
        ]);

        return $pdf->download('institutional_overview_report_'.date('Y-m-d').'.pdf');
    }

    public function export(Request $request, string $format): Response|StreamedResponse
    {
        $filters = $this->extractFilters($request);
        $tab = $request->query('tab', 'faculty');

        $result = $this->resolveReportForExport($tab, $filters);

        $filename = "{$tab}_report_".date('Ymd_His');

        if (strtolower($format) === 'csv') {
            return $this->exportCsv($filename, $result['headers'], $result['data'], $tab);
        } elseif (strtolower($format) === 'excel') {
            return $this->exportExcel($filename, $result['headers'], $result['data'], $tab);
        }

        abort(404, 'Unknown export format requested.');
    }

    protected function extractFilters(Request $request): array
    {
        return $request->only($this->validFilters);
    }

    protected function resolveReport(string $tab, array $filters): mixed
    {
        return match ($tab) {
            'faculty' => $this->reportService->getFacultyPerformanceReport($filters),
            'course' => $this->reportService->getCourseReport($filters),
            'department' => $this->reportService->getDepartmentReport($filters),
            'evaluation' => $this->reportService->getEvaluationReport($filters),
            'questions' => $this->reportService->getQuestionAnalysisReport($filters),
            'comments' => $this->reportService->getAnonymousCommentsReport($filters),
            'moderation' => $this->reportService->getAIModerationReport($filters),
            default => null,
        };
    }

    protected function resolveReportForPrint(string $tab, array $filters): array
    {
        $titles = [
            'faculty' => 'Faculty Performance Report',
            'course' => 'Course Performance Report',
            'department' => 'Department Performance Report',
            'evaluation' => 'Evaluation Cycles Report',
            'questions' => 'Question Analysis Report',
            'comments' => 'Anonymous Feedback Comments Report',
            'moderation' => 'AI Content Moderation Log',
        ];

        $printFilters = in_array($tab, ['comments', 'moderation'])
            ? array_merge($filters, ['per_page' => 1000])
            : $filters;

        return [
            'data' => $this->resolveReport($tab, $printFilters),
            'title' => $titles[$tab] ?? 'Report',
        ];
    }

    protected function resolveReportForExport(string $tab, array $filters): array
    {
        $config = [
            'faculty' => [
                'headers' => ['Faculty Name', 'Department', 'Average Rating', 'Total Feedback Received', 'Performance Score (%)', 'Overall Grade'],
            ],
            'course' => [
                'headers' => ['Course Name', 'Faculty', 'Total Students', 'Feedback Submitted', 'Average Rating', 'Completion Percentage (%)'],
            ],
            'department' => [
                'headers' => ['Department Name', 'Number of Faculty', 'Average Rating', 'Best Performing Faculty', 'Lowest Performing Faculty'],
            ],
            'evaluation' => [
                'headers' => ['Evaluation Name', 'Semester', 'Start Date', 'End Date', 'Status', 'Total Eligible Students', 'Submitted Feedback', 'Pending Feedback', 'Completion Percentage (%)'],
            ],
            'questions' => [
                'headers' => ['Question', 'Average Rating', 'Excellent %', 'Very Good %', 'Good %', 'Fair %', 'Poor %'],
            ],
            'comments' => [
                'headers' => ['Course', 'Faculty', 'Evaluation', 'Anonymous Comment', 'Date Submitted'],
            ],
            'moderation' => [
                'headers' => ['Comment Context (Course/Faculty)', 'Original Comment', 'Cleaned Comment', 'Status', 'Toxicity Score', 'Flags/Categories', 'Reason', 'Moderated At'],
            ],
        ];

        if (! isset($config[$tab])) {
            abort(400, 'Invalid report tab specified.');
        }

        $exportFilters = in_array($tab, ['comments', 'moderation'])
            ? array_merge($filters, ['per_page' => 1000])
            : $filters;

        $data = $this->resolveReport($tab, $exportFilters);

        if (in_array($tab, ['comments', 'moderation'])) {
            $data = $data->items();
        }

        return [
            'data' => $data,
            'headers' => $config[$tab]['headers'],
        ];
    }

    protected function loadDropdownOptions(): array
    {
        $tenantId = auth()->user()->university_id ?? null;

        $evaluationsQuery = Evaluation::query();
        $facultyQuery = User::where('role', Role::Faculty);

        if ($tenantId) {
            $evaluationsQuery->whereHas('creator', function ($q) use ($tenantId) {
                $q->where('university_id', $tenantId);
            });
            $facultyQuery->where('university_id', $tenantId);
        }

        $evaluations = $evaluationsQuery->select('id', 'title')->get();
        $semesters = Evaluation::distinct()->pluck('semester');

        $departments = User::whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct();
        if ($tenantId) {
            $departments->where('university_id', $tenantId);
        }
        $departments = $departments->pluck('department');

        $faculties = $facultyQuery->select('id', 'name')->get();
        $courses = Course::where('university_id', $tenantId)->select('id', 'code', 'title')->get();
        $statuses = ['draft', 'scheduled', 'active', 'closed', 'archived'];

        return compact('evaluations', 'semesters', 'departments', 'faculties', 'courses', 'statuses');
    }

    protected function exportCsv(string $filename, array $headers, mixed $data, string $tab): StreamedResponse
    {
        $callback = function () use ($headers, $data, $tab) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $headers);

            foreach ($data as $item) {
                fputcsv($file, $this->formatRowForExport($item, $tab));
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

    protected function exportExcel(string $filename, array $headers, mixed $data, string $tab): Response
    {
        $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $output .= '<head><meta http-equiv="Content-type" content="text/html;charset=utf-8" /></head>';
        $output .= '<body><table border="1">';

        $output .= '<tr>';
        foreach ($headers as $header) {
            $output .= '<th style="background-color: #0e48c1; color: #ffffff; font-weight: bold;">'.htmlspecialchars($header).'</th>';
        }
        $output .= '</tr>';

        foreach ($data as $item) {
            $output .= '<tr>';
            $formattedRow = $this->formatRowForExport($item, $tab);
            foreach ($formattedRow as $cell) {
                $output .= '<td>'.htmlspecialchars((string) $cell).'</td>';
            }
            $output .= '</tr>';
        }

        $output .= '</table></body></html>';

        return response($output, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.xls\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    protected function formatRowForExport(mixed $item, string $tab): array
    {
        $arr = is_array($item) ? $item : $item->toArray();

        return match ($tab) {
            'faculty' => [
                $arr['name'] ?? '',
                $arr['department'] ?? '',
                $arr['avg_rating'] ?? 0.00,
                $arr['total_feedback'] ?? 0,
                $arr['performance_score'] ?? 0.0,
                $arr['grade'] ?? '',
            ],
            'course' => [
                ($arr['code'] ?? '').' - '.($arr['title'] ?? ''),
                $arr['faculty_name'] ?? '',
                $arr['total_students'] ?? 0,
                $arr['feedback_submitted'] ?? 0,
                $arr['avg_rating'] ?? 0.00,
                $arr['completion_percentage'] ?? 0.0,
            ],
            'department' => [
                $arr['department_name'] ?? '',
                $arr['number_of_faculty'] ?? 0,
                $arr['avg_rating'] ?? 0.00,
                $arr['best_faculty'] ?? '',
                $arr['worst_faculty'] ?? '',
            ],
            'evaluation' => [
                $arr['title'] ?? '',
                $arr['semester'] ?? '',
                $arr['start_date'] ?? '',
                $arr['end_date'] ?? '',
                $arr['status'] ?? '',
                $arr['total_eligible_students'] ?? 0,
                $arr['submitted_feedback'] ?? 0,
                $arr['pending_feedback'] ?? 0,
                $arr['completion_percentage'] ?? 0.0,
            ],
            'questions' => [
                $arr['question'] ?? '',
                $arr['avg_rating'] ?? 0.00,
                ($arr['excellent_pct'] ?? 0.0).'%',
                ($arr['very_good_pct'] ?? 0.0).'%',
                ($arr['good_pct'] ?? 0.0).'%',
                ($arr['fair_pct'] ?? 0.0).'%',
                ($arr['poor_pct'] ?? 0.0).'%',
            ],
            'comments' => [
                ($item->feedback->course->code ?? '').' - '.($item->feedback->course->title ?? ''),
                $item->feedback->faculty->name ?? 'N/A',
                $item->feedback->evaluation->title ?? 'N/A',
                $item->text_answer ?? '',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '',
            ],
            'moderation' => [
                ($item->feedback->course->code ?? 'N/A').' / '.($item->feedback->faculty->name ?? 'N/A'),
                $item->original_comment ?? '',
                $item->cleaned_comment ?? '',
                $item->moderation_status ?? '',
                $item->toxicity_score ?? 0,
                is_array($item->moderation_categories) ? implode(', ', $item->moderation_categories) : (string) ($item->moderation_categories ?: 'None'),
                $item->moderation_reason ?? '',
                $item->moderated_at ? $item->moderated_at->format('Y-m-d H:i') : '',
            ],
            default => [],
        };
    }
}
