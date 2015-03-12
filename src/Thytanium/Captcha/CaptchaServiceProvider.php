<?php

namespace Thytanium\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function($app) {
            return new Captcha($app['config'], $app['session']);
        });
    }

    /**
     * Boot the servide provider
     */
    public function boot()
    {
        $this->package('thytanium/captcha');

        include __DIR__.'/../../routes.php';
    }
}