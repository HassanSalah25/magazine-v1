<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
            // Get current translation ID from route or request if available
            $translation = $this->route('blog')?->translations->firstWhere('locale', $locale);
            $translationId = $translation?->id;

            // Title
            $rules["$locale.title"] = ($locale === $default) ? 'required|string' : 'nullable|string';

            // Slug - unique, but ignore current record if updating
            $rules["$locale.slug"] = [
                $locale === $default ? 'required' : 'nullable',
                'string',
                Rule::unique('blog_translations', 'slug')->ignore($translationId),
                new LowercaseSlug,
            ];

            // Optional SEO fields
            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|string';
            $rules["$locale.meta_keywords"] = 'nullable|string';
            $rules["$locale.page_tags"] = 'nullable|string';
            $rules["$locale.body"] = 'nullable|string';
            $rules["$locale.url_redirect"] = 'nullable|string';

            // Image - only validate if uploading a new one
            $rules["$locale.featured_image"] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        return $rules;
    }
}
