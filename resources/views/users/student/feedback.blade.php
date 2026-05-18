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

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($pendingCourses->isEmpty() && !$course)
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 text-[#0e48c1]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">All caught up!</h2>
                <p class="text-gray-500">You have no pending course evaluations at this time.</p>
                <a href="{{ route('student.feedback.history') }}" class="inline-block mt-6 text-[#0e48c1] font-semibold hover:underline">View Evaluation History →</a>
            </div>
        @elseif($hasSubmitted)
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Feedback Already Submitted</h2>
                <p class="text-gray-500">You have already evaluated {{ $course->title }}.</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ route('student.feedback') }}" class="inline-block bg-[#0e48c1] text-white px-5 py-2 rounded-xl font-semibold hover:bg-blue-800">Evaluate Another Course</a>
                    <a href="{{ route('student.feedback.history') }}" class="inline-block bg-gray-100 text-gray-700 px-5 py-2 rounded-xl font-semibold hover:bg-gray-200">View History</a>
                </div>
            </div>
        @else
            <form method="POST" action="{{ route('student.feedback.store') }}" id="feedback-form">
                @csrf
                <input type="hidden" name="clarity" id="input-clarity" value="0">
                <input type="hidden" name="materials" id="input-materials" value="0">
                <input type="hidden" name="responsiveness" id="input-responsiveness" value="0">
                <input type="hidden" name="fairness" id="input-fairness" value="0">

                <!-- Course Evaluation Header -->
                <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-8 gap-4">
                    <div>
                        <h2 class="text-[28px] font-bold text-gray-900 mb-1">Course Evaluation</h2>
                        <p class="text-[14px] text-gray-500 font-medium">Please provide your honest perspective on the instructional experience.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <select name="course_id" id="course_id" class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-[14px] font-medium focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1] outline-none" onchange="window.location.href='/student/feedback/'+this.value">
                            @foreach($pendingCourses as $c)
                                <option value="{{ $c->id }}" {{ $course && $course->id == $c->id ? 'selected' : '' }}>
                                    {{ $c->code }} - {{ $c->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($course)
                    <div class="flex items-center gap-3 bg-[#f8fafc] rounded-2xl p-4 border border-gray-100 mb-8 w-fit">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-[#0e48c1] font-bold text-lg">
                            {{ substr($course->faculty->first()?->name ?? 'TBA', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[14px] font-bold text-gray-900">{{ $course->faculty->first()?->name ?? 'TBA' }}</p>
                            <p class="text-[12px] font-semibold text-[#0e48c1]">{{ $course->title }}</p>
                        </div>
                    </div>
                @endif

                <!-- Rating Criteria Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

                    <!-- Clarity of Instruction -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Clarity of Instruction</p>
                        </div>
                        <div class="flex gap-2 rating-group" data-target="clarity">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 text-gray-200 fill-current star-icon" data-val="{{ $i }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Quality of Course Materials -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Quality of Course Materials</p>
                        </div>
                        <div class="flex gap-2 rating-group" data-target="materials">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 text-gray-200 fill-current star-icon" data-val="{{ $i }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Instructor Responsiveness -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Instructor Responsiveness</p>
                        </div>
                        <div class="flex gap-2 rating-group" data-target="responsiveness">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 text-gray-200 fill-current star-icon" data-val="{{ $i }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Fairness of Grading -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Fairness of Grading</p>
                        </div>
                        <div class="flex gap-2 rating-group" data-target="fairness">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 cursor-pointer transition-transform hover:scale-110 text-gray-200 fill-current star-icon" data-val="{{ $i }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Text Area -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-6">
                    <p class="text-[15px] font-bold text-gray-900 mb-4">What could be improved or what went well?</p>
                    <textarea id="feedback-text" name="comments" rows="6" maxlength="2000"
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
                    <button type="button" class="text-[14px] font-bold text-[#0e48c1] hover:underline px-4 py-2">Cancel</button>
                    <button type="submit"
                        class="flex items-center gap-2 bg-[#0e48c1] text-white px-7 py-3.5 rounded-xl text-[14px] font-bold hover:bg-blue-800 transition-colors shadow-[0_4px_12px_rgba(14,72,193,0.25)]">
                        Submit Evaluation
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Textarea counter
            const textarea = document.getElementById('feedback-text');
            const counter = document.getElementById('char-count');
            if (textarea && counter) {
                textarea.addEventListener('input', () => {
                    counter.textContent = textarea.value.length + ' / 2000';
                });
            }

            // Star ratings
            const ratingGroups = document.querySelectorAll('.rating-group');
            ratingGroups.forEach(group => {
                const targetInputId = 'input-' + group.getAttribute('data-target');
                const targetInput = document.getElementById(targetInputId);
                const stars = group.querySelectorAll('.star-icon');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.getAttribute('data-val'));
                        targetInput.value = val;
                        
                        // Update visual state
                        stars.forEach(s => {
                            const sVal = parseInt(s.getAttribute('data-val'));
                            if (sVal <= val) {
                                s.classList.remove('text-gray-200');
                                s.classList.add('text-[#0e48c1]');
                            } else {
                                s.classList.remove('text-[#0e48c1]');
                                s.classList.add('text-gray-200');
                            }
                        });
                    });
                });
            });

            // Form validation
            const form = document.getElementById('feedback-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const clarity = document.getElementById('input-clarity').value;
                    const materials = document.getElementById('input-materials').value;
                    const responsiveness = document.getElementById('input-responsiveness').value;
                    const fairness = document.getElementById('input-fairness').value;

                    if (clarity === '0' || materials === '0' || responsiveness === '0' || fairness === '0') {
                        e.preventDefault();
                        alert('Please provide a rating for all criteria before submitting.');
                    }
                });
            }
        });
    </script>
</x-student>
