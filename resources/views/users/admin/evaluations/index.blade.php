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
                <a href="{{ route('admin.evaluations.new') }}"
                    class="flex items-center px-6 py-3 bg-[#0e48c1] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-[0_4px_10px_rgba(14,72,193,0.2)] transition-all transform active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Evaluation
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-50 text-center flex flex-col items-center justify-center min-h-[400px]">
            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No active evaluations</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-md">Start a new evaluation cycle to begin collecting student feedback for your faculty.</p>
            <a href="{{ route('admin.evaluations.new') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold text-sm rounded-lg transition-colors">Start New Cycle</a>
        </div>
    </div>
</x-admin>
