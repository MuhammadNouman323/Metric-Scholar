<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">
        <!-- Breadcrumb -->
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.departments') }}" class="hover:text-[#0e48c1]">Departments</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.show', $department) }}" class="hover:text-[#0e48c1]">{{ $departmentName }}</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Manage Department</span>
        </div>

        <!-- Header -->
        <div class="flex items-start gap-4 mb-8">
            <a href="{{ route('admin.departments.show', $department) }}" class="text-gray-500 hover:text-gray-900 transition-colors mt-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                    {{ $departmentName }} - Manage Department
                </h1>
                <p class="text-[15px] font-medium text-gray-500">Manage enrollment, faculty assignments, and course details.</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex items-center gap-8 text-sm font-semibold text-gray-500 overflow-x-auto border-b border-gray-100 mb-8">
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'courses']) }}" class="pb-4 whitespace-nowrap {{ $section === 'courses' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : 'hover:text-gray-900' }}">Courses</a>
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'faculty']) }}" class="pb-4 whitespace-nowrap {{ $section === 'faculty' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : 'hover:text-gray-900' }}">Faculty Assignment</a>
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'enrollment']) }}" class="pb-4 whitespace-nowrap {{ $section === 'enrollment' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : 'hover:text-gray-900' }}">Student Enrollment</a>
        </div>

        @if ($section === 'courses')
            <!-- Actions -->
            <div class="flex justify-end items-center gap-3 mb-6">
                <button class="inline-flex items-center gap-2 rounded-xl bg-[#eff4ff] px-4 py-2.5 text-sm font-bold text-[#0e48c1]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5zm0 0V4" />
                    </svg>
                    View Curriculum
                </button>
                <a href="{{ route('admin.departments.courses.new', $department) }}" class="inline-flex items-center gap-2 rounded-xl bg-[#0e48c1] px-4 py-2.5 text-sm font-bold text-white shadow-[0_4px_12px_rgba(14,72,193,0.2)]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Course
                </a>
            </div>

            <!-- Filters -->
            <div class="flex justify-between items-center bg-gray-50/50 p-2 rounded-2xl mb-6">
                <div class="flex gap-2">
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-100 text-gray-700 text-sm font-bold rounded-xl px-4 py-2.5 pr-10 focus:outline-none shadow-sm">
                            <option>Fall 2024</option>
                            <option>Spring 2025</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-100 text-gray-700 text-sm font-bold rounded-xl px-4 py-2.5 pr-10 focus:outline-none shadow-sm">
                            <option>All Statuses</option>
                            <option>Active</option>
                            <option>Under Review</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-xl p-1 shadow-sm">
                    <button class="p-1.5 text-gray-400 hover:text-gray-900 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </button>
                    <div class="w-px h-5 bg-gray-200"></div>
                    <button class="p-1.5 text-[#0e48c1] bg-[#eff4ff] rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-gray-100">
                                <th class="px-6 py-4 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest w-[120px]">CODE</th>
                                <th class="px-6 py-4 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest">COURSE NAME</th>
                                <th class="px-6 py-4 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest w-[150px]">CREDITS</th>
                                <th class="px-6 py-4 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest w-[150px]">STATUS</th>
                                <th class="px-6 py-4 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest text-right w-[100px]">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $course->code }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500">Semester: {{ $course->semester ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-500">{{ number_format($course->credit_hours, 1) }} Credits</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 bg-[#eff4ff] text-[#0e48c1] text-[11px] font-bold rounded-full">Active</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right space-x-2">
                                    <a href="{{ route('admin.departments.courses.edit', [$department, $course]) }}" class="inline-flex items-center justify-center text-gray-400 hover:text-[#0e48c1] transition-colors" title="Edit Course">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.departments.courses.destroy', [$department, $course]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center text-gray-400 hover:text-red-600 transition-colors" title="Delete Course">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm font-medium text-gray-500">
                                    No courses found for this department.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-8 flex items-center justify-between overflow-hidden relative">
                    <div class="relative z-10 w-2/3">
                        <h3 class="text-[18px] font-bold text-gray-900 mb-2">Curriculum Mapping</h3>
                        <p class="text-sm text-gray-500 mb-4">Visualize course prerequisites and tracks.</p>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-bold text-[#0e48c1] hover:underline">
                            Open Map
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="absolute right-0 top-0 bottom-0 w-1/3 md:w-5/12 bg-gray-50 flex items-center justify-end pr-4 rounded-l-[2rem] shadow-inner">
                        <div class="w-full max-w-[120px] bg-white rounded-lg shadow-sm border border-gray-200 p-2 transform -translate-x-2 translate-y-2 opacity-80">
                            <div class="h-2 w-1/2 bg-blue-100 rounded mb-1"></div>
                            <div class="h-1.5 w-full bg-gray-100 rounded mb-1"></div>
                            <div class="h-1.5 w-3/4 bg-gray-100 rounded"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-8 flex items-center justify-between overflow-hidden relative">
                    <div class="relative z-10 w-2/3">
                        <h3 class="text-[18px] font-bold text-gray-900 mb-2">Department Analytics</h3>
                        <p class="text-sm text-gray-500 mb-4">Review enrollment trends and faculty load.</p>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-bold text-[#0e48c1] hover:underline">
                            View Report
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="absolute right-0 top-0 bottom-0 w-1/3 md:w-5/12 bg-gray-50 flex items-center justify-end pr-4 rounded-l-[2rem] shadow-inner">
                        <div class="w-full max-w-[120px] bg-white rounded-lg shadow-sm border border-gray-200 p-2 transform -translate-x-2 -translate-y-2 opacity-80">
                            <div class="flex gap-1 items-end h-8 border-b border-gray-100 pb-1 mb-1">
                                <div class="w-2 bg-blue-500 h-[60%] rounded-t-sm"></div>
                                <div class="w-2 bg-blue-200 h-[40%] rounded-t-sm"></div>
                                <div class="w-2 bg-blue-500 h-[80%] rounded-t-sm"></div>
                                <div class="w-2 bg-blue-200 h-[50%] rounded-t-sm"></div>
                                <div class="w-2 bg-blue-500 h-[100%] rounded-t-sm"></div>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 rounded mb-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($section === 'faculty')
            <!-- Faculty Assignment -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search Faculty..." class="bg-gray-50 border border-gray-100 text-gray-900 text-sm font-medium rounded-xl focus:ring-[#0e48c1] focus:border-[#0e48c1] block w-full pl-10 p-3 shadow-sm">
                </div>
                <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0e48c1] px-5 py-3 text-sm font-bold text-white shadow-[0_4px_12px_rgba(14,72,193,0.2)] whitespace-nowrap w-full md:w-auto">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    + Assign Course
                </button>
            </div>

            <div class="space-y-4">
                <!-- Faculty Card 1 -->
                <div class="bg-[#f8fafc] border border-gray-100 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#eff4ff] flex items-center justify-center text-[#0e48c1] font-bold text-lg shrink-0">
                            AT
                        </div>
                        <div>
                            <h3 class="text-[17px] font-bold text-gray-900">Dr. Alan Turing</h3>
                            <p class="text-sm font-medium text-gray-500">Professor, Computer Science</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="flex gap-2 flex-wrap flex-1 md:flex-initial">
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-[#e2e8f0] text-gray-600 text-xs font-bold rounded-md">CS-402</span>
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-[#e2e8f0] text-gray-600 text-xs font-bold rounded-md">CS-410</span>
                        </div>
                        <button class="px-4 py-1.5 bg-[#e2e8f0] hover:bg-gray-300 text-[#0e48c1] font-bold text-sm rounded-lg transition-colors">Reassign</button>
                    </div>
                </div>

                <!-- Faculty Card 2 -->
                <div class="bg-[#f8fafc] border border-gray-100 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-lg shrink-0">
                            GH
                        </div>
                        <div>
                            <h3 class="text-[17px] font-bold text-gray-900">Dr. Grace Hopper</h3>
                            <p class="text-sm font-medium text-gray-500">Associate Professor</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="flex gap-2 flex-wrap flex-1 md:flex-initial">
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-[#e2e8f0] text-gray-600 text-xs font-bold rounded-md">CS-101</span>
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-[#e2e8f0] text-gray-600 text-xs font-bold rounded-md">CS-250</span>
                        </div>
                        <button class="px-4 py-1.5 bg-[#e2e8f0] hover:bg-gray-300 text-[#0e48c1] font-bold text-sm rounded-lg transition-colors">Reassign</button>
                    </div>
                </div>

                <!-- Faculty Card 3 -->
                <div class="bg-[#f8fafc] border border-gray-100 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#0e48c1] flex items-center justify-center text-white font-bold text-lg shrink-0">
                            JD
                        </div>
                        <div>
                            <h3 class="text-[17px] font-bold text-gray-900">Prof. John Doe</h3>
                            <p class="text-sm font-medium text-gray-500">Adjunct Faculty</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="flex gap-2 flex-wrap flex-1 md:flex-initial justify-end md:justify-start">
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-[#e2e8f0] text-gray-600 text-xs font-bold rounded-md">CS-305</span>
                        </div>
                        <button class="px-4 py-1.5 bg-[#e2e8f0] hover:bg-gray-300 text-[#0e48c1] font-bold text-sm rounded-lg transition-colors">Reassign</button>
                    </div>
                </div>
            </div>

        @elseif ($section === 'enrollment')
            <!-- Student Enrollment -->
            <div class="flex flex-col md:flex-row items-start md:items-center gap-3 mb-6">
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search Students..." class="bg-gray-50 border border-gray-100 text-gray-900 text-sm font-medium rounded-xl focus:ring-[#0e48c1] focus:border-[#0e48c1] block w-full pl-10 p-2.5 shadow-sm">
                </div>
                
                <div class="flex gap-3 w-full md:w-auto flex-1">
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-100 text-gray-700 text-sm font-medium rounded-xl px-4 py-2.5 pr-10 focus:outline-none shadow-sm h-full flex items-center justify-between min-w-[120px]">
                            <option>Course</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-100 text-gray-700 text-sm font-medium rounded-xl px-4 py-2.5 pr-10 focus:outline-none shadow-sm h-full flex items-center justify-between min-w-[120px]">
                            <option>Semester</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0e48c1] px-5 py-2.5 text-sm font-bold text-white shadow-[0_4px_12px_rgba(14,72,193,0.2)] whitespace-nowrap w-full md:w-auto">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m-3-3v6m-9-3a3 3 0 116 0 3 3 0 01-6 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    + Enroll Student
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Student Card 1 -->
                <div class="bg-[#f3f4f6] border border-gray-100 rounded-[1.5rem] p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-500 font-bold text-sm shrink-0 border border-gray-200">
                                EV
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Eleanor Vance</h3>
                                <p class="text-xs font-medium text-gray-500">ID: CS-2024-089</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 bg-[#e0e7ff] text-[#0e48c1] text-[10px] font-bold rounded-full">Active</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">ENROLLED COURSES</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">CS101</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">MATH205</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">PHY110</span>
                        </div>
                    </div>
                </div>

                <!-- Student Card 2 -->
                <div class="bg-[#f3f4f6] border border-gray-100 rounded-[1.5rem] p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-500 font-bold text-sm shrink-0 border border-gray-200">
                                MT
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Marcus Thorne</h3>
                                <p class="text-xs font-medium text-gray-500">ID: CS-2023-142</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 bg-gray-200 text-gray-600 text-[10px] font-bold rounded-full">Completed</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">ENROLLED COURSES</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">CS305</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">CS410</span>
                        </div>
                    </div>
                </div>

                <!-- Student Card 3 -->
                <div class="bg-[#f3f4f6] border border-gray-100 rounded-[1.5rem] p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#0e48c1] flex items-center justify-center text-white font-bold text-sm shrink-0">
                                SJ
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">Sarah Jenkins</h3>
                                <p class="text-xs font-medium text-gray-500">ID: CS-2024-012</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 bg-[#e0e7ff] text-[#0e48c1] text-[10px] font-bold rounded-full">Active</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">ENROLLED COURSES</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">CS101</span>
                            <span class="inline-flex items-center justify-center px-2 py-1 bg-white border border-gray-200 text-gray-600 text-[11px] font-bold rounded">ENG105</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-admin>
