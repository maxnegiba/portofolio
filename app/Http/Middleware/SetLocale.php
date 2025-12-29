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
        // Check for locale in query string (?lang=vitameza)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            // Set locale for this request
            app()->setLocale($locale);
            // Store in session for persistence
            session(['locale' => $locale]);
        }
        // Check for locale in session (from previous request)
        elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        // Check for locale in cookie
        elseif ($request->cookie('locale')) {
            app()->setLocale($request->cookie('locale'));
        }
        // Default to English
        else {
            app()->setLocale('en');
        }

        return $next($request);
    }
}
