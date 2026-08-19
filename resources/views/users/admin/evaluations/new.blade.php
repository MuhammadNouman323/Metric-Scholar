<x-admin>
    <!-- Top Header Bar -->
    <div class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between shadow-sm relative z-20">
        <!-- Breadcrumbs -->
        <nav class="flex items-center text-[13px] font-semibold text-slate-500" aria-label="Breadcrumb">
            <span class="text-slate-600">Admin</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-slate-600">Reports</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-[#0e48c1]">New Evaluation</span>
        </nav>
    </div>

    <!-- Page Body -->
    <div class="bg-[#f8fafc] min-h-[calc(100vh-81px)] pb-16">
        <div class="p-6 md:p-10 lg:p-12 max-w-[1400px] mx-auto space-y-10">
            <!-- Header Section -->
            <div class="space-y-2">
                <h1 class="text-[34px] font-extrabold tracking-tight text-[#0c3683]">Initiate New Evaluation</h1>
                <p class="text-[15px] text-slate-500 font-medium">Configure the parameters for the upcoming faculty evaluation cycle.</p>
            </div>

            <!-- Step Indicators -->
            <div class="flex items-center justify-center py-6 max-w-2xl mx-auto">
                <div class="flex items-center w-full relative">
                    <!-- Progress Line Background -->
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-[3px] bg-slate-200 z-0"></div>
                    <!-- Active Progress Line -->
                    <div id="progress-bar" class="absolute left-0 top-1/2 -translate-y-1/2 h-[3px] bg-[#0e48c1] transition-all duration-300 z-0" style="width: 50%;"></div>

                    <!-- Step 1 -->
                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div id="step-circle-1" class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1] transition-all duration-300">
                            1
                        </div>
                        <span id="step-label-1" class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0c3683] uppercase transition-colors duration-300">Configuration</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div id="step-circle-2" class="w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px] transition-all duration-300">
                            2
                        </div>
                        <span id="step-label-2" class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-400 uppercase transition-colors duration-300">Selection</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div id="step-circle-3" class="w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px] transition-all duration-300">
                            3
                        </div>
                        <span id="step-label-3" class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0e48c1] uppercase transition-colors duration-300">Preview</span>
                    </div>
                </div>
            </div>

            <!-- Form Wrapper -->
            <form action="#" method="POST" id="evaluation-form" class="space-y-8 mt-4">
                @csrf

                <!-- Step 1 Content -->
                <div id="step-1-content" class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Evaluation Details Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <!-- Card Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <!-- Settings Gear Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Details</h2>
                            </div>
                        </div>

                        <!-- Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Semester -->
                            <div class="space-y-2.5">
                                <label for="semester" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Semester</label>
                                <div class="relative">
                                    <select id="semester" name="semester" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        @foreach(semesterOptions() as $sem)
                                            <option>{{ $sem }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Evaluation Type -->
                            <div class="space-y-2.5">
                                <label for="type" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Evaluation Type</label>
                                <div class="relative">
                                    <select id="type" name="type" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        <option>Mid-term</option>
                                        <option>Final</option>
                                        <option>Annual</option>
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="space-y-2.5">
                                <label for="start_date" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Start Date</label>
                                <div class="relative">
                                    <input id="start_date" name="start_date" type="text" placeholder="mm/dd/yyyy" class="w-full rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" />
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="space-y-2.5">
                                <label for="end_date" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">End Date</label>
                                <div class="relative">
                                    <input id="end_date" name="end_date" type="text" placeholder="mm/dd/yyyy" class="w-full rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text'" />
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Advanced Settings Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <!-- Card Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <!-- Toggle Sliders Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-[20px] font-bold text-[#0c3683]">Advanced Settings</h2>
                            </div>
                        </div>

                        <!-- Toggles List -->
                        <div class="space-y-7">
                            <!-- Toggle 1 -->
                            <label class="flex items-start justify-between gap-6 cursor-pointer">
                                <div class="space-y-1">
                                    <span class="block text-[15px] font-bold text-slate-800">Anonymous Feedback</span>
                                    <span class="block text-[13px] text-slate-500 font-medium leading-normal">Do not disclose student identities to faculty.</span>
                                </div>
                                <span class="relative inline-flex items-center shrink-0">
                                    <input type="checkbox" name="anonymous_feedback" value="1" class="sr-only peer" checked>
                                    <span class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#0e48c1] transition-colors duration-200"></span>
                                    <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                                </span>
                            </label>

                            <!-- Toggle 2 -->
                            <label class="flex items-start justify-between gap-6 cursor-pointer">
                                <div class="space-y-1">
                                    <span class="block text-[15px] font-bold text-slate-800">Allow Faculty Responses</span>
                                    <span class="block text-[13px] text-slate-500 font-medium leading-normal">Enable direct faculty commentary on feedback.</span>
                                </div>
                                <span class="relative inline-flex items-center shrink-0">
                                    <input type="checkbox" name="allow_responses" value="1" class="sr-only peer">
                                    <span class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#0e48c1] transition-colors duration-200"></span>
                                    <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                                </span>
                            </label>

                            <!-- Toggle 3 -->
                            <label class="flex items-start justify-between gap-6 cursor-pointer">
                                <div class="space-y-1">
                                    <span class="block text-[15px] font-bold text-slate-800">Send Automatic Reminders</span>
                                    <span class="block text-[13px] text-slate-500 font-medium leading-normal">System-generated pings for pending evals.</span>
                                </div>
                                <span class="relative inline-flex items-center shrink-0">
                                    <input type="checkbox" name="send_reminders" value="1" class="sr-only peer" checked>
                                    <span class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#0e48c1] transition-colors duration-200"></span>
                                    <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                                </span>
                            </label>
                        </div>
                    </section>
                </div>

                <!-- Step 2 Content (Selection) -->
                <div id="step-2-content" class="hidden grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Evaluation Scope Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <!-- Card Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <!-- Target/Scope Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Scope</h2>
                            </div>
                        </div>

                        <!-- Department Selector -->
                        <div class="space-y-6">
                            <div class="space-y-2.5">
                                <label for="scope_department" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Department</label>
                                <div class="relative">
                                    <select id="scope_department" name="department" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        <option value="">All Departments</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept['name'] }}">{{ $dept['name'] }} ({{ $dept['count'] }} Faculty)</option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Faculty Selection -->
                            <div class="space-y-2.5">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Target Faculty</label>
                                    <button type="button" id="select-all-faculty" class="text-xs font-bold text-[#0e48c1] hover:underline">Deselect All</button>
                                </div>
                                <!-- Faculty List Container -->
                                <div class="border border-slate-100 rounded-2xl bg-[#f8fafc] p-4 max-h-[300px] overflow-y-auto space-y-3" id="faculty-list">
                                    @foreach($faculty as $member)
                                        <label class="flex items-center gap-4 bg-white p-3.5 rounded-xl border border-slate-100 cursor-pointer hover:bg-slate-50 transition-colors faculty-item animate-fade-in" data-department="{{ $member['department'] }}">
                                            <input type="checkbox" name="selected_faculty[]" value="{{ $member['id'] }}" class="w-4 h-4 rounded text-[#0e48c1] border-slate-300 focus:ring-[#0e48c1] faculty-checkbox" checked>
                                            <img src="{{ $member['avatar'] }}" alt="{{ $member['name'] }}" class="w-8 h-8 rounded-full object-cover bg-slate-100">
                                            <div class="flex-1">
                                                <span class="block text-sm font-bold text-slate-800 leading-none">{{ $member['name'] }}</span>
                                                <span class="block text-xs text-slate-400 font-medium mt-1">{{ $member['department'] ?: 'General' }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Selection Summary Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-[18px] font-bold text-[#0c3683]">Selection Summary</h3>
                                <p class="text-xs text-slate-400 font-semibold mt-1">Review coverage before previewing.</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-extrabold uppercase tracking-widest">Ready</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 flex-1 my-4">
                            <div class="rounded-2xl bg-[#f8fafc] p-5 border border-slate-100 flex flex-col justify-center">
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Faculty</div>
                                <div class="text-[28px] font-extrabold text-slate-800 leading-none" id="summary-faculty-count">{{ count($faculty) }}</div>
                                <div class="text-xs text-slate-400 font-semibold mt-1">selected</div>
                            </div>
                            <div class="rounded-2xl bg-[#f8fafc] p-5 border border-slate-100 flex flex-col justify-center">
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Departments</div>
                                <div class="text-[28px] font-extrabold text-slate-800 leading-none" id="summary-dept-count">{{ count($departments) }}</div>
                                <div class="text-xs text-slate-400 font-semibold mt-1">active</div>
                            </div>
                        </div>

                        <p class="text-xs text-slate-400 font-semibold leading-relaxed mt-2">Adjust department filters to scope down selection automatically.</p>
                    </section>
                </div>

                <!-- Step 3 Content (Preview) -->
                <div id="step-3-content" class="hidden grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Cycle Details Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <!-- Card Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <!-- Preview Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Cycle Preview</h2>
                            </div>
                        </div>

                        <!-- Details Summary Grid -->
                        <div class="grid grid-cols-2 gap-6 bg-[#f8fafc] p-6 rounded-2xl border border-slate-100 mb-6">
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Semester</span>
                                <span class="text-sm font-bold text-slate-800" id="preview-semester">{{ currentTerm() }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Evaluation Type</span>
                                <span class="text-sm font-bold text-slate-800" id="preview-type">Mid-term</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Start Date</span>
                                <span class="text-sm font-bold text-slate-800" id="preview-start-date">-</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">End Date</span>
                                <span class="text-sm font-bold text-slate-800" id="preview-end-date">-</span>
                            </div>
                        </div>

                        <!-- Selected Target -->
                        <div class="space-y-3">
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Scope Coverage</span>
                            <div class="border border-slate-100 rounded-2xl bg-[#f8fafc] p-5 flex justify-between items-center">
                                <div>
                                    <span class="block text-sm font-bold text-slate-800" id="preview-department">All Departments</span>
                                    <span class="block text-xs text-slate-400 font-semibold mt-1.5" id="preview-faculty-count">All Faculty Members selected</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Policies Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <!-- Policy Shield Icon -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-[20px] font-bold text-[#0c3683]">Enabled Policies</h2>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-sm font-semibold text-slate-600">Anonymous Feedback</span>
                                <span class="text-xs font-bold text-slate-500 uppercase px-2.5 py-1 bg-slate-100 rounded-full transition-all duration-300" id="preview-policy-anon">Disabled</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-sm font-semibold text-slate-600">Allow Faculty Responses</span>
                                <span class="text-xs font-bold text-slate-500 uppercase px-2.5 py-1 bg-slate-100 rounded-full transition-all duration-300" id="preview-policy-responses">Disabled</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-sm font-semibold text-slate-600">Send Automatic Reminders</span>
                                <span class="text-xs font-bold text-slate-500 uppercase px-2.5 py-1 bg-slate-100 rounded-full transition-all duration-300" id="preview-policy-reminders">Disabled</span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Info Banner (Heads up!) -->
                <section class="bg-[#eff6ff] border border-blue-100 rounded-[1.5rem] p-6 shadow-sm border-l-4 border-l-[#0e48c1] flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-white text-[#0e48c1] flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M4 20h16a2 2 0 002-2V7.414a2 2 0 00-.586-1.414l-3.414-3.414A2 2 0 0016.586 2H4a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-slate-800 mb-1">Heads up!</h3>
                        <p class="text-[13px] text-slate-500 font-medium leading-relaxed">Starting a new evaluation cycle will notify all eligible students via the Scholar Metric mobile app. Ensure your date range allows at least 14 days for comprehensive data collection.</p>
                    </div>
                </section>

                <!-- Action Buttons Footer -->
                <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                    <!-- Cancel Link -->
                    <a href="/admin/evaluations" id="btn-cancel" class="text-slate-500 font-extrabold text-[14px] hover:text-slate-800 transition-colors duration-200">Cancel</a>
                    
                    <!-- Back Button -->
                    <button type="button" id="btn-back" class="hidden px-6 py-3.5 rounded-2xl border border-slate-200 text-slate-600 font-extrabold text-[14px] hover:bg-slate-50 transition-colors duration-200">Cancel</button>
                    
                    <!-- Next Button -->
                    <button type="button" id="btn-next" class="px-6 py-3.5 rounded-2xl bg-[#0e48c1] text-white font-extrabold text-[14px] shadow-[0_4px_14px_rgba(14,72,193,0.35)] hover:bg-blue-800 transition-all duration-200 flex items-center gap-2 transform active:scale-[0.98]">
                        <span id="btn-next-text">Next: Select Faculty</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Submit Button -->
                    <button type="submit" id="btn-submit" class="hidden px-6 py-3.5 rounded-2xl bg-[#0e48c1] text-white font-extrabold text-[14px] shadow-[0_4px_14px_rgba(14,72,193,0.35)] hover:bg-blue-800 transition-all duration-200 flex items-center gap-2 transform active:scale-[0.98]">
                        <span>Next: Select Faculty</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;

    const step1Content = document.getElementById('step-1-content');
    const step2Content = document.getElementById('step-2-content');
    const step3Content = document.getElementById('step-3-content');

    const stepCircle1 = document.getElementById('step-circle-1');
    const stepCircle2 = document.getElementById('step-circle-2');
    const stepCircle3 = document.getElementById('step-circle-3');

    const stepLabel1 = document.getElementById('step-label-1');
    const stepLabel2 = document.getElementById('step-label-2');
    const stepLabel3 = document.getElementById('step-label-3');

    const progressBar = document.getElementById('progress-bar');

    const btnCancel = document.getElementById('btn-cancel');
    const btnBack = document.getElementById('btn-back');
    const btnNext = document.getElementById('btn-next');
    const btnNextText = document.getElementById('btn-next-text');
    const btnSubmit = document.getElementById('btn-submit');

    const departmentSelect = document.getElementById('scope_department');
    const facultyItems = document.querySelectorAll('.faculty-item');
    const facultyCheckboxes = document.querySelectorAll('.faculty-checkbox');
    const selectAllFacultyBtn = document.getElementById('select-all-faculty');

    const summaryFacultyCount = document.getElementById('summary-faculty-count');
    const summaryDeptCount = document.getElementById('summary-dept-count');

    // Update steps visual
    function updateWizard() {
        // Content blocks
        step1Content.classList.add('hidden');
        step1Content.classList.remove('grid');
        step2Content.classList.add('hidden');
        step2Content.classList.remove('grid');
        step3Content.classList.add('hidden');
        step3Content.classList.remove('grid');

        // Reset step circles
        stepCircle1.className = "w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px] transition-all duration-300";
        stepCircle2.className = "w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px] transition-all duration-300";
        stepCircle3.className = "w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px] transition-all duration-300";

        // Reset labels to grey
        stepLabel1.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-400 uppercase transition-colors duration-300";
        stepLabel2.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-400 uppercase transition-colors duration-300";
        stepLabel3.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-400 uppercase transition-colors duration-300";

        if (currentStep === 1) {
            step1Content.classList.remove('hidden');
            step1Content.classList.add('grid');

            // Circle 1 is active (blue)
            stepCircle1.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1] transition-all duration-300";
            stepLabel1.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-800 uppercase transition-colors duration-300";
            
            // Step 3 preview label is blue in the mockup
            stepLabel3.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0e48c1] uppercase transition-colors duration-300";

            progressBar.style.width = '0%';

            btnCancel.classList.remove('hidden');
            btnBack.classList.add('hidden');
            
            btnNext.classList.remove('hidden');
            btnNextText.innerText = "Next: Select Faculty";
            btnSubmit.classList.add('hidden');
        } else if (currentStep === 2) {
            step2Content.classList.remove('hidden');
            step2Content.classList.add('grid');

            // Circle 1 is checked (blue)
            stepCircle1.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]";
            // Circle 2 is active (blue)
            stepCircle2.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1] transition-all duration-300";
            
            stepLabel1.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase transition-colors duration-300";
            stepLabel2.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-800 uppercase transition-colors duration-300";
            stepLabel3.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0e48c1] uppercase transition-colors duration-300";

            progressBar.style.width = '50%';

            btnCancel.classList.add('hidden');
            btnBack.classList.remove('hidden');
            
            btnNext.classList.remove('hidden');
            btnNextText.innerText = "Next: Preview Cycle";
            btnSubmit.classList.add('hidden');
        } else if (currentStep === 3) {
            step3Content.classList.remove('hidden');
            step3Content.classList.add('grid');

            // Circle 1 & 2 are checked (blue)
            stepCircle1.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]";
            stepCircle2.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]";
            // Circle 3 is active (blue)
            stepCircle3.className = "w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1] transition-all duration-300";

            stepLabel1.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase transition-colors duration-300";
            stepLabel2.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase transition-colors duration-300";
            stepLabel3.className = "absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0e48c1] uppercase transition-colors duration-300";

            progressBar.style.width = '100%';

            btnCancel.classList.add('hidden');
            btnBack.classList.remove('hidden');
            
            btnNext.classList.add('hidden');
            btnSubmit.classList.remove('hidden');

            // Update Preview fields
            document.getElementById('preview-semester').innerText = document.getElementById('semester').value;
            document.getElementById('preview-type').innerText = document.getElementById('type').value;
            document.getElementById('preview-start-date').innerText = document.getElementById('start_date').value || 'Not set';
            document.getElementById('preview-end-date').innerText = document.getElementById('end_date').value || 'Not set';

            // Selected department & faculty preview
            const selectedDept = departmentSelect.value || 'All Departments';
            document.getElementById('preview-department').innerText = selectedDept;

            const selectedFacultyCount = document.querySelectorAll('.faculty-checkbox:checked').length;
            document.getElementById('preview-faculty-count').innerText = `${selectedFacultyCount} Faculty Member(s) selected`;

            // Toggles preview
            const anonChecked = document.querySelector('input[name="anonymous_feedback"]').checked;
            const responseChecked = document.querySelector('input[name="allow_responses"]').checked;
            const reminderChecked = document.querySelector('input[name="send_reminders"]').checked;

            document.getElementById('preview-policy-anon').innerText = anonChecked ? 'Enabled' : 'Disabled';
            document.getElementById('preview-policy-anon').className = `text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full ${anonChecked ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500'}`;

            document.getElementById('preview-policy-responses').innerText = responseChecked ? 'Enabled' : 'Disabled';
            document.getElementById('preview-policy-responses').className = `text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full ${responseChecked ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500'}`;

            document.getElementById('preview-policy-reminders').innerText = reminderChecked ? 'Enabled' : 'Disabled';
            document.getElementById('preview-policy-reminders').className = `text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full ${reminderChecked ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500'}`;
        }
    }

    // Step navigation event handlers
    btnNext.addEventListener('click', function() {
        if (currentStep < 3) {
            currentStep++;
            updateWizard();
        }
    });

    btnBack.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
        }
    });

    // Faculty filtering by department
    departmentSelect.addEventListener('change', function() {
        const deptValue = this.value;
        let visibleCount = 0;
        let activeDepts = new Set();

        facultyItems.forEach(item => {
            const itemDept = item.getAttribute('data-department');
            if (!deptValue || itemDept === deptValue) {
                item.style.display = 'flex';
                activeDepts.add(itemDept);
                if (item.querySelector('.faculty-checkbox').checked) {
                    visibleCount++;
                }
            } else {
                item.style.display = 'none';
            }
        });

        // Update active count summary
        updateSummaryCounts();
    });

    // Handle Select All Faculty
    selectAllFacultyBtn.addEventListener('click', function() {
        const deptValue = departmentSelect.value;
        const visibleCheckboxes = Array.from(facultyCheckboxes).filter(cb => {
            const parent = cb.closest('.faculty-item');
            return !deptValue || parent.getAttribute('data-department') === deptValue;
        });

        const allChecked = visibleCheckboxes.every(cb => cb.checked);
        visibleCheckboxes.forEach(cb => {
            cb.checked = !allChecked;
        });

        this.innerText = allChecked ? "Select All" : "Deselect All";
        updateSummaryCounts();
    });

    // Update Counts on Checkbox click
    facultyCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSummaryCounts);
    });

    function updateSummaryCounts() {
        const checkedBoxes = Array.from(facultyCheckboxes).filter(cb => {
            const parent = cb.closest('.faculty-item');
            const deptValue = departmentSelect.value;
            const isVisible = !deptValue || parent.getAttribute('data-department') === deptValue;
            return cb.checked && isVisible;
        });

        summaryFacultyCount.innerText = checkedBoxes.length;

        // Calculate active departments based on checked faculty
        const depts = new Set();
        checkedBoxes.forEach(cb => {
            const parent = cb.closest('.faculty-item');
            depts.add(parent.getAttribute('data-department'));
        });
        summaryDeptCount.innerText = depts.size;
    }

    // Success notification overlay on form submission
    document.getElementById('evaluation-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Create success modal element
        const modal = document.createElement('div');
        modal.className = "fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300";
        modal.innerHTML = `
            <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-[0_20px_50px_rgba(15,23,42,0.15)] text-center scale-95 transform transition-all duration-300 opacity-0" id="success-modal-card">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-[22px] font-extrabold text-slate-800 mb-2">Evaluation Cycle Initiated</h3>
                <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">The new faculty evaluation cycle has been successfully configured and started. Notifications have been dispatched.</p>
                <div class="text-xs text-slate-400 font-bold tracking-widest uppercase">Redirecting...</div>
            </div>
        `;

        document.body.appendChild(modal);

        // Animate elements in
        setTimeout(() => {
            document.getElementById('success-modal-card').classList.remove('scale-95', 'opacity-0');
            document.getElementById('success-modal-card').classList.add('scale-100', 'opacity-100');
        }, 50);

        // Redirect after a short delay
        setTimeout(() => {
            window.location.href = "/admin/evaluations";
        }, 2500);
    });

    updateWizard();
});
</script>
</x-admin>