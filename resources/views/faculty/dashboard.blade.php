<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <nav class="text-[13px] text-gray-400 font-medium mb-2">
                    <span>Faculty Analytics</span>
                    <span class="mx-2">›</span>
                    <span class="text-[#0e48c1] font-semibold">Academic Year 2023-24</span>
                </nav>
                <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 mb-1.5 tracking-tight">Faculty Overview</h1>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full sm:w-auto">
                <button
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-[0_4px_12px_rgba(14,72,193,0.2)] hover:bg-blue-800 transition-colors flex-1 sm:flex-none whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Report
                </button>
            </div>
        </div>

        <!-- 3 Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 lg:gap-6 mb-10 w-full">
            <!-- Average Rating -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Average Rating</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-[40px] font-bold text-gray-900 tracking-tight leading-none">4.8</span>
                    <span class="text-[18px] font-bold text-gray-300">/ 5.0</span>
                </div>
                <div class="flex items-center gap-1.5 text-[13px] font-semibold text-emerald-600 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    0.4 vs Last Semester
                </div>
            </div>

            <!-- Total Responses -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Total Responses</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-[40px] font-bold text-gray-900 tracking-tight leading-none mb-2">1,248</div>
                <div class="flex items-center gap-1.5 text-[13px] font-semibold text-gray-400 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Across 4 Active Courses
                </div>
            </div>

            <!-- Feedback Completion -->
            <div
                class="bg-white p-7 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-shadow">
                <div class="flex justify-between items-start mb-5">
                    <div class="text-[13px] font-bold text-gray-400 uppercase tracking-wider">Feedback Completion</div>
                    <div class="text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-[40px] font-bold text-gray-900 tracking-tight leading-none mb-3">92.4%</div>
                <div class="w-full bg-[#f1f5f9] rounded-full h-2">
                    <div class="bg-[#0e48c1] h-2 rounded-full" style="width: 92.4%"></div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 w-full">

            <!-- Criteria Performance -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-7">
                    <h3 class="text-[19px] font-bold text-[#0e48c1]">Criteria Performance</h3>
                    <div class="flex items-center gap-1.5 text-[12px] font-bold text-gray-500">
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0e48c1]"></div>
                        Target: 4.5
                    </div>
                </div>
                <div class="space-y-6">
                    <!-- Course Clarity -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Course Clarity</span>
                            <span class="text-[#0e48c1] font-bold">4.9</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: 98%"></div>
                        </div>
                    </div>
                    <!-- Student Support -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Student Support</span>
                            <span class="text-[#0e48c1] font-bold">4.7</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: 94%"></div>
                        </div>
                    </div>
                    <!-- Punctuality -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Punctuality</span>
                            <span class="text-[#0e48c1] font-bold">4.4</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: 88%"></div>
                        </div>
                    </div>
                    <!-- Material Quality -->
                    <div>
                        <div class="flex justify-between text-[13px] font-semibold text-gray-600 mb-2">
                            <span>Material Quality</span>
                            <span class="text-[#0e48c1] font-bold">4.6</span>
                        </div>
                        <div class="w-full bg-[#f1f5f9] rounded-full h-2.5">
                            <div class="bg-[#0e48c1] h-2.5 rounded-full shadow-sm shadow-blue-500/20"
                                style="width: 92%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historical Trend -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-7">
                    <h3 class="text-[19px] font-bold text-gray-900">Historical Trend</h3>
                    <span
                        class="text-[12px] font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg">Last 4 Semesters</span>
                </div>

                <!-- SVG Line Chart -->
                <div class="w-full h-[180px] relative mb-4">
                    <svg viewBox="0 0 600 180" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                        <!-- Grid lines -->
                        <line x1="0" y1="45" x2="600" y2="45" stroke="#f1f5f9" stroke-width="1.5"
                            stroke-dasharray="4 4" />
                        <line x1="0" y1="90" x2="600" y2="90" stroke="#f1f5f9" stroke-width="1.5"
                            stroke-dasharray="4 4" />
                        <line x1="0" y1="135" x2="600" y2="135" stroke="#f1f5f9" stroke-width="1.5"
                            stroke-dasharray="4 4" />

                        <!-- Trend Line -->
                        <path d="M 30 155 Q 170 130 310 110 T 570 35" stroke="#0e48c1" stroke-width="3.5" fill="none"
                            stroke-linecap="round" />

                        <!-- Data Points -->
                        <circle cx="30" cy="155" r="5" fill="white" stroke="#0e48c1" stroke-width="2.5" />
                        <circle cx="210" cy="128" r="5" fill="white" stroke="#0e48c1" stroke-width="2.5" />
                        <circle cx="390" cy="100" r="5" fill="white" stroke="#0e48c1" stroke-width="2.5" />
                        <circle cx="570" cy="35" r="7" fill="#0e48c1" stroke="white" stroke-width="2.5" />
                    </svg>
                </div>

                <!-- X Axis Labels -->
                <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                    <span>Fall '22</span>
                    <span>Spring '23</span>
                    <span>Fall '23</span>
                    <span class="text-[#0e48c1]">Spring '24</span>
                </div>

                <p class="text-[13px] text-gray-500 font-medium mt-5 italic border-t border-gray-50 pt-4">
                    "Performance metrics show a significant upward trend since the introduction of interactive labs."
                </p>
            </div>
        </div>

        <!-- Student Voice -->
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] mb-8">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h3 class="text-[19px] font-bold text-gray-900">Student Voice</h3>
                    <p class="text-[13.5px] text-gray-500 font-medium mt-0.5">Recent anonymous highlights from verified
                        course evaluations</p>
                </div>
                <a href="#"
                    class="text-[13px] font-bold text-[#0e48c1] hover:underline whitespace-nowrap flex items-center gap-1">
                    View All Comments
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-7">
                <!-- Comment 1 -->
                <div class="bg-[#f8fafc] rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-[12px] font-bold">
                                99</div>
                            <div class="flex text-amber-400">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">CS-402</span>
                    </div>
                    <p class="text-[14px] text-gray-700 leading-relaxed mb-4">
                        "Professor Vance explains complex algorithms in a way that just clicks. The real-world examples
                        in the 'Cloud Scalability' module were game-changing for my understanding."
                    </p>
                    <p class="text-[12px] text-gray-400 font-medium">— 3 days ago</p>
                </div>

                <!-- Comment 2 -->
                <div class="bg-[#f8fafc] rounded-2xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-[#0e48c1]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex text-amber-400">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <span
                            class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded">MATH-201</span>
                    </div>
                    <p class="text-[14px] text-gray-700 leading-relaxed mb-4">
                        "Extremely responsive during office hours. I felt supported throughout the difficult final
                        project. Sometimes the lab feedback can be a bit delayed, but always detailed."
                    </p>
                    <p class="text-[12px] text-gray-400 font-medium">— 1 week ago</p>
                </div>
            </div>
        </div>

        <!-- Tenure CTA Banner -->
        <div class="bg-[#0e48c1] rounded-[2rem] p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-[22px] font-bold text-white mb-2">Ready for Tenure Review?</h3>
                <p class="text-blue-200 text-[14px] font-medium max-w-[480px]">
                    Generate your comprehensive performance dossier including response distributions, historical
                    comparisons, and sentiment analysis summaries in a single PDF.
                </p>
            </div>
            <button
                class="bg-white text-[#0e48c1] font-bold text-[14px] px-7 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:bg-blue-50 transition-all whitespace-nowrap flex-shrink-0">
                Export Dossier 2024
            </button>
        </div>

    </div>
</x-faculty>
