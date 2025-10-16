<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $categoryId = $this->route('bcategory')->id;

        $rules = [
            'is_indexed' => 'required|boolean',
            'parent_id' => 'nullable|exists:blog_categories,id',
        ];
        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            $translation = $this->route('bcategory')
                ->translations->firstWhere('locale', $locale);
            if ($locale === $default) {
                $rules["$locale.title"] = 'required|string';
                $rules["$locale.slug"] = [
                    'required',
                    'string',
                    Rule::unique('blog_category_translations', 'slug')
                        ->ignore(optional($translation)->id),
                , new LowercaseSlug,];
            } else {
                $rules["$locale.title"] = 'nullable|string';
                $rules["$locale.slug"] = [
                    'nullable',
                    'string',
                    Rule::unique('blog_category_translations', 'slug')
                        ->ignore(optional($translation)->id),
                , new LowercaseSlug,];
            }

            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|string';
            $rules["$locale.meta_keywords"] = 'nullable|string';
            $rules["$locale.body"] = 'nullable|string';
            $rules["$locale.url_redirect"] = 'nullable|url';
            $rules["$locale.featured_image"] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }
}
