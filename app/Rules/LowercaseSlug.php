<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LowercaseSlug implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return; // Allow empty values, let other rules handle required validation
        }

        if (!is_string($value)) {
            $fail('The :attribute must be a string.');
            return;
        }

        // Check if the value contains any uppercase letters
        if (preg_match('/[A-Z]/', $value)) {
            $fail('The :attribute must be lowercase. Uppercase letters are not allowed.');
        }
    }
}
