@php($isFaculty = $user->role->value === 'faculty')
<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1100px] mx-auto min-h-screen space-y-8">

        <!-- Header with Back Button -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ $isFaculty ? '/admin/faculty' : '/admin/students' }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-[28px] font-bold text-gray-900 tracking-tight">{{ $isFaculty ? 'Faculty Details' : 'Student Details' }}</h1>
                    <p class="text-gray-500 text-[14px] font-medium">Read-only overview of the selected {{ $isFaculty ? 'faculty' : 'student' }} account.</p>
                </div>
            </div>
            <a href="{{ route('admin.users.edit', $user) }}"
                class="inline-flex items-center gap-2 bg-[#0e48c1] text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-[#0e48c1]/30 hover:bg-[#0a389f] transition-all duration-200 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit
            </a>
        </div>

        @if (session('success'))
            <div class="flash-message rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-bold text-green-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] overflow-hidden">
            <div class="relative h-32 bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8]">
                <div class="absolute -right-6 -top-6 w-[140px] h-[140px] bg-blue-500/30 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-4 bottom-4 w-12 h-12 border-[5px] border-blue-400/30 rounded-full pointer-events-none"></div>
            </div>
            <div class="px-8 pb-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 -mt-12">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                        <img class="w-24 h-24 rounded-2xl border-4 border-white shadow-xl object-cover bg-gray-100"
                            src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        <div class="pt-14 sm:pt-0">
                            <h2 class="text-[22px] font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-[13px] font-medium text-gray-500 mt-1">{{ $isFaculty ? 'FAC-' : '#SC-' }}{{ $user->id }} &middot; {{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[12px] font-bold rounded-lg mt-14 sm:mt-0">
                        <span class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-[#f4f6f8] rounded-2xl p-5">
                        <p class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Department</p>
                        <p class="text-[14px] font-bold text-gray-900">{{ $user->department ?? 'General' }}</p>
                    </div>
                    <div class="bg-[#f4f6f8] rounded-2xl p-5">
                        <p class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Phone</p>
                        <p class="text-[14px] font-bold text-gray-900">{{ $user->phone ?? '—' }}</p>
                    </div>
                    <div class="bg-[#f4f6f8] rounded-2xl p-5">
                        <p class="text-[11px] font-bold text-gray-500 tracking-wider uppercase mb-1">Member Since</p>
                        <p class="text-[14px] font-bold text-gray-900">{{ $user->created_at?->format('M d, Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- {{ $isFaculty ? 'Assigned Courses' : 'Enrolled Courses' }} -->
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.02)] overflow-hidden">
            <div class="px-8 pt-7 pb-4 flex items-center justify-between border-b border-gray-100">
                <div>
                    <h3 class="text-[17px] font-bold text-gray-900">{{ $isFaculty ? 'Assigned Courses' : 'Enrolled Courses' }}</h3>
                    <p class="text-[13px] text-gray-500 font-medium mt-0.5">{{ $isFaculty ? 'Courses assigned to this faculty member.' : 'Courses assigned to this student.' }}</p>
                </div>
                <span class="bg-blue-50 text-[#0e48c1] text-[12px] font-bold px-3 py-1 rounded-lg">{{ $courses->count() }} courses</span>
            </div>

            @forelse($courses as $course)
                <div class="px-8 py-5 flex items-center justify-between gap-4 border-b border-gray-50 last:border-0 hover:bg-blue-50/40 transition-colors">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-10 h-10 bg-blue-50 text-[#0e48c1] rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[14px] font-bold text-gray-900 truncate">{{ $course->title }}</p>
                            <p class="text-[12px] text-gray-500 font-medium">{{ $course->code }} &middot; {{ $course->credit_hours }} credit hours</p>
                        </div>
                    </div>
                    <span class="shrink-0 inline-flex px-3 py-1.5 bg-[#e0e7ff] text-[#3730a3] text-[12px] font-bold rounded-full">{{ $course->pivot->term ?? '—' }}</span>
                </div>
            @empty
                <div class="px-8 py-10 text-center">
                    <p class="text-gray-500 font-medium">No courses assigned to this {{ $isFaculty ? 'faculty member' : 'student' }}.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-admin>