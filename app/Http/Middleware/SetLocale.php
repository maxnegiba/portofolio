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
        $locale = null;

        // 1. Check for locale in query string (explicit override)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
        }
        // 2. Check for locale in route parameter (e.g., /ro/about)
        elseif ($request->route('locale')) {
            $locale = $request->route('locale');
        }
        // 3. Check for locale in session
        elseif (session()->has('locale')) {
            $locale = session('locale');
        }
        // 4. Check for locale in cookie
        elseif ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
        }

        // Validate locale against allowed list to prevent injection
        // Allowing vitameza for backward compatibility if needed, though 'vi' is preferred
        $allowedLocales = ['en', 'ro', 'vi', 'vitameza'];
        if (!$locale || !in_array($locale, $allowedLocales)) {
            $locale = 'en';
        }

        // Set the application locale
        app()->setLocale($locale);

        // Persist to session so it sticks if we go to a non-localized route (if any)
        session(['locale' => $locale]);

        return $next($request);
    }
}
