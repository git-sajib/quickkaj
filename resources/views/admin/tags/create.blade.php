@extends('layouts.admin')

@section('page_title', app()->getLocale() === 'bn' ? 'নতুন ট্যাগ' : 'New Tag')

@section('admin-content')
<div class="max-w-lg">
    <a href="{{ route('admin.tags.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_tags') }}</a>

    <form method="POST" action="{{ route('admin.tags.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label">নাম (বাংলা) <span class="text-red-500">*</span></label>
                <input type="text" name="name_bn" class="form-input @error('name_bn') border-red-400 @enderror" value="{{ old('name_bn') }}" required>
                @error('name_bn')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Name (English)</label>
                <input type="text" name="name_en" class="form-input" value="{{ old('name_en') }}">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.tags.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
