<x-admin>
    <div class="p-6 md:p-10 lg:p-12 max-w-[1400px] mx-auto min-h-screen">
        <div class="flex justify-between items-start mb-8">
            <div>
                <nav class="flex text-xs font-semibold text-gray-400 mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1">
                        <li class="inline-flex items-center">
                            <a href="/admin/dashboard" class="hover:text-blue-600 transition-colors">Admin</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mx-1 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-[#0e48c1]">Evaluations</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-1">Evaluation Cycles</h1>
                <p class="text-gray-500 font-medium text-sm max-w-lg leading-relaxed">Manage and monitor faculty evaluation cycles across departments.</p>
            </div>
            <div>
                <a href="{{ route('admin.evaluations.new.step1') }}"
                    class="flex items-center px-6 py-3 bg-[#0e48c1] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-[0_4px_10px_rgba(14,72,193,0.2)] transition-all transform active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Evaluation
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="flash-message bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 font-semibold border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if($evaluations->isEmpty())
            <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-50 text-center flex flex-col items-center justify-center min-h-[400px]">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No evaluations found</h3>
                <p class="text-sm text-gray-500 mb-6 max-w-md">Start a new evaluation cycle to begin collecting student feedback for your faculty.</p>
                <a href="{{ route('admin.evaluations.new.step1') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold text-sm rounded-lg transition-colors">Start New Cycle</a>
            </div>
        @else
            <!-- Active Evaluations Section -->
            @if($activeEvaluations->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Active Evaluations</h2>
                <div class="space-y-4">
                    @foreach($activeEvaluations as $activeEvaluation)
                    @php $progress = $activeEvaluationsProgress[$activeEvaluation->id] ?? [] @endphp
                    <div class="bg-white rounded-[2rem] p-8 border-2 border-[#0e48c1] shadow-[0_4px_20px_rgba(14,72,193,0.1)]">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-2xl font-extrabold text-gray-900">{{ $activeEvaluation->title }}</h3>
                                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Active</span>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Semester: {{ $activeEvaluation->semester }} | Ends on {{ $activeEvaluation->end_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-gray-100">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Eligible Students</p>
                                <p class="text-3xl font-black text-gray-900">{{ $progress['eligible'] ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Submitted</p>
                                <p class="text-3xl font-black text-emerald-600">{{ $progress['submitted'] ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pending</p>
                                <p class="text-3xl font-black text-orange-500">{{ $progress['pending'] ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Completion</p>
                                <div class="flex items-center gap-3">
                                    <p class="text-3xl font-black text-[#0e48c1]">{{ $progress['completion_percentage'] ?? 0 }}%</p>
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#0e48c1] rounded-full" style="width: {{ $progress['completion_percentage'] ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Scheduled Evaluations -->
            @if($scheduledEvaluations->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Scheduled Cycles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($scheduledEvaluations as $eval)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-900">{{ $eval->title }}</h3>
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Scheduled</span>
                            </div>
                            <p class="text-xs text-gray-500">Starts on {{ $eval->start_date->format('M d, Y') }} • {{ $eval->semester }}</p>
                        </div>
                        <a href="{{ route('admin.evaluations.edit', $eval) }}" class="shrink-0 flex items-center gap-1.5 text-xs font-bold text-[#0e48c1] hover:text-blue-800 transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Draft Evaluations -->
            @if($draftEvaluations->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Drafts</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($draftEvaluations as $eval)
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 border-dashed shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-1">{{ $eval->title }}</h3>
                        <p class="text-xs text-gray-500 mb-3">{{ $eval->semester }}</p>
                        <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">Draft</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Closed Evaluations -->
            @if($closedEvaluations->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Closed Cycles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($closedEvaluations as $eval)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <h3 class="font-bold text-gray-700 mb-1">{{ $eval->title }}</h3>
                        <p class="text-xs text-gray-500 mb-3">Ended {{ $eval->end_date->format('M d, Y') }}</p>
                        <span class="bg-gray-200 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">Closed</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
    </div>
</x-admin>
