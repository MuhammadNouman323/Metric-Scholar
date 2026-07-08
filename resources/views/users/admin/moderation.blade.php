<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1600px] mx-auto min-h-screen">
        
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-10 gap-5">
            <div>
                <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 tracking-tight">Content Moderation</h1>
                <p class="text-[14px] text-gray-500 font-medium mt-1">Review AI-moderated student feedback. Identity is strictly anonymous.</p>
            </div>
        </div>

        {{-- Top Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                <p class="text-[12px] font-bold text-gray-400 uppercase tracking-wider mb-2">Total Moderated</p>
                <div class="flex items-end justify-between">
                    <p class="text-[32px] font-bold text-gray-900 leading-none">{{ number_format($totalModerated) }}</p>
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-[#0e48c1]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50 rounded-[1.5rem] p-6 border border-emerald-100 flex flex-col justify-between">
                <p class="text-[12px] font-bold text-emerald-600 uppercase tracking-wider mb-2">Approved</p>
                <div class="flex items-end justify-between">
                    <p class="text-[32px] font-bold text-emerald-700 leading-none">{{ number_format($totalApproved) }}</p>
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 rounded-[1.5rem] p-6 border border-amber-100 flex flex-col justify-between">
                <p class="text-[12px] font-bold text-amber-600 uppercase tracking-wider mb-2">Flagged & Cleaned</p>
                <div class="flex items-end justify-between">
                    <p class="text-[32px] font-bold text-amber-700 leading-none">{{ number_format($totalFlagged) }}</p>
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[1.5rem] p-6 border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                <p class="text-[12px] font-bold text-gray-400 uppercase tracking-wider mb-2">Avg Toxicity</p>
                <div class="flex items-end justify-between">
                    <p class="text-[32px] font-bold {{ $avgToxicity > 50 ? 'text-red-500' : 'text-gray-900' }} leading-none">{{ number_format($avgToxicity, 1) }}<span class="text-[16px] text-gray-400 font-medium">/100</span></p>
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters & Table --}}
        <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_4px_16px_rgb(0,0,0,0.03)] overflow-hidden">
            
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.moderation') }}" class="flex items-center gap-3 w-full sm:w-auto flex-wrap">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments..." 
                            class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-[13px] font-medium text-gray-700 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 focus:border-[#0e48c1]/40">
                    </div>
                    
                    <select name="status" onchange="this.form.submit()"
                        class="bg-white border border-gray-200 rounded-xl px-4 py-2 text-[13px] font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#0e48c1]/20 cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="flagged" {{ request('status') === 'flagged' ? 'selected' : '' }}>Flagged</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    @if(request()->has('search') || request()->has('status'))
                        <a href="{{ route('admin.moderation') }}" class="text-[13px] font-medium text-gray-400 hover:text-gray-600">Clear</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Date & Course</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status & Toxicity</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Original Comment</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Cleaned Comment</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($answers as $answer)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-5 align-top">
                                    <p class="text-[13px] font-bold text-gray-900">{{ $answer->moderated_at?->format('M d, Y H:i') ?? 'N/A' }}</p>
                                    <p class="text-[12px] text-gray-500 mt-0.5">{{ $answer->feedback->course->code ?? 'Unknown Course' }}</p>
                                    <p class="text-[11px] text-gray-400 mt-1 uppercase tracking-wide">{{ str_replace('_', ' ', $answer->question_id) }}</p>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <div class="flex flex-col gap-2 items-start">
                                        @if($answer->moderation_status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-wider">Approved</span>
                                        @elseif($answer->moderation_status === 'flagged')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-wider">Flagged</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wider">Rejected</span>
                                        @endif
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $answer->toxicity_score > 50 ? 'bg-red-500' : ($answer->toxicity_score > 20 ? 'bg-amber-400' : 'bg-emerald-400') }}" style="width: {{ min(100, max(0, $answer->toxicity_score)) }}%"></div>
                                            </div>
                                            <span class="text-[11px] font-bold text-gray-500">{{ $answer->toxicity_score }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 align-top max-w-xs">
                                    <p class="text-[13px] text-gray-700 line-clamp-4">{{ $answer->original_comment }}</p>
                                </td>
                                <td class="px-6 py-5 align-top max-w-xs">
                                    @if($answer->original_comment === $answer->cleaned_comment)
                                        <p class="text-[12px] italic text-gray-400">No changes</p>
                                    @else
                                        <p class="text-[13px] text-gray-900 font-medium line-clamp-4 bg-yellow-50 p-2 rounded border border-yellow-100">{{ $answer->cleaned_comment }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5 align-top max-w-[200px]">
                                    <p class="text-[12px] font-medium text-gray-800 line-clamp-2">{{ $answer->moderation_reason ?? 'No reason provided' }}</p>
                                    @if(!empty($answer->moderation_categories))
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach(is_string($answer->moderation_categories) ? json_decode($answer->moderation_categories, true) ?? [] : $answer->moderation_categories as $cat)
                                                <span class="text-[9px] font-bold bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded uppercase">{{ str_replace('_', ' ', $cat) }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-[14px] font-bold text-gray-400">No moderated feedback found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($answers->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                    {{ $answers->links() }}
                </div>
            @endif
        </div>

    </div>
</x-admin>
