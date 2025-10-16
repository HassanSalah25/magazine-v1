<?php

namespace App\Traits;

use App\Rules\LowercaseSlug;
use Illuminate\Validation\Rule;

trait ValidatesSlug
{
    /**
     * Get validation rules for slug field
     *
     * @param string $table The table name for unique validation
     * @param string $column The column name (usually 'slug')
     * @param mixed $ignoreId The ID to ignore for unique validation (for updates)
     * @param bool $required Whether the slug is required
     * @return array
     */
    protected function getSlugValidationRules(string $table, string $column = 'slug', $ignoreId = null, bool $required = true): array
    {
        $rules = [
            $required ? 'required' : 'nullable',
            'string',
            new LowercaseSlug,
        ];

        // Add unique constraint
        if ($ignoreId) {
            $rules[] = Rule::unique($table, $column)->ignore($ignoreId);
        } else {
            $rules[] = "unique:{$table},{$column}";
        }

        return $rules;
    }

    /**
     * Automatically convert slug to lowercase before saving
     *
     * @param string $value
     * @return string
     */
    protected function normalizeSlug(string $value): string
    {
        return strtolower($value);
    }
}
