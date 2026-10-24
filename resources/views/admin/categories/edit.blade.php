@extends('layouts.admin')

@section('page_title', __('ui.edit') . ': ' . $category->name_bn)

@section('admin-content')
<div class="max-w-2xl">
    <a href="{{ route('admin.categories.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_categories') }}</a>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label">নাম (বাংলা) <span class="text-red-500">*</span></label>
                <input type="text" name="name_bn" class="form-input" value="{{ old('name_bn', $category->name_bn) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Name (English)</label>
                <input type="text" name="name_en" class="form-input" value="{{ old('name_en', $category->name_en) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">{{ app()->getLocale() === 'bn' ? 'অভিভাবক বিভাগ' : 'Parent Category' }}</label>
            <select name="parent_id" class="form-select">
                <option value="">— None —</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name_bn }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label">{{ app()->getLocale() === 'bn' ? 'আইকন' : 'Icon' }}</label>
                <input type="text" name="icon" class="form-input" value="{{ old('icon', $category->icon) }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ক্রম' : 'Order' }}</label>
                <input type="number" name="order" class="form-input" value="{{ old('order', $category->order ?? 0) }}" min="0">
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
