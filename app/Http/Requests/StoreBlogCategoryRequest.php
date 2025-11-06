<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'is_indexed' => 'required|boolean',
            'parent_id' => 'nullable|exists:blog_categories,id',
        ];

        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            if ($locale === $default) {
                $rules["$locale.title"] = 'required|string';
                $rules["$locale.slug"] = 'required|string|unique:service_category_translations,slug';
            } else {
                $rules["$locale.title"] = 'nullable|string';
                $rules["$locale.slug"] = 'nullable|string|unique:service_category_translations,slug';
            }
            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|string';
            $rules["$locale.meta_keywords"] = 'nullable|string';
            $rules["$locale.body"] = 'nullable|string';
            $rules["$locale.url_redirect"] = 'nullable|url';
            $rules["$locale.featured_image"] = 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'; // 👈 NEW
        }


        return $rules;
    }
}
