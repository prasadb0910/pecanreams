<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \URL::forceRootUrl(\Config::get('app.url'));
            
        // // And this if you wanna handle https URL scheme
        // // It's not usefull for http://www.example.com, it's just to make it more independant from the constant value
        // if (str_contains(\Config::get('app.url'), 'https://')) {
        //     \URL::forceScheme('https');
        //     //use \URL:forceSchema('https') if you use laravel < 5.4
        // }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
