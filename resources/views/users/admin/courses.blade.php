<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div class="flex flex-col gap-1">
                <div class="flex items-center text-[12px] font-semibold text-gray-500 mb-2">
                    
                    <span class="text-[#0e48c1]">Manage Courses</span>
                </div>
                <h1 class="text-[32px] font-bold text-[#1f2937] mb-1 tracking-tight">Curricular Catalog</h1>
                <p class="text-gray-500 text-[15px] font-medium">Manage and audit the institution's academic offerings
                    for the current cycle.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button onclick="window.location.href = '{{ route('admin.courses.newCourse') }}'"
                    class="flex items-center justify-center gap-2 bg-[#8934eb] text-white px-6 py-3.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Course
                </button>
                <button onclick="openDepartmentModal('faculty')"
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-6 py-3.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Assign Faculty
                </button>
                <button onclick="openDepartmentModal('students')"
                    class="flex items-center justify-center gap-2 bg-[#0e48c1] text-white px-6 py-3.5 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                    Assign Students
                </button>
            </div>
        </div>

        <!-- Filters Row -->
        <div class="flex flex-col lg:flex-row gap-4 items-center w-full">
            <!-- Semester Pills -->
            <div
                class="flex items-center bg-white border border-gray-100 rounded-[1rem] p-1 shadow-sm w-full lg:w-auto overflow-x-auto">
                <a href="{{ route('admin.courses') }}"
                    class="px-6 py-2.5 text-[13px] font-bold whitespace-nowrap rounded-[0.8rem] transition-colors {{ $selectedSemester === '' ? 'text-[#0e48c1] bg-[#e0e7ff]' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    All Semesters
                </a>
                @forelse($semesters as $option)
                    <a href="{{ route('admin.courses', ['semester' => $option]) }}"
                        class="px-6 py-2.5 text-[13px] font-bold whitespace-nowrap rounded-[0.8rem] transition-colors {{ $selectedSemester === $option ? 'text-[#0e48c1] bg-[#e0e7ff]' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                        {{ $option }}
                    </a>
                @empty
                @endforelse
            </div>

            <div class="flex items-center gap-4 w-full lg:w-auto ml-auto">
                <!-- Departments Dropdown -->
                <div class="relative w-full lg:w-[240px]">
                    <select id="departmentFilter"
                        class="w-full bg-white border border-gray-100 shadow-sm rounded-xl px-4 py-3 text-gray-700 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] text-[13px]"
                        onchange="window.location.href = '{{ route('admin.courses') }}?semester=' + encodeURIComponent('{{ $selectedSemester }}') + '&department=' + encodeURIComponent(this.value);">
                        <option value="">All Departments</option>
                        @forelse($departments as $dept)
                            <option value="{{ $dept }}" @selected($selectedDepartment === $dept)>{{ $dept }}</option>
                        @empty
                            <option disabled>No departments available</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full lg:w-auto">
                    <button
                        class="w-full flex items-center justify-between gap-3 bg-white border border-gray-100 shadow-sm rounded-xl px-4 py-3 text-gray-700 font-bold text-[13px] hover:bg-gray-50 transition-colors">
                        Status: All
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
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
                    <div class="text-[36px] font-extrabold text-[#0e48c1] leading-none">{{ number_format($totalEnrollment) }}</div>
                    <span
                        class="bg-[#dcfce7] text-[#166534] text-[12px] font-bold px-3 py-1 rounded-full flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ rand(5, 20) }}%
                    </span>
                </div>
            </div>

            <!-- Active Courses -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm flex flex-col justify-between">
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">ACTIVE COURSES</h4>
                <div class="flex flex-row items-end justify-between mt-auto">
                    <div class="text-[36px] font-extrabold text-[#0e48c1] leading-none">{{ $activeCourses }}</div>
                    <span class="text-[12px] font-medium text-gray-500 pb-1">{{ $courses->count() }} Total</span>
                </div>
            </div>

            <!-- Pending Evaluations -->
            <div class="bg-white border border-gray-100 rounded-[1.5rem] p-7 shadow-sm flex flex-col justify-between">
                <h4 class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-3">PENDING EVALUATIONS</h4>
                <div class="flex flex-row items-center justify-between mt-auto gap-4">
                    <div class="text-[36px] font-extrabold text-[#c2410c] leading-none">{{ $pendingEvaluations }}</div>
                    <div class="w-full bg-gray-100 rounded-full h-2 mb-1 flex-1">
                        <div class="bg-[#0e48c1] h-2 rounded-full" style="width: {{ $courses->count() > 0 ? ($pendingEvaluations / $courses->count()) * 100 : 0 }}%"></div>
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
                            <th
                                class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest whitespace-nowrap">
                                COURSE NAME</th>
                            <th
                                class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[150px]">
                                COURSE<br>CODE</th>
                            <th
                                class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[160px]">
                                DEPARTMENT</th>
                            <th
                                class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest w-[150px]">
                                SEMESTER</th>
                            <th
                                class="px-8 py-5 text-[11px] font-extrabold text-gray-600 uppercase tracking-widest text-right w-[150px]">
                                ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse($courses as $course)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 group course-row" data-department="{{ $course->department ?? 'General' }}">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-[#eff6ff] rounded-[1rem] flex items-center justify-center text-[#0e48c1]">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[15px] font-bold text-[#1f2937] leading-tight mb-0.5">{{ $course->title }}</span>
                                            <span class="text-[12px] font-medium text-gray-500">{{ $course->students_count }} Students Enrolled</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span
                                        class="inline-block px-3 py-1.5 bg-gray-100 text-gray-600 text-[12px] font-bold rounded-lg uppercase tracking-wide">{{ $course->code }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span class="text-[14px] font-bold text-[#1f2937]">{{ $course->department ?? 'General' }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">{{ $course->semester ?? currentTerm() }}</span>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap text-right space-x-2">
                                    <div class="flex items-center justify-end gap-2 text-gray-400">
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="inline-flex items-center justify-center text-gray-400 hover:text-[#0e48c1] transition-colors p-1.5 rounded-lg hover:bg-gray-100" title="Edit Course">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center text-gray-400 hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50" title="Delete Course">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center">
                                    <p class="text-gray-500 font-medium">No courses available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $courses->links('vendor.pagination.admin') }}
        </div>

        <!-- Department Selection Modal -->
        <div id="departmentModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 animate-in fade-in zoom-in-95 duration-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Select Department</h2>
                    <button onclick="closeDepartmentModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <p class="text-gray-600 text-sm mb-4">Choose a department to filter users for assignment:</p>

                <div class="space-y-2 mb-6">
                    @forelse($departments as $dept)
                        <button onclick="selectDepartment('{{ $dept }}')" 
                            class="w-full text-left px-4 py-3 rounded-lg border border-gray-200 hover:border-[#0e48c1] hover:bg-blue-50 transition-all duration-200 font-medium text-gray-700">
                            {{ $dept }}
                        </button>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">No departments available</p>
                    @endforelse
                </div>

                <button onclick="closeDepartmentModal()" 
                    class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
            </div>
        </div>

        <script>
            // Department Filter
            const departmentFilter = document.getElementById('departmentFilter');
            if (departmentFilter) {
                departmentFilter.addEventListener('change', function() {
                    const selectedDept = this.value;
                    const rows = document.querySelectorAll('.course-row');
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
                    const paginationText = document.querySelector('.px-8.py-5.flex.flex-col.sm\\:flex-row .text-\\[13px\\].font-medium');
                    if (paginationText) {
                        paginationText.textContent = `Showing ${visibleCount > 0 ? 1 : 0} to ${visibleCount} of ${visibleCount} courses`;
                    }

                    // Show no results message if needed
                    if (visibleCount === 0) {
                        const tbody = document.querySelector('tbody');
                        const noResults = tbody.querySelector('tr:last-child');
                        if (noResults && noResults.querySelector('td[colspan="5"]')) {
                            noResults.style.display = '';
                        }
                    }
                });
            }

            let selectedAssignmentType = null;

            function openDepartmentModal(type) {
                selectedAssignmentType = type;
                document.getElementById('departmentModal').classList.remove('hidden');
            }

            function closeDepartmentModal() {
                selectedAssignmentType = null;
                document.getElementById('departmentModal').classList.add('hidden');
            }

            function selectDepartment(department) {
                const routes = {
                    'faculty': '{{ route("admin.courses.assign-faculty", ":department") }}',
                    'students': '{{ route("admin.courses.assign-students", ":department") }}'
                };

                if (selectedAssignmentType && routes[selectedAssignmentType]) {
                    const url = routes[selectedAssignmentType].replace(':department', encodeURIComponent(department));
                    window.location.href = url;
                }
            }

            // Close modal when clicking outside
            document.getElementById('departmentModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDepartmentModal();
                }
            });
        </script>

    </div>
</x-admin>
