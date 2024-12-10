<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Luhn implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->validLuhn($value);
    }

    public function validLuhn($number)
    {
        settype($number, 'string');
        $sumTable = [
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            [0, 2, 4, 6, 8, 1, 3, 5, 7, 9]];
        $sum = 0;
        $flip = 0;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$number[$i]];
        }

        return $sum % 10 === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Last digit is incorrect.';
    }
}
