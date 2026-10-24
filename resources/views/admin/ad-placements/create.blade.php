@extends('layouts.admin')

@section('page_title', app()->getLocale() === 'bn' ? 'বিজ্ঞাপন স্লট তৈরি' : 'Create Ad Slot')

@section('admin-content')
<div class="max-w-2xl">
    <a href="{{ route('admin.ad-placements.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_ads') }}</a>

    <form method="POST" action="{{ route('admin.ad-placements.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'স্লট' : 'Ad Slot' }}</label>
            <select name="slot_key" class="form-select @error('slot_key') border-red-400 @enderror">
                <option value="">— {{ app()->getLocale() === 'bn' ? 'স্লট নির্বাচন করুন' : 'Select Slot' }} —</option>
                @foreach($remainingSlots as $key => $label)
                    <option value="{{ $key }}" {{ old('slot_key') === $key ? 'selected' : '' }}>{{ $label }} ({{ $key }})</option>
                @endforeach
            </select>
            @error('slot_key')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'লেবেল' : 'Label' }}</label>
            <input type="text" name="label" class="form-input" value="{{ old('label') }}" placeholder="e.g., Header Banner 728x90">
            @error('label')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                {{ app()->getLocale() === 'bn' ? 'Adsterra বা বিজ্ঞাপনের HTML কোড' : 'Ad HTML Code (Adsterra script/code)' }}
            </label>
            <p class="text-xs text-gray-400 mb-2">
                {{ app()->getLocale() === 'bn' ? 'Adsterra থেকে পাওয়া স্ক্রিপ্ট কোড সরাসরি এখানে পেস্ট করুন।' : 'Paste the ad script code from Adsterra directly here.' }}
            </p>
            <textarea name="html_code" class="form-textarea h-48 font-mono text-xs" spellcheck="false"
                      placeholder="<script type='text/javascript'>...</script>">{{ old('html_code') }}</textarea>
            @error('html_code')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" class="accent-blue-600 w-4 h-4 rounded" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
            <span class="text-sm font-medium">{{ __('ui.active') }}</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.ad-placements.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
