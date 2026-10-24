@extends('layouts.admin')

@section('page_title', app()->getLocale() === 'bn' ? 'বিজ্ঞাপন আপডেট' : 'Edit Ad Slot')

@section('admin-content')
<div class="max-w-2xl">
    <a href="{{ route('admin.ad-placements.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_ads') }}</a>

    <form method="POST" action="{{ route('admin.ad-placements.update', $adPlacement) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="bg-gray-50 rounded-xl px-4 py-2.5 text-sm text-gray-600">
            <span class="font-semibold">Slot:</span> <span class="font-mono text-blue-700">{{ $adPlacement->slot_key }}</span>
        </div>

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'লেবেল' : 'Label' }}</label>
            <input type="text" name="label" class="form-input" value="{{ old('label', $adPlacement->label) }}">
        </div>

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'HTML কোড' : 'Ad HTML Code' }}</label>
            <textarea name="html_code" class="form-textarea h-48 font-mono text-xs" spellcheck="false">{{ old('html_code', $adPlacement->html_code) }}</textarea>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="accent-blue-600 w-4 h-4 rounded"
                   {{ old('is_active', $adPlacement->is_active) ? 'checked' : '' }}>
            <span class="text-sm font-medium">{{ __('ui.active') }}</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.ad-placements.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
