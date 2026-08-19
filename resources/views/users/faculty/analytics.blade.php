<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div class="flex items-center gap-4">
                <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 tracking-tight">Faculty Analytics</h1>
                <span
                    class="text-[11px] font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full tracking-wider uppercase">Annual
                    Review {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="relative hidden sm:block">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search data points..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-[13px] text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 w-52">
                </div>
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Top 4 Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <!-- Global Performance -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Global Performance</p>
                <div class="flex items-baseline gap-1.5 mb-2">
                    <span class="text-[38px] font-bold text-gray-900 leading-none tracking-tight">{{ $avgRating > 0 ? $avgRating : '—' }}</span>
                    <span class="text-[16px] font-bold text-gray-300">/ 5.0</span>
                </div>
                @if(count($historicalTrend) >= 2)
                <div class="flex items-center gap-1 text-[12px] font-semibold {{ $trendingUp ? 'text-emerald-600' : 'text-orange-600' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="{{ $trendingUp ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}"></path>
                    </svg>
                    {{ $trendingUp ? '+' : '' }}{{ round(($historicalTrend[count($historicalTrend)-1]['rating'] - $historicalTrend[count($historicalTrend)-2]['rating']) / max($historicalTrend[count($historicalTrend)-2]['rating'], 0.01) * 100) }}% vs last semester
                </div>
                @endif
            </div>

            <!-- Response Rate -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Response Rate</p>
                <div class="text-[38px] font-bold text-gray-900 leading-none tracking-tight mb-3">{{ $completionRate > 0 ? $completionRate : 0 }}%</div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-[#0e48c1] h-2 rounded-full" style="width: {{ min($completionRate, 100) }}%"></div>
                </div>
            </div>

            <!-- Students Polled -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">Students Polled</p>
                <div class="text-[38px] font-bold text-gray-900 leading-none tracking-tight mb-2">{{ number_format($studentsPolled) }}</div>
                <p class="text-[12px] font-medium text-gray-400">Across {{ $coursesCount }} {{ Str::plural('Course', $coursesCount) }}</p>
            </div>

            <!-- Growth Areas -->
            <div class="bg-[#fff5f0] rounded-[1.5rem] p-6 border border-orange-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)]">
                <p class="text-[11px] font-bold text-orange-400 uppercase tracking-widest mb-4">Growth Areas</p>
                <div class="flex items-start gap-2 mb-2">
                    <div class="text-orange-400 mt-0.5 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-[17px] font-bold text-gray-900 leading-tight">{{ $lowestCriterion ? ucfirst($lowestCriterion) : 'N/A' }}</span>
                </div>
                <p class="text-[12px] font-medium text-orange-500">{{ $lowestCriterion && isset($criteriaStats[$lowestCriterion]) ? 'Score: ' . $criteriaStats[$lowestCriterion] . '/5 — Focus area for improvement' : 'No data available' }}</p>
            </div>
        </div>

        <!-- Middle Row: Rating Trends + Criteria Mapping -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Rating Trends (2/3) -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2 gap-3">
                    <div>
                        <h3 class="text-[20px] font-bold text-gray-900">Rating Trends</h3>
                        <p class="text-[13px] text-gray-400 font-medium mt-0.5">Longitudinal performance analysis
                            across 8 semesters</p>
                    </div>
                    <!-- Toggle -->
                    <div class="flex bg-gray-100 rounded-xl p-1 gap-1 self-start">
                        <button
                            class="px-4 py-1.5 rounded-lg text-[12px] font-bold text-gray-500 hover:text-gray-700 transition-colors">Semesters</button>
                        <button
                            class="px-4 py-1.5 rounded-lg text-[12px] font-bold bg-[#0e48c1] text-white shadow-sm transition-colors">Years</button>
                    </div>
                </div>

                <!-- Area Chart SVG -->
                <div class="w-full h-[240px] relative mt-4">
                    <svg viewBox="0 0 760 220" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                        <line x1="0" y1="55" x2="760" y2="55" stroke="#f1f5f9"
                            stroke-width="1.5" />
                        <line x1="0" y1="110" x2="760" y2="110" stroke="#f1f5f9"
                            stroke-width="1.5" />
                        <line x1="0" y1="165" x2="760" y2="165" stroke="#f1f5f9"
                            stroke-width="1.5" />

                        @if(!empty($trendAreaPath))
                        <path d="{{ $trendAreaPath }}"
                            fill="url(#areaGrad)" opacity="0.25" />
                        <path d="{{ $trendLinePath }}"
                            stroke="#0e48c1" stroke-width="3" fill="none" stroke-linecap="round" />

                        @foreach($trendPoints as $p)
                        <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" r="5" fill="white" stroke="#0e48c1"
                            stroke-width="2.5" />
                        @endforeach
                        @endif

                        <defs>
                            <linearGradient id="areaGrad" x1="0" y1="0" x2="0"
                                y2="1">
                                <stop offset="0%" stop-color="#0e48c1" stop-opacity="0.5" />
                                <stop offset="100%" stop-color="#0e48c1" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!-- X Axis Labels -->
                <div
                    class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-3 px-0">
                    @forelse($trendPoints as $p)
                        <span class="{{ $loop->last ? 'text-[#0e48c1]' : '' }}">{{ $p['semester'] }}</span>
                    @empty
                        <span class="text-gray-400">No historical data</span>
                    @endforelse
                </div>
            </div>

            <!-- Criteria Mapping / Radar (1/3) -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <h3 class="text-[20px] font-bold text-gray-900 mb-1">Criteria Mapping</h3>
                <p class="text-[13px] text-gray-400 font-medium mb-6">Balanced scorecard across metrics</p>

                <!-- Pentagon SVG Radar Chart -->
                <div class="flex justify-center mb-4">
                    <svg viewBox="0 0 300 300" class="w-full max-w-[240px] h-auto">
                        <!-- Labels -->
                        <text x="150" y="18" text-anchor="middle" class="text-[10px]" font-size="11"
                            font-weight="700" fill="#94a3b8" letter-spacing="1">CLARITY</text>
                        <text x="282" y="122" text-anchor="start" font-size="11" font-weight="700" fill="#94a3b8"
                            letter-spacing="1">SUPPORT</text>
                        <text x="236" y="258" text-anchor="middle" font-size="11" font-weight="700" fill="#94a3b8"
                            letter-spacing="1">MATERIALS</text>
                        <text x="64" y="258" text-anchor="middle" font-size="11" font-weight="700" fill="#94a3b8"
                            letter-spacing="1">EMPATHY</text>
                        <text x="8" y="122" text-anchor="start" font-size="11" font-weight="700" fill="#94a3b8"
                            letter-spacing="1">PACE</text>

                        <!-- Outer pentagon (background) -->
                        <polygon points="150,30 258,108 216,234 84,234 42,108" fill="#f8fafc" stroke="#e2e8f0"
                            stroke-width="1.5" />

                        <!-- Mid pentagon (grid) -->
                        <polygon points="150,80 214,127 190,199 110,199 86,127" fill="none" stroke="#e2e8f0"
                            stroke-width="1" stroke-dasharray="3 3" />

                        @if($radarPolygon)
                        <polygon points="{{ $radarPolygon }}" fill="#bfdbfe" stroke="#0e48c1"
                            stroke-width="2.5" fill-opacity="0.45" />
                        @endif

                        <circle cx="150" cy="150" r="3" fill="#0e48c1" opacity="0.3" />
                    </svg>
                </div>

                <!-- Scorecard rows -->
                <div class="space-y-3 border-t border-gray-50 pt-4">
                    @forelse($criteriaStats as $key => $value)
                    <div class="flex items-center justify-between text-[13px]">
                        <span class="font-medium text-gray-600">{{ ucfirst($key) }}</span>
                        <span class="font-bold {{ $value >= 4 ? 'text-[#0e48c1]' : ($value >= 3 ? 'text-amber-600' : 'text-orange-600') }}">{{ number_format($value, 1) }}/5</span>
                    </div>
                    @empty
                    <div class="flex items-center justify-between text-[13px]">
                        <span class="font-medium text-gray-400 italic">No criteria data available</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Row: Sentiment + Qualitative -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Student Sentiment Analysis -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <h3 class="text-[20px] font-bold text-gray-900 mb-6">Student Sentiment Analysis</h3>

                <!-- Positive Reception Bar -->
                <div class="mb-7">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[13px] font-semibold text-gray-600">Positive Reception</span>
                        <span class="text-[14px] font-bold text-[#0e48c1]">{{ $totalResponses > 0 ? round(($studentsPolled / max($totalResponses, 1)) * 100) : 0 }}%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full flex">
                            <div class="bg-[#0e48c1] h-full rounded-l-full" style="width: {{ $totalResponses > 0 ? round(($studentsPolled / max($totalResponses, 1)) * 100) : 0 }}%"></div>
                            <div class="bg-orange-300 h-full rounded-r-full" style="width: {{ $totalResponses > 0 ? 100 - round(($studentsPolled / max($totalResponses, 1)) * 100) : 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Subject Score Chips -->
                <div class="flex flex-wrap gap-3">
                    @php $chipColors = ['#0e48c1', '#2563eb', '#3b82f6', '#60a5fa', '#93c5fd']; @endphp
                    @forelse($criteriaStats as $key => $value)
                    @php $label = $criterionLabels[$key] ?? ucfirst($key); $color = $chipColors[$loop->index % count($chipColors)]; @endphp
                    <div class="flex-1 min-w-[80px] rounded-2xl p-4 text-center text-white" style="background-color: {{ $color }}">
                        <div class="text-[10px] font-bold uppercase tracking-widest mb-2 opacity-80">{{ $label }}</div>
                        <div class="text-[26px] font-bold leading-none">{{ number_format($value, 1) }}</div>
                    </div>
                    @empty
                    <div class="w-full text-center py-6 text-gray-400 text-sm font-medium">No sentiment data available yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Qualitative Synthesis -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <h3 class="text-[20px] font-bold text-gray-900 mb-6">Qualitative Synthesis</h3>

                <div class="space-y-5">
                    @forelse($recentComments as $comment)
                    <div class="bg-[#f8fafc] rounded-2xl p-5 border border-gray-100">
                        <p class="text-[14px] text-gray-700 leading-relaxed mb-4">
                            "{{ $comment['comment'] ?? 'No comment text' }}"
                        </p>
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <span
                                class="text-[10px] font-bold bg-blue-100 text-[#0e48c1] px-2.5 py-1 rounded-md tracking-wide uppercase">
                                {{ $comment['course'] ?? 'General' }}
                            </span>
                            <span class="text-[11px] font-medium text-gray-400">{{ $comment['submitted_at'] ? $comment['submitted_at']->diffForHumans() : '' }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="bg-[#f8fafc] rounded-2xl p-8 text-center border border-gray-100">
                        <p class="text-sm font-medium text-gray-400">No qualitative feedback available yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Floating Export Button -->
    <div class="fixed bottom-8 right-8 z-50">
        <button
            class="flex items-center gap-2.5 bg-[#0e48c1] text-white px-6 py-3.5 rounded-full text-[14px] font-bold shadow-[0_8px_24px_rgba(14,72,193,0.35)] hover:bg-blue-800 hover:shadow-[0_12px_28px_rgba(14,72,193,0.4)] transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Export Full Dossier
        </button>
    </div>
</x-faculty>
