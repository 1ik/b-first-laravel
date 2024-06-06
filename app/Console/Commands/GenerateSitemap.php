<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GenerateStaticSitemap;
use App\Jobs\GenerateDynamicSitemap;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate and update the sitemaps';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Dispatching sitemap generation jobs...');

        GenerateStaticSitemap::dispatch();
        GenerateDynamicSitemap::dispatch();
        

        $this->info('Sitemap generation jobs dispatched successfully.');
    }
}
