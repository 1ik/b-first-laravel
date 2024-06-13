<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class GenerateStaticSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $staticSitemapPath = public_path('sitemaps/sitemap_static.xml');

        // Check if the static sitemap already exists
        if (File::exists($staticSitemapPath)) {
            Log::info('Static sitemap already exists, skipping generation.');
            return;
        }

        Log::info('Generating static sitemap.');

        $urls = [
            'https://bfirst.news/',
            'https://bfirst.news/bangladesh',
            'https://bfirst.news/world',
            'https://bfirst.news/economy',
            'https://bfirst.news/feature',
            'https://bfirst.news/sports',
            'https://bfirst.news/tech',
            'https://bfirst.news/entertainment',
            'https://bfirst.news/education',
            'https://bfirst.news/interview',
            'https://bfirst.news/corporates',
            'https://bfirst.news/politics',
            'https://bfirst.news/latest',
            'https://bfirst.news/terms',
            'https://bfirst.news/privacy-policy',
            'https://bfirst.news/comments-policy',
            'https://bfirst.news/cookie-settings',
            'https://bfirst.news/accessibility',
            'https://bfirst.news/about-us',
            'https://bfirst.news/contact-us'
        ];

        $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($urls as $url) {
            $sitemapContent .= '    <url>' . PHP_EOL;
            $sitemapContent .= '        <loc>' . $url . '</loc>' . PHP_EOL;
            $sitemapContent .= '        <lastmod>' . now()->toAtomString() . '</lastmod>' . PHP_EOL;
            $sitemapContent .= '        <changefreq>never</changefreq>' . PHP_EOL;
            $sitemapContent .= '        <priority>0.8</priority>' . PHP_EOL;
            $sitemapContent .= '    </url>' . PHP_EOL;
        }

        $sitemapContent .= '</urlset>' . PHP_EOL;

        File::put($staticSitemapPath, $sitemapContent);

        Log::info('Static sitemap generated successfully.');
    }
}
