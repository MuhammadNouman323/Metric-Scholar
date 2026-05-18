<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="relative">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="Search records..."
                    class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-[13px] placeholder-gray-400 focus:outline-none w-52">
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg></button>
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg></button>
                <img src="https://i.pravatar.cc/40?img=33"
                    class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm">
            </div>
        </div>

        <!-- Hero Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Main hero -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)]">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <!-- Photo -->
                    <div class="relative shrink-0">
                        <div
                            class="w-[140px] h-[140px] rounded-2xl overflow-hidden border-2 border-[#0e48c1]/10 shadow-md bg-gradient-to-br from-blue-900 to-blue-600 flex items-center justify-center">
                            <img src="https://i.pravatar.cc/200?img=33" alt="Muhammad Saad"
                                class="w-full h-full object-cover">
                        </div>
                        <button
                            class="absolute bottom-2 right-2 w-7 h-7 bg-white rounded-lg shadow-md flex items-center justify-center text-gray-500 hover:text-[#0e48c1] transition-colors border border-gray-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <!-- Info -->
                    <div>
                        <span
                            class="inline-block text-[10px] font-bold text-[#0e48c1] bg-blue-50 px-3 py-1 rounded-full uppercase tracking-wider mb-3">Current
                            {{ ucfirst(auth()->user()->role) }}</span>
                        <h2 class="text-[32px] font-bold text-gray-900 tracking-tight mb-3">{{ auth()->user()->name }}</h2>
                        <div class="flex flex-wrap gap-x-5 gap-y-2 text-[13px] text-gray-500 font-medium">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                    </path>
                                </svg> ID: {{ auth()->user()->university_id }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg> {{ auth()->user()->department }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg> Enrolled {{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Academic Progress -->
                <div class="mt-7 pt-6 border-t border-gray-50">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-[16px] font-bold text-gray-900">Academic Progress</h3>
                        <a href="#" class="text-[12px] font-bold text-[#0e48c1] hover:underline">View Full
                            Transcript</a>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-[#f8fafc] rounded-2xl p-4">
                            <div class="text-[#0e48c1] mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg></div>
                            <p class="text-[11px] text-gray-400 font-medium mb-1">Current GPA</p>
                            <p class="text-[24px] font-bold text-gray-900 leading-none mb-1">N/A</p>
                            <p class="text-[11px] font-semibold text-gray-400">Not tracked yet</p>
                        </div>
                        <div class="bg-[#f8fafc] rounded-2xl p-4">
                            <div class="text-[#0e48c1] mb-2"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg></div>
                            <p class="text-[11px] text-gray-400 font-medium mb-1">Credits Enrolled</p>
                            <p class="text-[24px] font-bold text-gray-900 leading-none mb-2">{{ $totalCredits }}</p>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full">
                                <div class="h-1.5 bg-[#0e48c1] rounded-full" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="bg-[#f8fafc] rounded-2xl p-4">
                            <div class="text-orange-400 mb-2"><svg class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg></div>
                            <p class="text-[11px] text-gray-400 font-medium mb-1">Feedback Activity</p>
                            <p class="text-[24px] font-bold text-gray-900 leading-none mb-1">{{ $feedbackRate }}%</p>
                            <p class="text-[11px] font-semibold text-orange-500">{{ $feedbackRate >= 80 ? 'Exceptional Contributor' : ($feedbackRate >= 50 ? 'Good Contributor' : 'Needs Improvement') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <!-- Privacy Controls -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-[#0e48c1]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <h3 class="text-[16px] font-bold text-gray-900">Privacy Controls</h3>
                    </div>
                    <p class="text-[12px] text-gray-500 font-medium mb-5">Scholar Metric prioritizes your academic
                        integrity. These settings control how your data is shared with faculty and administrators.</p>
                    <div class="space-y-3 mb-5">
                        <!-- Toggle 1 -->
                        <div class="flex items-center gap-3 p-3 bg-[#f8fafc] rounded-2xl">
                            <div
                                class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-[#0e48c1] shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg></div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-gray-900">Feedback Anonymity</p>
                                <p class="text-[11px] text-gray-400">Hide your identity in reviews</p>
                            </div>
                            <div class="w-10 h-6 bg-[#0e48c1] rounded-full relative cursor-pointer shrink-0">
                                <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                            </div>
                        </div>
                        <!-- Toggle 2 -->
                        <div class="flex items-center gap-3 p-3 bg-[#f8fafc] rounded-2xl">
                            <div
                                class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-[#0e48c1] shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg></div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-gray-900">Aggregate Sharing</p>
                                <p class="text-[11px] text-gray-400">Used for institutional metrics</p>
                            </div>
                            <div class="w-10 h-6 bg-[#0e48c1] rounded-full relative cursor-pointer shrink-0">
                                <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                            </div>
                        </div>
                        <!-- Toggle 3 -->
                        <div class="flex items-center gap-3 p-3 bg-[#f8fafc] rounded-2xl">
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                    </path>
                                </svg></div>
                            <div class="flex-1">
                                <p class="text-[13px] font-bold text-gray-900">Peer Discovery</p>
                                <p class="text-[11px] text-gray-400">Currently Disabled</p>
                            </div>
                            <div class="w-10 h-6 bg-gray-200 rounded-full relative cursor-pointer shrink-0">
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full bg-[#0e48c1] text-white text-[13px] font-bold py-3 rounded-xl hover:bg-blue-800 transition-colors mb-2">Update
                        Privacy Policy</button>
                    <p class="text-[11px] text-gray-400 text-center">Last updated: October 24, 2023</p>
                </div>

                <!-- Enrollment Details -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)]">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Enrollment Details
                    </p>
                    <div class="space-y-3">
                        <div class="flex justify-between text-[13px]"><span class="font-medium text-gray-500">Academic
                                Year</span><span class="font-bold text-gray-900">Senior (Year 3)</span></div>
                        <div class="flex justify-between text-[13px]"><span
                                class="font-medium text-gray-500">Campus</span><span
                                class="font-bold text-gray-900">VULHR-49</span></div>
                        <div class="flex justify-between text-[13px]"><span
                                class="font-medium text-gray-500">Advisor</span><span
                                class="font-bold text-[#0e48c1]">Dr. Haroon</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluation History -->
        <div>
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-[20px] font-bold text-gray-900">Evaluation History</h3>
                <button class="p-2 rounded-xl text-gray-400 hover:bg-gray-100"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z">
                        </path>
                    </svg></button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @forelse($submissions as $submission)
                    <div class="bg-white rounded-[1.5rem] p-5 border border-gray-100 shadow-sm flex gap-4">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-purple-800 shrink-0 flex items-center justify-center text-white text-[10px] font-bold text-center p-2">
                            {{ strtoupper(substr($submission->course->title, 0, 10)) }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-[11px] font-bold text-[#0e48c1]">{{ $submission->course->code }}</p>
                                <span
                                    class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full shrink-0">Submitted</span>
                            </div>
                            <p class="text-[14px] font-bold text-gray-900 mb-1">{{ $submission->course->title }}</p>
                            <p class="text-[12px] text-gray-500 italic mb-3">"{{ Str::limit($submission->comments, 40) }}"</p>
                            <div class="flex items-center gap-3 text-[11px] text-gray-400 font-medium">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> {{ $submission->created_at->diffForHumans() }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg> Anonymous</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 p-6 text-center border border-dashed border-gray-200 rounded-2xl">
                        <p class="text-gray-500">No evaluation history available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-student>
