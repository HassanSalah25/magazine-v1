<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
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
        $pageId = $this->route('page')->id;

        $rules = [
            'status' => 'required|boolean',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'section_ids' => 'nullable|array',
            'section_ids.*' => 'exists:sections,id',
        ];

        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            if ($locale === $default) {
                $rules["$locale.title"] = 'required|string';
                $rules["$locale.slug"] = [
                    'required',
                    'string',
                    Rule::unique('page_translations', 'slug')->ignore($pageId, 'page_id')->where('locale', $locale)
                , new LowercaseSlug,];
            } else {
                $rules["$locale.title"] = 'nullable|string';
                $rules["$locale.slug"] = [
                    'nullable',
                    'string',
                    Rule::unique('page_translations', 'slug')->ignore($pageId, 'page_id')->where('locale', $locale)
                , new LowercaseSlug,];
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
