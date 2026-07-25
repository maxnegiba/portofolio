<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Psr\Http\Message\UriInterface;

class GenerateSitemap extends Command
{
    /**
     * Numele comenzii pe care o vei scrie in terminal.
     */
    protected $signature = 'sitemap:generate';

    /**
     * Descrierea comenzii.
     */
    protected $description = 'Genereaza sitemap-ul automat pentru site (indexeaza public-facing B2B pages).';

    /**
     * Executia propriu-zisa.
     */
    public function handle()
    {
        $this->info('Incep generarea sitemap-ului...');

        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(function (UriInterface $url) {
                $path = $url->getPath();

                // Exclude specific paths
                $excludedPaths = [
                    '/admin',
                    '/filament',
                    '/login',
                    '/register',
                    '/password',
                    '/api'
                ];

                foreach ($excludedPaths as $excluded) {
                    // Match either exact string or starts with + slash (e.g. /admin or /admin/...)
                    if (str_starts_with($path, $excluded)) {
                        return null; // Exclude from sitemap
                    }
                }

                return $url;
            })
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap-ul a fost generat cu succes in folderul public!');
    }
}
