<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 tracking-tight">Faculty Feedback</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('faculty.reports.feedback-export', array_filter(['course_id' => request('course_id'), 'sort' => request('sort')])) }}"
                   class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-[0_4px_12px_rgba(14,72,193,0.2)] hover:bg-blue-800 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Report
                </a>
            </div>
        </div>

        {{-- Top Stats Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            {{-- Overview Score (large card, 2/3 width) --}}
            <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-[26px] font-bold text-[#0e48c1] mb-1">Overview Score</h2>
                        <p class="text-[14px] text-gray-500 font-medium">
                            Based on {{ number_format($totalCount) }} verified student submission{{ $totalCount !== 1 ? 's' : '' }} this semester.
                        </p>
                    </div>
                    <div class="flex items-baseline gap-1.5 shrink-0">
                        <span class="text-[52px] font-bold text-[#0e48c1] leading-none tracking-tight">{{ $avgRating > 0 ? $avgRating : '—' }}</span>
                        <span class="text-[22px] font-bold text-gray-300">/ 5.0</span>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden mb-4">
                    <div class="h-full rounded-full flex">
                        <div class="bg-[#0e48c1] h-full transition-all" style="width: {{ $distribution['excellent'] }}%"></div>
                        <div class="bg-[#93c5fd] h-full transition-all" style="width: {{ $distribution['good'] }}%"></div>
                    </div>
                </div>

                {{-- Legend --}}
                <div class="flex flex-wrap items-center gap-6 text-[12px] font-bold">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#0e48c1]"></div>
                        <span class="text-gray-600 uppercase tracking-wider">Exceeded Expectations ({{ $distribution['excellent'] }}%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#93c5fd]"></div>
                        <span class="text-gray-600 uppercase tracking-wider">Met Expectations ({{ $distribution['good'] }}%)</span>
                    </div>
                </div>
            </div>

            {{-- Right side mini-cards --}}
            <div class="flex flex-col gap-4">
                {{-- Average Rating Card --}}
                <div class="bg-[#0e48c1] rounded-[1.5rem] p-6 flex-1 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold bg-white/20 text-white px-2.5 py-1 rounded-full">Avg Rating</span>
                    </div>
                    <p class="text-blue-200 text-[13px] font-semibold mb-1">Overall Score</p>
                    <p class="text-white text-[34px] font-bold leading-none tracking-tight">
                        {{ $avgRating > 0 ? $avgRating : '—' }} <span class="text-[20px] text-blue-300">/ 5</span>
                    </p>
                </div>

                {{-- New Feedback Card --}}
                <div class="bg-[#fff0eb] rounded-[1.5rem] p-6 flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center text-orange-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-[11px] font-bold text-orange-600 bg-orange-100 px-2.5 py-1 rounded-full">Last 30 Days</span>
                    </div>
                    <p class="text-orange-400 text-[13px] font-semibold mb-1">Recent Feedback</p>
                    <p class="text-gray-900 text-[34px] font-bold leading-none tracking-tight">{{ $newCount }}
                        <span class="text-[22px]">New</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ url('/faculty/feedback') }}" id="filter-form">
            <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
                <div class="flex items-center gap-3 flex-wrap">

                    {{-- Course Filter --}}
                    <div class="relative">
                        <select name="course_id" onchange="document.getElementById('filter-form').submit()"
                            class="appearance-none bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-[13px] font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 cursor-pointer shadow-sm">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $courseFilter == $course->id ? 'selected' : '' }}>
                                    {{ $course->code }} — {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div class="relative">
                        <select name="sort" onchange="document.getElementById('filter-form').submit()"
                            class="appearance-none bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-[13px] font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 cursor-pointer shadow-sm">
                            <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>Most Recent</option>
                            <option value="highest" {{ $sort === 'highest' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="lowest" {{ $sort === 'lowest' ? 'selected' : '' }}>Lowest Rated</option>
                        </select>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Result count --}}
                <p class="text-[13px] text-gray-500 font-medium">
                    Showing <span class="font-bold text-gray-800">{{ $feedbacks->count() }}</span>
                    of <span class="font-bold text-gray-800">{{ $feedbacks->total() }}</span> results
                </p>
            </div>
        </form>

        {{-- Feedback Cards Grid --}}
        @if($feedbacks->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 gap-4 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <p class="text-[16px] font-bold text-gray-400">No feedback found</p>
                <p class="text-[13px] text-gray-400 max-w-xs">
                    @if($courseFilter)
                        No feedback has been submitted for this course yet.
                    @else
                        Students haven't submitted any feedback for you yet. Check back after the evaluation period.
                    @endif
                </p>
            </div>
        @else
            <div id="feedback-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @foreach($feedbacks as $fb)
                    @php
                        $rating = round($fb->overall_rating);
                        $ratingColor = match(true) {
                            $rating >= 5  => 'text-emerald-500',
                            $rating >= 4  => 'text-amber-400',
                            $rating >= 3  => 'text-orange-400',
                            default       => 'text-red-400',
                        };
                    @endphp
                    <div class="feedback-card bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] hover:-translate-y-0.5 transition-all cursor-pointer flex flex-col gap-4"
                         data-course="{{ $fb->course?->code ?? 'N/A' }}"
                         data-course-title="{{ $fb->course?->title ?? '' }}"
                         data-rating="{{ $fb->overall_rating }}"
                         data-rating-rounded="{{ $rating }}"
                         data-rating-color="{{ $ratingColor }}"
                         data-date="{{ $fb->created_at->format('M d, Y') }}"
                         data-comments="{{ e($fb->comments ?? '') }}"
                         data-worked-well="{{ e($fb->what_worked_well ?? '') }}"
                         data-could-improve="{{ e($fb->what_could_improve ?? '') }}"
                         data-clarity="{{ $fb->clarity ?? '' }}"
                         data-materials="{{ $fb->materials ?? '' }}"
                         data-responsiveness="{{ $fb->responsiveness ?? '' }}"
                         data-fairness="{{ $fb->fairness ?? '' }}"
                         data-practical="{{ $fb->practical ?? '' }}"
                         data-organization="{{ $fb->organization ?? '' }}"
                    >

                        {{-- Card Header: course badge + stars --}}
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">
                                {{ $fb->course?->code ?? 'N/A' }}
                            </span>
                            <div class="flex {{ $ratingColor }}">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $rating ? 'fill-current' : 'fill-current opacity-20' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        {{-- Written comments (all three text fields) --}}
                        @php
                            $hasAnyText = $fb->comments || $fb->what_worked_well || $fb->what_could_improve;
                        @endphp

                        @if($hasAnyText)
                            <div class="flex flex-col gap-3 flex-1">

                                @if($fb->comments)
                                    <p class="text-[14px] text-gray-800 leading-relaxed font-medium line-clamp-3">
                                        "{{ $fb->comments }}"
                                    </p>
                                @endif

                                @if($fb->what_worked_well)
                                    <div>
                                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">✓ What Worked Well</span>
                                        <p class="text-[13px] text-gray-700 leading-relaxed mt-0.5 line-clamp-2">
                                            {{ $fb->what_worked_well }}
                                        </p>
                                    </div>
                                @endif

                                @if($fb->what_could_improve)
                                    <div>
                                        <span class="text-[10px] font-bold text-orange-500 uppercase tracking-wider">↗ Could Improve</span>
                                        <p class="text-[13px] text-gray-700 leading-relaxed mt-0.5 line-clamp-2">
                                            {{ $fb->what_could_improve }}
                                        </p>
                                    </div>
                                @endif

                            </div>
                        @else
                            <p class="text-[14px] text-gray-400 italic flex-1">No written comment provided.</p>
                        @endif

                        {{-- Metrics row (compact) --}}
                        @if($fb->clarity || $fb->materials || $fb->responsiveness)
                            <div class="flex flex-wrap gap-2">
                                @foreach(['clarity' => 'Clarity', 'materials' => 'Materials', 'responsiveness' => 'Responsiveness', 'fairness' => 'Fairness', 'practical' => 'Practical', 'organization' => 'Organization'] as $field => $label)
                                    @if($fb->$field)
                                        <span class="text-[10px] font-semibold bg-blue-50 text-[#0e48c1] px-2 py-0.5 rounded-md">
                                            {{ $label }}: {{ $fb->$field }}/5
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                            <div class="flex items-center gap-2 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-[12px] font-medium">Anonymous Student</span>
                            </div>
                            <span class="text-[11px] font-bold text-gray-400 tracking-wide uppercase">
                                {{ $fb->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Pagination --}}
            @if($feedbacks->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        @endif

    </div>
</x-faculty>

{{-- ===================== Feedback Detail Modal ===================== --}}
<div id="fb-modal-backdrop"
     class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 bg-black/40 backdrop-blur-sm hidden"
     role="dialog" aria-modal="true" aria-labelledby="fb-modal-title">

    <div id="fb-modal"
         class="relative bg-white rounded-[2rem] w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-[0_24px_80px_rgba(0,0,0,0.18)] translate-y-4 opacity-0 transition-all duration-300">

        {{-- Modal header --}}
        <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 flex items-center justify-between px-8 pt-7 pb-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0e48c1]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                </div>
                <div>
                    <h2 id="fb-modal-title" class="text-[18px] font-bold text-gray-900 leading-tight">Anonymous Feedback</h2>
                    <p id="fb-modal-meta" class="text-[12px] text-gray-400 font-medium"></p>
                </div>
            </div>
            <button id="fb-modal-close"
                    class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition-colors"
                    aria-label="Close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal body --}}
        <div class="px-8 pb-8 pt-6 flex flex-col gap-6">

            {{-- Overall rating --}}
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Overall Rating</p>
                    <div id="fb-modal-stars" class="flex gap-0.5"></div>
                </div>
                <div class="text-right">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Submitted</p>
                    <p id="fb-modal-date" class="text-[14px] font-bold text-gray-700"></p>
                </div>
            </div>

            {{-- Divider --}}
            <hr class="border-gray-100">

            {{-- Comments --}}
            <div id="fb-modal-comments-wrap" class="hidden">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">General Comments</p>
                <p id="fb-modal-comments" class="text-[15px] text-gray-800 leading-relaxed"></p>
            </div>

            {{-- What Worked Well --}}
            <div id="fb-modal-worked-wrap" class="hidden bg-emerald-50 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider mb-2">✓ What Worked Well</p>
                <p id="fb-modal-worked" class="text-[14px] text-gray-800 leading-relaxed"></p>
            </div>

            {{-- Could Improve --}}
            <div id="fb-modal-improve-wrap" class="hidden bg-orange-50 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-orange-500 uppercase tracking-wider mb-2">↗ Could Improve</p>
                <p id="fb-modal-improve" class="text-[14px] text-gray-800 leading-relaxed"></p>
            </div>

            {{-- Metrics grid --}}
            <div id="fb-modal-metrics-wrap" class="hidden">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Detailed Metrics</p>
                <div id="fb-modal-metrics" class="grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    const backdrop  = document.getElementById('fb-modal-backdrop');
    const modal     = document.getElementById('fb-modal');
    const closeBtn  = document.getElementById('fb-modal-close');

    const metaEl      = document.getElementById('fb-modal-meta');
    const starsEl     = document.getElementById('fb-modal-stars');
    const dateEl      = document.getElementById('fb-modal-date');
    const commentsWrap  = document.getElementById('fb-modal-comments-wrap');
    const commentsEl    = document.getElementById('fb-modal-comments');
    const workedWrap    = document.getElementById('fb-modal-worked-wrap');
    const workedEl      = document.getElementById('fb-modal-worked');
    const improveWrap   = document.getElementById('fb-modal-improve-wrap');
    const improveEl     = document.getElementById('fb-modal-improve');
    const metricsWrap   = document.getElementById('fb-modal-metrics-wrap');
    const metricsGrid   = document.getElementById('fb-modal-metrics');

    const ratingColorMap = {
        'text-emerald-500': '#10b981',
        'text-amber-400':   '#fbbf24',
        'text-orange-400':  '#fb923c',
        'text-red-400':     '#f87171',
    };

    const metricLabels = [
        { key: 'clarity',        label: 'Clarity' },
        { key: 'materials',      label: 'Materials' },
        { key: 'responsiveness', label: 'Responsiveness' },
        { key: 'fairness',       label: 'Fairness' },
        { key: 'practical',      label: 'Practical' },
        { key: 'organization',   label: 'Organization' },
    ];

    function openModal(card) {
        const d = card.dataset;

        /* --- meta --- */
        const courseTitle = d.courseTitle ? ` — ${d.courseTitle}` : '';
        metaEl.textContent = `${d.course}${courseTitle} · ${d.date}`;

        /* --- stars --- */
        const rating  = parseFloat(d.rating);
        const rounded = parseInt(d.ratingRounded, 10);
        const color   = ratingColorMap[d.ratingColor] || '#fbbf24';
        starsEl.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('viewBox', '0 0 20 20');
            svg.setAttribute('class', 'w-6 h-6');
            svg.style.fill = i <= rounded ? color : '#e5e7eb';
            svg.innerHTML = '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
            starsEl.appendChild(svg);
        }
        const ratingLabel = document.createElement('span');
        ratingLabel.className = 'ml-2 text-[16px] font-bold self-center';
        ratingLabel.style.color = color;
        ratingLabel.textContent = rating.toFixed(1) + ' / 5';
        starsEl.appendChild(ratingLabel);

        /* --- date --- */
        dateEl.textContent = d.date;

        /* --- text fields --- */
        if (d.comments) {
            commentsEl.textContent = d.comments;
            commentsWrap.classList.remove('hidden');
        } else {
            commentsWrap.classList.add('hidden');
        }

        if (d.workedWell) {
            workedEl.textContent = d.workedWell;
            workedWrap.classList.remove('hidden');
        } else {
            workedWrap.classList.add('hidden');
        }

        if (d.couldImprove) {
            improveEl.textContent = d.couldImprove;
            improveWrap.classList.remove('hidden');
        } else {
            improveWrap.classList.add('hidden');
        }

        /* --- metrics --- */
        metricsGrid.innerHTML = '';
        let hasMetric = false;
        metricLabels.forEach(({ key, label }) => {
            const val = d[key];
            if (!val) { return; }
            hasMetric = true;
            const score = parseInt(val, 10);
            const pct   = (score / 5) * 100;
            metricsGrid.insertAdjacentHTML('beforeend', `
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">${label}</p>
                    <p class="text-[22px] font-bold text-gray-900 leading-none mb-2">${score}<span class="text-[14px] text-gray-400 font-semibold">/5</span></p>
                    <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-[#0e48c1]" style="width:${pct}%"></div>
                    </div>
                </div>
            `);
        });
        metricsWrap.classList.toggle('hidden', !hasMetric);

        /* --- show --- */
        backdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0', 'translate-y-4');
        });
    }

    function closeModal() {
        modal.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => {
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    /* --- bind cards --- */
    document.querySelectorAll('.feedback-card').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });

    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', e => { if (e.target === backdrop) { closeModal(); } });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeModal(); } });
}());
</script>
