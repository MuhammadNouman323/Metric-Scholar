<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $type === 'analytics' ? 'Faculty Full Dossier' : 'Faculty Dashboard Report' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
        }
        .page { padding: 25px 30px; }
        .header {
            border-bottom: 3px solid #0e48c1;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0e48c1;
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .header .subtitle {
            color: #475569;
            font-size: 10px;
            font-weight: 600;
        }
        .header .meta {
            color: #94a3b8;
            font-size: 9px;
            font-weight: bold;
            margin-top: 4px;
        }
        .section-title {
            color: #0e48c1;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            margin-top: 20px;
            padding-bottom: 5px;
            border-bottom: 1.5px solid #e2e8f0;
        }

        /* Stats Grid */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-row {
            display: table-row;
        }
        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 8px 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .stat-card .label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .stat-card .value {
            font-size: 20px;
            font-weight: 800;
            color: #0e48c1;
        }
        .stat-card .value.green { color: #16a34a; }
        .stat-card .value.amber { color: #d97706; }
        .stat-card .value.default { color: #1e293b; }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        td { color: #475569; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-blue { color: #0e48c1; }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }

        /* Grade badges */
        .grade {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            text-transform: uppercase;
        }

        /* Rating bar */
        .bar-container {
            width: 80px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 4px;
        }
        .bar-fill {
            height: 100%;
            background-color: #0e48c1;
            border-radius: 3px;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1.5px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 8px;
            font-weight: 600;
        }

        .comment-block {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 8px;
        }
        .comment-text {
            color: #475569;
            font-size: 10px;
            font-style: italic;
            margin-bottom: 4px;
        }
        .comment-meta {
            color: #94a3b8;
            font-size: 8px;
            font-weight: bold;
        }

        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>{{ $type === 'analytics' ? 'Faculty Full Dossier' : 'Faculty Dashboard Report' }}</h1>
            <div class="subtitle">{{ $faculty->name }} &mdash; {{ $type === 'analytics' ? 'Comprehensive Performance Review' : 'Performance Summary' }} &bull; Term {{ $currentTerm }}</div>
            <div class="meta">Generated: {{ now()->format('F d, Y \a\t h:i A') }} | Department: {{ $faculty->department ?? 'N/A' }}</div>
        </div>

        <!-- Key Statistics -->
        <div class="section-title">Key Statistics</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="label">Average Rating</div>
                    <div class="value">{{ $avgRating > 0 ? number_format($avgRating, 1) : '—' }} / 5</div>
                </div>
                <div class="stat-card">
                    <div class="label">Total Responses</div>
                    <div class="value default">{{ number_format($totalResponses) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Assigned Courses</div>
                    <div class="value default">{{ number_format($coursesCount) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Completion Rate</div>
                    <div class="value {{ $completionRate >= 70 ? 'green' : ($completionRate >= 40 ? 'amber' : 'default') }}">{{ number_format($completionRate, 1) }}%</div>
                </div>
            </div>
        </div>

        <!-- Criteria Performance -->
        <div class="section-title">Criteria Performance</div>
        @if(!empty($criteriaStats) && array_sum($criteriaStats) > 0)
        <table>
            <thead>
                <tr>
                    <th>Criterion</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteriaStats as $key => $value)
                <tr>
                    <td class="font-bold">{{ ucfirst($key) }}</td>
                    <td class="text-center">
                        <div class="bar-container"><div class="bar-fill" style="width: {{ $value > 0 ? ($value / 5) * 100 : 0 }}%;"></div></div>
                        <span class="font-bold">{{ number_format($value, 1) }} / 5.0</span>
                    </td>
                    <td class="text-center">
                        @if($value >= 4.5)
                            <span class="grade" style="background:#dcfce7;color:#16a34a;">Excellent</span>
                        @elseif($value >= 4.0)
                            <span class="grade" style="background:#dbeafe;color:#0e48c1;">Very Good</span>
                        @elseif($value >= 3.0)
                            <span class="grade" style="background:#fef3c7;color:#d97706;">Good</span>
                        @else
                            <span class="grade" style="background:#fee2e2;color:#dc2626;">Needs Improvement</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color:#94a3b8; text-align:center; padding:15px;">No criteria data available.</p>
        @endif

        <!-- Historical Trend -->
        @if(!empty($historicalTrend))
        <div class="section-title">Historical Trend</div>
        <table>
            <thead>
                <tr>
                    <th>Semester</th>
                    <th class="text-center">Average Rating</th>
                    <th class="text-center">Performance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historicalTrend as $trend)
                <tr>
                    <td class="font-bold">{{ $trend['semester'] }}</td>
                    <td class="text-center font-bold text-blue">{{ number_format($trend['rating'], 1) }}</td>
                    <td class="text-center">
                        <div class="bar-container"><div class="bar-fill" style="width: {{ ($trend['rating'] / 5) * 100 }}%;"></div></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Analytics-only sections -->
        @if($type === 'analytics')
        <div class="page-break"></div>

        <!-- Sentiment Analysis -->
        <div class="section-title">Student Sentiment Analysis</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="label">Students Polled</div>
                    <div class="value default">{{ number_format($studentsPolled) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Total Tokens Issued</div>
                    <div class="value default">{{ number_format($totalTokens) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Positive Reception</div>
                    <div class="value {{ $positiveReception >= 70 ? 'green' : 'amber' }}">{{ $positiveReception }}%</div>
                </div>
                <div class="stat-card">
                    <div class="label">Growth Area</div>
                    <div class="value amber" style="font-size:14px;">{{ $lowestCriterion ? ucfirst($lowestCriterion) : 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Detailed Criteria Breakdown -->
        <div class="section-title">Detailed Criteria Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Criterion</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Label</th>
                </tr>
            </thead>
            <tbody>
                @foreach($criteriaStats as $key => $value)
                <tr>
                    <td class="font-bold">{{ ucfirst($key) }}</td>
                    <td class="text-center">
                        <div class="bar-container"><div class="bar-fill" style="width: {{ $value > 0 ? ($value / 5) * 100 : 0 }}%;"></div></div>
                        <span class="font-bold">{{ number_format($value, 1) }} / 5.0</span>
                    </td>
                    <td class="text-center">{{ $criterionLabels[$key] ?? ucfirst($key) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Qualitative Synthesis -->
        <div class="section-title">Qualitative Synthesis</div>
        @if(!empty($recentComments))
            @foreach($recentComments as $comment)
            <div class="comment-block">
                <div class="comment-text">"{{ $comment['comment'] ?? 'No comment text' }}"</div>
                <div class="comment-meta">
                    {{ $comment['course'] ?? 'General' }}
                    @if(isset($comment['submitted_at']) && $comment['submitted_at'])
                        &bull; {{ $comment['submitted_at']->format('M d, Y') }}
                    @endif
                </div>
            </div>
            @endforeach
        @else
        <p style="color:#94a3b8; text-align:center; padding:15px;">No qualitative feedback available yet.</p>
        @endif
        @endif

        <!-- Recent Comments (dashboard-only) -->
        @if($type === 'dashboard' && !empty($recentComments))
        <div class="section-title">Recent Student Comments</div>
            @foreach($recentComments as $comment)
            <div class="comment-block">
                <div class="comment-text">"{{ $comment['comment'] ?? 'No comment text' }}"</div>
                <div class="comment-meta">
                    {{ $comment['course'] ?? 'General' }}
                    @if(isset($comment['submitted_at']) && $comment['submitted_at'])
                        &bull; {{ $comment['submitted_at']->format('M d, Y') }}
                    @endif
                </div>
            </div>
            @endforeach
        @endif

        <!-- Footer -->
        <div class="footer">
            Confidential &mdash; Faculty Evaluation System | {{ $faculty->name }} | {{ now()->format('Y') }}
        </div>
    </div>
</body>
</html>
