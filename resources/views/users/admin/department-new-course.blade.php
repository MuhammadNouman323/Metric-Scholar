<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">
        <!-- Breadcrumb -->
        <div class="text-sm font-medium text-gray-500 mb-5">
            <a href="{{ route('admin.departments') }}" class="hover:text-[#0e48c1]">Departments</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.show', $department) }}" class="hover:text-[#0e48c1]">{{ $departmentName }}</a>
            <span class="mx-2">›</span>
            <a href="{{ route('admin.departments.manage', $department) }}" class="hover:text-[#0e48c1]">Manage Department</a>
            <span class="mx-2">›</span>
            <span class="text-gray-900 font-semibold">Add New Course</span>
        </div>

        <div class="max-w-4xl mx-auto space-y-8 mt-8">
            <div class="space-y-2">
                <h1 class="text-[40px] font-extrabold text-[#1f2937] leading-tight tracking-tight">Create New Course</h1>
                <p class="text-gray-500 text-[15px] font-medium">Add a new academic offering to the central curriculum registry. Ensure all departmental codes match official documentation.</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-[1.5rem] overflow-hidden shadow-sm">
                <div class="h-2 bg-[#0e48c1]"></div>

                <form action="{{ route('admin.departments.courses.store', $department) }}" method="POST" class="p-7 md:p-9 space-y-8">
                    @csrf

                    <section class="space-y-5">
                        <h2 class="text-[18px] font-bold text-[#1f2937]">Primary Details</h2>

                        <div class="space-y-2">
                            <label for="title" class="block text-[13px] font-bold text-[#1f2937]">Course Name</label>
                            <input id="title" name="title" type="text" placeholder="e.g. Introduction to Computer Science" value="{{ old('title') }}"
                                class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="code" class="block text-[13px] font-bold text-[#1f2937]">Course Code</label>
                                <input id="code" name="code" type="text" placeholder="e.g. CS-101" value="{{ old('code') }}"
                                class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                            @error('code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                            
                        </div>
                    </section>

                    <section class="pt-6 border-t border-gray-100 space-y-5">
                        <h2 class="text-[18px] font-bold text-[#1f2937]">Logistics & Credit</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="semester" class="block text-[13px] font-bold text-[#1f2937]">Effective Semester</label>
                                <select id="semester" name="semester"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white">
                                    <option value="">Select Term</option>
                                    @foreach(semesterOptions() as $sem)
                                        <option value="{{ $sem }}" {{ old('semester') === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                    @endforeach
                                </select>
                                @error('semester')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="credit_hours" class="block text-[13px] font-bold text-[#1f2937]">Course Credits</label>
                                <input id="credit_hours" name="credit_hours" type="number" min="1" max="8"
                                    placeholder="3" value="{{ old('credit_hours') }}"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                                @error('credit_hours')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.departments.manage', ['department' => $department, 'section' => 'courses']) }}"
                            class="px-6 py-3 rounded-xl border border-gray-100 bg-white text-[#0e48c1] font-bold text-[13px] hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-7 py-3 rounded-xl bg-[#0e48c1] text-white font-bold text-[13px] shadow-lg shadow-[#0e48c1]/25 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/30 transition-all">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>
