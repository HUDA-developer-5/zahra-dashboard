<?php

namespace App\Rules;

use App\Helpers\GoogleRecaptchaHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateGoogleRecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!(new GoogleRecaptchaHelper())->validateGoogleCaptcha($value)) {
            $fail(trans('api_v1.signup.google captcha validation failed'));
        }
    }
}
