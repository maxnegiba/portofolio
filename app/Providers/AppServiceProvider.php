<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forțăm HTTPS pentru absolut toate rutele și asset-urile,
        // asigurându-ne că proxy-ul și Laravel comunică pe aceeași schemă criptată.
        if ($this->app->environment('production', 'staging')) {
            URL::forceScheme('https');
        }
    }
}