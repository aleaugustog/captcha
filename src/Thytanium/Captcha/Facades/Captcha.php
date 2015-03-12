<?php

namespace Thytanium\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

class Captcha extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'captcha';
    }
}