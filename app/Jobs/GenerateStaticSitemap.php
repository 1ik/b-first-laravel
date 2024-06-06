<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateStaticSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $sitemapContent = $this->generateStaticSitemapContent();
        file_put_contents(public_path('sitemaps/sitemap_static.xml'), $sitemapContent);
    }

    protected function generateStaticSitemapContent()
    {
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

        $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $sitemapContent .= '<url>';
            $sitemapContent .= '<loc>' . $url . '</loc>';
            $sitemapContent .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $sitemapContent .= '<changefreq>never</changefreq>';
            $sitemapContent .= '<priority>0.8</priority>';
            $sitemapContent .= '</url>';
        }

        $sitemapContent .= '</urlset>';

        return $sitemapContent;
    }
}
