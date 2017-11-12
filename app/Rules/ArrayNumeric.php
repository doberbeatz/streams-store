<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayNumeric implements Rule
{
    /** @inheritdoc */
    public function passes($attribute, $value)
    {
        return is_array($value) || is_numeric($value);
    }

    /** @inheritdoc */
    public function message()
    {
        return 'The :attribute must be array or numeric.';
    }
}
