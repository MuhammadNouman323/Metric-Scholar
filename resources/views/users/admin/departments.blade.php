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
            @forelse ($departments as $department)
                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
                    <div class="flex justify-between items-start mb-4">
                        <x-department-icon :department="$department['name']" class="w-10 h-10" />
                        <span class="text-xs font-medium text-gray-400">{{ number_format($department['facultyCount']) }} Faculty</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $department['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Students: {{ number_format($department['studentCount']) }}</p>
                    <p class="text-sm text-gray-500 mb-6">Faculty: {{ number_format($department['facultyCount']) }}</p>
                    <a href="{{ route('admin.departments.show', $department['slug']) }}" class="inline-block text-center w-full py-2 rounded-lg bg-[#f1f5f9] text-[#0e48c1] font-bold">View Details →</a>
                </div>
            @empty
                <div class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] sm:col-span-2 lg:col-span-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">No Departments Found</h3>
                    <p class="text-sm text-gray-500">Create student and faculty users from the Users page to populate dynamic department data.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-admin>
