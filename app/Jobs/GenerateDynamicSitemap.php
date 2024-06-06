<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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

        $sitemapIndexContent = $this->generateSitemapIndexContent($sitemapFolder);

        file_put_contents("{$sitemapFolder}/sitemap.xml", $sitemapIndexContent);
    }

    protected function generateSitemapIndexContent($sitemapFolder)
    {
        $chunkSize = 100;
        $index = 1;
        $baseUrl = 'https://bfirst.news/public';
        $sitemapIndexContent = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemapIndexContent .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        Story::whereNull('deleted_at')->orderBy('id', 'desc')->chunk($chunkSize, function ($stories) use ($sitemapFolder, &$index, $baseUrl, &$sitemapIndexContent) {
            $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($stories as $story) {
                $url = $this->getNewsUrl($story);
                $sitemapContent .= '<url>';
                $sitemapContent .= '<loc>' . $url . '</loc>';
                $sitemapContent .= '<lastmod>' . $story->updated_at->toAtomString() . '</lastmod>';
                $sitemapContent .= '<changefreq>daily</changefreq>';
                $sitemapContent .= '<priority>1.0</priority>';
                $sitemapContent .= '</url>';
            }

            $sitemapContent .= '</urlset>';

            $sitemapFileName = "sitemap_news_{$index}.xml";
            file_put_contents("{$sitemapFolder}/{$sitemapFileName}", $sitemapContent);

            $sitemapIndexContent .= '<sitemap>';
            $sitemapIndexContent .= '<loc>' . "{$baseUrl}/sitemaps/{$sitemapFileName}" . '</loc>';
            $sitemapIndexContent .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $sitemapIndexContent .= '</sitemap>';

            $index++;
        });

        $sitemapIndexContent .= '<sitemap>';
        $sitemapIndexContent .= '<loc>' . "{$baseUrl}/sitemaps/sitemap_static.xml" . '</loc>';
        $sitemapIndexContent .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $sitemapIndexContent .= '</sitemap>';

        $sitemapIndexContent .= '</sitemapindex>';

        return $sitemapIndexContent;
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

