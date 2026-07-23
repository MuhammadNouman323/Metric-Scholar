<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <h1 class="text-3xl lg:text-[34px] font-bold text-[#0e48c1] mb-1.5 tracking-tight">Institutional Overview
                </h1>
                <p class="text-gray-500 text-[15px] font-medium">Welcome back. Here is the latest performance data for
                    Semester {{ currentTerm() }}.</p>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full sm:w-auto">
                <button
                    class="flex items-center justify-center gap-2 bg-[#f4f7fb] text-[#0e48c1] px-5 py-3 rounded-xl text-sm font-bold shadow-sm border border-blue-50/50 hover:bg-[#eaf1f8] transition-colors flex-1 sm:flex-none whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ currentTermLabel() }}
                </button>
                <button
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-[0_4px_12px_rgba(14,72,193,0.2)] hover:bg-blue-800 transition-colors flex-1 sm:flex-none whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Generate Report
                </button>
            </div>
        </div>

        <!-- 4 Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6 mb-8 w-full">
            <!-- Card 1 -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-[42px] h-[42px] rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#0e48c1]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">+12%</span>
                </div>
                <div class="text-gray-500 text-[13px] font-bold mb-1">Total Students</div>
                <div class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">{{ number_format($studentCount) }}</div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-[42px] h-[42px] rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full">Static</span>
                </div>
                <div class="text-gray-500 text-[13px] font-bold mb-1">Total Faculty</div>
                <div class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">{{ number_format($facultyCount) }}</div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-[42px] h-[42px] rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">+4.2%</span>
                </div>
                <div class="text-gray-500 text-[13px] font-bold mb-1">Total Courses</div>
                <div class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">{{ number_format($courseCount) }}</div>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-6">
                    <div
                        class="w-[42px] h-[42px] rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Active</span>
                </div>
                <div class="text-gray-500 text-[13px] font-bold mb-1">Feedback Submitted</div>
                <div class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">{{ number_format($feedbackCount) }}</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 w-full">
            <!-- Line Chart (2/3 width) -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-8 gap-4">
                    <div>
                        <h3 class="text-[19px] font-bold text-gray-900 mb-1">Engagement Trends</h3>
                        <p class="text-[13.5px] text-gray-500 font-medium">Feedback volume over the current semester</p>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-bold text-gray-600">
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-[#0e48c1]"></div> Current
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-[#cbd5e1]"></div> Last Year
                        </div>
                    </div>
                </div>

                <!-- Line Chart Visualization via SVG -->
                <div class="w-full h-[220px] relative mt-2">
                    <svg viewBox="0 0 1000 250" class="w-full h-full overflow-visible preserve-3d"
                        preserveAspectRatio="none">
                        <!-- Dashed bottom axis line -->
                        <path d="M 0 250 L 1000 250" stroke="#f1f5f9" stroke-width="2" fill="none"
                            stroke-dasharray="4 4" />

                        <!-- Last Year Dashed Line -->
                        <path d="M 0 220 Q 250 210 500 180 T 1000 120" stroke="#cbd5e1" stroke-width="3" fill="none"
                            stroke-dasharray="8 6" />

                        <!-- Current Year Solid Line -->
                        <path d="M 0 200 C 250 140 400 180 600 150 C 750 130 900 60 1000 30" stroke="#0e48c1"
                            stroke-width="4.5" fill="none" stroke-linecap="round" />
                    </svg>
                    <!-- X Axis Labels -->
                    <div
                        class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mt-6 px-1">
                        <span>August</span>
                        <span>September</span>
                        <span>October</span>
                        <span>November</span>
                        <span>December</span>
                    </div>
                </div>
            </div>

            <!-- Donut Chart (1/3 width) -->
            <div
                class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col">
                <h3 class="text-[19px] font-bold text-gray-900 mb-1">Course Ratings</h3>
                <p class="text-[13.5px] text-gray-500 font-medium mb-8">Distribution by percentile</p>

                <!-- SVG Donut Chart Mock -->
                <div class="flex-1 flex flex-col items-center justify-center shrink-0">
                    <div class="relative w-44 h-44 mb-2">
                        <svg viewBox="0 0 100 100"
                            class="w-full h-full transform -rotate-90 origin-center drop-shadow-sm">
                            <circle cx="50" cy="50" r="38" fill="transparent" stroke="#e2e8f0"
                                stroke-width="12" />
                            @if($ratingChart['goodPct'] > 0)
                            <circle cx="50" cy="50" r="38" fill="transparent" stroke="#93c5fd"
                                stroke-width="12" stroke-dasharray="{{ $ratingChart['circumference'] }}" stroke-dashoffset="{{ $ratingChart['goodOffset'] }}"
                                class="origin-center" style="rotate: {{ $ratingChart['goodRotation'] }}deg" stroke-linecap="round" />
                            @endif
                            @if($ratingChart['excellentPct'] > 0)
                            <circle cx="50" cy="50" r="38" fill="transparent" stroke="#0e48c1"
                                stroke-width="12" stroke-dasharray="{{ $ratingChart['circumference'] }}" stroke-dashoffset="{{ $ratingChart['excellentOffset'] }}"
                                stroke-linecap="round" />
                            @endif
                        </svg>
                        <!-- Central Metric -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-[34px] font-bold text-[#0e48c1] leading-none mb-1 shadow-sm">{{ $ratingChart['avgRating'] }}</span>
                            <span class="text-[8px] font-bold text-gray-500 uppercase tracking-[0.15em]">Avg
                                Rating</span>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-8 space-y-3 px-2">
                    <div class="flex items-center justify-between text-[13px]">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#0e48c1]"></div>
                            <span class="text-gray-600 font-medium">Excellent (4.5+)</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $ratingChart['excellentPct'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between text-[13px]">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#93c5fd]"></div>
                            <span class="text-gray-600 font-medium">Good (3.5-4.5)</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $ratingChart['goodPct'] }}%</span>
                    </div>
                    <div class="flex items-center justify-between text-[13px]">
                        <div class="flex items-center gap-2.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#e2e8f0]"></div>
                            <span class="text-gray-600 font-medium">Others</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $ratingChart['othersPct'] }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">

            <!-- Progress Bars -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-8 flex flex-col border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-[19px] font-bold text-gray-900">Faculty Performance by Department</h3>
                    <a href="#"
                        class="text-[11px] font-bold text-[#0e48c1] uppercase tracking-wider hover:underline px-2 py-1 bg-blue-50/50 rounded-lg">View
                        All</a>
                </div>
                <div class="space-y-6 flex-1 flex flex-col justify-center">
                    @forelse($departmentPerformance as $dept)
                    <div>
                        <div class="flex justify-between text-[12px] font-bold text-gray-500 mb-2.5 tracking-wide">
                            <span>{{ strtoupper($dept['name']) }}</span>
                            <span class="text-gray-800">{{ $dept['score'] }}%</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="h-2.5 rounded-full shadow-sm"
                                style="width: {{ $dept['score'] }}%; background-color: {{ $dept['color']['bar'] }}; box-shadow: 0 1px 3px -1px {{ $dept['color']['bar'] }}40;"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-sm font-medium text-gray-500">No department performance data available yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="bg-[#f2f4f7] rounded-[2rem] p-8 border border-gray-100 shadow-inner flex flex-col h-full">
                <h3 class="text-[19px] font-bold text-gray-900 mb-7">Recent Activity</h3>

                <div class="space-y-6 flex-1">
                    <!-- Item 1 -->
                    <div class="flex gap-4">
                        <div class="relative shrink-0">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover"
                                src="https://i.pravatar.cc/150?img=47" alt="Jane">
                            <div
                                class="absolute -bottom-1 -right-1 w-[18px] h-[18px] bg-[#0e48c1] rounded-full border-2 border-white flex items-center justify-center text-white">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-[13.5px] text-gray-800 leading-snug"><span
                                    class="font-bold text-gray-900">Jane Doe</span> submitted a review for <span
                                    class="font-bold text-gray-900">Adv. Algorithms</span></p>
                            <p class="text-[12.5px] text-gray-500 mt-1 italic">"Excellent delivery of complex topics.
                                Highly recommended."</p>
                            <p class="text-[9px] font-bold text-gray-400 mt-2 tracking-widest uppercase">2 Minutes Ago
                            </p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex gap-4">
                        <div class="relative shrink-0">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover"
                                src="https://i.pravatar.cc/150?img=11" alt="Robert">
                            <div
                                class="absolute -bottom-1 -right-1 w-[18px] h-[18px] bg-amber-600 rounded-full border-2 border-white flex items-center justify-center text-white">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-[13.5px] text-gray-800 leading-snug"><span
                                    class="font-bold text-gray-900">Dr. Robert Smith</span> joined the <span
                                    class="font-bold text-gray-900">Engineering faculty</span></p>
                            <div class="flex gap-2 mt-1.5 flex-wrap">
                                <span
                                    class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded">Faculty</span>
                                <span
                                    class="px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] font-bold rounded">New
                                    Hires</span>
                            </div>
                            <p class="text-[9px] font-bold text-gray-400 mt-2 tracking-widest uppercase">45 Minutes Ago
                            </p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex gap-4 pb-2">
                        <div class="shrink-0">
                            <div
                                class="w-10 h-10 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center text-[#0e48c1]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="pt-0.5">
                            <p class="text-[13.5px] font-bold text-gray-900 leading-snug">Privacy Policy was updated
                                for student feedback</p>
                            <p class="text-[9px] font-bold text-gray-400 mt-2 tracking-widest uppercase">3 Hours Ago
                            </p>
                        </div>
                    </div>
                </div>

                <button
                    class="w-full mt-4 bg-transparent hover:bg-gray-200/50 text-[#0e48c1] font-bold text-[13px] rounded-xl border border-gray-200/60 py-3 transition-colors">
                    View Activity Log
                </button>
            </div>

        </div>
    </div>
</x-admin>
