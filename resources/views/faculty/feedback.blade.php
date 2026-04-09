<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 tracking-tight">Faculty Feedback</h1>
            <div class="flex items-center gap-3">
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
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
                <button
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-[0_4px_12px_rgba(14,72,193,0.2)] hover:bg-blue-800 transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Report
                </button>
            </div>
        </div>

        <!-- Top Stats Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Overview Score (large card, 2/3 width) -->
            <div
                class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-[26px] font-bold text-[#0e48c1] mb-1">Overview Score</h2>
                        <p class="text-[14px] text-gray-500 font-medium">Based on 1,240 verified student submissions
                            this semester.</p>
                    </div>
                    <div class="flex items-baseline gap-1.5 shrink-0">
                        <span class="text-[52px] font-bold text-[#0e48c1] leading-none tracking-tight">4.8</span>
                        <span class="text-[22px] font-bold text-gray-300">/ 5.0</span>
                    </div>
                </div>

                <!-- Progress bar -->
                <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden mb-4">
                    <div class="h-full rounded-full flex">
                        <div class="bg-[#0e48c1] h-full" style="width: 85%"></div>
                        <div class="bg-[#93c5fd] h-full" style="width: 10%"></div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center gap-6 text-[12px] font-bold">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#0e48c1]"></div>
                        <span class="text-gray-600 uppercase tracking-wider">Exceeded Expectations (85%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-[#93c5fd]"></div>
                        <span class="text-gray-600 uppercase tracking-wider">Met Expectations (10%)</span>
                    </div>
                </div>
            </div>

            <!-- Right side mini-cards (1/3 width) -->
            <div class="flex flex-col gap-4">
                <!-- Engagement Rate -->
                <div class="bg-[#0e48c1] rounded-[1.5rem] p-6 flex-1 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span
                            class="text-[11px] font-bold bg-white/20 text-white px-2.5 py-1 rounded-full">+12% vs
                            LY</span>
                    </div>
                    <p class="text-blue-200 text-[13px] font-semibold mb-1">Engagement Rate</p>
                    <p class="text-white text-[34px] font-bold leading-none tracking-tight">94.2%</p>
                </div>

                <!-- Recent Feedback -->
                <div class="bg-[#fff0eb] rounded-[1.5rem] p-6 flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center text-orange-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-[11px] font-bold text-orange-600 bg-orange-100 px-2.5 py-1 rounded-full">Active</span>
                    </div>
                    <p class="text-orange-400 text-[13px] font-semibold mb-1">Recent Feedback</p>
                    <p class="text-gray-900 text-[34px] font-bold leading-none tracking-tight">42 <span
                            class="text-[22px]">New</span></p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Course Filter -->
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-[13px] font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 cursor-pointer shadow-sm">
                        <option>All Courses</option>
                        <option>PHY402</option>
                        <option>CS205</option>
                        <option>ECO101</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sort -->
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-[13px] font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 cursor-pointer shadow-sm">
                        <option>Most Recent</option>
                        <option>Highest Rated</option>
                        <option>Lowest Rated</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- View Toggle -->
            <div class="flex items-center gap-2">
                <button id="grid-view-btn"
                    class="w-9 h-9 bg-[#0e48c1] text-white rounded-xl flex items-center justify-center shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </button>
                <button id="list-view-btn"
                    class="w-9 h-9 bg-gray-100 text-gray-500 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Feedback Cards Grid -->
        <div id="feedback-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            <!-- Card 1 - PHY402 ★★★★★ -->
            <div
                class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span
                        class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">PHY402</span>
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-[14px] text-gray-800 leading-relaxed font-medium flex-1">
                    "Dr. Academic has an incredible way of explaining complex quantum concepts through real-world
                    analogies..."
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-[12px] font-medium">Anonymous Student</span>
                    </div>
                    <span class="text-[11px] font-bold text-gray-400 tracking-wide">OCT 24, 2023</span>
                </div>
            </div>

            <!-- Card 2 - CS205 ★★★★ -->
            <div
                class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span
                        class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">CS205</span>
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < 4; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <svg class="w-4 h-4 fill-current text-gray-200" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
                <p class="text-[14px] text-gray-800 leading-relaxed font-medium flex-1">
                    "Great lectures, though the midterm was quite difficult. I appreciated the extra office hours and
                    support..."
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-[12px] font-medium">Anonymous Student</span>
                    </div>
                    <span class="text-[11px] font-bold text-gray-400 tracking-wide">OCT 21, 2023</span>
                </div>
            </div>

            <!-- Card 3 - ECO101 ★★★★★ -->
            <div
                class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span
                        class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">ECO101</span>
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-[14px] text-gray-800 leading-relaxed font-medium flex-1">
                    "The real-world case studies made economic theory much easier to digest. Highly recommend this
                    course..."
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-[12px] font-medium">Anonymous Student</span>
                    </div>
                    <span class="text-[11px] font-bold text-gray-400 tracking-wide">OCT 18, 2023</span>
                </div>
            </div>

            <!-- Card 4 - PHY402 ★★★★★ -->
            <div
                class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span
                        class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">PHY402</span>
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-[14px] text-gray-800 leading-relaxed font-medium flex-1">
                    "The integration of research papers into the syllabus was brilliant. It felt like we were learning
                    at the frontier of the field..."
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-[12px] font-medium">Anonymous Student</span>
                    </div>
                    <span class="text-[11px] font-bold text-gray-400 tracking-wide">OCT 15, 2023</span>
                </div>
            </div>

            <!-- Card 5 - CS205 ★★★ -->
            <div
                class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-shadow flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span
                        class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">CS205</span>
                    <div class="flex text-amber-400">
                        @for ($i = 0; $i < 3; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        @for ($i = 0; $i < 2; $i++)
                            <svg class="w-4 h-4 fill-current text-gray-200" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-[14px] text-gray-800 leading-relaxed font-medium flex-1">
                    "Course content is solid, but the grading on the final project felt a bit subjective. Otherwise,
                    Dr. Academic is approachable..."
                </p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-[12px] font-medium">Anonymous Student</span>
                    </div>
                    <span class="text-[11px] font-bold text-gray-400 tracking-wide">OCT 12, 2023</span>
                </div>
            </div>

            <!-- Load More Card -->
            <div
                class="rounded-[1.5rem] p-6 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center gap-3 cursor-pointer hover:border-[#0e48c1] hover:bg-blue-50/30 transition-all group min-h-[200px]">
                <div
                    class="w-12 h-12 rounded-full bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#0e48c1] transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-[14px] font-bold text-[#0e48c1]">Load More Entries</p>
                <p class="text-[12px] text-gray-400 font-medium">Viewing 5 of 1,240 results</p>
            </div>

        </div>
    </div>
</x-faculty>
