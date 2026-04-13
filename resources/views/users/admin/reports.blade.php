<x-admin>
    {{-- <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="relative w-full max-w-xl">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" class="bg-gray-50/80 border-none text-gray-900 text-sm rounded-full focus:ring-blue-500 block w-full pl-11 p-2.5 placeholder-gray-400 font-medium" placeholder="Search reports, faculty, or IDs...">
        </div>

        <div class="flex items-center gap-6">
            <button class="text-gray-400 hover:text-gray-600 relative transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>
            <div class="flex items-center gap-3 border-l border-gray-200 pl-6">
                <div class="text-right">
                    <div class="text-sm font-bold text-gray-900 leading-tight">Admin Profile</div>
                    <div class="text-xs font-medium text-gray-500">System Administrator</div>
                </div>
                <img src="https://i.pravatar.cc/150?img=11" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
            </div>
        </div>
    </header> --}}

    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        <div class="flex justify-between items-start mb-8">
            <div>
                <nav class="flex text-xs font-semibold text-gray-400 mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1">
                        <li class="inline-flex items-center">
                            <a href="#" class="hover:text-blue-600 transition-colors">Admin</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-[#0e48c1]">Reports Management</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-1">Academic Reporting Hub</h1>
                <p class="text-gray-500 font-medium text-sm max-w-lg leading-relaxed">Centralized terminal for faculty
                    performance evaluations, student feedback syntheses, and departmental analytics.</p>
            </div>

            <div class="flex gap-4">
                <button
                    class="flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-[#0e48c1] text-sm font-bold rounded-xl transition-colors">
                    <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Send All Emails
                </button>
                <button
                    class="flex items-center px-6 py-3 bg-[#0e48c1] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-[0_4px_10px_rgba(14,72,193,0.2)] transition-all transform active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Generate All Reports
                </button>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex flex-col justify-between">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Total Reports</div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-extrabold text-[#0e48c1]">1,248</div>
                    <div class="bg-green-50 text-green-600 text-xs font-bold px-2 py-1 rounded-md mb-1">+12% vs LY</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex flex-col justify-between">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pending Review</div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-extrabold text-gray-900">42</div>
                    <div class="text-[#c75e2b] mb-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex flex-col justify-between">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Average Rating</div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-extrabold text-gray-900">4.82</div>
                    <div class="flex text-yellow-400 mb-1.5">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-50 flex flex-col justify-between">
                <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Completion Rate</div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-extrabold text-gray-900">94.2%</div>
                    <div class="w-16 h-2 bg-gray-100 rounded-full mb-2 overflow-hidden">
                        <div class="bg-[#0e48c1] w-[94.2%] h-full rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-50 mb-8 overflow-hidden">

            <div class="px-6 py-5 flex items-center justify-between border-b border-gray-50">
                <div class="flex gap-3">
                    <button
                        class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-full text-sm font-bold text-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Department: All
                    </button>
                    <button
                        class="flex items-center px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-full text-sm font-bold text-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Semester: Fall 2024
                    </button>
                </div>
                <div class="text-sm text-gray-400 font-medium">
                    Showing 1,248 faculty members across 12 departments
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider w-[35%]">
                                Faculty Name</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider w-[25%]">
                                Course / ID</th>
                            <th
                                class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-center">
                                Average Rating</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="https://i.pravatar.cc/150?img=32" alt="Helena"
                                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Dr. Helena Vance</div>
                                        <div class="text-xs font-medium text-gray-400">Senior Lecturer • Psychology
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700 text-sm">PSY-402: Behavioral Neuro</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-0.5">
                                    Section_A_2024</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="font-extrabold text-[#0e48c1] text-lg mb-1">4.92</div>
                                <div class="flex justify-center text-yellow-400 gap-0.5">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 tracking-wide">EVALUATED</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-gray-900 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-[#0e48c1] transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-green-600 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="https://i.pravatar.cc/150?img=12" alt="Julian"
                                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Prof. Julian Thorne</div>
                                        <div class="text-xs font-medium text-gray-400">Lead Researcher • Biology</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700 text-sm">BIO-101: Intro to Genetics</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-0.5">
                                    Section_B_2024</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="font-extrabold text-gray-900 text-lg mb-1">4.65</div>
                                <div class="flex justify-center text-yellow-400 gap-0.5 opacity-80">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current text-gray-200" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 tracking-wide">DRAFT</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-gray-900 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-[#0e48c1] transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-green-600 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="https://i.pravatar.cc/150?img=5" alt="Sarah"
                                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Dr. Sarah Jenkins</div>
                                        <div class="text-xs font-medium text-gray-400">Department Head • Economics
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700 text-sm">ECN-505: Macro Theory</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-0.5">
                                    Section_Grad_24</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="font-extrabold text-[#0e48c1] text-lg mb-1">5.00</div>
                                <div class="flex justify-center text-yellow-400 gap-0.5">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 tracking-wide">EVALUATED</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-gray-900 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-[#0e48c1] transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-green-600 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/50 transition-colors group border-b-0">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img src="https://i.pravatar.cc/150?img=53" alt="Marcus"
                                        class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Prof. Marcus Liang</div>
                                        <div class="text-xs font-medium text-gray-400">Asst. Professor • Mathematics
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700 text-sm">MAT-201: Calculus II</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mt-0.5">
                                    Section_C_2024</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="font-extrabold text-gray-900 text-lg mb-1">4.12</div>
                                <div class="flex justify-center text-yellow-400 gap-0.5 opacity-80">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                    <svg class="w-3 h-3 fill-current text-gray-200" viewBox="0 0 20 20">
                                        <path d="M9.049..."></path>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-[#c75e2b] tracking-wide">ACTION
                                    NEEDED</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-gray-900 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-[#0e48c1] transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg></button>
                                    <button class="hover:text-green-600 transition-colors"><svg class="w-5 h-5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm font-medium text-gray-500">
                    Showing <span class="font-bold text-gray-900">1 - 25</span> of 1,248 faculty members
                </div>
                <div class="flex items-center gap-1">
                    <button class="p-1 text-gray-400 hover:text-gray-900 disabled:opacity-50" disabled><svg
                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg></button>
                    <button class="p-1 text-gray-400 hover:text-gray-900 disabled:opacity-50 mr-2" disabled><svg
                            class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg></button>

                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md bg-[#0e48c1] text-white font-bold text-sm">1</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-200 text-gray-600 font-bold text-sm transition-colors">2</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-200 text-gray-600 font-bold text-sm transition-colors">3</button>
                    <span class="px-1 text-gray-400 font-bold">...</span>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-200 text-gray-600 font-bold text-sm transition-colors">50</button>

                    <button class="p-1 text-gray-400 hover:text-gray-900 ml-2"><svg class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></button>
                    <button class="p-1 text-gray-400 hover:text-gray-900"><svg class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                        </svg></button>
                </div>
            </div>
        </div>

        <div>
            <h2 class="flex items-center text-lg font-bold text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Recent System Activity
            </h2>
            <div class="grid grid-cols-3 gap-5">
                <div class="bg-gray-50/80 rounded-2xl p-5 border border-gray-100 flex gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm mb-1">Batch Reports Generated</div>
                        <div class="text-xs text-gray-500 leading-relaxed mb-3">Economics Department (24 reports)
                            successfully compiled and archived.</div>
                        <div class="text-[10px] font-bold text-[#0e48c1] uppercase tracking-wide">14 Minutes Ago</div>
                    </div>
                </div>

                <div class="bg-gray-50/80 rounded-2xl p-5 border border-gray-100 flex gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-[#0e48c1] shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm mb-1">Emails Dispatched</div>
                        <div class="text-xs text-gray-500 leading-relaxed mb-3">Auto-notification sent to all faculty
                            with ratings above 4.5/5.0.</div>
                        <div class="text-[10px] font-bold text-[#0e48c1] uppercase tracking-wide">1 Hour Ago</div>
                    </div>
                </div>

                <div class="bg-gray-50/80 rounded-2xl p-5 border border-gray-100 flex gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900 text-sm mb-1">Data Anomaly Detected</div>
                        <div class="text-xs text-gray-500 leading-relaxed mb-3">MAT-201 Section C shows significant
                            deviation in student response rate (12%).</div>
                        <div class="text-[10px] font-bold text-[#0e48c1] uppercase tracking-wide">3 Hours Ago</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin>
