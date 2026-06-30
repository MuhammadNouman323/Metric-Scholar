<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        {{-- Breadcrumb --}}
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.courses') }}" class="hover:text-[#0e48c1]">Courses</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Assign Students to Courses</span>
        </div>

        {{-- Header --}}
        <div class="flex items-start gap-4 mb-8">
            <a href="{{ route('admin.courses') }}" class="text-gray-500 hover:text-gray-900 transition-colors mt-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                    Assign Courses to Students
                </h1>
                <p class="text-[15px] font-medium text-gray-500">Manage student course enrollment across all departments.</p>
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

                {{-- Search Box --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input id="course-search" type="text" placeholder="Search for course code or title..." class="bg-white border border-gray-200 text-gray-900 text-sm font-medium rounded-xl focus:ring-[#0e48c1] focus:border-[#0e48c1] block w-full pl-10 p-3 shadow-sm" disabled>
                </div>

                {{-- No Student Selected Message --}}
                <div id="no-student-msg" class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m-3-3v6m-9-3a3 3 0 116 0 3 3 0 01-6 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Select a student to assign courses.</p>
                </div>

                {{-- Available Courses --}}
                <form id="assign-form" action="{{ route('admin.courses.store-student-assignments') }}" method="POST" class="hidden space-y-6">
                    @csrf
                    <input type="hidden" id="selected-student-id" name="student_id">

                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Available Courses</h2>
                        <div id="course-list" class="space-y-3">
                            @forelse($courses as $course)
                            <div class="course-item bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-4 shadow-[0_2px_8px_rgb(0,0,0,0.03)]"
                                 data-title="{{ strtolower($course->title) }}" data-code="{{ strtolower($course->code) }}">
                                <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#0e48c1] shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span class="inline-flex px-2 py-0.5 bg-[#eff4ff] text-[#0e48c1] text-[11px] font-bold rounded">{{ $course->code }}</span>
                                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $course->title }}</h3>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                        <span>★ {{ number_format($course->credit_hours, 0) }} Credits</span>
                                        @if($course->department)
                                            <span>· {{ $course->department }}</span>
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
                                <p class="text-sm font-medium text-gray-500">No courses available.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Hidden inputs container --}}
                    <div id="dynamic-inputs"></div>

                    {{-- Save Button --}}
                    <button type="submit" class="w-full bg-[#0e48c1] hover:bg-[#0a389f] text-white font-bold py-3 rounded-xl shadow-[0_4px_12px_rgba(14,72,193,0.2)] transition-all text-sm">
                        Save Enrollment
                    </button>
                </form>
            </div>

            {{-- Right: Summary --}}
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

                    {{-- Enrolled List --}}
                    <div class="mb-2">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Enrolled (<span id="assigned-count">0</span>)
                        </p>
                        <div id="assigned-list" class="space-y-2">
                        </div>
                        <p id="empty-msg" class="text-xs font-medium text-gray-400 italic">No courses enrolled yet.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let assignedIds = new Set();
        let currentStudentId = null;

        document.getElementById('student-select').addEventListener('change', function () {
            const studentId = this.value;
            if (!studentId) {
                document.getElementById('assign-form').classList.add('hidden');
                document.getElementById('no-student-msg').classList.remove('hidden');
                document.getElementById('summary-section').classList.add('hidden');
                currentStudentId = null;
                assignedIds.clear();
                return;
            }

            currentStudentId = studentId;
            const option = this.options[this.selectedIndex];
            const name = option.dataset.name;
            const email = option.dataset.email;

            document.getElementById('assign-form').classList.remove('hidden');
            document.getElementById('no-student-msg').classList.add('hidden');
            document.getElementById('summary-section').classList.remove('hidden');
            document.getElementById('course-search').disabled = false;
            document.getElementById('selected-student-id').value = studentId;
            document.getElementById('summary-name').textContent = name;
            document.getElementById('summary-email').textContent = email;

            assignedIds.clear();
            document.querySelectorAll('.assign-btn').forEach(btn => {
                btn.dataset.assigned = '0';
                btn.textContent = 'Enroll';
                btn.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            });
            updateDisplay();
        });

        function updateDisplay() {
            const count = assignedIds.size;
            document.getElementById('assigned-count').textContent = count;
            document.getElementById('empty-msg').classList.toggle('hidden', count > 0);
            syncHiddenInputs();
        }

        function syncHiddenInputs() {
            const container = document.getElementById('dynamic-inputs');
            container.innerHTML = '';
            assignedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'assigned_courses[]';
                input.value = id;
                container.appendChild(input);
            });
        }

        function addToSummary(id, code, title) {
            const list = document.getElementById('assigned-list');
            if (document.getElementById('summary-' + id)) return;
            const div = document.createElement('div');
            div.id = 'summary-' + id;
            div.className = 'flex items-center justify-between';
            div.innerHTML = `
                <div>
                    <p class="text-xs font-bold text-[#0e48c1]">${code}</p>
                    <p class="text-[11px] font-medium text-gray-600">${title}</p>
                </div>
                <button type="button" data-remove="${id}" class="remove-btn text-gray-300 hover:text-red-500 transition-colors ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>`;
            list.appendChild(div);
            div.querySelector('.remove-btn').addEventListener('click', () => removeAssignment(id));
        }

        function removeAssignment(id) {
            assignedIds.delete(id);
            const summaryEl = document.getElementById('summary-' + id);
            if (summaryEl) summaryEl.remove();
            const btn = document.querySelector(`.assign-btn[data-course-id="${id}"]`);
            if (btn) {
                btn.dataset.assigned = '0';
                btn.textContent = 'Enroll';
                btn.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            }
            updateDisplay();
        }

        document.querySelectorAll('.assign-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!currentStudentId) return;
                const id = parseInt(this.dataset.courseId);
                const code = this.dataset.courseCode;
                const title = this.dataset.courseTitle;
                if (this.dataset.assigned === '0') {
                    assignedIds.add(id);
                    this.dataset.assigned = '1';
                    this.textContent = 'Enrolled ✓';
                    this.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-green-50 text-green-600 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200';
                    addToSummary(id, code, title);
                } else {
                    removeAssignment(id);
                }
                updateDisplay();
            });
        });

        document.getElementById('course-search').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.course-item').forEach(item => {
                const match = item.dataset.title.includes(q) || item.dataset.code.includes(q);
                item.style.display = match ? '' : 'none';
            });
        });
    </script>
</x-admin>
