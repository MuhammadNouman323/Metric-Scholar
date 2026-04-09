<x-faculty>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
            <h1 class="text-[13px] font-bold text-gray-400 uppercase tracking-[0.2em]">Faculty Profile</h1>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search publications..."
                        class="bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-[13px] text-gray-600 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 w-52">
                </div>
                <button class="p-2.5 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Hero Profile Card -->
        <div
            class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.04)] mb-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Photo + Info -->
                <div class="flex flex-col sm:flex-row gap-7 flex-1">
                    <!-- Photo -->
                    <div class="shrink-0">
                        <img src="https://i.pravatar.cc/300?img=69" alt="Dr. Julian Academic"
                            class="w-[180px] h-[210px] object-cover rounded-2xl shadow-md bg-gray-100">
                    </div>

                    <!-- Info -->
                    <div class="flex flex-col justify-center gap-3">
                        <div>
                            <p class="text-[11px] font-bold text-[#0e48c1] uppercase tracking-[0.15em] mb-2">Faculty
                                Excellence</p>
                            <h2 class="text-[32px] font-bold text-gray-900 leading-tight tracking-tight">Dr. Julian
                                Academic</h2>
                            <p class="text-[15px] font-medium text-gray-500 mt-1">Senior Professor of Computational
                                Ethics</p>
                        </div>

                        <div class="space-y-2 mt-1">
                            <div class="flex items-center gap-2.5 text-[13px] text-gray-500 font-medium">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                Dept. of Humanities & Technology
                            </div>
                            <div class="flex items-center gap-2.5 text-[13px] text-gray-500 font-medium">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                j.academic@university.edu
                            </div>
                            <div class="flex items-center gap-2.5 text-[13px] text-gray-500 font-medium">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                North Hall, Room 402
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-wrap gap-3 mt-3">
                            <button
                                class="bg-[#0e48c1] text-white text-[13px] font-bold px-6 py-2.5 rounded-xl hover:bg-blue-800 transition-colors shadow-sm">
                                Download CV
                            </button>
                            <button
                                class="bg-white border border-gray-200 text-gray-700 text-[13px] font-bold px-6 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                                Contact Office
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Grid (2x2) -->
                <div class="grid grid-cols-2 gap-3 self-start lg:w-[260px] shrink-0">
                    <!-- Teaching Score -->
                    <div class="bg-[#eff4ff] rounded-2xl p-5 flex flex-col items-center text-center">
                        <div class="text-[#0e48c1] mb-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div class="text-[24px] font-bold text-[#0e48c1] leading-none mb-1">4.9<span
                                class="text-[14px] font-bold text-blue-300">/5</span></div>
                        <div class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">Teaching Score</div>
                    </div>

                    <!-- Citations -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center text-center shadow-sm">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="text-[24px] font-bold text-gray-900 leading-none mb-1">124</div>
                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Citations</div>
                    </div>

                    <!-- PhD Advisees -->
                    <div class="bg-[#fff5f0] border border-orange-100 rounded-2xl p-5 flex flex-col items-center text-center">
                        <div class="text-orange-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-[24px] font-bold text-gray-900 leading-none mb-1">15</div>
                        <div class="text-[9px] font-bold text-orange-400 uppercase tracking-widest">PhD Advisees</div>
                    </div>

                    <!-- Tenure Length -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-5 flex flex-col items-center text-center shadow-sm">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-[24px] font-bold text-gray-900 leading-none mb-1">22<span
                                class="text-[14px]">y</span></div>
                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Tenure Length</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Bio -->
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-6 bg-[#0e48c1] rounded-full"></div>
                <h3 class="text-[20px] font-bold text-gray-900">Academic Bio</h3>
            </div>
            <div class="space-y-4 text-[14px] leading-relaxed text-gray-600 max-w-4xl">
                <p>Dr. Julian Academic is a leading figure in the intersection of philosophy and emerging technology.
                    With over two decades of experience, his work focuses on the ethical frameworks required for
                    autonomous systems and the preservation of humanistic values in the digital age. He has served as a
                    senior advisor to several international ethics committees and is a frequent keynote speaker at global
                    technology summits.</p>
                <p>His research methodology blends classical philosophical inquiry with modern data science, creating a
                    unique cross-disciplinary bridge. Under his leadership, the Humanities & Technology department has
                    seen a 40% increase in interdisciplinary research grants and the establishment of the university's
                    first Ethics in AI laboratory.</p>
            </div>
        </div>

        <!-- Bottom Row: Publications + Teaching Load -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Recent Publications -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-[20px] font-bold text-gray-900">Recent Publications</h3>
                    <a href="#"
                        class="text-[13px] font-bold text-[#0e48c1] hover:underline flex items-center gap-1">
                        View All
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    <!-- Publication 1 -->
                    <div
                        class="bg-[#f8fafc] rounded-2xl p-5 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-[10px] font-bold text-[#0e48c1] bg-blue-50 px-2.5 py-1 rounded-md uppercase tracking-wide">Journal
                                Article</span>
                            <span class="text-[11px] font-medium text-gray-400">Oct 2023</span>
                        </div>
                        <h4 class="text-[14px] font-bold text-gray-900 mb-1.5 leading-snug">Ghost in the Machine:
                            Re-evaluating Cartesian Dualism in Neural Networks</h4>
                        <p class="text-[12px] text-gray-400 font-medium">International Journal of Digital Philosophy,
                            Vol 42, Issue 3</p>
                    </div>

                    <!-- Publication 2 -->
                    <div
                        class="bg-[#f8fafc] rounded-2xl p-5 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-md uppercase tracking-wide">Book
                                Chapter</span>
                            <span class="text-[11px] font-medium text-gray-400">May 2023</span>
                        </div>
                        <h4 class="text-[14px] font-bold text-gray-900 mb-1.5 leading-snug">The Algorithmic Commons:
                            Shared Values in Data Governance</h4>
                        <p class="text-[12px] text-gray-400 font-medium">Ethics for the Next Century, Oxford Press</p>
                    </div>

                    <!-- Publication 3 -->
                    <div
                        class="bg-[#f8fafc] rounded-2xl p-5 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md uppercase tracking-wide">Conference
                                Paper</span>
                            <span class="text-[11px] font-medium text-gray-400">Jan 2023</span>
                        </div>
                        <h4 class="text-[14px] font-bold text-gray-900 mb-1.5 leading-snug">Measuring Moral Weight in
                            Automated Decision Systems</h4>
                        <p class="text-[12px] text-gray-400 font-medium">Proceedings of the Global AI Ethics Summit
                        </p>
                    </div>
                </div>
            </div>

            <!-- Current Teaching Load -->
            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <h3 class="text-[20px] font-bold text-gray-900 mb-6">Current Teaching Load</h3>

                <div class="space-y-3 mb-5">
                    <!-- Course 1 -->
                    <div
                        class="flex items-center gap-4 bg-[#f8fafc] rounded-2xl p-4 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div
                            class="w-11 h-11 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[10px] font-bold text-[#0e48c1] shrink-0">
                            ETH
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-[13px] font-bold text-gray-900 leading-snug">ETH-402: Ethics of
                                    Automation</p>
                                <span
                                    class="text-[10px] font-bold text-[#0e48c1] bg-blue-50 px-2 py-0.5 rounded-md shrink-0 whitespace-nowrap">45
                                    Students</span>
                            </div>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Tue/Thu • 2:00 PM – 3:30 PM</p>
                            <div class="w-full h-1 bg-gray-100 rounded-full mt-2">
                                <div class="h-1 bg-[#0e48c1] rounded-full" style="width: 37%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Course 2 -->
                    <div
                        class="flex items-center gap-4 bg-[#f8fafc] rounded-2xl p-4 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div
                            class="w-11 h-11 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[10px] font-bold text-[#0e48c1] shrink-0">
                            LOG
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-[13px] font-bold text-gray-900 leading-snug">LOG-210: Computational
                                    Logic</p>
                                <span
                                    class="text-[10px] font-bold text-[#0e48c1] bg-blue-50 px-2 py-0.5 rounded-md shrink-0 whitespace-nowrap">120
                                    Students</span>
                            </div>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Mon/Wed • 10:00 AM – 11:30 AM</p>
                            <div class="w-full h-1 bg-gray-100 rounded-full mt-2">
                                <div class="h-1 bg-[#0e48c1] rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Course 3 -->
                    <div
                        class="flex items-center gap-4 bg-[#f8fafc] rounded-2xl p-4 border border-gray-100 hover:border-blue-100 transition-colors">
                        <div
                            class="w-11 h-11 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[10px] font-bold text-[#0e48c1] shrink-0">
                            SEM
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-[13px] font-bold text-gray-900 leading-snug">SEM-600: Graduate Research
                                </p>
                                <span
                                    class="text-[10px] font-bold text-[#93c5fd] bg-blue-50 px-2 py-0.5 rounded-md shrink-0 whitespace-nowrap">8
                                    Students</span>
                            </div>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">Fri • 1:00 PM – 4:00 PM</p>
                            <div class="w-full h-1 bg-gray-100 rounded-full mt-2">
                                <div class="h-1 bg-[#93c5fd] rounded-full" style="width: 7%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office Hours -->
                <div class="bg-[#eff4ff] rounded-2xl p-5 flex gap-3">
                    <div class="text-[#0e48c1] shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[13px] font-bold text-[#0e48c1] mb-1">Office Hours</p>
                        <p class="text-[13px] text-blue-600 font-medium leading-relaxed">Available for drop-ins on
                            Wednesdays from 2:00 PM to 4:00 PM in North Hall 402 or via the virtual lounge.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-faculty>
