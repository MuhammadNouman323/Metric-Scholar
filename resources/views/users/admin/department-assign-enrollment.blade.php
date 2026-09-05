<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        {{-- Breadcrumb --}}
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.departments') }}" class="hover:text-[#0e48c1]">Departments</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.show', $department) }}" class="hover:text-[#0e48c1]">{{ $departmentName }}</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'enrollment']) }}" class="hover:text-[#0e48c1]">Manage Department</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Assign Courses</span>
        </div>

        {{-- Header --}}
        <div class="flex items-start gap-4 mb-8">
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'enrollment']) }}" class="text-gray-500 hover:text-gray-900 transition-colors mt-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                    Assign Courses to Students
                </h1>
                <p class="text-[15px] font-medium text-gray-500">Manage student course enrollment for the upcoming semester.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">

            {{-- Left: Student Selection + Available Courses --}}
            <div class="space-y-6">

                {{-- Student Selection --}}
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Select Student</h2>
                    <div class="relative">
                        <select id="student-select" class="appearance-none bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-[#0e48c1] focus:border-[#0e48c1] shadow-sm w-full">
                            <option value="">-- Choose a student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}">
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Search + Filter --}}
                <div class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input id="course-search" type="text" placeholder="Search for course code or title..." class="bg-white border border-gray-200 text-gray-900 text-sm font-medium rounded-xl focus:ring-[#0e48c1] focus:border-[#0e48c1] block w-full pl-10 p-3 shadow-sm" disabled>
                    </div>
                    <div class="relative">
                        <select id="semester-filter" class="appearance-none bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl px-4 py-3 pr-10 focus:outline-none shadow-sm" disabled>
                            <option>All Semesters</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- No Student Selected Message --}}
                <div id="no-student-msg" class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m-3-3v6m-9-3a3 3 0 116 0 3 3 0 01-6 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Select a student to assign courses.</p>
                </div>

                {{-- Available Courses (hidden until student selected) --}}
                <form id="assign-form" action="{{ route('admin.departments.enrollment.store-assignments', $department) }}" method="POST" class="hidden space-y-6">
                    @csrf
                    <input type="hidden" id="selected-student-id" name="student_id">

                    {{-- Enrolled Courses Section --}}
                    <div id="enrolled-section" class="hidden">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Currently Enrolled Courses</h2>
                        <div id="enrolled-courses-list" class="space-y-3">
                        </div>
                        <div id="enrolled-empty-msg" class="bg-white border border-gray-100 rounded-2xl p-6 text-center">
                            <p class="text-sm font-medium text-gray-500">No courses currently enrolled.</p>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Available Courses</h2>

                        @if(session('success'))
                            <div class="flash-message mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div id="course-list" class="space-y-3">
                            @forelse($availableCourses as $course)
                            @php
                                $icons = ['M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'];
                                $iconPath = $icons[$loop->index % count($icons)];
                            @endphp
                            <div class="course-item bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-4 shadow-[0_2px_8px_rgb(0,0,0,0.03)] hover:shadow-md transition-all"
                                 data-title="{{ strtolower($course->title) }}" data-code="{{ strtolower($course->code) }}">
                                <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#0e48c1] shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="inline-flex px-2 py-0.5 bg-[#eff4ff] text-[#0e48c1] text-[11px] font-bold rounded">{{ $course->code }}</span>
                                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $course->title }}</h3>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                        <span>★ {{ number_format($course->credit_hours, 0) }} Credits</span>
                                        @if($course->semester)
                                            <span>· {{ $course->semester }}</span>
                                        @endif
                                    </div>
                                </div>
                                <button type="button"
                                    data-course-id="{{ $course->id }}"
                                    data-course-code="{{ $course->code }}"
                                    data-course-title="{{ $course->title }}"
                                    class="assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white"
                                    data-assigned="0">
                                    Enroll
                                </button>
                            </div>
                            @empty
                            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
                                <p class="text-sm font-medium text-gray-500">No courses available for this department.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Hidden inputs container for dynamic assignments --}}
                    <div id="dynamic-inputs"></div>

                    {{-- Save Button --}}
                    <button type="submit" class="w-full bg-[#0e48c1] hover:bg-[#0a389f] text-white font-bold py-3 rounded-xl shadow-[0_4px_12px_rgba(14,72,193,0.2)] transition-all text-sm">
                        Save Enrollment
                    </button>
                </form>
            </div>

            {{-- Right: Assignment Summary --}}
            <div id="summary-section" class="space-y-4 hidden">
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Summary</h2>
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[11px] font-bold rounded-full">Draft</span>
                    </div>

                    {{-- Student Info --}}
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <div id="student-info" class="space-y-2">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Student Name</p>
                                <p id="summary-name" class="text-sm font-bold text-gray-900">--</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Email</p>
                                <p id="summary-email" class="text-sm font-bold text-gray-900 truncate">--</p>
                            </div>
                        </div>
                    </div>

                    {{-- Courses Bar --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Changes</span>
                            <span id="course-display" class="text-xs font-bold text-gray-700">0 Changes</span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div id="course-bar" class="h-full bg-[#0e48c1] rounded-full transition-all" style="width: 0%"></div>
                        </div>
                    </div>

                    {{-- Modified List --}}
                    <div class="mb-2">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Modified (<span id="assigned-count">0</span>)
                        </p>
                        <div id="assigned-list" class="space-y-2">
                        </div>
                        <p id="empty-msg" class="text-xs font-medium text-gray-400 italic">No changes made yet.</p>
                    </div>
                </div>

                {{-- Tip card --}}
                <div class="bg-[#fff8f1] border border-orange-100 rounded-[1.5rem] p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-base">💡</span>
                        <p class="text-sm font-bold text-gray-900">Did you know?</p>
                    </div>
                    <p class="text-xs font-medium text-orange-700 leading-relaxed">
                        Most students take 3-5 courses per semester. Ensure proper course load balance for optimal academic performance.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Enrolled courses data from PHP - populated dynamically
        let studentCourses = {
            @foreach($students as $student)
            {{ $student->id }}: [{{ $student->courses->pluck('id')->implode(',') }}],
            @endforeach
        };

        // Course data from server
        const courseCredits = {
            @foreach($availableCourses as $c)
            {{ $c->id }}: {{ (int) $c->credit_hours }},
            @endforeach
        };

        // Track assigned course IDs and course data
        const courseData = {
            @foreach($availableCourses as $c)
            {{ $c->id }}: { code: '{{ $c->code }}', title: '{{ $c->title }}' },
            @endforeach
        };

        // Track assigned course IDs and removals
        let assignedIds = new Set();
        let removedIds = new Set();
        let currentStudentId = null;
        let originalEnrolledIds = new Set();

        // Student selection
        document.getElementById('student-select').addEventListener('change', function () {
            const studentId = this.value;
            if (!studentId) {
                // Hide form and show message
                document.getElementById('assign-form').classList.add('hidden');
                document.getElementById('no-student-msg').classList.remove('hidden');
                document.getElementById('summary-section').classList.add('hidden');
                currentStudentId = null;
                assignedIds.clear();
                removedIds.clear();
                originalEnrolledIds.clear();
                return;
            }

            currentStudentId = studentId;
            const option = this.options[this.selectedIndex];
            const name = option.dataset.name;
            const email = option.dataset.email;

            // Get enrolled course IDs for this student
            originalEnrolledIds = new Set(studentCourses[studentId] || []);

            // Show form
            document.getElementById('assign-form').classList.remove('hidden');
            document.getElementById('no-student-msg').classList.add('hidden');
            document.getElementById('summary-section').classList.remove('hidden');

            // Enable search and filter
            document.getElementById('course-search').disabled = false;
            document.getElementById('semester-filter').disabled = false;

            // Update hidden input
            document.getElementById('selected-student-id').value = studentId;

            // Update summary
            document.getElementById('summary-name').textContent = name;
            document.getElementById('summary-email').textContent = email;

            // Reset changes
            assignedIds.clear();
            removedIds.clear();

            // Display enrolled courses
            displayEnrolledCourses();

            // Reset all assignment buttons
            document.querySelectorAll('.assign-btn').forEach(btn => {
                const courseId = parseInt(btn.dataset.courseId);
                const isEnrolled = originalEnrolledIds.has(courseId);
                btn.dataset.assigned = isEnrolled ? '1' : '0';
                btn.textContent = isEnrolled ? 'Enrolled ✓' : 'Enroll';
                btn.className = isEnrolled
                    ? 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-green-50 text-green-600 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200'
                    : 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            });

            updateDisplay();
        });

        function displayEnrolledCourses() {
            const list = document.getElementById('enrolled-courses-list');
            const emptyMsg = document.getElementById('enrolled-empty-msg');
            const enrolledSection = document.getElementById('enrolled-section');
            
            list.innerHTML = '';

            if (originalEnrolledIds.size === 0) {
                enrolledSection.classList.add('hidden');
                return;
            }

            enrolledSection.classList.remove('hidden');

            originalEnrolledIds.forEach(courseId => {
                const data = courseData[courseId];
                if (!data) return;

                const div = document.createElement('div');
                div.id = 'enrolled-item-' + courseId;
                div.className = 'flex items-center justify-between bg-green-50 border border-green-200 rounded-xl p-3';
                div.innerHTML = `
                    <div>
                        <p class="text-xs font-bold text-green-600">${data.code}</p>
                        <p class="text-[11px] font-medium text-green-700">${data.title}</p>
                    </div>
                    <button type="button" data-remove="${courseId}" class="unenroll-btn text-gray-400 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>`;
                list.appendChild(div);
                div.querySelector('.unenroll-btn').addEventListener('click', (e) => {
                    e.preventDefault();
                    removeEnrollment(courseId);
                });
            });
        }

        function updateDisplay() {
            const changeCount = assignedIds.size + removedIds.size;
            document.getElementById('course-display').textContent = changeCount + ' Change' + (changeCount !== 1 ? 's' : '');
            document.getElementById('assigned-count').textContent = changeCount;
            document.getElementById('empty-msg').classList.toggle('hidden', changeCount > 0);
            syncHiddenInputs();
        }

        function syncHiddenInputs() {
            const container = document.getElementById('dynamic-inputs');
            container.innerHTML = '';

            // New enrollments
            assignedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'assigned_courses[]';
                input.value = id;
                container.appendChild(input);
            });

            // Add original enrollments minus removals
            originalEnrolledIds.forEach(id => {
                if (!removedIds.has(id)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'assigned_courses[]';
                    input.value = id;
                    container.appendChild(input);
                }
            });
        }

        function addToSummary(id, code, title, isNew = true) {
            const list = document.getElementById('assigned-list');
            if (document.getElementById('summary-' + id)) return;
            const div = document.createElement('div');
            div.id = 'summary-' + id;
            div.className = 'flex items-center justify-between';
            const badgeColor = isNew ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600';
            const badgeText = isNew ? '+ Added' : '- Removed';
            div.innerHTML = `
                <div>
                    <p class="text-xs font-bold text-[#0e48c1]">${code}</p>
                    <p class="text-[11px] font-medium text-gray-600">${title}</p>
                </div>
                <span class="text-[10px] font-bold px-2 py-1 rounded ${badgeColor}">${badgeText}</span>`;
            list.appendChild(div);
        }

        function removeFromSummary(id) {
            const el = document.getElementById('summary-' + id);
            if (el) el.remove();
        }

        function removeEnrollment(courseId) {
            const enrolledItem = document.getElementById('enrolled-item-' + courseId);
            if (enrolledItem) enrolledItem.remove();

            removedIds.add(courseId);
            assignedIds.delete(courseId);

            const btn = document.querySelector(`.assign-btn[data-course-id="${courseId}"]`);
            if (btn) {
                btn.dataset.assigned = '0';
                btn.textContent = 'Enroll';
                btn.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            }

            removeFromSummary(courseId);
            const data = courseData[courseId];
            if (data) {
                addToSummary(courseId, data.code, data.title, false);
            }

            updateDisplay();
        }

        // Assign buttons
        document.querySelectorAll('.assign-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!currentStudentId) return;
                const id = parseInt(this.dataset.courseId);
                const code = this.dataset.courseCode;
                const title = this.dataset.courseTitle;

                if (this.dataset.assigned === '0') {
                    // Enroll
                    assignedIds.add(id);
                    removedIds.delete(id);
                    this.dataset.assigned = '1';
                    this.textContent = 'Enrolled ✓';
                    this.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-green-50 text-green-600 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200';
                    removeFromSummary(id);
                    addToSummary(id, code, title, true);
                } else {
                    // Unenroll
                    removeEnrollment(id);
                }
                updateDisplay();
            });
        });

        // Search
        document.getElementById('course-search').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.course-item').forEach(item => {
                const match = item.dataset.title.includes(q) || item.dataset.code.includes(q);
                item.style.display = match ? '' : 'none';
            });
        });
    </script>
</x-admin>
