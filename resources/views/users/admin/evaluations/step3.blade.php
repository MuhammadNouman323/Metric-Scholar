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

    <div class="bg-[#f8fafc] min-h-[calc(100vh-81px)] pb-16">
        <div class="p-6 md:p-10 lg:p-12 max-w-[1400px] mx-auto space-y-10">
            <div class="space-y-2">
                <h1 class="text-[34px] font-extrabold tracking-tight text-[#0c3683]">Initiate New Evaluation</h1>
                <p class="text-[15px] text-slate-500 font-medium">Configure the parameters for the upcoming faculty evaluation cycle.</p>
            </div>

            <div class="flex items-center justify-center py-6 max-w-2xl mx-auto">
                <div class="flex items-center w-full relative">
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-[3px] bg-slate-200 z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-[3px] bg-[#0e48c1] transition-all duration-300 z-0" style="width: 100%;"></div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]">1</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase">Configuration</span>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] border border-[#0e48c1]">2</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-slate-500 uppercase">Selection</span>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-8 h-8 rounded-full bg-[#0e48c1] text-white flex items-center justify-center font-bold text-[13px] shadow-[0_4px_10px_rgba(14,72,193,0.3)] border border-[#0e48c1]">3</div>
                        <span class="absolute top-10 whitespace-nowrap text-[11px] font-extrabold tracking-widest text-[#0e48c1] uppercase">Preview</span>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-[1rem] relative" role="alert">
                    <strong class="font-bold">Oops! There were some problems.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.evaluations.new.publish') }}" method="POST" class="space-y-8 mt-4" id="publish-form">
                @csrf
                <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Cycle Details Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div><h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Cycle Preview</h2></div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 bg-[#f8fafc] p-6 rounded-2xl border border-slate-100 mb-6">
                            <div class="col-span-2">
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Title</span>
                                <span class="text-lg font-bold text-[#0c3683]">{{ $step1['title'] }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Semester</span>
                                <span class="text-sm font-bold text-slate-800">{{ $step1['semester'] }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Evaluation Type</span>
                                <span class="text-sm font-bold text-slate-800">{{ $step1['evaluation_type'] }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Start Date</span>
                                <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($step1['start_date'])->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">End Date</span>
                                <span class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($step1['end_date'])->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Scope Coverage</span>
                            <div class="border border-slate-100 rounded-2xl bg-[#f8fafc] p-5 flex justify-between items-center">
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">{{ count($faculty) }} Faculty Members</span>
                                    <span class="block text-xs text-slate-400 font-semibold mt-1.5">{{ count($courses) }} Selected Courses ({{ $totalEligibleStudents }} Eligible Students)</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Policies Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div><h2 class="text-[20px] font-bold text-[#0c3683]">Enabled Policies</h2></div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-sm font-semibold text-slate-600">Anonymous Feedback</span>
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full {{ $step1['is_anonymous'] ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $step1['is_anonymous'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                <span class="text-sm font-semibold text-slate-600">Send Automatic Reminders</span>
                                <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full {{ $step1['send_reminder'] ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $step1['send_reminder'] ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="bg-[#eff6ff] border border-blue-100 rounded-[1.5rem] p-6 shadow-sm border-l-4 border-l-[#0e48c1] flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-white text-[#0e48c1] flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h.01M4 20h16a2 2 0 002-2V7.414a2 2 0 00-.586-1.414l-3.414-3.414A2 2 0 0016.586 2H4a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-slate-800 mb-1">Heads up!</h3>
                        <p class="text-[13px] text-slate-500 font-medium leading-relaxed">Publishing this evaluation cycle will notify all eligible students and generate anonymous feedback tokens. This action will initiate the feedback process.</p>
                    </div>
                </section>

                <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.evaluations.new.step2') }}" class="px-6 py-3.5 rounded-2xl border border-slate-200 text-slate-600 font-extrabold text-[14px] hover:bg-slate-50 transition-colors duration-200">Back</a>
                    <button type="submit" id="btn-publish" class="px-6 py-3.5 rounded-2xl bg-emerald-600 text-white font-extrabold text-[14px] shadow-[0_4px_14px_rgba(16,185,129,0.35)] hover:bg-emerald-700 transition-all duration-200 flex items-center gap-2 transform active:scale-[0.98]">
                        <span>Publish Evaluation</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    document.getElementById('publish-form').addEventListener('submit', function(e) {
        const btn = document.getElementById('btn-publish');
        btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Publishing...
        `;
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
    </script>
</x-admin>
