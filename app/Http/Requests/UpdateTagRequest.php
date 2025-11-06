<?php

namespace App\Http\Requests;

use App\Rules\LowercaseSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
        ];

        $tag = $this->route('tag');

        $locales = ['en', 'ar'];
        $default = 'en';

        foreach ($locales as $locale) {
            if ($locale === $default) {
                $rules["$locale.name"] = 'required|string';
                $rules["$locale.slug"] = [
                    'required',
                    'string',
                    Rule::unique('tag_translations', 'slug')->ignore($tag?->id),
                , new LowercaseSlug,];            } else {
                $rules["$locale.name"] = 'nullable|string';
                $rules["$locale.slug"] = [
                    'nullable',
                    'string',
                    Rule::unique('tag_translations', 'slug')->ignore($tag?->id),
                , new LowercaseSlug,];            }
            $trans = $tag->translations->firstWhere('locale', $locale);
            $rules["$locale.meta_title"] = 'nullable|string';
            $rules["$locale.meta_desc"] = 'nullable|string';
            $rules["$locale.canonical"] = 'nullable|url';
            $rules["$locale.url_redirect"] = 'nullable|url';
        }

        return $rules;
    }
}
