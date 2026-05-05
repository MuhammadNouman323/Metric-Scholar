<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1400px] mx-auto min-h-screen">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="space-y-2">
                <h1 class="text-[40px] font-extrabold text-[#1f2937] leading-tight tracking-tight">Create New Course</h1>
                <p class="text-gray-500 text-[15px] font-medium">Add a new academic offering to the central curriculum
                    registry. Ensure all details match official departmental records.</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-[1.5rem] overflow-hidden shadow-sm">
                <div class="h-2 bg-[#0e48c1]"></div>

                <form class="p-7 md:p-9 space-y-8" onsubmit="return false;">

                    <section class="space-y-5">
                        <h2 class="text-[18px] font-bold text-[#1f2937]">Primary Details</h2>

                        <div class="space-y-2">
                            <label for="title" class="block text-[13px] font-bold text-[#1f2937]">Course Name</label>
                            <input id="title" name="title" type="text" placeholder="e.g. Introduction to Computer Science"
                                class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="code" class="block text-[13px] font-bold text-[#1f2937]">Course Code</label>
                                <input id="code" name="code" type="text" placeholder="e.g. CS-101"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                            </div>
                            <div class="space-y-2">
                                <label for="department" class="block text-[13px] font-bold text-[#1f2937]">Department</label>
                                <select id="department" name="department"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white">
                                    <option value="">Select Department</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Economics">Economics</option>
                                    <option value="Humanities">Humanities</option>
                                    <option value="Design">Design</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <section class="pt-6 border-t border-gray-100 space-y-5">
                        <h2 class="text-[18px] font-bold text-[#1f2937]">Logistics & Credits</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="semester" class="block text-[13px] font-bold text-[#1f2937]">Effective Semester</label>
                                <select id="semester" name="semester"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white">
                                    <option value="">Select Term</option>
                                    <option value="Spring 2024">Spring 2024</option>
                                    <option value="Fall 2024">Fall 2024</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="credit_hours" class="block text-[13px] font-bold text-[#1f2937]">Course Credits</label>
                                <input id="credit_hours" name="credit_hours" type="number" min="1" max="8"
                                    placeholder="3"
                                    class="w-full border border-gray-100 bg-[#f8fafc] rounded-xl px-4 py-3 text-[14px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                            </div>
                        </div>
                    </section>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="/admin/courses"
                            class="px-6 py-3 rounded-xl border border-gray-100 bg-white text-[#0e48c1] font-bold text-[13px] hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="button"
                            class="px-7 py-3 rounded-xl bg-[#0e48c1] text-white font-bold text-[13px] shadow-lg shadow-[#0e48c1]/25 hover:bg-[#0a389f] hover:shadow-xl hover:shadow-[#0e48c1]/30 transition-all">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin>
