<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen space-y-8">

        @if (session('success'))
            <div class="flash-message rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 ">
            <div class="flex flex-col gap-2">
                <h1 class="text-[32px] font-bold text-gray-900 mb-2 tracking-tight">Manage Students</h1>
                <p class="text-gray-500 text-[15px] font-medium">Overview and administration of the {{ date('Y') }} academic cohort.
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

                <button id="exportStudentsBtn"
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
        <form method="GET" action="{{ route('admin.students') }}" id="studentsFilterForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative w-full">
            <!-- Left Controls Area (Spans 2 columns) -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Search -->
                <div class="sm:col-span-2">
                    <label
                        class="block text-[11px] font-bold text-gray-500 tracking-wider mb-3 uppercase">Search</label>
                    <div id="student-search-wrap" class="relative">
                        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="student-search-input" value="{{ request('search') }}" placeholder="Search by name, email or phone..." autocomplete="off"
                            class="w-full bg-[#f4f6f8] border border-transparent rounded-xl pl-10 pr-4 py-3.5 text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white text-[14px]">
                        <div id="student-search-suggestions"
                            class="hidden absolute left-0 right-0 top-full mt-2 z-30 bg-white border border-gray-100 rounded-xl shadow-[0_10px_30px_rgb(15,23,42,0.12)] overflow-hidden max-h-72 overflow-y-auto divide-y divide-gray-50"></div>
                    </div>
                </div>
                <!-- Department -->
                <div>
                    <label
                        class="block text-[11px] mt-2 font-bold text-gray-500 tracking-wider mb-3 uppercase">Department</label>
                    <div class="relative">
                        <select name="department" onchange="this.form.submit()"
                            class="w-full bg-[#f4f6f8] border border-transparent rounded-xl px-4 py-3.5 text-gray-900 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white text-[14px]">
                            <option value="">All Departments</option>
                            @forelse($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
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
                            <option>{{ currentTerm() }} (Current)</option>
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
                    <div class="flex gap-3 items-center justify-between">
                        <button
                            class="flex items-center gap-2 bg-[#0e48c1] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/40 transition-all duration-200 whitespace-nowrap">
                            Active
                        </button>
                        @if(request()->filled('search') || request()->filled('department'))
                            <a href="{{ route('admin.students') }}" class="inline-flex items-center gap-1.5 text-[13px] font-medium text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

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
                                            src="{{ $student->avatar_url }}" alt="{{ $student->name }}">
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
                                        <a href="{{ route('admin.users.show', $student) }}"
                                            class="p-1.5 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg></a>
                                        <a href="{{ route('admin.users.edit', $student) }}"
                                            class="p-1.5 text-[#0e48c1] hover:bg-blue-100 rounded-lg transition-colors duration-150"><svg
                                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg></a>
                                        <form action="{{ route('admin.users.destroy', $student) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete {{ $student->name }}? This will permanently remove their account and related records.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 text-red-500 hover:bg-red-100 rounded-lg transition-colors duration-150"><svg
                                                    class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <p class="text-gray-500 font-medium">No students match your search or filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $students->links('vendor.pagination.admin') }}
        </div>

        <script>
            // Export List - respect the active search and department filters
            const exportStudentsBtn = document.getElementById('exportStudentsBtn');
            if (exportStudentsBtn) {
                exportStudentsBtn.addEventListener('click', function() {
                    const form = document.getElementById('studentsFilterForm');
                    const params = new URLSearchParams();
                    if (form) {
                        const dept = form.elements['department'] ? form.elements['department'].value : '';
                        const search = form.elements['search'] ? form.elements['search'].value : '';
                        if (dept) params.set('department', dept);
                        if (search) params.set('search', search);
                    }
                    const qs = params.toString();
                    window.location.href = "{{ route('admin.students.export') }}" + (qs ? '?' + qs : '');
                });
            }
        </script>

        <script>
            (function () {
                var input = document.getElementById('student-search-input');
                var box = document.getElementById('student-search-suggestions');
                if (!input || !box) return;

                var url = "{{ route('admin.students.suggest') }}";
                var timer = null;
                var items = [];
                var active = -1;

                function close() {
                    box.classList.add('hidden');
                    box.innerHTML = '';
                    items = [];
                    active = -1;
                }

                function render() {
                    box.innerHTML = '';
                    items.forEach(function (person, index) {
                        var el = document.createElement('button');
                        el.type = 'button';
                        el.className = 'w-full text-left px-4 py-2.5 flex items-center gap-3 hover:bg-[#eff4ff] transition-colors ' + (index === active ? 'bg-[#eff4ff]' : 'bg-white');
                        var img = document.createElement('img');
                        img.className = 'w-8 h-8 rounded-full object-cover shrink-0 bg-gray-100';
                        img.src = person.avatar_url || '';
                        img.alt = person.name;
                        var mid = document.createElement('span');
                        mid.className = 'flex flex-col min-w-0 flex-1';
                        var name = document.createElement('span');
                        name.className = 'text-[13px] font-bold text-gray-900 truncate';
                        name.textContent = person.name;
                        var email = document.createElement('span');
                        email.className = 'text-[11px] font-medium text-gray-400 truncate';
                        email.textContent = person.email;
                        mid.appendChild(name);
                        mid.appendChild(email);
                        var badge = document.createElement('span');
                        badge.className = 'text-[11px] font-bold text-[#3730a3] bg-[#e0e7ff] rounded-full px-2.5 py-0.5 shrink-0';
                        badge.textContent = person.department || 'General';
                        el.appendChild(img);
                        el.appendChild(mid);
                        el.appendChild(badge);
                        el.addEventListener('click', function () {
                            input.value = person.name;
                            close();
                            input.form.submit();
                        });
                        box.appendChild(el);
                    });
                    box.classList.remove('hidden');
                }

                function select(index) {
                    if (index < 0 || index >= items.length) return;
                    input.value = items[index].name;
                    close();
                    input.form.submit();
                }

                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    var q = input.value.trim();
                    if (!q) { close(); return; }
                    timer = setTimeout(function () {
                        fetch(url + '?q=' + encodeURIComponent(q), {
                            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(function (response) { return response.json(); })
                            .then(function (data) {
                                items = (data && data.students) || [];
                                active = -1;
                                if (!items.length) { close(); return; }
                                render();
                            })
                            .catch(function () { close(); });
                    }, 250);
                });

                input.addEventListener('keydown', function (e) {
                    if (box.classList.contains('hidden') || !items.length) return;
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        active = (active + 1) % items.length;
                        render();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        active = (active - 1 + items.length) % items.length;
                        render();
                    } else if (e.key === 'Enter') {
                        if (active >= 0) {
                            e.preventDefault();
                            select(active);
                        }
                    } else if (e.key === 'Escape') {
                        close();
                    }
                });

                input.addEventListener('blur', function () {
                    setTimeout(close, 120);
                });

                document.addEventListener('click', function (e) {
                    if (!e.target.closest('#student-search-wrap')) close();
                });
            })();
        </script>

    </div>
</x-admin>
