<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'is_indexed' => 'required|boolean',
            'status' => 'required|boolean',
            'parent_category_id' => 'nullable|integer|exists:blog_categories,id',
            'sub_category_id' => 'nullable|integer|exists:blog_categories,id',
        ];

        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            if ($locale === $default) {
                $rules["$locale.title"] = 'required|string';
                $rules["$locale.slug"] = ['required', 'string', 'unique:blog_translations,slug', new LowercaseSlug];
            } else {
                $rules["$locale.title"] = 'nullable|string';
                $rules["$locale.slug"] = ['nullable', 'string', 'unique:blog_translations,slug', new LowercaseSlug];
            }

            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|string';
            $rules["$locale.meta_keywords"] = 'nullable|string';
            $rules["$locale.page_tags"] = 'nullable|string';
            $rules["$locale.body"] = 'nullable|string';
            $rules["$locale.url_redirect"] = 'nullable|string';
            $rules["$locale.featured_image"] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        return $rules;
    }
}
