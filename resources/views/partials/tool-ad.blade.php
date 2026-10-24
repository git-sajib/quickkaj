@php
    $toolAd = $toolAd ?? \App\Models\AdPlacement::getSlot('tool-bottom');
@endphp

@if(!empty($toolAd))
    <div class="my-8 text-center" id="tool-bottom-ad-container">
        <div class="inline-block max-w-full bg-white rounded-2xl p-4 shadow-sm border border-gray-100 overflow-hidden text-center">
            <span class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Advertisement</span>
            <div class="flex justify-center items-center min-h-[90px] overflow-x-auto">
                {!! $toolAd->html_code !!}
            </div>
        </div>
    </div>
@endif
