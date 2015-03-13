<?php

Route::get('captcha', function() {
    Captcha::create(Input::has('id')?Input::get('id'):null);
});