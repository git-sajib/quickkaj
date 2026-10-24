@extends('layouts.admin')

@section('page_title', app()->getLocale() === 'bn' ? 'নতুন নিবন্ধ' : 'New Article')

@section('admin-content')
<div class="max-w-3xl">
    <a href="{{ route('admin.articles.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_articles') }}</a>

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="font-bold text-gray-900 border-b pb-3">বাংলা তথ্য</h2>
            <div class="form-group">
                <label class="form-label">শিরোনাম (বাংলা) <span class="text-red-500">*</span></label>
                <input type="text" name="title_bn" class="form-input @error('title_bn') border-red-400 @enderror" value="{{ old('title_bn') }}" required>
                @error('title_bn')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">সারসংক্ষেপ (বাংলা)</label>
                <textarea name="excerpt_bn" class="form-textarea h-20" maxlength="600">{{ old('excerpt_bn') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">বিষয়বস্তু (বাংলা)</label>
                <textarea name="body_bn" class="form-textarea h-48" id="body-bn-input">{{ old('body_bn') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="font-bold text-gray-900 border-b pb-3">English Content</h2>
            <div class="form-group">
                <label class="form-label">Title (English)</label>
                <input type="text" name="title_en" class="form-input" value="{{ old('title_en') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Excerpt (English)</label>
                <textarea name="excerpt_en" class="form-textarea h-20" maxlength="600">{{ old('excerpt_en') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Body (English)</label>
                <textarea name="body_en" class="form-textarea h-40">{{ old('body_en') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            <h2 class="font-bold text-gray-900 border-b pb-3">{{ app()->getLocale() === 'bn' ? 'মেটাডেটা' : 'Metadata' }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">{{ __('ui.category') }}</label>
                    <select name="category_id" class="form-select">
                        <option value="">— {{ app()->getLocale() === 'bn' ? 'বিভাগ নির্বাচন করুন' : 'Select Category' }} —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->getName() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ছবি' : 'Featured Image' }}</label>
                    <input type="file" name="featured_image" class="form-input" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('ui.tags') }}</label>
                <div class="flex flex-wrap gap-2 bg-gray-50 rounded-xl p-3 border border-gray-200">
                    @foreach($tags as $tag)
                        <label class="flex items-center gap-1.5 text-sm cursor-pointer">
                            <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" class="accent-blue-600"
                                   {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                            {{ $tag->getName() }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">SEO Title</label>
                <input type="text" name="seo_title" class="form-input" value="{{ old('seo_title') }}" maxlength="160">
            </div>
            <div class="form-group">
                <label class="form-label">SEO Description</label>
                <textarea name="seo_description" class="form-textarea h-16" maxlength="300">{{ old('seo_description') }}</textarea>
            </div>

            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="accent-blue-600 w-4 h-4 rounded" {{ old('is_published') ? 'checked' : '' }}>
                    <span class="text-sm font-medium">{{ app()->getLocale() === 'bn' ? 'প্রকাশ করুন' : 'Publish' }}</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" class="accent-blue-600 w-4 h-4 rounded" {{ old('is_featured') ? 'checked' : '' }}>
                    <span class="text-sm font-medium"><i class="fa-solid fa-star text-amber-500 mr-1"></i>{{ app()->getLocale() === 'bn' ? 'বিশেষ' : 'Featured' }}</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk mr-1.5"></i>{{ __('ui.save') }}</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
