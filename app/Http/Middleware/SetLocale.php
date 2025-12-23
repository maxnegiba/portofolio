<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obține locale-ul din parametrul rutei
        $locale = $request->route('locale');

        // Verifică dacă locale-ul este valid (existent în config)
        if ($locale && in_array($locale, config('app.available_locales', ['en']))) {
            // Setează limba aplicației
            app()->setLocale($locale);

            // Stochează locale-ul în cookie pentru 1 an (365 zile * 24 ore * 60 minute)
            return $next($request)->withCookie(cookie('user_locale', $locale, 60 * 24 * 365));
        }
        // Dacă nu e valid sau nu e prezent, Laravel va folosi limba implicită din config/app.php

        return $next($request);
    }
}