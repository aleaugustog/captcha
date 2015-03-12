<?php

Route::get('captcha', function() {
    Captcha::create();
});