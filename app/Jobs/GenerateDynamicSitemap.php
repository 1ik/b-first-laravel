<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use App\Models\Story;
use Illuminate\Support\Facades\File;

class GenerateDynamicSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $sitemapFolder = public_path('sitemaps');
        if (!File::exists($sitemapFolder)) {
            File::makeDirectory($sitemapFolder, 0755, true);
        }

        $sitemapIndex = SitemapIndex::create();
        $chunkSize = 100;
        $index = 1;
        $baseUrl = 'https://bfirst.news/public';

        Story::whereNull('deleted_at')->orderBy('id')->chunk($chunkSize, function ($stories) use ($sitemapFolder, $sitemapIndex, &$index, $baseUrl) {
            $sitemap = Sitemap::create()
                ->add(Url::create('https://bfirst.news/')
                    ->setPriority(1.0)
                    ->setChangeFrequency('daily')
                    ->setLastModificationDate(now()));

            foreach ($stories as $story) {
                $sitemap->add(
                    Url::create($this->getNewsUrl($story))
                        ->setLastModificationDate($story->updated_at)
                        ->setChangeFrequency('daily')
                        ->setPriority(1.0)
                );
            }

            $sitemapFileName = "sitemap_news_{$index}.xml";
            $sitemap->writeToFile("{$sitemapFolder}/{$sitemapFileName}");
            $sitemapIndex->add("{$baseUrl}/sitemaps/{$sitemapFileName}");
            $index++;
        });

        $sitemapIndex->add("{$baseUrl}/sitemaps/sitemap_static.xml");

        $sitemapIndex->writeToFile("{$sitemapFolder}/sitemap.xml");
    }

    protected function getNewsUrl($news)
    {
        $baseUrl = "https://bfirst.news/news";
        $id = $news->id ?? '';
        $title = $news->title ?? '';
        $formattedTitle = strtolower(preg_replace('/[^\w\s-]/', '', str_replace(' ', '-', $title)));
        return "{$baseUrl}/{$id}/{$formattedTitle}";
    }
}

