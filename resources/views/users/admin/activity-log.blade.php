<x-admin>
    <div class="p-6 md:p-10 lg:p-12 pb-24 max-w-[1600px] mx-auto min-h-screen">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-5">
            <div>
                <h1 class="text-3xl lg:text-[34px] font-bold text-gray-900 tracking-tight">Activity Log</h1>
                <p class="text-[14px] text-gray-500 font-medium mt-1">Feedback submissions and new member registrations across your university.</p>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex gap-3 mb-8 flex-wrap">
            @php
                $tabs = [
                    'all' => ['label' => 'All Activity', 'count' => $counts['all']],
                    'feedback' => ['label' => 'Feedback', 'count' => $counts['feedback']],
                    'user' => ['label' => 'New Members', 'count' => $counts['user']],
                ];
            @endphp
            @foreach($tabs as $key => $tab)
                <a href="{{ route('admin.activity-log', ['filter' => $key]) }}"
                    class="px-5 py-2.5 rounded-xl text-[13px] font-bold transition-all duration-200
                        @if($filter === $key)
                            bg-gradient-to-r from-[#0e48c1] to-[#3d6ae8] text-white shadow-[0_6px_16px_rgba(14,72,193,0.3)]
                        @else
                            bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900
                        @endif">
                    {{ $tab['label'] }}
                    <span class="ml-1.5 {{ $filter === $key ? 'text-white/70' : 'text-gray-400' }}">
                        ({{ $tab['count'] }})
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Timeline --}}
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]">
            <div class="relative">
                <div class="absolute left-[19px] top-2 bottom-2 w-px bg-gradient-to-b from-blue-200 via-gray-200 to-gray-100"></div>

                <div class="space-y-1">
                    @forelse($paginated as $item)
                        @if($item['type'] === 'feedback')
                            <div class="relative flex gap-4 py-3.5">
                                <div class="relative shrink-0 z-10">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center text-[#0e48c1]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-[18px] h-[18px] bg-[#0e48c1] rounded-full border-2 border-white flex items-center justify-center text-white">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="pt-0.5 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <p class="text-[13.5px] text-gray-800 leading-snug"><span
                                                class="font-bold text-gray-900">{{ $item['actor'] }}</span>
                                            submitted feedback for <span
                                                class="font-bold text-gray-900">{{ $item['course'] }}</span></p>
                                        <span
                                            class="px-2.5 py-1 bg-blue-50 text-[#0e48c1] text-[10px] font-bold rounded-lg uppercase tracking-wider">Feedback</span>
                                    </div>
                                    @if(!empty($item['quote']))
                                    <p class="text-[12.5px] text-gray-500 mt-1 italic">"{{ $item['quote'] }}"</p>
                                    @endif
                                    <p
                                        class="text-[9px] font-bold text-gray-400 mt-2 tracking-widest uppercase">{{ $item['time'] }}</p>
                                </div>
                            </div>
                        @else
                            <div class="relative flex gap-4 py-3.5">
                                <div class="relative shrink-0 z-10">
                                    <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover"
                                        src="{{ $item['avatar_url'] }}" alt="{{ $item['name'] }}">
                                    <div
                                        class="absolute -bottom-1 -right-1 w-[18px] h-[18px] bg-amber-600 rounded-full border-2 border-white flex items-center justify-center text-white">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="pt-0.5 flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <p class="text-[13.5px] text-gray-800 leading-snug"><span
                                                class="font-bold text-gray-900">{{ $item['name'] }}</span> joined as a
                                            <span class="font-bold text-gray-900">{{ $item['role'] }}</span></p>
                                        <span
                                            class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-lg uppercase tracking-wider">New Member</span>
                                    </div>
                                    <div class="flex gap-2 mt-1.5 flex-wrap">
                                        <span
                                            class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded">{{ $item['role'] }}</span>
                                        @if(!empty($item['department']))
                                        <span
                                            class="px-2 py-0.5 bg-orange-100 text-orange-700 text-[10px] font-bold rounded">{{ $item['department'] }}</span>
                                        @endif
                                    </div>
                                    <p
                                        class="text-[9px] font-bold text-gray-400 mt-2 tracking-widest uppercase">{{ $item['time'] }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-16">
                            <div
                                class="w-14 h-14 mx-auto mb-4 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">No activity found for this filter.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            @if($paginated->hasPages())
                <div class="mt-8 pt-6 border-t border-gray-100">
                    {{ $paginated->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin>