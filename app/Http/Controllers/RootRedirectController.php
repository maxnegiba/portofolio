<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class RootRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 1. Check for existing cookie
        $cookieLocale = $request->cookie('user_locale');
        $availableLocales = config('app.available_locales', ['en']);

        if ($cookieLocale && in_array($cookieLocale, $availableLocales)) {
            return redirect($cookieLocale);
        }

        // 2. Detect location from IP
        // Using request->ip() works, but proxies might need consideration.
        // Location::get() usually handles finding the right IP.
        $position = Location::get($request->ip());

        $detectedLocale = 'en'; // Default

        if ($position && $position->countryCode === 'RO') {
            $detectedLocale = 'ro';
        }

        // Ensure detected locale is supported
        if (!in_array($detectedLocale, $availableLocales)) {
            $detectedLocale = 'en';
        }

        // 3. Redirect
        // We do not strictly need to set the cookie here because the destination route
        // uses SetLocale middleware which will set the cookie.
        return redirect($detectedLocale);
    }
}
