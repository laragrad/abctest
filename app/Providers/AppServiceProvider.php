<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Exception;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('config_has_key', function ($attribute, $value, $parameters, $validator) {
            if (empty($parameters[0])) {
                throw new Exception('Parameter required for config_has_key rule!');
            }

            return isset(config($parameters[0])[$value]);
        });

        Validator::extend('config_in_array', function ($attribute, $value, $parameters, $validator) {
            if (empty($parameters[0])) {
                throw new Exception('Parameter required for config_in_array rule!');
            }

            return in_array($value, config($parameters[0]));
        });
    }
}
