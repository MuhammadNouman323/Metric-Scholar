@if ($paginator->hasPages())
    <div class="px-6 md:px-8 py-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-[13px] font-medium text-gray-500">
            Showing <span class="font-bold text-gray-900">{{ $paginator->firstItem() ?? 0 }}</span>
            to <span class="font-bold text-gray-900">{{ $paginator->lastItem() }}</span>
            of <span class="font-bold text-gray-900">{{ $paginator->total() }}</span>
            {{ $paginator->total() === 1 ? 'result' : 'results' }}
        </div>
        <div class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-8 h-8 flex items-center justify-center text-gray-400 opacity-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-[#0e48c1] transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-1 text-gray-400 font-bold">...</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0e48c1] text-white font-bold text-[13px] shadow-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 font-bold text-[13px] transition-colors duration-150">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-[#0e48c1] transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span class="w-8 h-8 flex items-center justify-center text-gray-400 opacity-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif
