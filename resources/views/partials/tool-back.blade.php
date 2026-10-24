@php
    $toolLocale = app()->getLocale() ?: config('app.locale', 'bn');
    $isBn = $toolLocale === 'bn';
@endphp
<div class="mb-5 flex items-center justify-between no-print">
    <a href="{{ route('tools.index', ['locale' => $toolLocale]) }}"
       class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-600 hover:text-blue-600 bg-white hover:bg-blue-50/70 border border-gray-200/90 hover:border-blue-200 px-3.5 py-1.5 rounded-xl transition-all shadow-2xs group">
        <i class="fa-solid fa-arrow-left text-xs text-gray-400 group-hover:text-blue-600 group-hover:-translate-x-1 transition-transform"></i>
        <span>{{ $isBn ? 'সকল টুলস' : 'All Tools' }}</span>
    </a>

    <div class="hidden sm:flex items-center gap-2 text-[11px] text-gray-400">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span>{{ $isBn ? 'অনলাইন ফ্রি টুলস' : 'Free Online Utility' }}</span>
    </div>
</div>
