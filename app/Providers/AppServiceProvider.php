<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class AppServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

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
        // Laravel Localization needs locale-aware cached route files.
        // Without this loader, a normal route cache can make non-default
        // locale URLs such as /ro/... return 404.
        RouteServiceProvider::loadCachedRoutesUsing(fn () => $this->loadCachedRoutes());

        // Forțăm HTTPS pentru absolut toate rutele și asset-urile,
        // asigurându-ne că proxy-ul și Laravel comunică pe aceeași schemă criptată.
        if ($this->app->environment('production', 'staging')) {
            URL::forceScheme('https');
        }
    }
}
