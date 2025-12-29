<?php
namespace App\Http\Middleware;

use Closure;
use App\Services\MatomoTrackerService;

class TrackMatomoPageView
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

          \Log::info('Matomo track', [
    'url' => $request->fullUrl(),
    'ua'  => $request->userAgent(),
    'ip'  => $request->ip(),
]);

        if ($request->isMethod('get') && !$request->ajax()) {
            MatomoTrackerService::track(
                $request->fullUrl(),
                $request->route()?->getName() ?? $request->path()
            );
        }

        return $response;
    }
}
