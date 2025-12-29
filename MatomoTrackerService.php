<?php
namespace App\Services;

use MatomoTracker;

class MatomoTrackerService
{
    public static function track(string $url, string $title, array $extra = [])
    {
        $tracker = new MatomoTracker(
            (int) config('app.matomo_site_id'),
            config('app.matomo_url')
        );
        $tracker->setTokenAuth(config('app.matomo_token'));
        $tracker->setUrl($url);
        $tracker->setUserAgent(request()->userAgent());
        $tracker->setIp($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');

        if (empty($extra)) {
            return $tracker->doTrackPageView($title);
        }

        if ($extra['type'] === 'event') {
            return $tracker->doTrackEvent(
                $extra['category'],
                $extra['action'],
                $extra['label'] ?? null,
                $extra['value'] ?? null
            );
        }
    }
}
