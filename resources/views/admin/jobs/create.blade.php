@extends('layouts.admin')

@section('page_title', app()->getLocale() === 'bn' ? 'নতুন চাকরি যোগ করুন' : 'Add New Job')

@section('admin-content')
<div class="max-w-3xl">
    <a href="{{ route('admin.jobs.index') }}" class="text-blue-600 text-sm hover:underline mb-4 inline-block">← {{ __('ui.manage_jobs') }}</a>

    <form method="POST" action="{{ route('admin.jobs.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="font-bold text-gray-900 border-b pb-3">{{ app()->getLocale() === 'bn' ? 'বাংলা তথ্য' : 'Bengali Info' }}</h2>

            <div class="form-group">
                <label class="form-label">শিরোনাম (বাংলা) <span class="text-red-500">*</span></label>
                <input type="text" name="title_bn" class="form-input @error('title_bn') border-red-400 @enderror" value="{{ old('title_bn') }}" required>
                @error('title_bn')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">নিয়োগকর্তা (বাংলা)</label>
                <input type="text" name="employer_bn" class="form-input" value="{{ old('employer_bn') }}">
            </div>

            <div class="form-group">
                <label class="form-label">অবস্থান (বাংলা)</label>
                <input type="text" name="location_bn" class="form-input" value="{{ old('location_bn') }}">
            </div>

            <div class="form-group">
                <label class="form-label">যোগ্যতা (বাংলা)</label>
                <textarea name="eligibility_bn" class="form-textarea h-28">{{ old('eligibility_bn') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">বিবরণ (বাংলা)</label>
                <textarea name="description_bn" class="form-textarea h-36">{{ old('description_bn') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="font-bold text-gray-900 border-b pb-3">English Info</h2>

            <div class="form-group">
                <label class="form-label">Title (English)</label>
                <input type="text" name="title_en" class="form-input" value="{{ old('title_en') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">Employer (English)</label>
                    <input type="text" name="employer_en" class="form-input" value="{{ old('employer_en') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Location (English)</label>
                    <input type="text" name="location_en" class="form-input" value="{{ old('location_en') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Eligibility (English)</label>
                <textarea name="eligibility_en" class="form-textarea h-28">{{ old('eligibility_en') }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h2 class="font-bold text-gray-900 border-b pb-3">{{ app()->getLocale() === 'bn' ? 'বিস্তারিত' : 'Details' }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="form-label">{{ __('ui.deadline') }}</label>
                    <input type="date" name="deadline" class="form-input" value="{{ old('deadline') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'চাকরির ধরন' : 'Employment Type' }}</label>
                    <select name="employment_type" class="form-input">
                        <option value="">— {{ app()->getLocale() === 'bn' ? 'নির্বাচন করুন' : 'Select' }} —</option>
                        <option value="full-time"  {{ old('employment_type') === 'full-time'  ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time"  {{ old('employment_type') === 'part-time'  ? 'selected' : '' }}>Part-time</option>
                        <option value="contract"   {{ old('employment_type') === 'contract'   ? 'selected' : '' }}>Contract</option>
                        <option value="internship" {{ old('employment_type') === 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'শিক্ষাগত যোগ্যতা' : 'Education Level' }}</label>
                    <select name="education_level" class="form-input">
                        <option value="">— {{ app()->getLocale() === 'bn' ? 'নির্বাচন করুন' : 'Select' }} —</option>
                        <option value="any"          {{ old('education_level') === 'any'          ? 'selected' : '' }}>{{ app()->getLocale() === 'bn' ? 'যেকোনো' : 'Any' }}</option>
                        <option value="ssc"          {{ old('education_level') === 'ssc'          ? 'selected' : '' }}>SSC</option>
                        <option value="hsc"          {{ old('education_level') === 'hsc'          ? 'selected' : '' }}>HSC</option>
                        <option value="graduate"     {{ old('education_level') === 'graduate'     ? 'selected' : '' }}>{{ app()->getLocale() === 'bn' ? 'স্নাতক' : 'Graduate' }}</option>
                        <option value="postgraduate" {{ old('education_level') === 'postgraduate' ? 'selected' : '' }}>{{ app()->getLocale() === 'bn' ? 'স্নাতকোত্তর' : 'Postgraduate' }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'বিভাগ' : 'Category' }}</label>
                    <select name="category_id" class="form-input">
                        <option value="">— {{ app()->getLocale() === 'bn' ? 'বিভাগ নেই' : 'No category' }} —</option>
                        @foreach(\App\Models\Category::orderBy('order')->get() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->getName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'সূত্র URL' : 'Source URL' }}</label>
                    <input type="url" name="source_url" class="form-input" value="{{ old('source_url') }}" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'আবেদন URL' : 'Application URL' }}</label>
                    <input type="url" name="application_url" class="form-input" value="{{ old('application_url') }}" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'bn' ? 'ছবি' : 'Featured Image' }}</label>
                    <input type="file" name="featured_image" class="form-input" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">SEO Title</label>
                <input type="text" name="seo_title" class="form-input" value="{{ old('seo_title') }}" maxlength="160">
            </div>

            <div class="form-group">
                <label class="form-label">SEO Description</label>
                <textarea name="seo_description" class="form-textarea h-20" maxlength="300">{{ old('seo_description') }}</textarea>
            </div>

            <div class="flex flex-wrap gap-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="w-4 h-4 rounded accent-blue-600" {{ old('is_published') ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">{{ app()->getLocale() === 'bn' ? 'এখনই প্রকাশ করুন' : 'Publish Now' }}</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_verified" value="0">
                    <input type="checkbox" name="is_verified" value="1" class="w-4 h-4 rounded accent-emerald-600" {{ old('is_verified') ? 'checked' : '' }}>
                    <span class="text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-shield-halved text-emerald-500 mr-1"></i>
                        {{ app()->getLocale() === 'bn' ? 'যাচাইকৃত' : 'Verified' }}
                    </span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer bg-blue-50/60 px-3 py-1.5 rounded-xl border border-blue-100">
                    <input type="checkbox" name="send_push" value="1" class="w-4 h-4 rounded accent-blue-600" {{ old('send_push', '1') ? 'checked' : '' }}>
                    <span class="text-sm font-semibold text-blue-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-bell text-blue-600"></i>
                        {{ app()->getLocale() === 'bn' ? 'ইউজারদের ফোনে পুশ নোটিফিকেশন পাঠান' : 'Send Push Notification to Users' }}
                    </span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-floppy-disk mr-2"></i>{{ __('ui.save') }}
            </button>
            <a href="{{ route('admin.jobs.index') }}" class="btn-secondary">{{ __('ui.cancel') }}</a>
        </div>
    </form>
</div>
@endsection

