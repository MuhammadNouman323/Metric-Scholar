<x-admin>
    <div class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between shadow-sm relative z-20">
        <nav class="flex items-center text-[13px] font-semibold text-slate-500" aria-label="Breadcrumb">
            <span class="text-slate-600">Admin</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-slate-600">Evaluations</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-[#0e48c1]">New Evaluation</span>
        </nav>
    </div>

    <div class="bg-[#f8fafc] min-h-[calc(100vh-81px)] pb-16" x-data="evaluationWizard()">
        <div class="p-6 md:p-10 lg:p-12 max-w-[1400px] mx-auto space-y-10">
            <div class="space-y-2">
                <h1 class="text-[34px] font-extrabold tracking-tight text-[#0c3683]">Initiate New Evaluation</h1>
                <p class="text-[15px] text-slate-500 font-medium">Configure the parameters for the upcoming faculty evaluation cycle.</p>
            </div>

            <div class="flex items-center justify-center py-6 max-w-2xl mx-auto">
                <div class="flex items-center w-full relative">
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-[3px] bg-slate-200 z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-[3px] bg-[#0e48c1] transition-all duration-300 z-0" style="width: 50%;"></div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]">1</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase">Configuration</span>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1]">2</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-800 uppercase">Selection</span>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-white border-2 border-slate-300 text-slate-400 flex items-center justify-center font-bold text-[13px]">3</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-400 uppercase">Preview</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.evaluations.new.storeStep2') }}" method="POST" class="space-y-8 mt-4" id="step2-form">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Evaluation Scope Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div><h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Scope</h2></div>
                        </div>

                        <div class="space-y-6">
                            <!-- Department -->
                            <div class="space-y-2.5">
                                <label for="department" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Department</label>
                                <div class="relative">
                                    <select id="department" name="department" x-model="selectedDepartment" @change="fetchFaculty" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        <option value="" disabled>Select a Department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}">{{ $dept }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <!-- Loading State -->
                            <div x-show="loading" class="py-10 text-center">
                                <svg class="animate-spin h-8 w-8 text-[#0e48c1] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-sm text-slate-500 font-medium mt-3">Loading faculty & courses...</p>
                            </div>

                            <!-- Faculty & Courses Selection -->
                            <div x-show="!loading && faculty.length > 0" class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <label class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Target Faculty & Courses</label>
                                    <button type="button" @click="selectAll" class="text-xs font-bold text-[#0e48c1] hover:underline" x-text="allSelected ? 'Deselect All' : 'Select All'"></button>
                                </div>
                                
                                <div class="border border-slate-100 rounded-2xl bg-[#f8fafc] p-4 max-h-[500px] overflow-y-auto space-y-4">
                                    <template x-for="member in faculty" :key="member.id">
                                        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm animate-fade-in">
                                            <!-- Faculty Header -->
                                            <label class="flex items-center gap-4 cursor-pointer hover:bg-slate-50 transition-colors">
                                                <input type="checkbox" name="selected_faculty[]" :value="member.id" x-model="selectedFaculty" @change="toggleFaculty(member)" class="w-5 h-5 rounded text-[#0e48c1] border-slate-300 focus:ring-[#0e48c1]">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-[#0e48c1] flex items-center justify-center font-bold text-lg" x-text="member.name.charAt(0)"></div>
                                                <div class="flex-1">
                                                    <span class="block text-sm font-bold text-slate-800 leading-none" x-text="member.name"></span>
                                                    <span class="block text-xs text-slate-400 font-medium mt-1" x-text="member.department"></span>
                                                </div>
                                            </label>

                                            <!-- Courses List -->
                                            <div class="mt-4 pl-14 space-y-2 border-l-2 border-slate-100 ml-5">
                                                <template x-for="course in member.courses" :key="course.id">
                                                    <label class="flex items-center justify-between cursor-pointer group py-1.5">
                                                        <div class="flex items-center gap-3">
                                                            <input type="checkbox" name="selected_courses[]" :value="course.id" x-model="selectedCourses" @change="updateSelection" class="w-4 h-4 rounded text-[#0e48c1] border-slate-300 focus:ring-[#0e48c1]">
                                                            <div>
                                                                <span class="text-sm font-bold text-slate-700 group-hover:text-[#0e48c1] transition-colors" x-text="course.code + ' - ' + course.title"></span>
                                                            </div>
                                                        </div>
                                                        <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest" x-text="course.students_count + ' Students'"></span>
                                                    </label>
                                                </template>
                                                <div x-show="member.courses.length === 0" class="text-xs text-slate-400 font-medium italic">
                                                    No courses assigned.
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <div x-show="!loading && faculty.length === 0 && selectedDepartment !== ''" class="py-10 text-center border border-dashed border-slate-300 rounded-2xl bg-white">
                                <p class="text-sm text-slate-500 font-medium">No faculty found in this department.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Selection Summary Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8 flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-[18px] font-bold text-[#0c3683]">Selection Summary</h3>
                                <p class="text-xs text-slate-400 font-semibold mt-1">Review coverage before previewing.</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-widest"
                                  :class="selectedCourses.length > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500'"
                                  x-text="selectedCourses.length > 0 ? 'Ready' : 'Pending'">
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 flex-1 my-4">
                            <div class="rounded-2xl bg-[#f8fafc] p-5 border border-slate-100 flex flex-col justify-center">
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Faculty</div>
                                <div class="text-[28px] font-extrabold text-slate-800 leading-none" x-text="selectedFaculty.length">0</div>
                                <div class="text-xs text-slate-400 font-semibold mt-1">selected</div>
                            </div>
                            <div class="rounded-2xl bg-[#f8fafc] p-5 border border-slate-100 flex flex-col justify-center">
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Courses</div>
                                <div class="text-[28px] font-extrabold text-slate-800 leading-none" x-text="selectedCourses.length">0</div>
                                <div class="text-xs text-slate-400 font-semibold mt-1">selected</div>
                            </div>
                        </div>

                        <p class="text-xs text-slate-400 font-semibold leading-relaxed mt-2">At least one course must be selected to proceed.</p>
                    </section>
                </div>

                <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.evaluations.new.step1') }}" class="px-6 py-3.5 rounded-2xl border border-slate-200 text-slate-600 font-extrabold text-[14px] hover:bg-slate-50 transition-colors duration-200">Back</a>
                    <button type="submit" :disabled="selectedCourses.length === 0" class="px-6 py-3.5 rounded-2xl bg-[#0e48c1] text-white font-extrabold text-[14px] shadow-[0_4px_14px_rgba(14,72,193,0.35)] hover:bg-blue-800 transition-all duration-200 flex items-center gap-2 transform active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <span>Next: Preview Cycle</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('evaluationWizard', () => ({
                selectedDepartment: '{{ old('department', $selectionData['department'] ?? '') }}',
                loading: false,
                faculty: [],
                selectedFaculty: {!! json_encode(old('selected_faculty', $selectionData['selected_faculty'] ?? [])) !!},
                selectedCourses: {!! json_encode(old('selected_courses', $selectionData['selected_courses'] ?? [])) !!},
                allSelected: false,

                init() {
                    if (this.selectedDepartment) {
                        this.fetchFaculty();
                    }
                },

                async fetchFaculty() {
                    if (!this.selectedDepartment) return;
                    
                    this.loading = true;
                    try {
                        const response = await fetch(`/admin/evaluations/api/faculty-courses?department=${encodeURIComponent(this.selectedDepartment)}`);
                        const data = await response.json();
                        this.faculty = data.faculty;
                        this.updateSelection();
                    } catch (error) {
                        console.error('Error fetching faculty:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                toggleFaculty(member) {
                    const isSelected = this.selectedFaculty.includes(member.id.toString()) || this.selectedFaculty.includes(member.id);
                    
                    if (isSelected) {
                        // Select all courses for this faculty
                        member.courses.forEach(course => {
                            if (!this.selectedCourses.includes(course.id.toString()) && !this.selectedCourses.includes(course.id)) {
                                this.selectedCourses.push(course.id.toString());
                            }
                        });
                    } else {
                        // Deselect all courses for this faculty
                        member.courses.forEach(course => {
                            this.selectedCourses = this.selectedCourses.filter(id => id.toString() !== course.id.toString());
                        });
                    }
                    this.updateSelection();
                },

                selectAll() {
                    this.allSelected = !this.allSelected;
                    
                    if (this.allSelected) {
                        this.selectedFaculty = this.faculty.map(f => f.id.toString());
                        this.selectedCourses = this.faculty.flatMap(f => f.courses.map(c => c.id.toString()));
                    } else {
                        this.selectedFaculty = [];
                        this.selectedCourses = [];
                    }
                },

                updateSelection() {
                    // Check if all are selected
                    if (this.faculty.length > 0) {
                        const allFacultyIds = this.faculty.map(f => f.id.toString());
                        const allCourseIds = this.faculty.flatMap(f => f.courses.map(c => c.id.toString()));
                        
                        this.allSelected = 
                            allFacultyIds.every(id => this.selectedFaculty.includes(id) || this.selectedFaculty.includes(parseInt(id))) &&
                            allCourseIds.every(id => this.selectedCourses.includes(id) || this.selectedCourses.includes(parseInt(id)));
                    }
                }
            }))
        })
    </script>
</x-admin>
