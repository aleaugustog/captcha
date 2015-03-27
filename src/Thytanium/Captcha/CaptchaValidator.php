<?php

namespace Thytanium\Captcha;

use Illuminate\Validation\Validator;
use Captcha;

class CaptchaValidator extends Validator
{
    /**
     * Captcha validation
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateCaptcha($attribute, $value, $parameters)
    {
        return Captcha::check($value);
    }
}
