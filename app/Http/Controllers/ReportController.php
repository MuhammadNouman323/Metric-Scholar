<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * Display the reports page.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'evaluation_id',
            'semester',
            'department',
            'faculty_id',
            'course_id',
            'start_date',
            'end_date',
            'status',
            'academic_year',
            'search',
            'sort',
        ]);

        $tab = $request->query('tab', 'summary');

        // Statistics Summary Cards
        $stats = $this->reportService->getSummaryStats($filters);

        // Chart Data
        $chartData = $this->reportService->getChartData($filters);

        // Dropdown options for filter panels
        $tenantId = auth()->user()->university_id ?? null;

        $evaluationsQuery = Evaluation::query();
        $facultyQuery = User::where('role', 'faculty');
        $courseQuery = Course::query();

        if ($tenantId) {
            $evaluationsQuery->where('created_by', function ($q) use ($tenantId) {
                $q->select('id')->from('users')->where('university_id', $tenantId)->limit(1);
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
        $courses = $courseQuery->select('id', 'code', 'title')->get();
        $statuses = ['draft', 'scheduled', 'active', 'closed', 'archived'];

        // Get report data depending on the selected tab
        $reportData = null;
        switch ($tab) {
            case 'faculty':
                $reportData = $this->reportService->getFacultyPerformanceReport($filters);
                break;
            case 'course':
                $reportData = $this->reportService->getCourseReport($filters);
                break;
            case 'department':
                $reportData = $this->reportService->getDepartmentReport($filters);
                break;
            case 'evaluation':
                $reportData = $this->reportService->getEvaluationReport($filters);
                break;
            case 'questions':
                $reportData = $this->reportService->getQuestionAnalysisReport($filters);
                break;
            case 'comments':
                $reportData = $this->reportService->getAnonymousCommentsReport($filters);
                break;
            case 'moderation':
                $reportData = $this->reportService->getAIModerationReport($filters);
                break;
        }

        return view('users.admin.reports', compact(
            'stats',
            'chartData',
            'evaluations',
            'semesters',
            'departments',
            'faculties',
            'courses',
            'statuses',
            'reportData',
            'tab',
            'filters'
        ));
    }

    /**
     * Render the report optimized for printing (PDF fallback).
     */
    public function print(Request $request)
    {
        $filters = $request->only([
            'evaluation_id',
            'semester',
            'department',
            'faculty_id',
            'course_id',
            'start_date',
            'end_date',
            'status',
            'academic_year',
            'search',
            'sort',
        ]);

        $tab = $request->query('tab', 'summary');

        $reportData = null;
        $title = 'Report';

        switch ($tab) {
            case 'faculty':
                $reportData = $this->reportService->getFacultyPerformanceReport($filters);
                $title = 'Faculty Performance Report';
                break;
            case 'course':
                $reportData = $this->reportService->getCourseReport($filters);
                $title = 'Course Performance Report';
                break;
            case 'department':
                $reportData = $this->reportService->getDepartmentReport($filters);
                $title = 'Department Performance Report';
                break;
            case 'evaluation':
                $reportData = $this->reportService->getEvaluationReport($filters);
                $title = 'Evaluation Cycles Report';
                break;
            case 'questions':
                $reportData = $this->reportService->getQuestionAnalysisReport($filters);
                $title = 'Question Analysis Report';
                break;
            case 'comments':
                $reportData = $this->reportService->getAnonymousCommentsReport(array_merge($filters, ['per_page' => 1000]));
                $title = 'Anonymous Feedback Comments Report';
                break;
            case 'moderation':
                $reportData = $this->reportService->getAIModerationReport(array_merge($filters, ['per_page' => 1000]));
                $title = 'AI Content Moderation Log';
                break;
        }

        return view('users.admin.reports-print', compact('reportData', 'tab', 'title', 'filters'));
    }

    /**
     * Export reports to CSV or Excel.
     */
    public function export(Request $request, string $format)
    {
        $filters = $request->only([
            'evaluation_id',
            'semester',
            'department',
            'faculty_id',
            'course_id',
            'start_date',
            'end_date',
            'status',
            'academic_year',
            'search',
            'sort',
        ]);

        $tab = $request->query('tab', 'faculty');
        $data = null;
        $headers = [];

        // Load data based on tab
        switch ($tab) {
            case 'faculty':
                $data = $this->reportService->getFacultyPerformanceReport($filters);
                $headers = ['Faculty Name', 'Department', 'Average Rating', 'Total Feedback Received', 'Performance Score (%)', 'Overall Grade'];
                break;
            case 'course':
                $data = $this->reportService->getCourseReport($filters);
                $headers = ['Course Name', 'Faculty', 'Total Students', 'Feedback Submitted', 'Average Rating', 'Completion Percentage (%)'];
                break;
            case 'department':
                $data = $this->reportService->getDepartmentReport($filters);
                $headers = ['Department Name', 'Number of Faculty', 'Average Rating', 'Best Performing Faculty', 'Lowest Performing Faculty'];
                break;
            case 'evaluation':
                $data = $this->reportService->getEvaluationReport($filters);
                $headers = ['Evaluation Name', 'Semester', 'Start Date', 'End Date', 'Status', 'Total Eligible Students', 'Submitted Feedback', 'Pending Feedback', 'Completion Percentage (%)'];
                break;
            case 'questions':
                $data = $this->reportService->getQuestionAnalysisReport($filters);
                $headers = ['Question', 'Average Rating', 'Excellent %', 'Very Good %', 'Good %', 'Fair %', 'Poor %'];
                break;
            case 'comments':
                // For exports, load comments without pagination limit
                $data = $this->reportService->getAnonymousCommentsReport(array_merge($filters, ['per_page' => 1000]))->items();
                $headers = ['Course', 'Faculty', 'Evaluation', 'Anonymous Comment', 'Date Submitted'];
                break;
            case 'moderation':
                // For exports, load moderation logs without pagination limit
                $data = $this->reportService->getAIModerationReport(array_merge($filters, ['per_page' => 1000]))->items();
                $headers = ['Comment Context (Course/Faculty)', 'Original Comment', 'Cleaned Comment', 'Status', 'Toxicity Score', 'Flags/Categories', 'Reason', 'Moderated At'];
                break;
            default:
                abort(400, 'Invalid report tab specified.');
        }

        $filename = "{$tab}_report_".date('Ymd_His');

        if (strtolower($format) === 'csv') {
            return $this->exportCsv($filename, $headers, $data, $tab);
        } elseif (strtolower($format) === 'excel') {
            return $this->exportExcel($filename, $headers, $data, $tab);
        }

        abort(404, 'Unknown export format requested.');
    }

    /**
     * Generate and stream a standard CSV file.
     */
    protected function exportCsv(string $filename, array $headers, $data, string $tab)
    {
        $callback = function () use ($headers, $data, $tab) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for MS Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write column headers
            fputcsv($file, $headers);

            // Write row data
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

    /**
     * Stream an Excel-compatible HTML format file.
     */
    protected function exportExcel(string $filename, array $headers, $data, string $tab)
    {
        $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $output .= '<head><meta http-equiv="Content-type" content="text/html;charset=utf-8" /></head>';
        $output .= '<body><table border="1">';

        // Header
        $output .= '<tr>';
        foreach ($headers as $header) {
            $output .= '<th style="background-color: #0e48c1; color: #ffffff; font-weight: bold;">'.htmlspecialchars($header).'</th>';
        }
        $output .= '</tr>';

        // Rows
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

    /**
     * Helper to map objects/arrays to a flat list for exporting.
     */
    protected function formatRowForExport($item, string $tab): array
    {
        $arr = is_array($item) ? $item : $item->toArray();

        switch ($tab) {
            case 'faculty':
                return [
                    $arr['name'] ?? '',
                    $arr['department'] ?? '',
                    $arr['avg_rating'] ?? 0.00,
                    $arr['total_feedback'] ?? 0,
                    $arr['performance_score'] ?? 0.0,
                    $arr['grade'] ?? '',
                ];
            case 'course':
                return [
                    ($arr['code'] ?? '').' - '.($arr['title'] ?? ''),
                    $arr['faculty_name'] ?? '',
                    $arr['total_students'] ?? 0,
                    $arr['feedback_submitted'] ?? 0,
                    $arr['avg_rating'] ?? 0.00,
                    $arr['completion_percentage'] ?? 0.0,
                ];
            case 'department':
                return [
                    $arr['department_name'] ?? '',
                    $arr['number_of_faculty'] ?? 0,
                    $arr['avg_rating'] ?? 0.00,
                    $arr['best_faculty'] ?? '',
                    $arr['worst_faculty'] ?? '',
                ];
            case 'evaluation':
                return [
                    $arr['title'] ?? '',
                    $arr['semester'] ?? '',
                    $arr['start_date'] ?? '',
                    $arr['end_date'] ?? '',
                    $arr['status'] ?? '',
                    $arr['total_eligible_students'] ?? 0,
                    $arr['submitted_feedback'] ?? 0,
                    $arr['pending_feedback'] ?? 0,
                    $arr['completion_percentage'] ?? 0.0,
                ];
            case 'questions':
                return [
                    $arr['question'] ?? '',
                    $arr['avg_rating'] ?? 0.00,
                    ($arr['excellent_pct'] ?? 0.0).'%',
                    ($arr['very_good_pct'] ?? 0.0).'%',
                    ($arr['good_pct'] ?? 0.0).'%',
                    ($arr['fair_pct'] ?? 0.0).'%',
                    ($arr['poor_pct'] ?? 0.0).'%',
                ];
            case 'comments':
                return [
                    ($item->feedback->course->code ?? '').' - '.($item->feedback->course->title ?? ''),
                    $item->feedback->faculty->name ?? 'N/A',
                    $item->feedback->evaluation->title ?? 'N/A',
                    $item->text_answer ?? '',
                    $item->created_at ? $item->created_at->format('Y-m-d H:i') : '',
                ];
            case 'moderation':
                $categories = $item->moderation_categories;
                $categoryString = is_array($categories) ? implode(', ', $categories) : (string) $categories;

                return [
                    ($item->feedback->course->code ?? 'N/A').' / '.($item->feedback->faculty->name ?? 'N/A'),
                    $item->original_comment ?? '',
                    $item->cleaned_comment ?? '',
                    $item->moderation_status ?? '',
                    $item->toxicity_score ?? 0,
                    $categoryString ?: 'None',
                    $item->moderation_reason ?? '',
                    $item->moderated_at ? $item->moderated_at->format('Y-m-d H:i') : '',
                ];
        }

        return [];
    }
}
