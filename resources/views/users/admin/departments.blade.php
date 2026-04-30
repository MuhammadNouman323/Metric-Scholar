<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <h1 class="text-3xl lg:text-[34px] font-bold text-[#0e48c1] mb-1.5 tracking-tight">Academic Departments</h1>
                <p class="text-gray-500 text-[15px] font-medium">Overview of active departments, faculty distribution, and current evaluation cycles.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                    <button class="text-sm px-3 py-2 rounded-md bg-[#f4f7fb] text-[#0e48c1] font-bold">Grid</button>
                    <button class="text-sm px-3 py-2 rounded-md ml-2 text-gray-600">List</button>
                </div>
            </div>
        </div>

        <!-- Departments Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-lg bg-[#eef2ff] flex items-center justify-center text-[#0e48c1]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400">42 Faculty</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Computer Science</h3>
                <p class="text-sm text-gray-500 mb-6">Pioneering research in artificial intelligence, machine learning, and advanced software engineering.</p>
                <a href="{{ route('admin.departments.show', 'computer-science') }}" class="inline-block text-center w-full py-2 rounded-lg bg-[#f1f5f9] text-[#0e48c1] font-bold">View Details →</a>
            </div>

            <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-lg bg-[#fff7ed] flex items-center justify-center text-[#b45309]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.567-3 3.5S10.343 15 12 15s3-1.567 3-3.5S13.657 8 12 8z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400">28 Faculty</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Applied Physics</h3>
                <p class="text-sm text-gray-500 mb-6">Exploring the frontier of quantum materials, condensed matter physics, and advanced computation.</p>
                <a href="{{ route('admin.departments.show', 'applied-physics') }}" class="inline-block text-center w-full py-2 rounded-lg bg-[#f1f5f9] text-[#0e48c1] font-bold">View Details →</a>
            </div>

            <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-lg bg-[#f1f5f9] flex items-center justify-center text-[#065f46]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M2 12h20" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-gray-400">35 Faculty</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Bio-Chemistry</h3>
                <p class="text-sm text-gray-500 mb-6">Leading investigative studies in metabolic pathways, structural biology, and molecular genetics.</p>
                <a href="{{ route('admin.departments.show', 'bio-chemistry') }}" class="inline-block text-center w-full py-2 rounded-lg bg-[#f1f5f9] text-[#0e48c1] font-bold">View Details →</a>
            </div>
        </div>

    </div>
</x-admin>
