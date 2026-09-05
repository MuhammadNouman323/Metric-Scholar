<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Manage Faculty</h1>
                <p class="text-gray-500 text-[15px] font-medium">Directory of active academic staff and institutional
                    roles.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </div>
                    <select id="departmentFilterFaculty"
                        class="w-full md:w-[220px] bg-[#f4f6f8] border border-transparent rounded-xl pl-10 pr-10 py-3.5 text-gray-700 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white text-[14px]">
                        <option value="">All Departments</option>
                        @forelse($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @empty
                            <option disabled>No departments available</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>

                <a href="/admin/user"
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-6 py-3.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                    Add Faculty
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Faculty -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#eff6ff] text-[#0e48c1] rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="bg-[#dcfce7] text-[#166534] text-[11px] font-bold px-2.5 py-1 rounded-full">+4%</span>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">TOTAL FACULTY</h4>
                <div class="text-[28px] font-extrabold text-gray-900 leading-none">{{ $totalFaculty }}</div>
            </div>

            <!-- Pending Reviews -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#fff7ed] text-[#ea580c] rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <span class="bg-[#ffedd5] text-[#c2410c] text-[11px] font-bold px-2.5 py-1 rounded-full">High</span>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">PENDING REVIEWS</h4>
                <div class="text-[28px] font-extrabold text-gray-900 leading-none">{{ $pendingReviews }}</div>
            </div>

            <!-- Active Courses -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#eff6ff] text-[#0e48c1] rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">ACTIVE COURSES</h4>
                <div class="text-[28px] font-extrabold text-gray-900 leading-none">{{ $activeCourses }}</div>
            </div>

            <!-- Tenured Staff -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#f1f5f9] text-[#475569] rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">TENURED STAFF</h4>
                <div class="text-[28px] font-extrabold text-gray-900 leading-none">{{ $tenuredPercentage }}%</div>
            </div>
        </div>

        <!-- Table View -->
        <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100">
            <div class="p-6 md:p-8 flex flex-col md:flex-row items-center justify-between border-b border-gray-100">
                <h2 class="text-[18px] font-bold text-[#0e48c1]">Faculty Directory</h2>
                <div class="flex items-center gap-3">
                    <button id="exportFacultyBtn" title="Export List"
                        class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </button>
                    
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/80">
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest whitespace-nowrap">
                                FACULTY ID</th>
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                NAME</th>
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                DESIGNATION</th>
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                DEPARTMENT</th>
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-center">
                                COURSES</th>
                            <th
                                class="px-6 md:px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-right">
                                ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($faculties as $faculty)
                            <tr class="hover:bg-blue-50/40 transition-colors duration-150 group faculty-row" data-department="{{ $faculty->department ?? 'General' }}">
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap">
                                    <div class="text-[13px] font-medium text-gray-500">FAC-{{ $faculty->id }}</div>
                                </td>
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            src="{{ $faculty->avatar_url }}" alt="{{ $faculty->name }}">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[14px] font-bold text-gray-900 group-hover:text-[#0e48c1] transition-colors cursor-pointer">{{ $faculty->name }}</span>
                                            <span
                                                class="text-[12px] font-medium text-gray-500">{{ $faculty->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap text-[14px] font-medium text-gray-700">
                                    {{ $faculty->designation ?? 'Faculty' }}
                                </td>
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">{{ $faculty->department ?? 'General' }}</span>
                                </td>
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap text-center">
                                    <span class="text-[14px] font-bold text-gray-900">{{ $faculty->courses_count ?? 0 }}</span>
                                </td>
                                <td class="px-6 md:px-8 py-5 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.users.show', $faculty) }}"
                                            title="View"
                                            class="text-gray-500 hover:bg-gray-100 p-2 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg></a>
                                        <a href="{{ route('admin.faculty.assign-courses', $faculty->id) }}"
                                            title="Assign Courses"
                                            class="text-[#0e48c1] hover:bg-blue-50 p-2 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></a>
                                        <a href="{{ route('admin.users.edit', $faculty) }}"
                                            class="text-[#0e48c1] hover:bg-blue-50 p-2 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 md:px-8 py-10 text-center">
                                    <p class="text-gray-500 font-medium">No faculty members available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $faculties->links('vendor.pagination.admin') }}
        </div>

        <script>
            // Department Filter
            const deptFilterFaculty = document.getElementById('departmentFilterFaculty');
            if (deptFilterFaculty) {
                deptFilterFaculty.addEventListener('change', function() {
                    const selectedDept = this.value;
                    const rows = document.querySelectorAll('.faculty-row');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const rowDept = row.getAttribute('data-department');
                        if (selectedDept === '' || rowDept === selectedDept) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update pagination info
                    const paginationSpans = document.querySelectorAll('.px-6.md\\:px-8.py-5.border-t .font-bold');
                    if (paginationSpans.length >= 2) {
                        paginationSpans[0].textContent = `${visibleCount > 0 ? 1 : 0}-${visibleCount}`;
                    }
                });
            }

            // Export List - respect the active department filter
            const exportFacultyBtn = document.getElementById('exportFacultyBtn');
            if (exportFacultyBtn) {
                exportFacultyBtn.addEventListener('click', function() {
                    const baseUrl = "{{ route('admin.faculty.export') }}";
                    const deptValue = deptFilterFaculty ? deptFilterFaculty.value : '';
                    const separator = baseUrl.includes('?') ? '&' : '?';
                    window.location.href = baseUrl + (deptValue ? separator + 'department=' + encodeURIComponent(deptValue) : '');
                });
            }
        </script>

    </div>
</x-admin>
