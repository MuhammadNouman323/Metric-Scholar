<x-student>
    {{-- Anonymous notice bar --}}
    <div class="bg-[#eef3ff] border-b border-[#c7d8f8] px-6 py-3 flex items-center gap-2.5">
        <svg class="w-4 h-4 text-[#0e48c1] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
            </path>
        </svg>
        <p class="text-[13px] font-semibold text-[#0e48c1]">Your feedback is 100% anonymous</p>
    </div>

    <div class="p-6 md:p-10 pb-28 max-w-[900px] mx-auto">

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-red-400 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">There were errors with your submission</h3>
                        <ul class="mt-1.5 text-sm text-red-700 list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- All caught up state --}}
        @if ($pendingCourses->isEmpty() && !$course)
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div
                    class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-[#0e48c1]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">All caught up!</h2>
                <p class="text-gray-500">You have no pending course evaluations at this time.</p>
                <a href="{{ route('student.feedback.history') }}"
                    class="inline-block mt-6 text-[#0e48c1] font-semibold hover:underline">View Evaluation History
                    →</a>
            </div>

        {{-- Already submitted state --}}
        @elseif($hasSubmitted)
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div
                    class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Feedback Already Submitted</h2>
                <p class="text-gray-500">You have already evaluated {{ $course->title }}.</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ route('student.feedback') }}"
                        class="inline-block bg-[#0e48c1] text-white px-5 py-2 rounded-xl font-semibold hover:bg-blue-800">Evaluate
                        Another Course</a>
                    <a href="{{ route('student.feedback.history') }}"
                        class="inline-block bg-gray-100 text-gray-700 px-5 py-2 rounded-xl font-semibold hover:bg-gray-200">View
                        History</a>
                </div>
            </div>

        @else
            <form method="POST" action="{{ route('student.feedback.store') }}" id="feedback-form">
                @csrf
                <input type="hidden" name="token" value="{{ $feedbackToken }}">
                {{-- Hidden inputs for all 7 rating fields --}}
                <input type="hidden" name="overall_rating" id="input-overall_rating" value="0">
                <input type="hidden" name="clarity" id="input-clarity" value="0">
                <input type="hidden" name="materials" id="input-materials" value="0">
                <input type="hidden" name="responsiveness" id="input-responsiveness" value="0">
                <input type="hidden" name="fairness" id="input-fairness" value="0">
                <input type="hidden" name="practical" id="input-practical" value="0">
                <input type="hidden" name="organization" id="input-organization" value="0">
                <input type="hidden" name="recommendation" id="input-recommendation" value="">

                {{-- Page header row --}}
                <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-8 gap-4">
                    <div>
                        <h1 class="text-[26px] font-bold text-gray-900 leading-tight">Course Evaluation</h1>
                        <p class="text-[13px] text-gray-500 mt-1">Help improve teaching quality through anonymous
                            feedback</p>
                    </div>

                    {{-- Course selector --}}
                    @if ($pendingCourses->count() > 1)
                        <div class="shrink-0">
                            <select id="course_select"
                                class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-[13px] font-semibold text-gray-700 focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] outline-none shadow-sm"
                                onchange="loadCourseDetails(this.value)">
                                @foreach ($pendingCourses as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $course && $course->id == $c->id ? 'selected' : '' }}>
                                        {{ $c->code }} — {{ $c->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                {{-- Faculty card --}}
                @if ($course)
                    @php
                        $faculty = $course->faculty->first();
                        $facultyInitials = $faculty ? strtoupper(substr($faculty->name, 0, 2)) : 'NA';
                        $displayRating = $avgRating ?? null;
                    @endphp
                    <div id="faculty-card"
                        class="bg-gradient-to-r from-[#0e48c1] to-[#1a5fd6] rounded-2xl p-6 mb-6 text-white flex flex-col sm:flex-row sm:items-center gap-5">
                        <div class="flex items-center gap-4 flex-1">
                            <div id="faculty-initials"
                                class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center font-bold text-xl shrink-0 backdrop-blur-sm">
                                {{ $facultyInitials }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p id="faculty-name" class="font-bold text-[17px]">{{ $faculty?->name ?? 'TBA' }}</p>
                                    @if ($faculty?->designation)
                                        <span id="faculty-designation"
                                            class="text-[11px] font-semibold bg-white/20 px-2 py-0.5 rounded-full">{{ $faculty->designation }}</span>
                                    @else
                                        <span id="faculty-designation"
                                            class="text-[11px] font-semibold bg-white/20 px-2 py-0.5 rounded-full">Instructor</span>
                                    @endif
                                </div>
                                <p id="faculty-department" class="text-white/70 text-[13px] mt-0.5">
                                    {{ $faculty?->department ?? $course->department ?? 'Department' }}</p>
                                <div class="flex items-center gap-3 mt-2 flex-wrap">
                                    <span id="course-title"
                                        class="flex items-center gap-1.5 text-[12px] font-medium bg-white/15 px-2.5 py-1 rounded-full">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        {{ $course->code }} — {{ $course->title }}
                                    </span>
                                    <span id="course-semester"
                                        class="flex items-center gap-1.5 text-[12px] font-medium bg-white/15 px-2.5 py-1 rounded-full">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $course->semester ?? 'Current Semester' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="avg-rating-block" class="shrink-0 text-center bg-white/15 rounded-xl px-5 py-3 backdrop-blur-sm {{ !$displayRating ? 'hidden' : '' }}">
                            <p id="avg-rating-value" class="text-[28px] font-black leading-none">{{ number_format($displayRating ?? 0, 1) }}</p>
                            <div id="avg-rating-stars" class="flex gap-0.5 justify-center mt-1">
                                @for ($s = 1; $s <= 5; $s++)
                                    <svg class="w-3.5 h-3.5 {{ $s <= round($displayRating ?? 0) ? 'text-yellow-400' : 'text-white/30' }} fill-current"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-[10px] text-white/60 mt-1 font-medium">Avg. Rating</p>
                        </div>
                    </div>
                @endif

                {{-- Evaluation progress --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#0e48c1]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span class="text-[14px] font-bold text-gray-900">Evaluation Progress</span>
                        </div>
                        <span id="progress-label" class="text-[13px] font-bold text-[#0e48c1]">0 of 5
                            completed</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div id="progress-bar"
                            class="h-full bg-gradient-to-r from-[#0e48c1] to-[#3b7df5] rounded-full transition-all duration-500"
                            style="width: 0%"></div>
                    </div>
                    <div class="flex justify-between mt-1.5">
                        <span class="text-[11px] text-gray-400 font-medium">Started</span>
                        <span id="progress-pct" class="text-[11px] text-gray-400 font-medium">0%</span>
                    </div>
                </div>

                {{-- Overall rating --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                    <p class="text-[15px] font-bold text-gray-900 mb-1">Overall Course Experience</p>
                    <p class="text-[13px] text-gray-400 mb-5">How would you rate your overall experience with this
                        course and instructor?</p>
                    <div class="flex gap-3 rating-group justify-center" data-target="overall_rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-10 h-10 cursor-pointer transition-all duration-150 hover:scale-125 text-gray-200 fill-current star-icon"
                                data-val="{{ $i }}" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        @endfor
                    </div>
                    <div class="flex justify-center gap-3 mt-3">
    @foreach ([
        ['star' => 1, 'label' => 'Poor'],
        ['star' => 2, 'label' => 'Fair'],
        ['star' => 3, 'label' => 'Good'],
        ['star' => 4, 'label' => 'Very Good'],
        ['star' => 5, 'label' => 'Excellent']
    ] as $item)
        <div class="w-10 text-center">
            <span class="text-[11px] text-gray-500 font-medium leading-tight block">
                {{ $item['label'] }}
            </span>
        </div>
    @endforeach
</div>
                </div>

                {{-- 6-criteria grid --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[15px] font-bold text-gray-900">Evaluation Criteria</p>
                        <span class="text-[12px] text-gray-400 font-medium bg-gray-100 px-2.5 py-1 rounded-full">6
                            areas</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php
                            $criteria = [
                                ['key' => 'clarity', 'label' => 'Clarity of Instruction', 'desc' => 'How clearly were concepts explained and presented?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.8zz28 9.9a5 5 0 117.072 0l-.347.5A3.001 3.001 0 0112 21a3 3 0 01-2.79-1.9l-.348-.5z"/>'],
                                ['key' => 'materials', 'label' => 'Quality of Course Materials', 'desc' => 'Were slides, readings, and resources helpful?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                                ['key' => 'responsiveness', 'label' => 'Instructor Responsiveness', 'desc' => 'How promptly were questions and concerns addressed?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>'],
                                ['key' => 'fairness', 'label' => 'Fairness of Grading', 'desc' => 'Were assessments graded fairly and transparently?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                                ['key' => 'practical', 'label' => 'Practical Learning Experience', 'desc' => 'Did hands-on tasks reinforce real-world skills?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>'],
                                ['key' => 'organization', 'label' => 'Course Organization', 'desc' => 'Was the course structure logical and well-paced?', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
                            ];
                        @endphp

                        @foreach ($criteria as $criterion)
                            <div
                                class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:border-[#0e48c1]/20 transition-colors group">
                                <div class="flex items-start gap-3 mb-4">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-[#0e48c1]/10 transition-colors">
                                        <svg class="w-4 h-4 text-[#0e48c1]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            {!! $criterion['icon'] !!}
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-bold text-gray-800">{{ $criterion['label'] }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $criterion['desc'] }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2 rating-group" data-target="{{ $criterion['key'] }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-7 h-7 cursor-pointer transition-all duration-150 hover:scale-125 text-gray-200 fill-current star-icon"
                                            data-val="{{ $i }}" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Written feedback (split) --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                    <p class="text-[15px] font-bold text-gray-900 mb-4">Written Feedback</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- What worked well --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-lg">✅</span>
                                <p class="text-[13px] font-bold text-gray-800">What worked well?</p>
                            </div>
                            <textarea id="worked-well" name="what_worked_well" rows="4" maxlength="2000"
                                placeholder="Describe the strengths of the instructor, teaching methods, or course structure."
                                class="w-full bg-[#f8fafc] border border-gray-100 rounded-xl p-3.5 text-[13px] text-gray-700 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1]/40 transition-all"></textarea>
                            <div class="flex justify-between mt-1.5">
                                <span class="text-[11px] text-gray-400">Minimum 80 characters recommended</span>
                                <span id="worked-count" class="text-[11px] text-gray-400 font-medium">0</span>
                            </div>
                        </div>
                        {{-- What could be improved --}}
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-lg">💡</span>
                                <p class="text-[13px] font-bold text-gray-800">What could be improved?</p>
                            </div>
                            <textarea id="could-improve" name="what_could_improve" rows="4" maxlength="2000"
                                placeholder="Provide constructive suggestions for future improvements."
                                class="w-full bg-[#f8fafc] border border-gray-100 rounded-xl p-3.5 text-[13px] text-gray-700 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1]/40 transition-all"></textarea>
                            <div class="flex justify-between mt-1.5">
                                <span class="text-[11px] text-gray-400">Minimum 80 characters recommended</span>
                                <span id="improve-count" class="text-[11px] text-gray-400 font-medium">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recommendation --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
                    <p class="text-[15px] font-bold text-gray-900 mb-1">Would you recommend this instructor?</p>
                    <p class="text-[13px] text-gray-400 mb-4">Would you recommend this instructor to other students?</p>
                    <div class="flex flex-wrap gap-3" id="recommendation-buttons">
                        @foreach ([['value' => 'yes_definitely', 'label' => 'Yes, definitely'], ['value' => 'neutral', 'label' => 'Neutral'], ['value' => 'not_really', 'label' => 'Not really']] as $option)
                            <button type="button"
                                class="rec-btn px-5 py-2 rounded-full border border-gray-200 text-[13px] font-semibold text-gray-600 hover:border-[#0e48c1] hover:text-[#fffff] transition-all duration-150"
                                data-value="{{ $option['value'] }}">
                                {{ $option['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Privacy banner --}}
                <div class="bg-[#f0f4ff] border border-[#c7d8f8] rounded-2xl p-5 mb-8 flex gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-[#0e48c1]/10 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-[#0e48c1]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-[#0e48c1] mb-0.5">Your privacy is completely protected
                        </p>
                        <p class="text-[12px] text-[#0e48c1]/70 leading-relaxed">Your identity is never shared with
                            instructors. Feedback is aggregated and reviewed only by academic administrators for
                            institutional improvement purposes.</p>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center justify-between">
                    <button type="button" id="save-draft-btn"
                        class="flex items-center gap-2 border border-gray-200 text-gray-600 px-5 py-2.5 rounded-xl text-[13px] font-bold hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                        Save Draft
                    </button>
                    <button type="submit" id="submit-btn"
                        class="flex items-center gap-2 bg-[#0e48c1] text-white px-8 py-2.5 rounded-xl text-[13px] font-bold hover:bg-blue-800 transition-colors shadow-[0_4px_12px_rgba(14,72,193,0.3)] disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                            </path>
                        </svg>
                        Submit Evaluation
                    </button>
                </div>
                <div id="already-submitted-overlay" class="hidden text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm mt-6">
                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Feedback Already Submitted</h2>
                    <p class="text-gray-500">You have already evaluated this course.</p>
                </div>
            </form>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ── Rating groups ──────────────────────────────────────────────
            const ratingGroups = document.querySelectorAll('.rating-group');
            const totalSteps = ratingGroups.length; // 7 (overall + 6 criteria)
            let completedSteps = 0;

            ratingGroups.forEach(group => {
                const targetInputId = 'input-' + group.getAttribute('data-target');
                const targetInput = document.getElementById(targetInputId);
                const stars = group.querySelectorAll('.star-icon');
                let rated = false;

                stars.forEach(star => {
                    // Hover preview
                    star.addEventListener('mouseenter', function() {
                        const hoverVal = parseInt(this.getAttribute('data-val'));
                        stars.forEach(s => {
                            const sVal = parseInt(s.getAttribute('data-val'));
                            s.classList.toggle('text-[#0e48c1]', sVal <= hoverVal);
                            s.classList.toggle('text-yellow-400', false);
                            s.classList.toggle('text-gray-200', sVal > hoverVal);
                        });
                    });

                    // Reset to committed value on mouse leave
                    group.addEventListener('mouseleave', function() {
                        const committed = parseInt(targetInput.value) || 0;
                        stars.forEach(s => {
                            const sVal = parseInt(s.getAttribute('data-val'));
                            s.classList.toggle('text-yellow-400', sVal <= committed);
                            s.classList.toggle('text-[#0e48c1]', false);
                            s.classList.toggle('text-gray-200', sVal > committed);
                        });
                    });

                    // Click to commit
                    star.addEventListener('click', function() {
                        const val = parseInt(this.getAttribute('data-val'));
                        const prev = parseInt(targetInput.value) || 0;
                        targetInput.value = val;

                        stars.forEach(s => {
                            const sVal = parseInt(s.getAttribute('data-val'));
                            s.classList.toggle('text-yellow-400', sVal <= val);
                            s.classList.toggle('text-[#0e48c1]', false);
                            s.classList.toggle('text-gray-200', sVal > val);
                        });

                        // Track progress
                        if (!rated) {
                            rated = true;
                            completedSteps++;
                            updateProgress();
                        }
                    });
                });
            });

            function updateProgress() {
                const pct = Math.round((completedSteps / totalSteps) * 100);
                document.getElementById('progress-bar').style.width = pct + '%';
                document.getElementById('progress-pct').textContent = pct + '%';
                document.getElementById('progress-label').textContent =
                    completedSteps + ' of ' + totalSteps + ' completed';
            }

            // ── Written feedback counters ──────────────────────────────────
            [['worked-well', 'worked-count'], ['could-improve', 'improve-count']].forEach(
                ([textareaId, countId]) => {
                    const ta = document.getElementById(textareaId);
                    const counter = document.getElementById(countId);
                    if (ta && counter) {
                        ta.addEventListener('input', () => {
                            counter.textContent = ta.value.length;
                        });
                    }
                });

            // ── Recommendation buttons ─────────────────────────────────────
            const recBtns = document.querySelectorAll('.rec-btn');
            const recInput = document.getElementById('input-recommendation');
            recBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    recBtns.forEach(b => {
                        b.classList.remove('bg-[#0e48c1]', 'text-white', 'border-[#0e48c1]');
                        b.classList.add('border-gray-200', 'text-gray-600');
                    });
                    this.classList.add('bg-[#0e48c1]', 'text-white', 'border-[#0e48c1]');
                    this.classList.remove('border-gray-200', 'text-gray-600');
                    recInput.value = this.getAttribute('data-value');
                });
            });

            // ── Save draft (localStorage) ──────────────────────────────────
            const DRAFT_KEY = 'feedback_draft_{{ $course?->id ?? "none" }}';

            function saveDraft() {
                const draft = {
                    overall_rating: document.getElementById('input-overall_rating')?.value,
                    clarity: document.getElementById('input-clarity')?.value,
                    materials: document.getElementById('input-materials')?.value,
                    responsiveness: document.getElementById('input-responsiveness')?.value,
                    fairness: document.getElementById('input-fairness')?.value,
                    practical: document.getElementById('input-practical')?.value,
                    organization: document.getElementById('input-organization')?.value,
                    what_worked_well: document.getElementById('worked-well')?.value,
                    what_could_improve: document.getElementById('could-improve')?.value,
                    recommendation: recInput?.value,
                };
                localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
                const btn = document.getElementById('save-draft-btn');
                const original = btn.innerHTML;
                btn.innerHTML =
                    '<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <span class="text-emerald-600">Saved!</span>';
                setTimeout(() => { btn.innerHTML = original; }, 2000);
            }

            function restoreDraft() {
                const raw = localStorage.getItem(DRAFT_KEY);
                if (!raw) { return; }
                try {
                    const draft = JSON.parse(raw);
                    ['overall_rating', 'clarity', 'materials', 'responsiveness', 'fairness', 'practical',
                        'organization'
                    ].forEach(field => {
                        const input = document.getElementById('input-' + field);
                        if (input && draft[field] && parseInt(draft[field]) > 0) {
                            input.value = draft[field];
                            const group = document.querySelector(
                                `.rating-group[data-target="${field}"]`);
                            if (group) {
                                const val = parseInt(draft[field]);
                                group.querySelectorAll('.star-icon').forEach(s => {
                                    const sVal = parseInt(s.getAttribute('data-val'));
                                    s.classList.toggle('text-yellow-400', sVal <= val);
                                    s.classList.toggle('text-gray-200', sVal > val);
                                });
                                completedSteps++;
                                updateProgress();
                            }
                        }
                    });
                    if (draft.what_worked_well) {
                        const ta = document.getElementById('worked-well');
                        if (ta) {
                            ta.value = draft.what_worked_well;
                            document.getElementById('worked-count').textContent = ta.value.length;
                        }
                    }
                    if (draft.what_could_improve) {
                        const ta = document.getElementById('could-improve');
                        if (ta) {
                            ta.value = draft.what_could_improve;
                            document.getElementById('improve-count').textContent = ta.value.length;
                        }
                    }
                    if (draft.recommendation) {
                        recInput.value = draft.recommendation;
                        recBtns.forEach(b => {
                            if (b.getAttribute('data-value') === draft.recommendation) {
                                b.classList.add('bg-[#0e48c1]', 'text-white', 'border-[#0e48c1]');
                                b.classList.remove('border-gray-200', 'text-gray-600');
                            }
                        });
                    }
                } catch (e) {}
            }

            document.getElementById('save-draft-btn')?.addEventListener('click', saveDraft);
            restoreDraft();

            // ── Form validation & AJAX Submission ─────────────────────────
            const form = document.getElementById('feedback-form');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const required = ['overall_rating', 'clarity', 'materials', 'responsiveness',
                        'fairness', 'practical', 'organization'
                    ];
                    const missing = required.filter(f => {
                        const el = document.getElementById('input-' + f);
                        return !el || el.value === '0';
                    });
                    if (missing.length > 0) {
                        alert(
                            'Please rate all ' + required.length +
                            ' criteria (including Overall) before submitting.'
                        );
                        return;
                    }

                    const submitBtn = document.getElementById('submit-btn');
                    const originalBtnContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Submitting...';
                    submitBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (response.ok) {
                            localStorage.removeItem(DRAFT_KEY);
                            window.location.href = data.redirect || '{{ route("student.feedback.history") }}';
                        } else {
                            alert(data.message || 'An error occurred. Please try again.');
                            submitBtn.innerHTML = originalBtnContent;
                            submitBtn.disabled = false;
                        }
                    } catch (error) {
                        alert('Network error. Please try again.');
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.disabled = false;
                    }
                });
            }
        });

        // ── Dynamic Course Fetching ────────────────────────────────────
        async function loadCourseDetails(courseId) {
            if (!courseId) return;
            
            try {
                const response = await fetch(`/student/feedback/api/course-details/${courseId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                
                if (!response.ok) throw new Error('Failed to fetch course details');
                
                const data = await response.json();
                
                // Update faculty card UI
                if (data.instructor) {
                    const name = data.instructor.name;
                    const initials = name.substring(0, 2).toUpperCase();
                    document.getElementById('faculty-initials').textContent = initials;
                    document.getElementById('faculty-name').textContent = name;
                    document.getElementById('faculty-designation').textContent = data.instructor.designation || 'Instructor';
                    document.getElementById('faculty-department').textContent = data.instructor.department || data.course.department || 'Department';
                } else {
                    document.getElementById('faculty-initials').textContent = 'NA';
                    document.getElementById('faculty-name').textContent = 'TBA';
                    document.getElementById('faculty-designation').textContent = 'Instructor';
                    document.getElementById('faculty-department').textContent = data.course.department || 'Department';
                }

                // Update course details
                document.getElementById('course-title').innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> ${data.course.code} — ${data.course.title}`;
                document.getElementById('course-semester').innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> ${data.course.semester || 'Current Semester'}`;

                // Update token
                const tokenInput = document.querySelector('input[name="token"]');
                if (tokenInput && data.feedbackToken) {
                    tokenInput.value = data.feedbackToken;
                }

                // Handle already submitted state dynamically
                const submitBtn = document.getElementById('submit-btn');
                const saveDraftBtn = document.getElementById('save-draft-btn');
                const overlay = document.getElementById('already-submitted-overlay');
                
                if (data.hasSubmitted) {
                    submitBtn.disabled = true;
                    saveDraftBtn.disabled = true;
                    overlay.classList.remove('hidden');
                } else {
                    submitBtn.disabled = false;
                    saveDraftBtn.disabled = false;
                    overlay.classList.add('hidden');
                }

                // Update average rating
                const ratingBlock = document.getElementById('avg-rating-block');
                if (data.avgRating !== null) {
                    ratingBlock.classList.remove('hidden');
                    document.getElementById('avg-rating-value').textContent = Number(data.avgRating).toFixed(1);
                    
                    const starsContainer = document.getElementById('avg-rating-stars');
                    let starsHtml = '';
                    for (let s = 1; s <= 5; s++) {
                        const colorClass = s <= Math.round(data.avgRating) ? 'text-yellow-400' : 'text-white/30';
                        starsHtml += `<svg class="w-3.5 h-3.5 ${colorClass} fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" /></svg>`;
                    }
                    starsContainer.innerHTML = starsHtml;
                } else {
                    ratingBlock.classList.add('hidden');
                }

                // Optional: update localStorage Draft Key for the new course
                // DRAFT_KEY = 'feedback_draft_' + courseId;
                // restoreDraft();

            } catch (error) {
                console.error('Error fetching course details:', error);
            }
        }
    </script>
</x-student>
