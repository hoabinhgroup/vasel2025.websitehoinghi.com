<?php

namespace Theme\Vasel2025\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoAllUppercase implements Rule
{
    public function passes($attribute, $value)
    {
        return strtolower($value) !== $value && strtoupper($value) !== $value;
    }

    public function message()
    {
        return 'Chủ đề không được viết hoa toàn bộ.';
    }
}