<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 mb-1.5 tracking-tight">Faculty Overview</h1>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full sm:w-auto">
                <a href="{{ route('faculty.reports.dashboard-pdf') }}"
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-[0_4px_12px_rgba(14,72,193,0.2)] hover:bg-blue-800 transition-colors flex-1 sm:flex-none whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Report
                </a>
            </div>
        </div>

        <!-- Active Evaluation Notifications -->
        @forelse($activeEvaluations as $activeEvaluation)
        <div class="mb-6 bg-[#f0f4ff] border border-[#0e48c1]/20 rounded-2xl p-6 lg:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </span>
                    <h2 class="text-xl font-bold text-gray-900">{{ $activeEvaluation->title }}</h2>
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-md uppercase tracking-wider">{{ $activeEvaluation->status }}</span>
                </div>
                <p class="text-[14px] text-gray-600 font-medium">
                    An evaluation cycle is currently {{ $activeEvaluation->status }}. It runs from 
                    <strong class="text-gray-900">{{ $activeEvaluation->start_date->format('M d, Y') }}</strong> to 
                    <strong class="text-gray-900">{{ $activeEvaluation->end_date->format('M d, Y') }}</strong>.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="text-[13px] font-bold text-gray-400 flex items-center mr-2">Assigned Courses:</span>
                    @forelse($assignedCourses as $course)
                        <span class="bg-white border border-gray-200 text-gray-700 text-xs font-bold px-3 py-1.5 rounded-lg">{{ $course->code }}</span>
                    @empty
                        <span class="text-[13px] text-gray-500">No courses assigned for this cycle.</span>
                    @endforelse
                </div>
            </div>
            <a href="{{ route('faculty.feedback') }}" class="shrink-0 bg-[#0e48c1] text-white px-5 py-2.5 rounded-xl text-[14px] font-bold shadow-sm hover:bg-blue-800 transition-colors">
                View Feedback
            </a>
        </div>
        @empty
        <div class="mb-10 bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center">
            <p class="text-sm text-gray-500 font-medium">No active evaluation cycles at the moment.</p>
        </div>
        @endforelse

        <!-- 3 Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 lg:gap-6 mb-10 w-full">
            <!-- Average Rating -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Average Rating</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-[40px] font-bold text-gray-900 tracking-tight leading-none">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-[18px] font-bold text-gray-300">/ 5.0</span>
                </div>
                <div class="flex items-center gap-1.5 text-[13px] font-semibold text-gray-400 mt-1">
                    Based on student evaluations
                </div>
            </div>

            <!-- Total Responses -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Total Responses</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-[40px] font-bold text-gray-900 tracking-tight leading-none mb-2">{{ number_format($totalResponsesCount) }}</div>
                <div class="flex items-center gap-1.5 text-[13px] font-semibold text-gray-400 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Across {{ $coursesCount }} {{ Str::plural('Course', $coursesCount) }}
                </div>
            </div>

            <!-- Feedback Completion -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Feedback Completion</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-[40px] font-bold text-gray-900 tracking-tight leading-none mb-3">{{ number_format($completionRate, 1) }}%</div>
                <div class="w-full bg-[#f1f5f9] rounded-full h-2">
                    <div class="bg-[#0e48c1] h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 w-full">

            <!-- Criteria Performance -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-7">
                    <h3 class="text-[19px] font-bold text-[#0e48c1]">Criteria Performance</h3>
                    <div class="flex items-center gap-1.5 text-[12px] font-bold text-gray-500">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0e48c1]"></div>
                        Target: 4.5
                    </div>
                </div>
                <div class="space-y-6">
                    <!-- Course Clarity -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Course Clarity</span>
                            <span class="text-[#0e48c1] font-bold">{{ number_format($criteriaStats['clarity'], 1) }}</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: {{ $criteriaStats['clarity'] > 0 ? ($criteriaStats['clarity'] / 5.0) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <!-- Student Support -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Student Support</span>
                            <span class="text-[#0e48c1] font-bold">{{ number_format($criteriaStats['responsiveness'], 1) }}</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: {{ $criteriaStats['responsiveness'] > 0 ? ($criteriaStats['responsiveness'] / 5.0) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <!-- Punctuality -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Organization & Punctuality</span>
                            <span class="text-[#0e48c1] font-bold">{{ number_format($criteriaStats['organization'], 1) }}</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: {{ $criteriaStats['organization'] > 0 ? ($criteriaStats['organization'] / 5.0) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <!-- Material Quality -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Material Quality</span>
                            <span class="text-[#0e48c1] font-bold">{{ number_format($criteriaStats['materials'], 1) }}</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: {{ $criteriaStats['materials'] > 0 ? ($criteriaStats['materials'] / 5.0) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historical Trend -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-7">
                    <h3 class="text-[19px] font-bold text-gray-900">Historical Trend</h3>
                    <span class="text-[12px] font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">Last Semesters</span>
                </div>

                <!-- SVG Line Chart -->
                <div class="w-full h-[180px] relative mb-4">
                    <svg viewBox="0 0 600 180" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                        <!-- Grid lines -->
                        <line x1="0" y1="45" x2="600" y2="45" stroke="#f1f5f9"
                            stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="0" y1="90" x2="600" y2="90" stroke="#f1f5f9"
                            stroke-width="1.5" stroke-dasharray="4 4" />
                        <line x1="0" y1="135" x2="600" y2="135" stroke="#f1f5f9"
                            stroke-width="1.5" stroke-dasharray="4 4" />

                        <!-- Trend Line -->
                        @if(count($svgPoints) > 1)
                            @php
                                $pathD = "";
                                foreach($svgPoints as $index => $pt) {
                                    $pathD .= ($index === 0 ? "M " : " L ") . $pt['x'] . " " . $pt['y'];
                                }
                            @endphp
                            <path d="{{ $pathD }}" stroke="#0e48c1" stroke-width="3.5"
                                fill="none" stroke-linecap="round" />
                        @endif

                        <!-- Data Points -->
                        @foreach($svgPoints as $pt)
                            <circle cx="{{ $pt['x'] }}" cy="{{ $pt['y'] }}" r="5" fill="white" stroke="#0e48c1"
                                stroke-width="2.5" />
                        @endforeach
                    </svg>
                </div>

                <!-- X Axis Labels -->
                <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    @foreach($svgPoints as $pt)
                        <span>{{ $pt['semester'] }}</span>
                    @endforeach
                </div>

                <p class="text-[13px] text-gray-500 font-medium mt-5 italic border-t border-gray-50 pt-4">
                    "Performance metrics show progress as feedback is incorporated semester over semester."
                </p>
            </div>
        </div>

        <!-- Student Voice -->
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] mb-8">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h3 class="text-[19px] font-bold text-gray-900">Student Voice</h3>
                    <p class="text-[13.5px] text-gray-500 font-medium mt-0.5">Recent anonymous highlights from verified
                        course evaluations</p>
                </div>
                <a href="{{ route('faculty.feedback') }}"
                    class="text-[13px] font-bold text-[#0e48c1] hover:underline whitespace-nowrap flex items-center gap-1">
                    View All Comments
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-7">
                @forelse($recentComments as $comment)
                <div class="bg-[#f8fafc] rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $comment['rating'] ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">{{ $comment['course'] }}</span>
                    </div>
                    <p class="text-[14px] text-gray-700 leading-relaxed mb-4">
                        "{{ $comment['text'] }}"
                    </p>
                    <p class="text-[12px] text-gray-400 font-medium">— {{ $comment['date'] }}</p>
                </div>
                @empty
                <div class="col-span-2 bg-[#f8fafc] rounded-2xl p-8 border border-gray-100 text-center">
                    <p class="text-[15px] text-gray-500 font-medium">No written comments have been submitted yet.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tenure CTA Banner -->
        <div class="bg-[#0e48c1] rounded-[2rem] p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-[22px] font-bold text-white mb-2">Ready for Tenure Review?</h3>
                <p class="text-blue-200 text-[14px] font-medium max-w-[480px]">
                    Generate your comprehensive performance dossier including response distributions, historical
                    comparisons, and sentiment analysis summaries in a single PDF.
                </p>
            </div>
            <a href="{{ route('faculty.reports.analytics-pdf') }}"
                class="bg-white text-[#0e48c1] font-bold text-[14px] px-7 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all whitespace-nowrap flex-shrink-0">
                Export Dossier {{ date('Y') }}
            </a>
        </div>

    </div>
</x-faculty>