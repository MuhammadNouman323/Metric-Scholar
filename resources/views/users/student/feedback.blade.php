<x-student>
    <!-- Anonymous notice -->
    <div class="bg-[#f0f4ff] border-l-4 border-[#0e48c1] px-6 py-3.5 flex items-center gap-3">
        <svg class="w-4 h-4 text-[#0e48c1] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
            </path>
        </svg>
        <p class="text-[13px] font-semibold text-gray-700">Your feedback is 100% anonymous and used only for
            institutional improvement.</p>
    </div>

    <div class="p-6 md:p-10 pb-24 max-w-[1100px] mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-[22px] font-bold text-gray-900">Feedback Hub</h1>
        </div>

        <!-- Course Evaluation Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-[28px] font-bold text-gray-900 mb-1">Course Evaluation</h2>
                <p class="text-[14px] text-gray-500 font-medium">Please provide your honest perspective on the
                    instructional experience.</p>
            </div>
            <div class="flex items-center gap-3 bg-[#f8fafc] rounded-2xl p-3 border border-gray-100 shrink-0">
                <img src="https://i.pravatar.cc/80?img=69" alt="Dr. Helena Vance"
                    class="w-12 h-12 rounded-xl object-cover">
                <div>
                    <p class="text-[13px] font-bold text-gray-900">Dr. Helena Vance</p>
                    <p class="text-[12px] font-semibold text-[#0e48c1]">Molecular Biology II</p>
                </div>
            </div>
        </div>

        <!-- Rating Criteria Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

            <!-- Clarity of Instruction -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Clarity of Instruction</p>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 {{ $i <= 4 ? 'text-[#0e48c1]' : 'text-gray-200' }} fill-current"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    @endfor
                </div>
            </div>

            <!-- Quality of Course Materials -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Quality of Course Materials
                    </p>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 {{ $i <= 3 ? 'text-[#0e48c1]' : 'text-gray-200' }} fill-current"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    @endfor
                </div>
            </div>

            <!-- Instructor Responsiveness -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Instructor Responsiveness
                    </p>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 text-[#0e48c1] fill-current"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    @endfor
                </div>
            </div>

            <!-- Fairness of Grading -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Fairness of Grading</p>
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                        </path>
                    </svg>
                </div>
                <div class="flex gap-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 {{ $i <= 4 ? 'text-[#0e48c1]' : 'text-gray-200' }} fill-current"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Text Area -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-6">
            <p class="text-[15px] font-bold text-gray-900 mb-4">What could be improved or what went well?</p>
            <textarea id="feedback-text" rows="6" maxlength="2000"
                placeholder="Share your thoughts on the lecture style, lab sessions, and overall course structure..."
                class="w-full bg-[#f8fafc] border border-gray-100 rounded-xl p-4 text-[14px] text-gray-700 placeholder-gray-300 resize-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 transition-all"></textarea>
            <div class="flex items-center justify-between mt-3">
                <div class="flex items-center gap-1.5 text-[12px] text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Minimum 50 characters recommended for quality feedback.
                </div>
                <span id="char-count" class="text-[12px] text-gray-400 font-medium">0 / 2000</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <button class="text-[14px] font-bold text-[#0e48c1] hover:underline px-4 py-2">Save as Draft</button>
            <button
                class="flex items-center gap-2 bg-[#0e48c1] text-white px-7 py-3.5 rounded-xl text-[14px] font-bold hover:bg-blue-800 transition-colors shadow-[0_4px_12px_rgba(14,72,193,0.25)]">
                Submit Evaluation
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        const textarea = document.getElementById('feedback-text');
        const counter = document.getElementById('char-count');
        if (textarea) {
            textarea.addEventListener('input', () => {
                counter.textContent = textarea.value.length + ' / 2000';
            });
        }
    </script>
</x-student>
