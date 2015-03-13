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
        $this->publishes([
            __DIR__.'/../../config/captcha.php' => config_path('captcha.php'),
        ]);

        include __DIR__.'/../../routes.php';

        $this->app->validator->resolver(function($translator, $data, $rules, $messages) {
            $messages['captcha'] = "Captcha text doesn't match.";
            return new CaptchaValidator($translator, $data, $rules, $messages);
        });
    }
}