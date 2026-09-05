<x-admin>
    <div class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between shadow-sm relative z-20">
        <nav class="flex items-center text-[13px] font-semibold text-slate-500" aria-label="Breadcrumb">
            <span class="text-slate-600">Admin</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-slate-600">Evaluations</span>
            <span class="mx-2 text-slate-300">›</span>
            <span class="text-[#0e48c1]">Edit Scheduled Cycle</span>
        </nav>
    </div>

    <div class="bg-[#f8fafc] min-h-[calc(100vh-81px)] pb-16">
        <div class="p-6 md:p-10 lg:p-12 max-w-[1400px] mx-auto space-y-10">
            <!-- Header with Back Button -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.evaluations') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-900 hover:border-gray-300 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-[28px] font-bold text-gray-900 tracking-tight">Edit Scheduled Evaluation</h1>
                    <p class="text-gray-500 text-[14px] font-medium">Update the configuration for this scheduled evaluation cycle.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="flash-message bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 font-semibold border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $datesLocked = $evaluation->start_date->lte(now());
            @endphp

            @if($datesLocked)
                <div class="bg-amber-50 text-amber-700 p-4 rounded-xl font-semibold border border-amber-200 flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    This evaluation cycle has already started. Dates cannot be changed.
                </div>
            @endif

            <form action="{{ route('admin.evaluations.update', $evaluation) }}" method="POST" class="space-y-8 mt-4">
                @csrf
                @method('PUT')

                @if($datesLocked)
                    <input type="hidden" name="start_date" value="{{ $evaluation->start_date->format('Y-m-d') }}">
                    <input type="hidden" name="end_date" value="{{ $evaluation->end_date->format('Y-m-d') }}">
                @endif

                <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-8">
                    <!-- Evaluation Details Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#0e48c1] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div><h2 class="text-[20px] font-bold text-[#0c3683]">Evaluation Details</h2></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="space-y-2.5 col-span-1 md:col-span-2">
                                <label for="title" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Evaluation Name</label>
                                <input id="title" name="title" type="text" required value="{{ old('title', $evaluation->title) }}" class="w-full rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 text-[14px] font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white" />
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Semester -->
                            <div class="space-y-2.5">
                                <label for="semester" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Semester</label>
                                <div class="relative">
                                    <select id="semester" name="semester" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        @foreach(semesterOptions() as $sem)
                                            <option value="{{ $sem }}" {{ old('semester', $evaluation->semester) == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <!-- Evaluation Type -->
                            <div class="space-y-2.5">
                                <label for="evaluation_type" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Evaluation Type</label>
                                <div class="relative">
                                    <select id="evaluation_type" name="evaluation_type" class="w-full appearance-none rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 pr-12 text-[14px] font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white transition-all duration-200">
                                        @foreach(['Mid-Term', 'Final', 'Annual', 'Custom'] as $type)
                                            <option value="{{ $type }}" {{ old('evaluation_type', $evaluation->evaluation_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="pointer-events-none absolute right-5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="space-y-2.5">
                                <label for="start_date" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">Start Date</label>
                                <input id="start_date" name="start_date" type="date" required value="{{ old('start_date', $evaluation->start_date->format('Y-m-d')) }}" {{ $datesLocked ? 'disabled' : '' }} class="w-full rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 text-[14px] font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed" />
                                @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- End Date -->
                            <div class="space-y-2.5">
                                <label for="end_date" class="block text-[11px] font-extrabold text-slate-400 tracking-widest uppercase">End Date</label>
                                <input id="end_date" name="end_date" type="date" required value="{{ old('end_date', $evaluation->end_date->format('Y-m-d')) }}" {{ $datesLocked ? 'disabled' : '' }} class="w-full rounded-2xl border border-slate-100 bg-[#f8fafc] px-5 py-4 text-[14px] font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0e48c1] focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed" />
                                @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Advanced Settings Card -->
                    <section class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgba(15,23,42,0.04)] p-8">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-11 h-11 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <div><h2 class="text-[20px] font-bold text-[#0c3683]">Advanced Settings</h2></div>
                        </div>

                        <div class="space-y-7">
                            <input type="hidden" name="is_anonymous" value="0">
                            <label class="flex items-start justify-between gap-6 cursor-pointer">
                                <div class="space-y-1">
                                    <span class="block text-[15px] font-bold text-slate-800">Anonymous Feedback</span>
                                    <span class="block text-[13px] text-slate-500 font-medium leading-normal">Do not disclose student identities to faculty or admin.</span>
                                </div>
                                <span class="relative inline-flex items-center shrink-0">
                                    <input type="checkbox" name="is_anonymous" value="1" class="sr-only peer" {{ old('is_anonymous', $evaluation->is_anonymous) ? 'checked' : '' }}>
                                    <span class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#0e48c1] transition-colors duration-200"></span>
                                    <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                                </span>
                            </label>

                            <input type="hidden" name="send_reminder" value="0">
                            <label class="flex items-start justify-between gap-6 cursor-pointer">
                                <div class="space-y-1">
                                    <span class="block text-[15px] font-bold text-slate-800">Send Automatic Reminders</span>
                                    <span class="block text-[13px] text-slate-500 font-medium leading-normal">System-generated pings for pending evals.</span>
                                </div>
                                <span class="relative inline-flex items-center shrink-0">
                                    <input type="checkbox" name="send_reminder" value="1" class="sr-only peer" {{ old('send_reminder', $evaluation->send_reminder) ? 'checked' : '' }}>
                                    <span class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-[#0e48c1] transition-colors duration-200"></span>
                                    <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
                                </span>
                            </label>
                        </div>
                    </section>
                </div>

                <div class="flex justify-end items-center gap-4 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.evaluations') }}" class="text-slate-500 font-extrabold text-[14px] hover:text-slate-800 transition-colors duration-200">Cancel</a>
                    <button type="submit" class="px-6 py-3.5 rounded-2xl bg-[#0e48c1] text-white font-extrabold text-[14px] shadow-[0_4px_14px_rgba(14,72,193,0.35)] hover:bg-blue-800 transition-all duration-200 flex items-center gap-2 transform active:scale-[0.98]">
                        <span>Save Changes</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin>
