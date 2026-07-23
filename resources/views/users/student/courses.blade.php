<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-5">
            <div class="flex items-center gap-3">
                <h1 class="text-[22px] font-bold text-gray-900">Feedback Hub</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search courses..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-[13px] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 w-48">
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

        <!-- Hero -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-[32px] font-bold text-gray-900 tracking-tight mb-2">My Enrolled Courses</h2>
                    <p class="text-[14px] text-gray-500 font-medium">Managing your academic journey through curated
                        feedback and performance analytics for the {{ currentTerm() }} Semester.</p>
                </div>
                <div class="flex gap-3 shrink-0">
                    <button
                        class="flex items-center gap-2 border border-gray-200 bg-white text-gray-700 px-5 py-2.5 rounded-xl text-[13px] font-bold hover:bg-gray-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z">
                            </path>
                        </svg>
                        Filter
                    </button>
                    
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Total Credits</p>
                    <p class="text-[28px] font-bold text-gray-900 leading-none">{{ $totalCredits }}</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Current GPA</p>
                    <p class="text-[28px] font-bold text-gray-900 leading-none">N/A</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <p class="text-[12px] text-gray-400 font-medium mb-1">Active Courses</p>
                    <p class="text-[28px] font-bold text-gray-900 leading-none">{{ $activeCourses }}</p>
                </div>
                <div class="bg-[#fff5f0] rounded-2xl p-5 border border-orange-100 shadow-sm">
                    <p class="text-[12px] text-orange-500 font-bold mb-1">Pending Feedback</p>
                    <p class="text-[28px] font-bold text-gray-900 leading-none">{{ $pendingFeedback }}</p>
                </div>
            </div>

            <!-- Course Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse($courses as $course)
                    <div
                        class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                        <div class="flex items-start justify-between">
                            <span
                                class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full uppercase tracking-wide">{{ $course->department ?? 'General' }}</span>
                            @php
                                $instructor = $course->faculty->first();
                            @endphp
                            <img src="{{ $instructor ? $instructor->avatar_url : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2232%22 height=%2232%22 viewBox=%220 0 32 32%22%3E%3Crect width=%2232%22 height=%2232%22 fill=%22%230e48c1%22 rx=%226%22/%3E%3Ctext x=%2216%22 y=%2216%22 text-anchor=%22middle%22 dominant-baseline=%22central%22 font-family=%22system-ui,sans-serif%22 font-size=%2213%22 font-weight=%22600%22 fill=%22%23fff%22%3ETBA%3C/text%3E%3C/svg%3E' }}"
                                alt="{{ $instructor ? $instructor->name : 'TBA' }}"
                                class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-[15px] font-bold text-[#0e48c1] mb-2 leading-snug">{{ $course->title }}</h4>
                            <p class="text-[13px] text-gray-500 leading-relaxed">{{ $course->description ?? 'Course description not available' }}</p>
                        </div>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-[12px] text-gray-500 font-medium">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                                {{ $course->faculty->isNotEmpty() ? $course->faculty->first()->name : 'TBA' }}
                            </div>
                            <div class="flex items-center gap-2 text-[12px] text-gray-500 font-medium">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ currentTerm() }} • Course {{ $course->code ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="flex gap-2 pt-1 border-t border-gray-50">
                            <button
                                class="flex-1 border border-gray-200 text-gray-700 text-[12px] font-bold py-2.5 rounded-xl hover:bg-gray-50 transition-colors">Details</button>
                            <a href="{{ route('student.feedback', $course->id) }}"
                                class="flex-1 bg-[#0e48c1] text-white text-[12px] font-bold py-2.5 rounded-xl hover:bg-blue-800 transition-colors text-center">Feedback</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 font-medium">You are not enrolled in any courses yet.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-student>
