<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div class="flex flex-col gap-1">
                <div class="flex items-center text-[12px] font-semibold text-gray-500 mb-2">
                    <span>Academic Curator</span>
                    <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-[#0e48c1]">Manage Courses</span>
                </div>
                <h1 class="text-[32px] font-bold text-[#1f2937] mb-1 tracking-tight">Curricular Catalog</h1>
                <p class="text-gray-500 text-[15px] font-medium">Manage and audit the institution's academic offerings for the current cycle.</p>
            </div>
            
            <button class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-6 py-3.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Course
            </button>
        </div>

        <!-- Filters Row -->
        <div class="flex flex-col lg:flex-row gap-4 items-center w-full">
            <!-- Semester Pills -->
            <div class="flex items-center bg-white border border-gray-100 rounded-[1rem] p-1 shadow-sm w-full lg:w-auto overflow-x-auto">
                <button class="px-6 py-2.5 text-[13px] font-bold text-[#0e48c1] bg-[#e0e7ff] rounded-[0.8rem] whitespace-nowrap">
                    All Semesters
                </button>
                <button class="px-6 py-2.5 text-[13px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-[0.8rem] transition-colors whitespace-nowrap">
                    Spring 2024
                </button>
                <button class="px-6 py-2.5 text-[13px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-[0.8rem] transition-colors whitespace-nowrap">
                    Fall 2024
                </button>
            </div>

            <div class="flex items-center gap-4 w-full lg:w-auto ml-auto">
                <!-- Departments Dropdown -->
                <div class="relative w-full lg:w-[240px]">
                    <select class="w-full bg-white border border-gray-100 shadow-sm rounded-xl px-4 py-3 text-gray-700 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] text-[13px]">
                        <option>All Departments</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full lg:w-auto">
                    <button class="w-full flex items-center justify-between gap-3 bg-white border border-gray-100 shadow-sm rounded-xl px-4 py-3 text-gray-700 font-bold text-[13px] hover:bg-gray-50 transition-colors">
                        Status: All
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Enrollment -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm flex flex-col justify-between">
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">TOTAL ENROLLMENT</h4>
                <div class="flex items-center justify-between mt-auto">
                    <div class="text-[36px] font-extrabold text-[#0e48c1] leading-none">2,840</div>
                    <span class="bg-[#dcfce7] text-[#166534] text-[12px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        12%
                    </span>
                </div>
            </div>

            <!-- Active Courses -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm flex flex-col justify-between">
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">ACTIVE COURSES</h4>
                <div class="flex flex-row items-end justify-between mt-auto">
                    <div class="text-[36px] font-extrabold text-[#0e48c1] leading-none">142</div>
                    <span class="text-[12px] font-medium text-gray-500 pb-1">8 New this semester</span>
                </div>
            </div>

            <!-- Pending Evaluations -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm flex flex-col justify-between">
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">PENDING EVALUATIONS</h4>
                <div class="flex flex-row items-center justify-between mt-auto gap-4">
                    <div class="text-[36px] font-extrabold text-[#c2410c] leading-none">14</div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-1 flex-1">
                        <div class="bg-[#0e48c1] h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest whitespace-nowrap">
                        COURSE NAME</th>
                        <th class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[150px]">
                        COURSE<br>CODE</th>
                        <th class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[160px]">
                        DEPARTMENT</th>
                        <th class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[150px]">
                        SEMESTER</th>
                        <th class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-right w-[150px]">
                        ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#eff6ff] rounded-[1rem] flex items-center justify-center text-[#0e48c1]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[15px] font-bold text-[#1f2937] leading-tight mb-0.5">Advanced Algorithm<br>Design</span>
                                    <span class="text-[12px] font-medium text-gray-500">34 Students Enrolled</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-block px-3 py-1.5 bg-gray-100 text-gray-600 text-[12px] font-bold rounded-lg uppercase tracking-wide">CS-402</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-[14px] font-bold text-[#1f2937]">Computer<br>Science</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">Spring 2024</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 text-gray-400">
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </button>
                                <button class="hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#fff7ed] rounded-[1rem] flex items-center justify-center text-[#ea580c]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[15px] font-bold text-[#1f2937] leading-tight mb-0.5">Behavioral Economics</span>
                                    <span class="text-[12px] font-medium text-gray-500">28 Students Enrolled</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-block px-3 py-1.5 bg-gray-100 text-gray-600 text-[12px] font-bold rounded-lg uppercase tracking-wide">ECON-215</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-[14px] font-bold text-[#1f2937]">Economics</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 bg-[#f1f5f9] text-[#64748b] text-[12px] font-bold rounded-full">Fall 2024</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 text-gray-400">
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </button>
                                <button class="hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#eff6ff] rounded-[1rem] flex items-center justify-center text-[#0e48c1]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[15px] font-bold text-[#1f2937] leading-tight mb-0.5">Digital Humanities 101</span>
                                    <span class="text-[12px] font-medium text-gray-500">45 Students Enrolled</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-block px-3 py-1.5 bg-gray-100 text-gray-600 text-[12px] font-bold rounded-lg uppercase tracking-wide">HUM-101</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-[14px] font-bold text-[#1f2937]">Humanities</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">Spring 2024</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 text-gray-400">
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </button>
                                <button class="hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150 group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#eff6ff] rounded-[1rem] flex items-center justify-center text-[#0e48c1]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[15px] font-bold text-[#1f2937] leading-tight mb-0.5">UI/UX System Architecture</span>
                                    <span class="text-[12px] font-medium text-gray-500">18 Students Enrolled</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-block px-3 py-1.5 bg-gray-100 text-gray-600 text-[12px] font-bold rounded-lg uppercase tracking-wide">DSGN-305</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="text-[14px] font-bold text-[#1f2937]">Design</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">Spring 2024</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2 text-gray-400">
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </button>
                                <button class="hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-[13px] font-medium text-gray-500">
                    Showing 1 to 4 of 142 courses
                </div>
                <div class="flex items-center gap-2">
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-[#0e48c1] transition-colors duration-150 disabled:opacity-50" disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0e48c1] text-white font-bold text-[13px] shadow-sm hover:bg-[#0a389f] transition-colors duration-150">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">3</button>
                    <span class="px-1 text-gray-400 font-bold">...</span>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">36</button>
                    <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#0e48c1] transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-admin>
