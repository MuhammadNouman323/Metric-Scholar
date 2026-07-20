<x-student>
    <div class="p-6 md:p-10 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Hero Section -->
        <div class="mb-8">
            <h1 class="text-[32px] font-bold text-[#0e48c1] tracking-tight mb-2">My Instructors</h1>
            <p class="text-[14px] text-gray-500 font-medium max-w-2xl">
                Connect with the faculty members leading your current courses. Access office hours, research profiles, and provide academic feedback.
            </p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Academic Network -->
            <div class="md:col-span-2 bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)] flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-[16px] font-bold text-[#0e48c1] mb-1">Academic Network</h3>
                    <p class="text-[14px] text-gray-500 font-medium">
                        You are currently learning from <span class="font-bold text-gray-700">{{ $totalTeachersCount }}</span> distinguished faculty members across <span class="font-bold text-gray-700">{{ $uniqueDepartmentsCount }}</span> departments.
                    </p>
                </div>
                <div class="flex items-center -space-x-3">
                    @foreach($teachers->take(4) as $index => $t)
                        <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover" src="{{ $t->avatar_url }}" alt="{{ $t->name }}">
                    @endforeach
                    @if($teachers->count() > 4)
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-100 shadow-sm flex items-center justify-center text-[12px] font-bold text-gray-600 z-10">
                            +{{ $teachers->count() - 4 }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Active Office Hours -->
            <div class="bg-[#eef2f9] rounded-[24px] p-6 border border-[#e1e8f5] shadow-sm flex flex-col justify-center">
                <p class="text-[13px] text-gray-500 font-medium mb-1">Active Office Hours</p>
                <div class="flex items-end gap-2">
                    <p class="text-[32px] font-bold text-gray-900 leading-none">02</p>
                    <p class="text-[13px] text-gray-500 font-medium pb-1">instructors available now</p>
                </div>
            </div>
        </div>

        <!-- Instructor Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
            @forelse($teachers as $teacher)
                @php
                    $firstCourse = $teacher->teaching_courses->first();
                    $department = $teacher->department ?: ($firstCourse->department ?? 'General');
                @endphp
                <div class="bg-white rounded-[24px] overflow-hidden border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_28px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col group">
                    <!-- Image Header -->
                    <div class="relative h-48 w-full overflow-hidden bg-gray-100">
                        <!-- Abstract background if no profile picture, you can integrate real image field later -->
                        <img src="{{ $teacher->avatar_url }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-[#0e48c1] text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                                {{ $department }}
                            </span>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="p-6 flex-1 flex flex-col">
                        <h4 class="text-[18px] font-bold text-gray-900 mb-1">{{ $teacher->name }}</h4>
                        
                        @if($firstCourse)
                            <p class="text-[13px] font-bold text-[#0e48c1] mb-4">
                                {{ $firstCourse->title }} <span class="font-normal">({{ $firstCourse->code }})</span>
                            </p>
                        @endif

                        <div class="space-y-2.5 mb-6">
                            <div class="flex items-center gap-3 text-[13px] text-gray-500 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="truncate">{{ $teacher->email }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-[13px] text-gray-500 font-medium">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $department }} Wing, Faculty Office</span>
                            </div>
                        </div>

                        <div class="mt-auto flex gap-3">
                            <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-[13px] font-bold py-2.5 rounded-xl transition-colors">
                                View Profile
                            </button>
                            @if($firstCourse)
                                <a href="{{ route('student.feedback', $firstCourse->id) }}" class="flex-1 bg-[#0e48c1] hover:bg-blue-800 text-white text-[13px] font-bold py-2.5 rounded-xl transition-colors text-center inline-block">
                                    Give Feedback
                                </a>
                            @else
                                <a href="{{ route('student.feedback') }}" class="flex-1 bg-[#0e48c1] hover:bg-blue-800 text-white text-[13px] font-bold py-2.5 rounded-xl transition-colors text-center inline-block">
                                    Give Feedback
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Instructors Found</h3>
                    <p class="text-gray-500 font-medium">You are not currently enrolled in any courses with assigned faculty.</p>
                </div>
            @endforelse
        </div>

        <!-- Evaluation Banner -->
        <div class="bg-gray-50/80 rounded-[24px] p-6 md:p-8 flex flex-col md:flex-row gap-6 items-start">
            <div class="w-12 h-12 bg-blue-100/50 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-[#0e48c1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-[16px] font-bold text-[#0e48c1] mb-2">Evaluation Period Active</h3>
                <p class="text-[14px] text-gray-600 font-medium leading-relaxed mb-4 max-w-4xl">
                    The mid-semester faculty evaluation period is now open. Your feedback is anonymous and helps us maintain high academic standards. Please take a moment to provide constructive feedback for your current instructors by clicking the "Give Feedback" button on their card.
                </p>
                <a href="#" class="text-[14px] font-bold text-[#0e48c1] hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                    View Evaluation Guidelines 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</x-student>
