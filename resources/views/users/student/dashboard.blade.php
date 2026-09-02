<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <p class="text-[13px] text-gray-400 font-medium mb-1">{{ currentTerm() }} Semester</p>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome back, {{ $student->name }} 👋</h1>
            </div>
            <div class="flex items-center gap-3">
                
                <a href="/student/feedback"
                    class="flex items-center gap-2 bg-[#0e48c1] text-white px-5 py-2.5 rounded-xl text-[13px] font-bold hover:bg-blue-800 transition-colors shadow-sm" >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    Submit Feedback
                </a>
            </div>
        </div>

        <!-- Anonymous Notice Banner -->
        <div class="bg-[#f0f4ff] border-l-4 border-[#0e48c1] px-6 py-4 rounded-r-xl mb-10 flex items-center gap-3">
            <svg class="w-5 h-5 text-[#0e48c1] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <div>
                <p class="text-[14px] font-bold text-gray-900">Your feedback is completely anonymous.</p>
                <p class="text-[13px] text-gray-600 mt-0.5">Your honest input drives academic improvement and cannot be traced back to you.</p>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Total Assigned</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-1">{{ $activeCourses }}</p>
                <p class="text-[12px] font-semibold text-gray-400">Evaluations this semester</p>
            </div>
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Completed</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-2">{{ $submittedFeedbackCount }}</p>
                <div class="w-full h-1.5 bg-gray-100 rounded-full">
                    <div class="h-1.5 bg-[#0e48c1] rounded-full" style="width: {{ $activeCourses > 0 ? ($submittedFeedbackCount / $activeCourses) * 100 : 0 }}%"></div>
                </div>
            </div>
            <div class="bg-[#fff5f0] rounded-[1.5rem] p-6 border border-orange-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)]">
                <p class="text-[11px] font-bold text-orange-400 uppercase tracking-widest mb-3">Pending Action</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-1">{{ $pendingFeedback }}</p>
                <a href="/student/feedback" class="text-[12px] font-bold text-orange-500 hover:underline">Complete now →</a>
            </div>
            <div class="bg-[#0e48c1] rounded-[1.5rem] p-6 text-white shadow-sm">
                <p class="text-blue-200 text-[11px] font-bold uppercase tracking-widest mb-3">Participation</p>
                <p class="text-[34px] font-bold leading-none mb-1">{{ $feedbackRate }}%</p>
                <p class="text-[12px] font-medium text-blue-200">{{ $feedbackRate >= 80 ? 'Exceptional Contributor' : 'Keep it up!' }}</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Upcoming Deadlines -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-7 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[18px] font-bold text-gray-900">Pending Evaluations</h3>
                    <span class="text-[11px] font-bold bg-orange-50 text-orange-600 px-2.5 py-1 rounded-full">{{ $pendingFeedback }} Due</span>
                </div>
                <div class="space-y-4">
                    @forelse($pendingEvaluations as $token)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-5 bg-[#f8fafc] rounded-2xl border-l-4 border-[#0e48c1]">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-[11px] font-bold text-gray-400">{{ $token->course->code }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span class="text-[11px] font-bold text-gray-400">{{ $token->evaluation->semester ?? currentTerm() }}</span>
                                    <span class="text-[10px] font-bold bg-orange-100 text-orange-600 px-2 py-0.5 rounded-md ml-2">Pending</span>
                                </div>
                                <p class="text-[16px] font-bold text-gray-900 mb-1">{{ $token->course->title }}</p>
                                <p class="text-[12px] text-gray-500 font-medium">Faculty: <span class="text-gray-900">{{ $token->faculty->name ?? 'TBA' }}</span> • {{ $token->faculty->department ?? 'Department N/A' }}</p>
                            </div>
                            <div class="text-left sm:text-right shrink-0 mt-2 sm:mt-0">
                                @php 
                                    $endDate = \Carbon\Carbon::parse($token->evaluation->end_date);
                                    $daysLeft = (int) now()->diffInDays($endDate, false);
                                    $daysLeft = max(0, $daysLeft);
                                    $weeks = intdiv($daysLeft, 7);
                                    $days = $daysLeft % 7;
                                    $parts = [];
                                    if ($weeks > 0) $parts[] = $weeks . ' week' . ($weeks > 1 ? 's' : '');
                                    if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
                                    $daysLabel = $daysLeft <= 0 ? 'Less than a day' : (implode(' ', $parts) ?: 'Less than a day');
                                @endphp
                                <p class="text-[12px] font-bold {{ $daysLeft <= 3 ? 'text-red-500' : 'text-gray-500' }} mb-2">
                                    <svg class="w-3.5 h-3.5 inline-block mr-0.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $daysLabel }}
                                </p>
                                <a href="{{ route('student.feedback', ['token' => $token->token]) }}"
                                    class="inline-block bg-[#0e48c1] text-white text-[12px] font-bold px-4 py-2 rounded-xl hover:bg-blue-800 transition-colors">
                                    Evaluate →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            @if($totalEvaluations == 0)
                                <div class="text-4xl mb-3">📅</div>
                                <h4 class="text-[16px] font-bold text-gray-900 mb-1">There are currently no active evaluations.</h4>
                                <p class="text-[13px] text-gray-500 font-medium">We will notify you when a new evaluation cycle begins.</p>
                            @else
                                <div class="text-4xl mb-3">🎉</div>
                                <h4 class="text-[16px] font-bold text-gray-900 mb-1">All evaluations completed!</h4>
                                <p class="text-[13px] text-gray-500 font-medium">Thank you for your feedback. Your voice helps shape our faculty.</p>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar (History) -->
            <div class="space-y-6">
                <!-- Submission History Snippet -->
                <div class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-[16px] font-bold text-gray-900">Recent Submissions</h3>
                        <a href="{{ route('student.feedback.history') }}" class="text-[12px] font-bold text-[#0e48c1] hover:underline">View All</a>
                    </div>
                    @if($recentSubmission)
                        <div class="space-y-4">
                            <!-- We only have one recent submission passed down by default from the controller, we will show it -->
                            <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                                <p class="text-[14px] font-bold text-gray-900 mb-1">{{ $recentSubmission->course->title }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-[12px] text-gray-400">{{ $recentSubmission->course->semester ?? currentTerm() }}</p>
                                    <span class="inline-block text-[10px] font-bold bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-md">✓ Submitted</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-[12px] text-gray-500 text-center py-4">No submissions yet this semester.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-student>
