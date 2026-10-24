<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isEditor() ?? false;
    }

    public function rules(): array
    {
        return [
            'title_bn' => 'required|string|max:300',
            'title_en' => 'nullable|string|max:300',
            'employer_bn' => 'nullable|string|max:200',
            'employer_en' => 'nullable|string|max:200',
            'location_bn' => 'nullable|string|max:200',
            'location_en' => 'nullable|string|max:200',
            'eligibility_bn' => 'nullable|string|max:2000',
            'eligibility_en' => 'nullable|string|max:2000',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'deadline' => 'nullable|date',
            'source_url' => 'nullable|url|max:2048',
            'application_url' => 'nullable|url|max:2048',
            'employment_type' => 'nullable|in:full-time,part-time,contract,internship',
            'education_level' => 'nullable|in:any,ssc,hsc,graduate,postgraduate',
            'category_id' => 'nullable|integer|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'is_published' => 'boolean',
            'is_verified' => 'boolean',
            'is_outdated' => 'boolean',
            'seo_title' => 'nullable|string|max:160',
            'seo_description' => 'nullable|string|max:300',
        ];
    }
}
