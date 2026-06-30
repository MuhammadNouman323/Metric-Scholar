<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 ">
            <div class="flex flex-col gap-2">
                <h1 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Manage Students</h1>
                <p class="text-gray-500 text-[15px] font-medium">Overview and administration of the 2024 academic cohort.
                </p>
            </div>
            <!-- Total Card (Column 3) -->
            <div class="bg-[#0e48c1] text-white rounded-[1.5rem] p-7 relative overflow-hidden w-full md:w-auto">
                <!-- Decorative Circles -->
                <div
                    class="absolute -right-6 -top-6 w-[140px] h-[140px] bg-blue-500/30 rounded-full blur-2xl pointer-events-none">
                </div>
                <div
                    class="absolute right-4 bottom-4 w-12 h-12 border-[5px] border-blue-400/30 rounded-full pointer-events-none">
                </div>
                <div class="absolute right-12 bottom-2 w-16 h-16 bg-blue-400/20 rounded-full pointer-events-none"></div>

                <h3 class="text-[11px] font-bold tracking-widest text-blue-200 uppercase mb-2 z-10">Total Students</h3>
                <div class="text-[44px] font-extrabold leading-none tracking-tight mb-3 z-10">{{ number_format($totalStudents) }}</div>
                <div class="flex items-center text-[12px] font-bold text-blue-200 z-10 text-align-left">
                    <svg class="w-4 h-4 mr-2 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    +12% from last semester
                </div>
            </div>
            <div class="flex gap-3">

                <button
                    class="flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-bold hover:border-[#0e48c1] hover:text-[#0e48c1] transition-all duration-200 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export List
                </button>
                <a href="/admin/user"
                    class="flex items-center gap-2 bg-[#0e48c1] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Student
</a>
            </div>
        </div>


        <!-- Filters & Total Card Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative w-full">
            <!-- Left Controls Area (Spans 2 columns) -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Department -->
                <div>
                    <label
                        class="block text-[11px] mt-2 font-bold text-gray-500 tracking-wider mb-3 uppercase">Department</label>
                    <div class="relative">
                        <select id="departmentFilterStudents"
                            class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white text-[14px]">
                            <option value="">All Departments</option>
                            @forelse($departments as $dept)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Semester -->
                <div>
                    <label
                        class="block text-[11px] font-bold text-gray-500 tracking-wider mb-3 uppercase">Semester</label>
                    <div class="relative">
                        <select
                            class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white text-[14px]">
                            <option>Fall 2024 (Current)</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Status Toggle -->
                <div class="sm:col-span-2 mt-2">
                    <label
                        class="block text-[11px] font-bold text-gray-500 tracking-wider mb-4 uppercase">Status</label>
                    <div class="flex gap-3">
                        <button
                            class="flex items-center gap-2 bg-[#0e48c1] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                            Active
                        </button>
                        <button
                            class="flex items-center gap-3 border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-xl text-sm font-bold hover:border-[#0e48c1] hover:text-[#0e48c1] transition-all duration-200 whitespace-nowrap">
                            On Leave
                        </button>
                    </div>
                </div>
            </div>


        </div>

        <!-- Table View -->
        <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/80">
                            <th
                                class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest whitespace-nowrap">
                                Student ID</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                Name</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                Email</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                Department</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest">
                                Status</th>
                            <th
                                class="px-6 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($students as $student)
                            <tr class="hover:bg-blue-50/40 transition-colors duration-150 group student-row" data-department="{{ $student->department ?? 'General' }}">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-[13px] font-bold text-[#0e48c1]">#SC-{{ $student->id }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full border-2 border-gray-200 object-cover shadow-sm"
                                            src="https://i.pravatar.cc/150?img={{ rand(0, 70) }}" alt="{{ $student->name }}">
                                        <span
                                            class="text-[14px] font-bold text-gray-900 group-hover:text-[#0e48c1] transition-colors cursor-pointer">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span class="text-[13px] font-medium text-gray-600">{{ $student->email }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1.5 bg-blue-100 text-blue-700 text-[12px] font-bold rounded-lg">{{ $student->department ?? 'General' }}</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full {{ $student->is_active ? 'bg-emerald-500' : 'bg-gray-400' }} shadow-sm"></span>
                                        <span class="text-[13px] font-bold text-gray-900">{{ $student->is_active ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.users.edit', $student) }}"
                                            class="p-1.5 text-[#0e48c1] hover:bg-blue-100 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg></a>
                                        <button
                                            class="p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <p class="text-gray-500 font-medium">No students available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-5 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-[13px] font-medium text-gray-600">
                    Showing <span class="font-bold text-gray-900">{{ $students->count() > 0 ? 1 : 0 }}-{{ $students->count() }}</span> of <span
                        class="font-bold text-gray-900">{{ $totalStudents }}</span> students
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-gray-300 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0e48c1] text-white font-bold text-[13px] shadow-sm hover:bg-[#0a389f] transition-colors duration-150">1</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">2</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">3</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-gray-300 transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Graduation Rate -->

            <div class="bg-[#f4f6f8] rounded-[1.5rem] p-7">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#e2e8f0] text-gray-600 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <span class="bg-[#d1fae5] text-[#047857] text-[11px] font-bold px-2 py-1 rounded">+4.2%</span>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Graduation Rate</h4>
                <div class="text-[32px] font-extrabold text-gray-900 leading-none mb-5">94.8%</div>
                <div class="w-full bg-[#e2e8f0] rounded-full h-[5px] flex">
                    <div class="bg-[#0e48c1] h-[5px] rounded-full" style="width: 94.8%"></div>
                </div>
            </div>

            <!-- Avg Student GPA -->
            <div class="bg-[#f4f6f8] rounded-[1.5rem] p-7">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#fcece3] text-[#c55d31] rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <span class="bg-[#dbeafe] text-[#1e40af] text-[11px] font-bold px-2 py-1 rounded">Top Dept</span>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Avg. Student GPA</h4>
                <div class="text-[32px] font-extrabold text-gray-900 leading-none mb-5">3.62</div>
                <div class="flex items-end h-[5px] gap-1.5">
                    <div class="bg-[#0e48c1] h-full rounded-full w-1/5"></div>
                    <div class="bg-[#0e48c1] h-full rounded-full w-1/5"></div>
                    <div class="bg-[#0e48c1] h-full rounded-full w-1/5"></div>
                    <div class="bg-[#cbd5e1] h-full rounded-full w-1/5"></div>
                    <div class="bg-[#cbd5e1] h-full rounded-full w-1/5"></div>
                </div>
            </div>

            <!-- Feedback Sent -->
            <div class="bg-[#f4f6f8] rounded-[1.5rem] p-7">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-10 h-10 bg-[#e2e8f0] text-gray-500 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="bg-[#e2e8f0] text-gray-600 text-[11px] font-bold px-2 py-1 rounded">82 Pending</span>
                </div>
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Feedback Sent</h4>
                <div class="text-[32px] font-extrabold text-gray-900 leading-none mb-3">1,402</div>
                <p class="text-[12px] text-gray-500 font-medium leading-snug">92% of students received feedback
                    this<br>week.</p>
            </div>
        </div>

        <script>
            // Department Filter
            const deptFilterStudents = document.getElementById('departmentFilterStudents');
            if (deptFilterStudents) {
                deptFilterStudents.addEventListener('change', function() {
                    const selectedDept = this.value;
                    const rows = document.querySelectorAll('.student-row');
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
                    const paginationSpans = document.querySelectorAll('.px-6.py-5.border-t .font-bold');
                    if (paginationSpans.length >= 2) {
                        paginationSpans[0].textContent = `${visibleCount > 0 ? 1 : 0}-${visibleCount}`;
                    }
                });
            }
        </script>

    </div>
</x-admin>
