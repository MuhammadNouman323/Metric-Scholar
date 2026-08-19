<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Institutional Overview Report</title>
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

        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>Faculty Evaluation System</h1>
            <div class="subtitle">Institutional Overview Report &mdash; Semester {{ $currentTerm }}</div>
            <div class="meta">Generated: {{ now()->format('F d, Y \a\t h:i A') }} | University ID: {{ strtoupper(substr(auth()->user()->university_id ?? 'N/A', 0, 8)) }}</div>
        </div>

        <!-- Key Statistics -->
        <div class="section-title">Key Statistics</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stat-card">
                    <div class="label">Total Students</div>
                    <div class="value default">{{ number_format($studentCount) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Total Faculty</div>
                    <div class="value default">{{ number_format($facultyCount) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Total Courses</div>
                    <div class="value default">{{ number_format($courseCount) }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Feedback Submitted</div>
                    <div class="value blue">{{ number_format($feedbackCount) }}</div>
                </div>
            </div>
        </div>

        <!-- Department Performance -->
        <div class="section-title">Faculty Performance by Department</div>
        @if($departmentPerformance->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th class="text-center">Performance Score</th>
                    <th class="text-center">Average Rating</th>
                    <th class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departmentPerformance as $dept)
                <tr>
                    <td class="font-bold">{{ strtoupper($dept['name']) }}</td>
                    <td class="text-center">
                        <div class="bar-container"><div class="bar-fill" style="width: {{ $dept['score'] }}%;"></div></div>
                        <span class="font-bold">{{ $dept['score'] }}%</span>
                    </td>
                    <td class="text-center font-bold text-blue">{{ $dept['avg_rating'] }} / 5.0</td>
                    <td class="text-center">
                        @if($dept['score'] >= 90)
                            <span class="grade" style="background:#dcfce7;color:#16a34a;">Excellent</span>
                        @elseif($dept['score'] >= 70)
                            <span class="grade" style="background:#dbeafe;color:#0e48c1;">Good</span>
                        @elseif($dept['score'] >= 50)
                            <span class="grade" style="background:#fef3c7;color:#d97706;">Fair</span>
                        @else
                            <span class="grade" style="background:#fee2e2;color:#dc2626;">Needs Improvement</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color:#94a3b8; text-align:center; padding:15px;">No department performance data available.</p>
        @endif

        <!-- Rating Distribution -->
        <div class="section-title">Rating Distribution Overview</div>
        <table>
            <thead>
                <tr>
                    <th class="text-center">Overall Average</th>
                    <th class="text-center">Excellent (4.5+)</th>
                    <th class="text-center">Good (3.5-4.5)</th>
                    <th class="text-center">Others (&lt;3.5)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center font-bold text-blue" style="font-size:16px;">{{ $ratingChart['avgRating'] }}</td>
                    <td class="text-center font-bold">{{ $ratingChart['excellentPct'] }}%</td>
                    <td class="text-center font-bold">{{ $ratingChart['goodPct'] }}%</td>
                    <td class="text-center font-bold">{{ $ratingChart['othersPct'] }}%</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            Confidential &mdash; Faculty Evaluation System | Generated by Admin | {{ now()->format('Y') }}
        </div>
    </div>
</body>
</html>
