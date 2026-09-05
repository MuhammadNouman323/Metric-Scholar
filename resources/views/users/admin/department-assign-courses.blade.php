<x-admin>
    @php
        $initials = collect(explode(' ', $faculty->name))->filter()->take(2)->map(fn ($p) => strtoupper(substr($p, 0, 1)))->implode('');
        $totalCredits = $assignedCourses->sum('credit_hours');
        $maxCredits = 12;
    @endphp

    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        {{-- Breadcrumb --}}
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.departments') }}" class="hover:text-[#0e48c1]">Departments</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.show', $department) }}" class="hover:text-[#0e48c1]">{{ $departmentName }}</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'faculty']) }}" class="hover:text-[#0e48c1]">Manage Department</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Assign Courses</span>
        </div>

        {{-- Header --}}
        <div class="flex items-start gap-4 mb-8">
            <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'faculty']) }}" class="text-gray-500 hover:text-gray-900 transition-colors mt-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="flex-1 flex flex-col md:flex-row md:items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                        Assign Courses - {{ $faculty->name }}
                    </h1>
                    <p class="text-[15px] font-medium text-gray-500">Manage teaching responsibilities for the upcoming semester. Balance workload and departmental requirements.</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-sm text-right shrink-0">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Current Load</p>
                    <p class="text-sm font-bold text-gray-900">{{ $assignedCourses->count() }}/4 Courses</p>
                    <div class="mt-2 h-1.5 w-36 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#0e48c1] rounded-full transition-all" style="width: {{ min(($assignedCourses->count() / 4) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">

            {{-- Left: Faculty Info + Available Courses --}}
            <div class="space-y-6">

                {{-- Faculty Info Card --}}
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 flex items-center gap-6">
                    <div class="w-14 h-14 rounded-full bg-[#eff4ff] flex items-center justify-center text-[#0e48c1] font-bold text-xl shrink-0">
                        {{ $initials }}
                    </div>
                    <div class="grid grid-cols-3 gap-6 flex-1">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Department</p>
                            <p class="text-sm font-bold text-gray-900">{{ $faculty->department ?? $departmentName }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rank</p>
                            <p class="text-sm font-bold text-gray-900">Faculty</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $faculty->email }}</p>
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
                        <input id="course-search" type="text" placeholder="Search for course code or title..." class="bg-white border border-gray-200 text-gray-900 text-sm font-medium rounded-xl focus:ring-[#0e48c1] focus:border-[#0e48c1] block w-full pl-10 p-3 shadow-sm">
                    </div>
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl px-4 py-3 pr-10 focus:outline-none shadow-sm">
                            @foreach(semesterOptions() as $sem)
                                <option>{{ $sem }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Available Courses --}}
                <form id="assign-form" action="{{ route('admin.departments.faculty.store-assignments', [$department, $faculty]) }}" method="POST">
                    @csrf

                    {{-- Pre-check already assigned courses --}}
                    @foreach($assignedCourses as $ac)
                        <input type="hidden" name="assigned_courses[]" value="{{ $ac->id }}" class="pre-assigned" data-id="{{ $ac->id }}">
                    @endforeach

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
                                $isAssigned = $assignedCourses->contains('id', $course->id);
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
                                    class="assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all {{ $isAssigned ? 'bg-green-50 text-green-600 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200' : 'bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white' }}"
                                    data-assigned="{{ $isAssigned ? '1' : '0' }}">
                                    {{ $isAssigned ? 'Assigned ✓' : 'Assign' }}
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
                </form>
            </div>

            {{-- Right: Assignment Summary --}}
            <div class="space-y-4">
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Assignment Summary</h2>
                        <span class="px-2.5 py-1 bg-gray-100 text-gray-500 text-[11px] font-bold rounded-full">Draft</span>
                    </div>

                    {{-- Credit Hours Bar --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Credit Hours</span>
                            <span id="credit-display" class="text-xs font-bold text-gray-700">{{ $totalCredits }} / {{ $maxCredits }} Credits</span>
                        </div>
                        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div id="credit-bar" class="h-full bg-[#0e48c1] rounded-full transition-all" style="width: {{ min(($totalCredits / $maxCredits) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    {{-- Assigned List --}}
                    <div class="mb-2">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Assigned (<span id="assigned-count">{{ $assignedCourses->count() }}</span>)
                        </p>
                        <div id="assigned-list" class="space-y-2">
                            @foreach($assignedCourses as $ac)
                            <div id="summary-{{ $ac->id }}" class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-[#0e48c1]">{{ $ac->code }}</p>
                                    <p class="text-[11px] font-medium text-gray-600">{{ $ac->title }}</p>
                                </div>
                                <button type="button" data-remove="{{ $ac->id }}" class="remove-btn text-gray-300 hover:text-red-500 transition-colors ml-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <p id="empty-msg" class="text-xs font-medium text-gray-400 italic {{ $assignedCourses->count() > 0 ? 'hidden' : '' }}">No courses assigned yet.</p>
                    </div>

                    {{-- Save Button --}}
                    <button type="submit" form="assign-form" class="w-full mt-4 bg-[#0e48c1] hover:bg-[#0a389f] text-white font-bold py-3 rounded-xl shadow-[0_4px_12px_rgba(14,72,193,0.2)] transition-all text-sm">
                        Save Assignments
                    </button>
                    <p class="text-[11px] text-gray-400 text-center mt-2">This action will update the faculty ledger for the current academic cycle.</p>
                </div>

                {{-- Did you know card --}}
                <div class="bg-[#fff8f1] border border-orange-100 rounded-[1.5rem] p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-base">💡</span>
                        <p class="text-sm font-bold text-gray-900">Did you know?</p>
                    </div>
                    <p class="text-xs font-medium text-orange-700 leading-relaxed">
                        Full-time professors are typically assigned 4 courses per year. Consider workload balance when assigning courses to ensure quality teaching outcomes.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Course data from server for credit tracking
        const courseCredits = {
            @foreach($availableCourses as $c)
            {{ $c->id }}: {{ (int) $c->credit_hours }},
            @endforeach
        };

        // Track assigned course IDs
        let assignedIds = new Set([
            @foreach($assignedCourses as $ac)
            {{ $ac->id }},
            @endforeach
        ]);

        function updateCreditDisplay() {
            let total = 0;
            assignedIds.forEach(id => { total += (courseCredits[id] || 0); });
            const max = 12;
            document.getElementById('credit-display').textContent = total + ' / ' + max + ' Credits';
            document.getElementById('credit-bar').style.width = Math.min((total / max) * 100, 100) + '%';
            document.getElementById('assigned-count').textContent = assignedIds.size;
            document.getElementById('empty-msg').classList.toggle('hidden', assignedIds.size > 0);
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
            // Remove pre-assigned hidden inputs (managed dynamically now)
            document.querySelectorAll('.pre-assigned').forEach(el => el.remove());
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
            // Reset the assign button
            const btn = document.querySelector(`.assign-btn[data-course-id="${id}"]`);
            if (btn) {
                btn.dataset.assigned = '0';
                btn.textContent = 'Assign';
                btn.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            }
            syncHiddenInputs();
            updateCreditDisplay();
        }

        // Assign buttons
        document.querySelectorAll('.assign-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = parseInt(this.dataset.courseId);
                const code = this.dataset.courseCode;
                const title = this.dataset.courseTitle;
                if (this.dataset.assigned === '0') {
                    assignedIds.add(id);
                    this.dataset.assigned = '1';
                    this.textContent = 'Assigned ✓';
                    this.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-green-50 text-green-600 border border-green-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200';
                    addToSummary(id, code, title);
                } else {
                    removeAssignment(id);
                }
                syncHiddenInputs();
                updateCreditDisplay();
            });
        });

        // Remove buttons (for pre-assigned)
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                removeAssignment(parseInt(this.dataset.remove));
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

        // Initial sync (replace pre-assigned hidden inputs with JS-managed ones)
        syncHiddenInputs();
        updateCreditDisplay();
    </script>
</x-admin>
