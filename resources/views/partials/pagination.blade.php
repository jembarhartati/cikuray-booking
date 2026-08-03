@if ($paginator->hasPages())
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <!-- Mobile View -->
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-mountain-400 bg-white border border-mountain-200 rounded-xl cursor-not-allowed">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-semibold text-mountain-700 bg-white border border-mountain-200 rounded-xl hover:bg-mountain-50 transition-colors">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-semibold text-mountain-700 bg-white border border-mountain-200 rounded-xl hover:bg-mountain-50 transition-colors">
                    Selanjutnya
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-semibold text-mountain-400 bg-white border border-mountain-200 rounded-xl cursor-not-allowed">
                    Selanjutnya
                </span>
            @endif
        </div>

        <!-- Desktop View -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-mountain-500">
                    Menampilkan <span class="font-bold text-mountain-850">{{ $paginator->firstItem() }}</span> sampai <span class="font-bold text-mountain-850">{{ $paginator->lastItem() }}</span> dari <span class="font-bold text-mountain-850">{{ $paginator->total() }}</span> hasil
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-xl shadow-sm -space-x-px border border-mountain-200 overflow-hidden" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-3 py-2 bg-white text-mountain-400 cursor-not-allowed border-r border-mountain-200">
                            <span class="sr-only">Sebelumnya</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 bg-white text-mountain-500 hover:bg-mountain-50 transition-colors border-r border-mountain-200">
                            <span class="sr-only">Sebelumnya</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 bg-white text-mountain-400 text-xs font-semibold border-r border-mountain-200">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="z-10 bg-forest-50 border-r border-mountain-200 text-forest-750 relative inline-flex items-center px-4 py-2 text-xs font-bold">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="bg-white border-r border-mountain-200 text-mountain-650 hover:bg-mountain-50 transition-colors relative inline-flex items-center px-4 py-2 text-xs font-semibold">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 bg-white text-mountain-500 hover:bg-mountain-50 transition-colors">
                            <span class="sr-only">Selanjutnya</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-3 py-2 bg-white text-mountain-400 cursor-not-allowed">
                            <span class="sr-only">Selanjutnya</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
@endif
