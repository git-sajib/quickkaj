@extends('layouts.admin')

@section('page_title', __('ui.settings'))

@section('admin-content')
<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-2xl space-y-5">
    @csrf

    @php
        $groups = collect($settingDefinitions)->groupBy(fn($def) => $def['group']);
    @endphp

    @foreach($groups as $group => $groupSettings)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="font-bold text-gray-900 border-b pb-3 capitalize">{{ $group }}</h2>
            @foreach($groupSettings as $key => $def)
                <div class="form-group">
                    <label class="form-label">{{ $def['label'] }}</label>
                    <input type="text" name="{{ $key }}" class="form-input" value="{{ old($key, $settings[$key] ?? '') }}">
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="flex gap-3">
        <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
    </div>
</form>

{{-- System Tools & Cache Clear --}}
<div class="max-w-2xl mt-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-gray-900 border-b pb-3 mb-4 flex items-center justify-between">
            <span>{{ app()->getLocale() === 'bn' ? 'সিস্টেম ক্যাশ ক্লিয়ার' : 'System Cache Utility' }}</span>
            <span class="badge-blue text-[10px]">Maintenance</span>
        </h2>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <p class="text-xs font-bold text-gray-800">{{ app()->getLocale() === 'bn' ? 'এক ক্লিকে ভিউ ও কনফিগ ক্যাশ ক্লিয়ার করুন' : 'One-Click Cache Clear' }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">{{ app()->getLocale() === 'bn' ? 'যেকোনো আপডেট সাথে সাথে দেখতে ব্রাউজার থেকেই ক্যাশ পরিষ্কার করুন।' : 'Force refresh compiled views and cache directly from browser.' }}</p>
            </div>
            <form method="POST" action="{{ route('admin.clear-cache') }}">
                @csrf
                <button type="submit" class="btn-secondary btn-sm flex items-center gap-1.5 whitespace-nowrap">
                    <i class="fa-solid fa-broom text-amber-500"></i>
                    <span>{{ app()->getLocale() === 'bn' ? 'ক্যাশ ক্লিয়ার করুন' : 'Clear Cache Now' }}</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
