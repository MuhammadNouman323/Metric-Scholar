<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <p class="text-[13px] text-gray-400 font-medium mb-1">Fall 2024 Semester</p>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome back, {{ $student->name }} 👋</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative hidden sm:block">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search courses..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-[13px] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 w-48">
                </div>
                <button
                    class="flex items-center gap-2 bg-[#0e48c1] text-white px-5 py-2.5 rounded-xl text-[13px] font-bold hover:bg-blue-800 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    Submit Feedback
                </button>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Current GPA</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-1">N/A</p>
                <p class="text-[12px] font-semibold text-gray-400">Not tracked yet</p>
            </div>
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Credits Enrolled</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-2">{{ $student->courses()->sum('credit_hours') }}</p>
                <div class="w-full h-1.5 bg-gray-100 rounded-full">
                    <div class="h-1.5 bg-[#0e48c1] rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Active Courses</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-1">{{ $activeCourses }}</p>
                <p class="text-[12px] font-medium text-gray-400">This semester</p>
            </div>
            <div class="bg-[#fff5f0] rounded-[1.5rem] p-6 border border-orange-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)]">
                <p class="text-[11px] font-bold text-orange-400 uppercase tracking-widest mb-3">Pending Feedback</p>
                <p class="text-[34px] font-bold text-gray-900 leading-none mb-1">{{ $pendingFeedback }}</p>
                <a href="/student/feedback" class="text-[12px] font-bold text-orange-500 hover:underline">Complete now
                    →</a>
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
                    @forelse($pendingEvaluations as $course)
                        <div class="flex items-center gap-4 p-5 bg-[#f8fafc] rounded-2xl border-l-4 border-[#0e48c1]">
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-gray-400 mb-1">{{ $course->code }} • {{ $course->semester ?? 'Current Sem' }}</p>
                                <p class="text-[16px] font-bold text-gray-900">{{ $course->title }}</p>
                                <p class="text-[12px] text-gray-400 font-medium mt-0.5">{{ $course->faculty->first()?->name ?? 'TBA' }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-[11px] font-bold text-gray-400 mb-2">Needs Feedback</p>
                                <a href="{{ route('student.feedback', $course->id) }}"
                                    class="inline-block bg-[#0e48c1] text-white text-[12px] font-bold px-4 py-2 rounded-xl hover:bg-blue-800 transition-colors">
                                    Evaluate →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-gray-500 font-medium">All caught up! No pending evaluations.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="space-y-4">
                <div class="bg-[#0e48c1] rounded-[2rem] p-7 text-white">
                    <p class="text-blue-200 text-[13px] font-semibold mb-2">Feedback Activity</p>
                    <p class="text-[42px] font-bold leading-none mb-1">{{ $feedbackRate }}%</p>
                    <p class="text-blue-200 text-[12px] font-medium">{{ $feedbackRate >= 80 ? 'Exceptional Contributor' : ($feedbackRate >= 50 ? 'Good Contributor' : 'Needs Improvement') }}</p>
                    <div class="mt-4 w-full h-1.5 bg-white/20 rounded-full">
                        <div class="h-1.5 bg-white rounded-full" style="width: {{ $feedbackRate }}%"></div>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                    <p class="text-[13px] font-bold text-gray-500 mb-4">Recent Submission</p>
                    @if($recentSubmission)
                        <p class="text-[14px] font-bold text-gray-900 mb-1">{{ $recentSubmission->course->title }}</p>
                        <p class="text-[12px] text-gray-400">{{ $recentSubmission->course->code }} · {{ $recentSubmission->created_at->diffForHumans() }}</p>
                        <span
                            class="inline-block mt-3 text-[10px] font-bold bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full">✓
                            Submitted</span>
                    @else
                        <p class="text-[12px] text-gray-400">No submissions yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-student>
