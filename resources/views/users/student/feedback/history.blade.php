<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-[22px] font-bold text-gray-900">Feedback Hub</h1>
        </div>

        <!-- Top Hero Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
            <!-- Your Voice Matters -->
            <div class="lg:col-span-2 bg-[#0e48c1] rounded-[2rem] p-8 text-white relative overflow-hidden">
                <h2 class="text-[28px] font-bold mb-2">Your Voice Matters.</h2>
                <p class="text-blue-200 text-[14px] font-medium mb-6">Your feedback has helped improve <span
                        class="text-white font-bold underline">{{ $submissions->count() }} courses</span> this academic year.</p>
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        @foreach ([44, 45, 46] as $img)
                            <img src="https://i.pravatar.cc/32?img={{ $img }}"
                                class="w-8 h-8 rounded-full border-2 border-[#0e48c1] object-cover">
                        @endforeach
                        <div
                            class="w-8 h-8 rounded-full border-2 border-[#0e48c1] bg-white/20 flex items-center justify-center text-[10px] font-bold">
                            +12</div>
                    </div>
                    <p class="text-blue-200 text-[13px] font-medium">Join 4,200 students shaping the future of our
                        curriculum.</p>
                </div>
            </div>

            <!-- Engagement -->
            <div
                class="bg-[#fff5f0] rounded-[2rem] p-8 border border-orange-100 flex flex-col items-center justify-center text-center">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 mb-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                @php
                    $totalCourses = auth()->user()->courses()->count();
                    $feedbackRate = $totalCourses > 0 ? round(($submissions->count() / $totalCourses) * 100) : 0;
                @endphp
                <p class="text-[36px] font-bold text-gray-900 leading-none mb-1">{{ $feedbackRate }}%</p>
                <p class="text-[11px] font-bold text-orange-500 uppercase tracking-widest mb-2">Overall Engagement</p>
                <p class="text-[12px] text-gray-500 font-medium">You are among the most active contributors in your faculty.</p>
            </div>
        </div>

        <!-- Main Content: Active + History -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Active Feedback -->
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-[18px] font-bold text-[#0e48c1]">Active Feedback</h3>
                    <span class="text-[11px] font-bold bg-orange-50 text-orange-600 px-2.5 py-1 rounded-full">{{ $pendingFeedback }} Action
                        Items</span>
                </div>
                <div class="space-y-4">
                    @forelse($pendingCourses->take(3) as $course)
                        <div class="bg-white rounded-2xl p-5 border-l-4 border-[#0e48c1] border border-gray-100 shadow-sm flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 mb-1">{{ $course->code }} • {{ $course->semester ?? 'Current Sem' }}</p>
                                <p class="text-[18px] font-bold text-gray-900">{{ $course->title }}</p>
                                <div class="flex items-center gap-1.5 mt-1 text-[12px] text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $course->faculty->first()?->name ?? 'TBA' }}
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <p class="text-[11px] font-bold text-red-500 mb-2 flex items-center gap-1">Needs Feedback</p>
                                <a href="{{ route('student.feedback', $course->id) }}" class="inline-flex items-center gap-1.5 bg-[#0e48c1] text-white text-[12px] font-bold px-4 py-2.5 rounded-xl hover:bg-blue-800 transition-colors">
                                    Complete Evaluation <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <p class="text-gray-500 font-medium">All caught up! No pending evaluations.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- History -->
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-[18px] font-bold text-gray-900">History</h3>
                    <a href="/student/feedback/history"
                        class="text-[13px] font-bold text-[#0e48c1] hover:underline">View All</a>
                </div>
                <div class="relative pl-6">
                    <div class="absolute left-2 top-2 bottom-2 w-0.5 bg-gray-100"></div>
                    <div class="space-y-5">
                        @forelse($submissions as $index => $submission)
                            <div class="relative">
                                <div class="absolute -left-6 top-1.5 w-3 h-3 rounded-full {{ $index === 0 ? 'bg-[#0e48c1]' : 'bg-gray-200' }} border-2 border-white {{ $index === 0 ? 'shadow-sm' : '' }}"></div>
                                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="text-[14px] font-bold text-gray-900">{{ $submission->course->title }}</p>
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Submitted</span>
                                    </div>
                                    <p class="text-[11px] text-gray-400 font-medium mb-3">Submitted on {{ $submission->updated_at->format('M j, Y') }}</p>
                                    <div class="flex gap-3 text-[11px] font-bold text-[#0e48c1]">
                                        <span class="flex items-center gap-1">
                                            Feedback is fully anonymous and unlinked from your account.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-gray-500 font-medium">No feedback submitted yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- How feedback is used -->
        <div
            class="bg-white rounded-[2rem] p-7 border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
            <div>
                <h3 class="text-[16px] font-bold text-gray-900 mb-2">How your feedback is used</h3>
                <p class="text-[13px] text-gray-500 font-medium max-w-lg">Scholar Metric anonymizes your feedback
                    before sharing it with faculty leads. Your responses directly influence faculty performance reviews
                    and curriculum adjustments for the following semester.</p>
            </div>
            <div class="flex gap-3 shrink-0">
                <button
                    class="border border-gray-200 text-gray-700 text-[12px] font-bold px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-colors whitespace-nowrap">Read
                    Our Privacy Policy</button>
                <button
                    class="border border-gray-200 text-gray-700 text-[12px] font-bold px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">Methodology</button>
            </div>
        </div>
    </div>
</x-student>
