<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;

class LanguageDetectionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure available locales are set
        Config::set('app.available_locales', ['en', 'ro']);
    }

    public function test_redirects_to_cookie_locale_if_present()
    {
        $response = $this->withCookie('user_locale', 'ro')->get('/');

        $response->assertRedirect('/ro');
    }

    public function test_detects_romania_from_ip_and_redirects_to_ro()
    {
        // Mock Location
        $position = new Position();
        $position->countryCode = 'RO';

        Location::shouldReceive('get')
            ->once()
            ->andReturn($position);

        $response = $this->get('/');

        $response->assertRedirect('/ro');
    }

    public function test_detects_us_from_ip_and_redirects_to_en()
    {
        // Mock Location
        $position = new Position();
        $position->countryCode = 'US';

        Location::shouldReceive('get')
            ->once()
            ->andReturn($position);

        $response = $this->get('/');

        $response->assertRedirect('/en');
    }

    public function test_defaults_to_en_if_location_fails()
    {
        // Mock Location returning false/null
        Location::shouldReceive('get')
            ->once()
            ->andReturn(false);

        $response = $this->get('/');

        $response->assertRedirect('/en');
    }

    public function test_visiting_locale_sets_cookie()
    {
        $response = $this->get('/ro');

        $response->assertCookie('user_locale', 'ro');

        $response = $this->get('/en');

        $response->assertCookie('user_locale', 'en');
    }
}
