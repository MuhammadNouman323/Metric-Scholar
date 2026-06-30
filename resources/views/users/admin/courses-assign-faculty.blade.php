<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        {{-- Breadcrumb --}}
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.courses') }}" class="hover:text-[#0e48c1]">Courses</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">Assign Faculty to Courses</span>
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
                    Assign Courses to Faculty
                </h1>
                <p class="text-[15px] font-medium text-gray-500">Manage faculty course assignments across all departments.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8">

            {{-- Left: Faculty Selection + Available Courses --}}
            <div class="space-y-6">

                {{-- Faculty Selection --}}
                <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Select Faculty Member</h2>
                    <div class="relative">
                        <select id="faculty-select" class="appearance-none bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl px-4 py-3 pr-10 focus:outline-none focus:ring-[#0e48c1] focus:border-[#0e48c1] shadow-sm w-full">
                            <option value="">-- Choose a faculty member --</option>
                            @foreach($faculty as $member)
                                <option value="{{ $member->id }}" data-name="{{ $member->name }}" data-email="{{ $member->email }}">
                                    {{ $member->name }} ({{ $member->email }})
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

                {{-- No Faculty Selected Message --}}
                <div id="no-faculty-msg" class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m-3-3v6m-9-3a3 3 0 116 0 3 3 0 01-6 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Select a faculty member to assign courses.</p>
                </div>

                {{-- Available Courses --}}
                <form id="assign-form" action="{{ route('admin.courses.store-faculty-assignments') }}" method="POST" class="hidden space-y-6">
                    @csrf
                    <input type="hidden" id="selected-faculty-id" name="faculty_id">

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
                                    Assign
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
                        Save Assignment
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

                    {{-- Faculty Info --}}
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <div id="faculty-info" class="space-y-2">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Faculty Name</p>
                                <p id="summary-name" class="text-sm font-bold text-gray-900">--</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Email</p>
                                <p id="summary-email" class="text-sm font-bold text-gray-900 truncate">--</p>
                            </div>
                        </div>
                    </div>

                    {{-- Assigned List --}}
                    <div class="mb-2">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            Assigned (<span id="assigned-count">0</span>)
                        </p>
                        <div id="assigned-list" class="space-y-2">
                        </div>
                        <p id="empty-msg" class="text-xs font-medium text-gray-400 italic">No courses assigned yet.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let assignedIds = new Set();
        let currentFacultyId = null;

        document.getElementById('faculty-select').addEventListener('change', function () {
            const facultyId = this.value;
            if (!facultyId) {
                document.getElementById('assign-form').classList.add('hidden');
                document.getElementById('no-faculty-msg').classList.remove('hidden');
                document.getElementById('summary-section').classList.add('hidden');
                currentFacultyId = null;
                assignedIds.clear();
                return;
            }

            currentFacultyId = facultyId;
            const option = this.options[this.selectedIndex];
            const name = option.dataset.name;
            const email = option.dataset.email;

            document.getElementById('assign-form').classList.remove('hidden');
            document.getElementById('no-faculty-msg').classList.add('hidden');
            document.getElementById('summary-section').classList.remove('hidden');
            document.getElementById('course-search').disabled = false;
            document.getElementById('selected-faculty-id').value = facultyId;
            document.getElementById('summary-name').textContent = name;
            document.getElementById('summary-email').textContent = email;

            assignedIds.clear();
            document.querySelectorAll('.assign-btn').forEach(btn => {
                btn.dataset.assigned = '0';
                btn.textContent = 'Assign';
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
                btn.textContent = 'Assign';
                btn.className = 'assign-btn px-4 py-1.5 rounded-xl text-sm font-bold transition-all bg-[#eff4ff] text-[#0e48c1] hover:bg-[#0e48c1] hover:text-white';
            }
            updateDisplay();
        }

        document.querySelectorAll('.assign-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                if (!currentFacultyId) return;
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
