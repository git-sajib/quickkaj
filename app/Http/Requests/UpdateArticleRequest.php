<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isEditor() ?? false;
    }

    public function rules(): array
    {
        return [
            'title_bn' => 'required|string|max:400',
            'title_en' => 'nullable|string|max:400',
            'excerpt_bn' => 'nullable|string|max:600',
            'excerpt_en' => 'nullable|string|max:600',
            'body_bn' => 'nullable|string',
            'body_en' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,webp',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'seo_title' => 'nullable|string|max:160',
            'seo_description' => 'nullable|string|max:300',
        ];
    }
}
