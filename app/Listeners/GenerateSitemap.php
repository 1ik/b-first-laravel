<?php

namespace App\Listeners;

use App\Events\StorySitemapGenerateEvent;
use App\Jobs\GenerateDynamicSitemap;
use App\Jobs\GenerateStaticSitemap;
use App\Jobs\GenerateGoogleNewsSitemap;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GenerateSitemap implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(StorySitemapGenerateEvent $event)
    {
        GenerateStaticSitemap::dispatch();
        GenerateGoogleNewsSitemap::dispatch();
        GenerateDynamicSitemap::dispatch();
    }
}
