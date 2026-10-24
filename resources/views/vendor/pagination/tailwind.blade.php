@php
    $locale = app()->getLocale();
    $isBn   = $locale === 'bn';
    $bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
    $enDigits = ['0','1','2','3','4','5','6','7','8','9'];
    $fnNum  = fn($n) => $isBn ? str_replace($enDigits, $bnDigits, (string)$n) : (string)$n;
@endphp

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ $isBn ? 'পৃষ্ঠা নেভিগেশন' : 'Pagination Navigation' }}" class="flex items-center justify-between w-full py-2">

        {{-- Mobile View (< sm) --}}
        <div class="flex items-center justify-between w-full sm:hidden gap-3">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-400 bg-gray-50 border border-gray-200/60 cursor-not-allowed select-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>{{ $isBn ? 'পূর্ববর্তী' : 'Previous' }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-white border border-gray-200 shadow-2xs hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    <span>{{ $isBn ? 'পূর্ববর্তী' : 'Previous' }}</span>
                </a>
            @endif

            {{-- Mobile Current Page Indicator --}}
            <span class="text-xs font-medium text-gray-500">
                {{ $isBn
                    ? 'পৃষ্ঠা ' . $fnNum($paginator->currentPage()) . ' / ' . $fnNum($paginator->lastPage())
                    : 'Page ' . $paginator->currentPage() . ' of ' . $paginator->lastPage() }}
            </span>

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-white border border-gray-200 shadow-2xs hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                    <span>{{ $isBn ? 'পরবর্তী' : 'Next' }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-gray-400 bg-gray-50 border border-gray-200/60 cursor-not-allowed select-none">
                    <span>{{ $isBn ? 'পরবর্তী' : 'Next' }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop / Tablet View (>= sm) --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between gap-4">
            {{-- Results counter --}}
            <div>
                <p class="text-xs text-gray-500 font-medium">
                    @if ($paginator->firstItem())
                        @if($isBn)
                            মোট <span class="font-bold text-gray-800">{{ $fnNum($paginator->total()) }}</span> টির মধ্যে
                            <span class="font-bold text-gray-800">{{ $fnNum($paginator->firstItem()) }}</span> - <span class="font-bold text-gray-800">{{ $fnNum($paginator->lastItem()) }}</span> দেখানো হচ্ছে
                        @else
                            Showing <span class="font-bold text-gray-800">{{ $paginator->firstItem() }}</span> to <span class="font-bold text-gray-800">{{ $paginator->lastItem() }}</span> of <span class="font-bold text-gray-800">{{ $paginator->total() }}</span> results
                        @endif
                    @else
                        @if($isBn)
                            মোট <span class="font-bold text-gray-800">{{ $fnNum($paginator->count()) }}</span> টি ফলাফল
                        @else
                            <span class="font-bold text-gray-800">{{ $paginator->count() }}</span> results
                        @endif
                    @endif
                </p>
            </div>

            {{-- Pagination Links Pill Buttons --}}
            <div>
                <ul class="inline-flex items-center gap-1.5 list-none m-0 p-0">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li aria-disabled="true" aria-label="{{ $isBn ? 'পূর্ববর্তী' : 'Previous' }}">
                            <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-gray-300 bg-gray-50 border border-gray-200/50 cursor-not-allowed select-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                               class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-gray-600 bg-white border border-gray-200 shadow-2xs hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all font-semibold"
                               title="{{ $isBn ? 'পূর্ববর্তী পৃষ্ঠা' : 'Previous page' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li aria-disabled="true">
                                <span class="w-7 h-9 inline-flex items-center justify-center text-gray-400 font-bold select-none text-xs tracking-widest">&hellip;</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li aria-current="page">
                                        <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center font-bold text-xs bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-xs shadow-blue-300 select-none">
                                            {{ $fnNum($page) }}
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}"
                                           class="w-9 h-9 rounded-xl inline-flex items-center justify-center font-semibold text-xs text-gray-700 bg-white border border-gray-200 shadow-2xs hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all">
                                            {{ $fnNum($page) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                               class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-gray-600 bg-white border border-gray-200 shadow-2xs hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all font-semibold"
                               title="{{ $isBn ? 'পরবর্তী পৃষ্ঠা' : 'Next page' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </li>
                    @else
                        <li aria-disabled="true" aria-label="{{ $isBn ? 'পরবর্তী' : 'Next' }}">
                            <span class="w-9 h-9 rounded-xl inline-flex items-center justify-center text-gray-300 bg-gray-50 border border-gray-200/50 cursor-not-allowed select-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </li>
                    @endif

                </ul>
            </div>
        </div>

    </nav>
@endif
