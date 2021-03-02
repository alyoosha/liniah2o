<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Url implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/[a-z0-9-]/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' ';
//        return 'Значение поля "Url" может содержать латиницу в нижнем регистре, цифры и знак "-"';
    }
}
