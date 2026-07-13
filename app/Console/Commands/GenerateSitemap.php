<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * Numele comenzii pe care o vei scrie in terminal.
     */
    protected $signature = 'sitemap:generate';

    /**
     * Descrierea comenzii.
     */
    protected $description = 'Genereaza sitemap-ul automat pentru site.';

    /**
     * Executia propriu-zisa.
     */
    public function handle()
    {
        $this->info('Incep generarea sitemap-ului...');

        // Inlocuieste cu URL-ul tau exact
        SitemapGenerator::create('https://negibamaxim.eu')
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap-ul a fost generat cu succes in folderul public!');
    }
}
