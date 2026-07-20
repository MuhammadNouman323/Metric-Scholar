<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation Reports - {{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.5;
            padding: 20px;
            margin: 0;
        }
        .header {
            border-bottom: 2px solid #0e48c1;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0e48c1;
            font-size: 20px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header .meta {
            font-size: 10px;
            color: #64748b;
            font-weight: bold;
        }
        .filters-summary {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 25px;
        }
        .filters-summary h2 {
            font-size: 11px;
            text-transform: uppercase;
            color: #475569;
            margin: 0 0 5px 0;
        }
        .filters-summary p {
            margin: 0;
            font-size: 10px;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .grade-badge {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            text-transform: uppercase;
        }
        .italic {
            font-style: italic;
        }
        .page-break {
            page-break-before: always;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
            .filters-summary {
                background-color: #ffffff;
            }
            th {
                background-color: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Faculty Evaluation System</h1>
        <div class="meta">
            REPORT TYPE: {{ strtoupper($title) }} | GENERATED AT: {{ date('Y-m-d H:i:s') }}
        </div>
    </div>

    <!-- Active Filters Summary -->
    <div class="filters-summary">
        <h2>Report Scope & Filters</h2>
        <p>
            @php
                $active = [];
                if (!empty($filters['evaluation_id'])) {
                    $active[] = 'Evaluation ID: ' . $filters['evaluation_id'];
                }
                if (!empty($filters['semester'])) {
                    $active[] = 'Semester: ' . $filters['semester'];
                }
                if (!empty($filters['department'])) {
                    $active[] = 'Department: ' . $filters['department'];
                }
                if (!empty($filters['faculty_id'])) {
                    $active[] = 'Faculty ID: ' . $filters['faculty_id'];
                }
                if (!empty($filters['course_id'])) {
                    $active[] = 'Course ID: ' . $filters['course_id'];
                }
                if (!empty($filters['status'])) {
                    $active[] = 'Status: ' . $filters['status'];
                }
                if (!empty($filters['search'])) {
                    $active[] = 'Search: "' . $filters['search'] . '"';
                }
            @endphp
            Filters Applied: {{ empty($active) ? 'None (All Records)' : implode(' | ', $active) }}
        </p>
    </div>

    <!-- Report Table Data -->
    @if ($tab === 'faculty')
        <table>
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Department</th>
                    <th class="text-center">Average Rating</th>
                    <th class="text-center">Total Feedback</th>
                    <th class="text-center">Performance Score</th>
                    <th class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td class="font-bold">{{ $row['name'] }}</td>
                        <td>{{ $row['department'] }}</td>
                        <td class="text-center font-bold">{{ $row['avg_rating'] }} / 5.0</td>
                        <td class="text-center">{{ $row['total_feedback'] }}</td>
                        <td class="text-center font-bold">{{ $row['performance_score'] }}%</td>
                        <td class="text-center">{{ $row['grade'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No faculty performance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'course')
        <table>
            <thead>
                <tr>
                    <th>Course Code & Title</th>
                    <th>Faculty Member</th>
                    <th class="text-center">Enrolled Students</th>
                    <th class="text-center">Feedback Submitted</th>
                    <th class="text-center">Average Rating</th>
                    <th class="text-center">Completion Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td><span class="font-bold">{{ $row['code'] }}</span> - {{ $row['title'] }}</td>
                        <td class="font-bold">{{ $row['faculty_name'] }}</td>
                        <td class="text-center">{{ $row['total_students'] }}</td>
                        <td class="text-center">{{ $row['feedback_submitted'] }}</td>
                        <td class="text-center font-bold">{{ $row['avg_rating'] }} / 5.0</td>
                        <td class="text-center font-bold">{{ $row['completion_percentage'] }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No course records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'department')
        <table>
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th class="text-center">Number of Faculty</th>
                    <th class="text-center">Average Rating</th>
                    <th>Best Performing Faculty</th>
                    <th>Lowest Performing Faculty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td class="font-bold">{{ $row['department_name'] }}</td>
                        <td class="text-center">{{ $row['number_of_faculty'] }}</td>
                        <td class="text-center font-bold">{{ $row['avg_rating'] }} / 5.0</td>
                        <td class="font-bold" style="color: #16a34a;">{{ $row['best_faculty'] }}</td>
                        <td class="font-bold" style="color: #dc2626;">{{ $row['worst_faculty'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No department records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'evaluation')
        <table>
            <thead>
                <tr>
                    <th>Evaluation Cycle</th>
                    <th>Semester</th>
                    <th class="text-center">Start Date</th>
                    <th class="text-center">End Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Eligible Students</th>
                    <th class="text-center">Submitted Feedback</th>
                    <th class="text-center">Pending Feedback</th>
                    <th class="text-center">Completion Rate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td class="font-bold">{{ $row['title'] }}</td>
                        <td>{{ $row['semester'] }}</td>
                        <td class="text-center">{{ $row['start_date'] }}</td>
                        <td class="text-center">{{ $row['end_date'] }}</td>
                        <td class="text-center font-bold">{{ $row['status'] }}</td>
                        <td class="text-center">{{ $row['total_eligible_students'] }}</td>
                        <td class="text-center">{{ $row['submitted_feedback'] }}</td>
                        <td class="text-center">{{ $row['pending_feedback'] }}</td>
                        <td class="text-center font-bold">{{ $row['completion_percentage'] }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No evaluation cycles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'questions')
        <table>
            <thead>
                <tr>
                    <th>Evaluation Question</th>
                    <th class="text-center">Average Rating</th>
                    <th class="text-center">Excellent (5★)</th>
                    <th class="text-center">Very Good (4★)</th>
                    <th class="text-center">Good (3★)</th>
                    <th class="text-center">Fair (2★)</th>
                    <th class="text-center">Poor (1★)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $row)
                    <tr>
                        <td class="font-bold">{{ $row['question'] }}</td>
                        <td class="text-center font-bold">{{ $row['avg_rating'] }} / 5.0</td>
                        <td class="text-center">{{ $row['excellent_pct'] }}%</td>
                        <td class="text-center">{{ $row['very_good_pct'] }}%</td>
                        <td class="text-center">{{ $row['good_pct'] }}%</td>
                        <td class="text-center">{{ $row['fair_pct'] }}%</td>
                        <td class="text-center">{{ $row['poor_pct'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif ($tab === 'comments')
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Context Details</th>
                    <th>Anonymous Feedback Comments (AI Moderated & Approved)</th>
                    <th style="width: 15%;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td>
                            <div class="font-bold">{{ $row->feedback->course->code ?? 'N/A' }}</div>
                            <div class="font-bold" style="color: #0e48c1;">{{ $row->feedback->faculty->name ?? 'N/A' }}</div>
                            <div style="font-size: 9px; color: #64748b;">{{ $row->feedback->evaluation->title ?? 'N/A' }}</div>
                        </td>
                        <td class="italic">"{{ $row->text_answer }}"</td>
                        <td>{{ $row->created_at ? $row->created_at->format('Y-m-d H:i') : '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No approved anonymous comments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @elseif ($tab === 'moderation')
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Context Details</th>
                    <th>Comments (Original / Cleaned)</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Toxicity</th>
                    <th>Moderation Analysis & Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                    <tr>
                        <td>
                            <div class="font-bold">{{ $row->feedback->course->code ?? 'N/A' }}</div>
                            <div class="font-bold" style="color: #0e48c1;">{{ $row->feedback->faculty->name ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div style="color: #64748b; margin-bottom: 4px;"><span class="font-bold">Original:</span> "{{ $row->original_comment }}"</div>
                            @if($row->cleaned_comment && $row->cleaned_comment !== $row->original_comment)
                                <div style="color: #16a34a; font-weight: bold;"><span class="font-bold">Cleaned:</span> "{{ $row->cleaned_comment }}"</div>
                            @endif
                        </td>
                        <td class="text-center font-bold" style="text-transform: uppercase;">{{ $row->moderation_status }}</td>
                        <td class="text-center font-bold">{{ $row->toxicity_score }}</td>
                        <td>
                            <div><span class="font-bold">Reason:</span> {{ $row->moderation_reason ?: 'None' }}</div>
                            <div><span class="font-bold">Flags:</span> 
                                @if(is_array($row->moderation_categories) && !empty($row->moderation_categories))
                                    {{ implode(', ', $row->moderation_categories) }}
                                @else
                                    None
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No moderation logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <script>
        // Auto trigger browser print window after page loads
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
