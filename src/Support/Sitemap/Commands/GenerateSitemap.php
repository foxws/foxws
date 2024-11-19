<?php

declare(strict_types=1);

namespace Support\Sitemap\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command implements Isolatable
{
    /**
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    public function handle(): void
    {
        SitemapGenerator::create(config('app.url'))
            ->writeToFile(public_path('sitemap.xml'));
    }
}
