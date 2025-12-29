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
        // Optimization: Skip locale logic for static assets if they somehow hit this middleware
        if ($request->is('css/*', 'js/*', 'images/*', 'fonts/*', 'storage/*')) {
            return $next($request);
        }

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

        // STANDARDIZATION: Map legacy 'vitameza' to standard 'vi'
        // This ensures that even if the URL is /vitameza/, the app uses 'vi' internally
        // which matches the database keys we are now enforcing.
        if ($locale === 'vitameza') {
            $locale = 'vi';
        }

        // Set the application locale
        app()->setLocale($locale);

        // Persist to session so it sticks if we go to a non-localized route (if any)
        // Optimization: Only write to session if the locale actually changed to avoid unnecessary I/O
        if (session('locale') !== $locale) {
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
