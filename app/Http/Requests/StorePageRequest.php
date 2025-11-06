<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'status' => 'required|boolean',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            if ($locale === $default) {
                $rules["$locale.title"] = 'required|string';
                $rules["$locale.slug"] = ['required', 'string', 'unique:page_translations,slug', new LowercaseSlug];
            } else {
                $rules["$locale.title"] = 'nullable|string';
                $rules["$locale.slug"] = ['nullable', 'string', 'unique:page_translations,slug', new LowercaseSlug];
            }

            $rules["$locale.content"] = 'nullable|string';
            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|string';
            $rules["$locale.keywords"] = 'nullable|string';
            $rules["$locale.redirect_url"] = 'nullable|string';
        }


        return $rules;
    }
}

