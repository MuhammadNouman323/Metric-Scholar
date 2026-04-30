<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">
        @php
            $activeSection = $section ?? 'overview';
        @endphp
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.departments') }}" class="hover:text-[#0e48c1]">Departments</a>
            <span class="mx-2">›</span>
            <span class="text-gray-700">{{ $department['name'] }}</span>
        </div>

        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-8 mb-8 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center rounded-full bg-[#eef2ff] px-3 py-1 text-[11px] font-bold tracking-[0.14em] text-[#0e48c1]">{{ $department['departmentCode'] }}</span>
                        <span class="text-sm font-medium text-gray-500">{{ $department['established'] }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 tracking-tight">{{ $department['name'] }}</h1>
                    <p class="text-base text-gray-500 leading-7 max-w-2xl">{{ $department['description'] }}</p>
                </div>

                <div class="flex flex-wrap gap-3 shrink-0">
                    <button class="inline-flex items-center gap-2 rounded-xl bg-[#eff4ff] px-4 py-3 text-sm font-bold text-[#0e48c1]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5zm0 0V4" />
                        </svg>
                        View Curriculum
                    </button>
                    <button class="inline-flex items-center gap-2 rounded-xl bg-[#0e48c1] px-4 py-3 text-sm font-bold text-white shadow-[0_4px_12px_rgba(14,72,193,0.2)]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        </svg>
                        Manage Department
                    </button>
                </div>
            </div>

            <div class="absolute right-0 bottom-0 h-28 w-28 rounded-tl-[3rem] bg-[#f8fafc]"></div>
        </div>

        <div class="flex items-center gap-8 border-b border-gray-100 mb-8 text-sm font-semibold text-gray-500 overflow-x-auto">
                <a href="{{ route('admin.departments.show', ['department' => $department['slug'], 'section' => 'overview']) }}" class="pb-4 whitespace-nowrap {{ $activeSection === 'overview' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : '' }}">Department Overview</a>
                <a href="{{ route('admin.departments.show', ['department' => $department['slug'], 'section' => 'faculty']) }}" class="pb-4 whitespace-nowrap {{ $activeSection === 'faculty' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : '' }}">Faculty Roster</a>
                <a href="{{ route('admin.departments.show', ['department' => $department['slug'], 'section' => 'enrollment']) }}" class="pb-4 whitespace-nowrap {{ $activeSection === 'enrollment' ? 'border-b-2 border-[#0e48c1] text-[#0e48c1]' : '' }}">Student Enrollment</a>
        </div>

            @if ($activeSection === 'overview')
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                    <div class="xl:col-span-2 space-y-6">
                        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-7">
                            <div class="flex items-center justify-between gap-4 mb-5">
                                <div>
                                    <h2 class="text-[18px] font-bold text-gray-900">Department Pulse</h2>
                                    <p class="text-sm text-gray-500 mt-1">Live metrics for {{ $department['name'] }}</p>
                                </div>
                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold text-emerald-600">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Live Updates
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="rounded-2xl bg-[#f8fafc] p-4 border-b-2 border-[#0e48c1]">
                                    <div class="text-[11px] font-bold uppercase tracking-[0.14em] text-gray-400 mb-1">Avg GPA</div>
                                    <div class="text-[30px] font-bold text-gray-900 leading-none mb-2">{{ $department['pulse']['avgGpa'] }}</div>
                                    <div class="text-xs font-semibold text-emerald-600">+0.04</div>
                                </div>
                                <div class="rounded-2xl bg-[#f8fafc] p-4 border-b-2 border-[#0e48c1]">
                                    <div class="text-[11px] font-bold uppercase tracking-[0.14em] text-gray-400 mb-1">Feedback Rate</div>
                                    <div class="text-[30px] font-bold text-gray-900 leading-none mb-2">{{ $department['pulse']['feedbackRate'] }}</div>
                                    <div class="text-xs font-semibold text-emerald-600">+2%</div>
                                </div>
                                <div class="rounded-2xl bg-[#ffe7db] p-4">
                                    <div class="text-[11px] font-bold uppercase tracking-[0.14em] text-gray-400 mb-1">Pending Reviews</div>
                                    <div class="text-[30px] font-bold text-gray-900 leading-none mb-2">{{ $department['pulse']['pendingReviews'] }}</div>
                                    <div class="text-xs font-semibold text-orange-600">Action Required</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-7">
                            <div class="flex items-center justify-between gap-4 mb-6">
                                <h2 class="text-[18px] font-bold text-gray-900">Key Faculty Highlights</h2>
                                <a href="{{ route('admin.departments.show', ['department' => $department['slug'], 'section' => 'faculty']) }}" class="text-sm font-bold text-[#0e48c1]">View Roster</a>
                            </div>

                            <div class="space-y-5">
                                @foreach (array_slice($department['faculty'], 0, 2) as $member)
                                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-5 last:border-b-0 last:pb-0">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="h-12 w-12 rounded-full bg-[#eff4ff] flex items-center justify-center text-sm font-bold text-[#0e48c1] shrink-0">
                                                {{ $member['initials'] }}
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="text-sm font-bold text-gray-900 truncate">{{ $member['name'] }}</h3>
                                                <p class="text-sm text-gray-500 truncate">{{ $member['role'] }}</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex rounded-full bg-[#eff4ff] px-3 py-1 text-[11px] font-bold text-[#0e48c1] whitespace-nowrap">{{ $member['status'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[1.75rem] border-l-4 border-[#0e48c1] bg-white p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                            <h2 class="text-[18px] font-bold text-gray-900 mb-5">Enrollment Overview</h2>
                            <div class="space-y-4">
                                @foreach ($department['enrollment'] as $enrollment)
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="text-sm text-gray-500">{{ $enrollment['label'] }}</div>
                                        <div class="text-base font-bold text-gray-900">{{ $enrollment['value'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-[1.75rem] bg-[#f3f4f6] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                            <h2 class="text-[18px] font-bold text-gray-900 mb-5">Recent Activity</h2>
                            <div class="relative pl-4">
                                <div class="absolute left-1.5 top-0 bottom-0 w-px bg-gray-200"></div>
                                <div class="space-y-6">
                                    @foreach ($department['activity'] as $activity)
                                        <div class="relative">
                                            <span class="absolute -left-4 top-1.5 h-3 w-3 rounded-full bg-[#0e48c1]"></span>
                                            <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
                                                <div class="flex items-center justify-between gap-4 mb-1">
                                                    <h3 class="text-sm font-bold text-gray-900">{{ $activity['title'] }}</h3>
                                                    <span class="text-xs font-semibold text-gray-400 whitespace-nowrap">{{ $activity['time'] }}</span>
                                                </div>
                                                <p class="text-sm text-gray-500">{{ $activity['detail'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($activeSection === 'faculty')
                <div class="bg-white rounded-[1.75rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-7">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="text-[18px] font-bold text-gray-900">Faculty Roster</h2>
                        <span class="text-sm font-medium text-gray-500">{{ count($department['faculty']) }} faculty members listed</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($department['faculty'] as $member)
                            <div class="rounded-[1.5rem] border border-gray-100 bg-white p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="h-11 w-11 rounded-full bg-[#eff4ff] flex items-center justify-center text-sm font-bold text-[#0e48c1] shrink-0">
                                            {{ $member['initials'] }}
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-base font-bold text-gray-900 truncate">{{ $member['name'] }}</h3>
                                            <p class="text-sm font-medium text-[#0e48c1] truncate">{{ $member['role'] }}</p>
                                        </div>
                                    </div>
                                    <button class="text-gray-400 hover:text-gray-700" aria-label="More options">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-2 text-sm text-gray-500 mb-5">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-400">@</span>
                                        <span class="truncate">{{ $member['email'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-400">#</span>
                                        <span class="truncate">{{ $member['office'] }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-[11px] font-bold text-gray-500">{{ $member['status'] }}</span>
                                    <a href="#" class="text-sm font-bold text-[#0e48c1]">View Profile -&gt;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                    <div class="xl:col-span-2 bg-white rounded-[1.75rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] p-6 md:p-7">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <h2 class="text-[18px] font-bold text-gray-900">Student Enrollment</h2>
                            <span class="text-sm font-medium text-gray-500">{{ count($department['students']) }} students listed</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($department['students'] as $student)
                                <div class="rounded-[1.5rem] border border-gray-100 bg-white p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="h-11 w-11 rounded-full bg-[#eff4ff] flex items-center justify-center text-sm font-bold text-[#0e48c1] shrink-0">
                                                {{ $student['initials'] }}
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="text-base font-bold text-gray-900 truncate">{{ $student['name'] }}</h3>
                                                <p class="text-sm font-medium text-[#0e48c1] truncate">{{ $student['program'] }}</p>
                                            </div>
                                        </div>
                                        <button class="text-gray-400 hover:text-gray-700" aria-label="More options">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm0 5.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-2 text-sm text-gray-500 mb-5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-400">@</span>
                                            <span class="truncate">{{ $student['email'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-400">#</span>
                                            <span class="truncate">{{ $department['name'] }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between gap-3">
                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-[11px] font-bold text-gray-500">{{ $student['status'] }}</span>
                                        <a href="#" class="text-sm font-bold text-[#0e48c1]">View Profile -&gt;</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[1.75rem] border-l-4 border-[#0e48c1] bg-white p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                            <h2 class="text-[18px] font-bold text-gray-900 mb-5">Enrollment Overview</h2>
                            <div class="space-y-4">
                                @foreach ($department['enrollment'] as $enrollment)
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="text-sm text-gray-500">{{ $enrollment['label'] }}</div>
                                        <div class="text-base font-bold text-gray-900">{{ $enrollment['value'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-[1.75rem] bg-[#f3f4f6] p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                            <h2 class="text-[18px] font-bold text-gray-900 mb-5">Recent Activity</h2>
                            <div class="space-y-4">
                                @foreach ($department['activity'] as $activity)
                                    <div class="rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
                                        <div class="flex items-center justify-between gap-4 mb-1">
                                            <h3 class="text-sm font-bold text-gray-900">{{ $activity['title'] }}</h3>
                                            <span class="text-xs font-semibold text-gray-400 whitespace-nowrap">{{ $activity['time'] }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $activity['detail'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </div>
</x-admin>
