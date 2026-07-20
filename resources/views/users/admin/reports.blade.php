<x-admin>
    <div class="p-4 md:p-8 max-w-[1600px] mx-auto min-h-screen space-y-8 pb-24">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <nav class="flex text-xs font-semibold text-gray-400 mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1">
                        <li class="inline-flex items-center">
                            <a href="/admin/dashboard" class="hover:text-[#0e48c1] transition-colors">Home</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-[#0e48c1]">Reports & Analytics</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">Reports & Analytics Hub</h1>
                <p class="text-slate-500 font-medium text-sm leading-relaxed">Analyze faculty performance evaluations, department performance, and AI-moderated feedback.</p>
            </div>

            <!-- Export Buttons -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.reports.print', array_merge(['tab' => $tab], $filters)) }}" target="_blank"
                    class="flex items-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4"></path>
                    </svg>
                    Print / PDF
                </a>
                <a href="{{ route('admin.reports.export', array_merge(['format' => 'excel', 'tab' => $tab], $filters)) }}"
                    class="flex items-center px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Excel Export
                </a>
                <a href="{{ route('admin.reports.export', array_merge(['format' => 'csv', 'tab' => $tab], $filters)) }}"
                    class="flex items-center px-4 py-2.5 bg-[#0e48c1] hover:bg-blue-800 text-white text-xs font-bold rounded-xl transition-all shadow-[0_4px_12px_rgba(14,72,193,0.2)]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    CSV Export
                </a>
            </div>
        </div>

        @php
            $hasActiveFilters = collect($filters)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();
        @endphp

        <!-- Filters Form (collapsible) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <!-- Toggle Button -->
            <button
                type="button"
                id="filter-panel-toggle"
                onclick="toggleFilterPanel()"
                class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-slate-50 transition-colors group"
            >
                <span class="flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#0e48c1]/10 text-[#0e48c1] group-hover:bg-[#0e48c1]/15 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </span>
                    <span class="text-sm font-bold text-slate-800">Filter and Search Panel</span>
                    @if($hasActiveFilters)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#0e48c1] text-white text-[10px] font-bold rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>
                            Active
                        </span>
                    @endif
                </span>
                <span class="flex items-center gap-2 text-xs font-semibold text-slate-400 group-hover:text-slate-600 transition-colors">
                    <span id="filter-panel-label">{{ $hasActiveFilters ? 'Edit Filters' : 'Open Filters' }}</span>
                    <svg id="filter-panel-chevron" class="w-4 h-4 transition-transform duration-300 {{ $hasActiveFilters ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </span>
            </button>

            <!-- Collapsible Body -->
            <div
                id="filter-panel-body"
                class="overflow-hidden transition-all duration-300 ease-in-out"
                style="{{ $hasActiveFilters ? '' : 'max-height: 0;' }}"
            >
                <div class="px-6 pb-6 pt-2 border-t border-slate-100">
                    <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
                        <input type="hidden" name="tab" value="{{ $tab }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="space-y-1 sm:col-span-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Search Query</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Faculty, Course, Dept, Evaluation..."
                                        class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <svg class="absolute left-3.5 top-3 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Evaluation -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Evaluation Cycle</label>
                                <select name="evaluation_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Evaluations</option>
                                    @foreach($evaluations as $eval)
                                        <option value="{{ $eval->id }}" {{ ($filters['evaluation_id'] ?? '') == $eval->id ? 'selected' : '' }}>
                                            {{ $eval->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semester -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Semester</label>
                                <select name="semester" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Semesters</option>
                                    @foreach($semesters as $sem)
                                        <option value="{{ $sem }}" {{ ($filters['semester'] ?? '') === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Department</label>
                                <select name="department" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ ($filters['department'] ?? '') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Faculty -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Faculty</label>
                                <select name="faculty_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Faculty</option>
                                    @foreach($faculties as $fac)
                                        <option value="{{ $fac->id }}" {{ ($filters['faculty_id'] ?? '') == $fac->id ? 'selected' : '' }}>{{ $fac->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Course</label>
                                <select name="course_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Courses</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ ($filters['course_id'] ?? '') == $course->id ? 'selected' : '' }}>
                                            {{ $course->code }} - {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Academic Year -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Academic Year / Year</label>
                                <input type="text" name="academic_year" value="{{ $filters['academic_year'] ?? '' }}" placeholder="e.g. 2024"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                            </div>

                            <!-- Evaluation Status -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Evaluation Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $st)
                                        <option value="{{ $st }}" {{ ($filters['status'] ?? '') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date range Start -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Start Date</label>
                                <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                            </div>

                            <!-- Date range End -->
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">End Date</label>
                                <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] transition-all">
                            </div>

                            <!-- Actions -->
                            <div class="flex items-end gap-2 sm:col-span-2">
                                <button type="submit" class="flex-1 px-4 py-2 bg-[#0e48c1] hover:bg-blue-800 text-white font-bold text-sm rounded-xl transition-all shadow-sm">
                                    Apply Filters
                                </button>
                                <a href="{{ route('admin.reports.index', ['tab' => $tab]) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm rounded-xl transition-all">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            (function () {
                var body  = document.getElementById('filter-panel-body');
                var chevron = document.getElementById('filter-panel-chevron');
                var label   = document.getElementById('filter-panel-label');
                var isOpen  = body.style.maxHeight !== '0px' && body.style.maxHeight !== '';

                // Set explicit max-height so CSS transition works correctly
                if (isOpen) {
                    body.style.maxHeight = body.scrollHeight + 'px';
                } else {
                    body.style.maxHeight = '0';
                }

                window.toggleFilterPanel = function () {
                    isOpen = !isOpen;
                    if (isOpen) {
                        body.style.maxHeight = body.scrollHeight + 'px';
                        chevron.style.transform = 'rotate(180deg)';
                        label.textContent = 'Close Filters';
                    } else {
                        body.style.maxHeight = '0';
                        chevron.style.transform = 'rotate(0deg)';
                        label.textContent = 'Open Filters';
                    }
                };
            })();
        </script>

        <!-- Summary statistics cards grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            <!-- Total Evaluations -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Evaluations</div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_evaluations'] }}</div>
            </div>
            <!-- Active Evaluations -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Active Evaluations</div>
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $stats['active_evaluations'] }}</div>
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                </div>
            </div>
            <!-- Closed Evaluations -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Closed Evaluations</div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['closed_evaluations'] }}</div>
            </div>
            <!-- Total Faculty -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Faculty</div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_faculty'] }}</div>
            </div>
            <!-- Total Students -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Students</div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_students'] }}</div>
            </div>
            <!-- Total Courses -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Courses</div>
                <div class="text-2xl font-extrabold text-slate-900">{{ $stats['total_courses'] }}</div>
            </div>
            <!-- Total Feedback Submitted -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Feedback Submitted</div>
                <div class="text-2xl font-extrabold text-[#0e48c1]">{{ $stats['total_feedback'] }}</div>
            </div>
            <!-- Pending Feedback -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Pending Feedback</div>
                <div class="text-2xl font-extrabold text-amber-600">{{ $stats['pending_feedback'] }}</div>
            </div>
            <!-- Overall Average Rating -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Overall Avg Rating</div>
                <div class="flex items-center gap-1.5">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $stats['overall_average'] }}</div>
                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
            <!-- Evaluation Completion Percentage -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Completion Rate</div>
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-extrabold text-slate-900">{{ $stats['completion_rate'] }}%</div>
                    <div class="w-16 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-[#0e48c1] h-full rounded-full" style="width: {{ $stats['completion_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="border-b border-slate-200">
            <nav class="flex flex-wrap -mb-px space-x-2 md:space-x-4">
                @foreach([
                    'summary' => 'Summary & Charts',
                    'faculty' => 'Faculty Performance',
                    'course' => 'Course Reports',
                    'department' => 'Department Reports',
                    'evaluation' => 'Evaluation cycles',
                    'questions' => 'Question Analysis',
                    'comments' => 'Anonymous Comments',
                    'moderation' => 'AI Moderation Log'
                ] as $key => $label)
                    <a href="{{ route('admin.reports.index', array_merge($filters, ['tab' => $key])) }}"
                       class="whitespace-nowrap pb-4 px-3 border-b-2 font-bold text-sm transition-all
                              {{ $tab === $key 
                                 ? 'border-[#0e48c1] text-[#0e48c1]' 
                                 : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Tab contents -->
        @if ($tab === 'summary')
            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bar Chart: Faculty average ratings -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Faculty Average Ratings</h3>
                    <div class="h-[300px] relative">
                        <canvas id="facultyBarChart"></canvas>
                    </div>
                </div>

                <!-- Horizontal Bar Chart: Top 10 Faculty -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Top 10 Highest Rated Faculty</h3>
                    <div class="h-[300px] relative">
                        <canvas id="topFacultyChart"></canvas>
                    </div>
                </div>

                <!-- Pie Chart: Rating Distribution -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Overall Rating Distribution</h3>
                    <div class="h-[250px] relative mx-auto w-full max-w-[250px]">
                        <canvas id="ratingDistributionChart"></canvas>
                    </div>
                    <div class="grid grid-cols-5 text-center text-xs font-semibold text-slate-500 mt-4">
                        <div>Excellent<br><span class="font-bold text-[#0e48c1]" id="dist-5"></span></div>
                        <div>Very Good<br><span class="font-bold text-emerald-600" id="dist-4"></span></div>
                        <div>Good<br><span class="font-bold text-yellow-600" id="dist-3"></span></div>
                        <div>Fair<br><span class="font-bold text-orange-500" id="dist-2"></span></div>
                        <div>Poor<br><span class="font-bold text-red-500" id="dist-1"></span></div>
                    </div>
                </div>

                <!-- Doughnut Chart: Completion Rate -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Evaluation Completion Rate</h3>
                    <div class="h-[250px] relative mx-auto w-full max-w-[250px]">
                        <canvas id="completionDoughnutChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-6 text-xs font-semibold text-slate-500 mt-4">
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#0e48c1] mr-2"></span>Submitted: <span class="font-bold ml-1 text-slate-800" id="compl-sub"></span></div>
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-slate-200 mr-2"></span>Pending: <span class="font-bold ml-1 text-slate-800" id="compl-pend"></span></div>
                    </div>
                </div>

                <!-- Line Chart: Performance Trend by Semester -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 md:col-span-2">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Faculty Performance Trend by Semester</h3>
                    <div class="h-[320px] relative">
                        <canvas id="semesterLineChart"></canvas>
                    </div>
                </div>
            </div>
        @else
            <!-- Data Table Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    @if ($tab === 'faculty')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Faculty Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Average Rating</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Total Feedback</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Performance Score</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Overall Grade</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-800 flex items-center gap-3">
                                            <img src="{{ $row['avatar'] }}" alt="{{ $row['name'] }}" class="w-8 h-8 rounded-full object-cover">
                                            <span>{{ $row['name'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">{{ $row['department'] }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-[#0e48c1]">{{ $row['avg_rating'] }} / 5.0</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['total_feedback'] }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="bg-[#0e48c1] h-full rounded-full" style="width: {{ $row['performance_score'] }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">{{ $row['performance_score'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-full
                                                @if($row['grade'] === 'Excellent') bg-blue-50 text-blue-700
                                                @elseif($row['grade'] === 'Very Good') bg-emerald-50 text-emerald-700
                                                @elseif($row['grade'] === 'Good') bg-yellow-50 text-yellow-700
                                                @elseif($row['grade'] === 'Fair') bg-orange-50 text-orange-700
                                                @else bg-red-50 text-red-700 @endif">
                                                {{ $row['grade'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">No faculty performance records found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    @elseif ($tab === 'course')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Course Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Faculty</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Enrolled Students</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Feedback Submitted</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Average Rating</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Completion Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800 text-sm">{{ $row['code'] }}</div>
                                            <div class="text-xs font-semibold text-slate-400 mt-0.5">{{ $row['title'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $row['faculty_name'] }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['total_students'] }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['feedback_submitted'] }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-[#0e48c1]">{{ $row['avg_rating'] }} / 5.0</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="bg-[#0e48c1] h-full rounded-full" style="width: {{ $row['completion_percentage'] }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">{{ $row['completion_percentage'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-medium">No course reports found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    @elseif ($tab === 'department')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Department Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Number of Faculty</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Average Rating</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Best Performing Faculty</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Lowest Performing Faculty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-800">{{ $row['department_name'] }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['number_of_faculty'] }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-[#0e48c1]">{{ $row['avg_rating'] }} / 5.0</td>
                                        <td class="px-6 py-4 text-sm font-bold text-emerald-600">{{ $row['best_faculty'] }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-red-500">{{ $row['worst_faculty'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">No department records found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    @elseif ($tab === 'evaluation')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Evaluation Cycle</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Semester</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Duration</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Total Students</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Submitted / Pending</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Completion Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-800">{{ $row['title'] }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-500">{{ $row['semester'] }}</td>
                                        <td class="px-6 py-4 text-center text-xs font-medium text-slate-500">
                                            {{ $row['start_date'] }} <span class="text-slate-300">to</span> {{ $row['end_date'] }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2 py-0.5 text-[10px] font-bold rounded-full tracking-wide uppercase
                                                @if(strtolower($row['status']) === 'active') bg-emerald-50 text-emerald-600
                                                @elseif(strtolower($row['status']) === 'closed') bg-slate-100 text-slate-600
                                                @else bg-blue-50 text-blue-600 @endif">
                                                {{ $row['status'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['total_eligible_students'] }}</td>
                                        <td class="px-6 py-4 text-center text-xs font-semibold text-slate-500">
                                            <span class="text-[#0e48c1]">{{ $row['submitted_feedback'] }}</span>
                                            <span class="text-slate-300 mx-1">/</span>
                                            <span class="text-amber-600">{{ $row['pending_feedback'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="bg-[#0e48c1] h-full rounded-full" style="width: {{ $row['completion_percentage'] }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">{{ $row['completion_percentage'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">No evaluation reports found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    @elseif ($tab === 'questions')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider w-[40%]">Question</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Average Rating</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Excellent (5★)</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Very Good (4★)</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Good (3★)</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Fair (2★)</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Poor (1★)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-800">{{ $row['question'] }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-[#0e48c1]">{{ $row['avg_rating'] }} / 5.0</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['excellent_pct'] }}%</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['very_good_pct'] }}%</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['good_pct'] }}%</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['fair_pct'] }}%</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-slate-600">{{ $row['poor_pct'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @elseif ($tab === 'comments')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Context</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Anonymous Feedback Comment</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs" style="width: 25%;">
                                            <div class="font-bold text-slate-800">{{ $row->feedback->course->code ?? 'N/A' }}</div>
                                            <div class="font-bold text-[#0e48c1] mt-0.5">{{ $row->feedback->faculty->name ?? 'N/A' }}</div>
                                            <div class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $row->feedback->evaluation->title ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700 font-medium leading-relaxed italic">
                                            "{{ $row->text_answer }}"
                                        </td>
                                        <td class="px-6 py-4 text-xs text-slate-400 font-bold whitespace-nowrap">
                                            {{ $row->created_at ? $row->created_at->diffForHumans() : 'Recently' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium">No approved anonymous comments found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-4 border-t border-slate-100">
                            {{ $reportData->appends(request()->query())->links() }}
                        </div>

                    @elseif ($tab === 'moderation')
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Context</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Comments (Original / Cleaned)</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Toxicity Score</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Flags & Details</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reportData as $row)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs" style="width: 20%;">
                                            <div class="font-bold text-slate-800">{{ $row->feedback->course->code ?? 'N/A' }}</div>
                                            <div class="font-bold text-[#0e48c1] mt-0.5">{{ $row->feedback->faculty->name ?? 'N/A' }}</div>
                                            <div class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $row->feedback->evaluation->title ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-relaxed" style="width: 45%;">
                                            <div class="mb-1 text-slate-500 font-medium"><span class="text-xs font-bold text-slate-400 uppercase mr-1">Original:</span> "{{ $row->original_comment }}"</div>
                                            @if($row->cleaned_comment && $row->cleaned_comment !== $row->original_comment)
                                                <div class="text-emerald-700 font-semibold"><span class="text-xs font-bold text-emerald-500 uppercase mr-1">Cleaned:</span> "{{ $row->cleaned_comment }}"</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2 py-0.5 text-[10px] font-bold rounded-full tracking-wide uppercase
                                                @if($row->moderation_status === 'approved') bg-emerald-50 text-emerald-600
                                                @elseif($row->moderation_status === 'flagged') bg-amber-50 text-amber-600
                                                @else bg-red-50 text-red-600 @endif">
                                                {{ $row->moderation_status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-extrabold {{ $row->toxicity_score >= 50 ? 'text-red-500' : 'text-slate-700' }}">
                                            {{ $row->toxicity_score }}
                                        </td>
                                        <td class="px-6 py-4 text-xs space-y-1">
                                            <div><span class="font-bold text-slate-400 uppercase">Reason:</span> <span class="font-medium text-slate-600">{{ $row->moderation_reason ?: 'N/A' }}</span></div>
                                            <div>
                                                <span class="font-bold text-slate-400 uppercase">Categories:</span>
                                                @if(is_array($row->moderation_categories) && !empty($row->moderation_categories))
                                                    @foreach($row->moderation_categories as $cat)
                                                        <span class="inline-block bg-slate-100 text-slate-700 font-bold px-1.5 py-0.5 rounded text-[9px] mr-1">{{ $cat }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-slate-500 font-medium">None</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-slate-400 font-bold mt-1">Moderated: {{ $row->moderated_at ? $row->moderated_at->format('Y-m-d H:i') : 'N/A' }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">No moderation log entries found matching the filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-4 border-t border-slate-100">
                            {{ $reportData->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <!-- Chart.js and rendering scripts -->
    @if ($tab === 'summary')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const colors = {
                    primary: '#0e48c1',
                    primaryLight: 'rgba(14, 72, 193, 0.1)',
                    primaryBorder: 'rgba(14, 72, 193, 0.4)',
                    emerald: '#10b981',
                    emeraldLight: 'rgba(16, 185, 129, 0.1)',
                    amber: '#f59e0b',
                    orange: '#f97316',
                    red: '#ef4444',
                    slate200: '#e2e8f0',
                    slate600: '#475569',
                    fontFamily: 'Inter, system-ui, -apple-system, sans-serif'
                };

                Chart.defaults.font.family = colors.fontFamily;
                Chart.defaults.font.size = 11;
                Chart.defaults.color = colors.slate600;

                // Data injected from ReportService
                const chartData = @json($chartData);

                // Populate legends or percentages in elements
                const pieLabels = chartData.rating_pie.labels;
                const pieData = chartData.rating_pie.data;
                const totalRatings = pieData.reduce((a, b) => a + b, 0);

                const getPctString = (val) => {
                    if (totalRatings === 0) return '0%';
                    return Math.round((val / totalRatings) * 100) + '% (' + val + ')';
                };

                document.getElementById('dist-5').innerText = getPctString(pieData[0] || 0);
                document.getElementById('dist-4').innerText = getPctString(pieData[1] || 0);
                document.getElementById('dist-3').innerText = getPctString(pieData[2] || 0);
                document.getElementById('dist-2').innerText = getPctString(pieData[3] || 0);
                document.getElementById('dist-1').innerText = getPctString(pieData[4] || 0);

                document.getElementById('compl-sub').innerText = chartData.completion_doughnut.data[0];
                document.getElementById('compl-pend').innerText = chartData.completion_doughnut.data[1];

                // Chart 1: Faculty Average Ratings (Bar Chart)
                new Chart(document.getElementById('facultyBarChart'), {
                    type: 'bar',
                    data: {
                        labels: chartData.faculty_bar.labels,
                        datasets: [{
                            label: 'Average Rating',
                            data: chartData.faculty_bar.data,
                            backgroundColor: colors.primary,
                            borderRadius: 6,
                            maxBarThickness: 32
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                min: 1,
                                max: 5,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });

                // Chart 2: Top 10 Highest Rated Faculty (Horizontal Bar)
                new Chart(document.getElementById('topFacultyChart'), {
                    type: 'bar',
                    data: {
                        labels: chartData.top_faculty_horizontal.labels,
                        datasets: [{
                            label: 'Average Rating',
                            data: chartData.top_faculty_horizontal.data,
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            maxBarThickness: 24
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                min: 1,
                                max: 5,
                                ticks: { stepSize: 1 }
                            },
                            y: {
                                grid: { display: false }
                            }
                        }
                    }
                });

                // Chart 3: Overall Rating Distribution (Pie Chart)
                new Chart(document.getElementById('ratingDistributionChart'), {
                    type: 'pie',
                    data: {
                        labels: chartData.rating_pie.labels,
                        datasets: [{
                            data: chartData.rating_pie.data,
                            backgroundColor: [colors.primary, colors.emerald, colors.amber, colors.orange, colors.red],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });

                // Chart 4: Completion Rate (Doughnut Chart)
                new Chart(document.getElementById('completionDoughnutChart'), {
                    type: 'doughnut',
                    data: {
                        labels: chartData.completion_doughnut.labels,
                        datasets: [{
                            data: chartData.completion_doughnut.data,
                            backgroundColor: [colors.primary, colors.slate200],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });

                // Chart 5: Performance Trend (Line Chart)
                new Chart(document.getElementById('semesterLineChart'), {
                    type: 'line',
                    data: {
                        labels: chartData.semester_line.labels,
                        datasets: [{
                            label: 'Departmental Average Rating',
                            data: chartData.semester_line.data,
                            borderColor: colors.primary,
                            backgroundColor: colors.primaryLight,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: colors.primary,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                min: 1,
                                max: 5,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
</x-admin>
