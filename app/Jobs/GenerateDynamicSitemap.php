<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Story;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class GenerateDynamicSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        try {
            Log::info('Generating dynamic sitemap.');

            $chunkSize = 2000;
            $baseUrl = 'https://bfirst.news';
            $sitemapsPath = 'public/sitemaps';
            $sitemaps = [];

            // Ensure the sitemaps directory exists
            if (!File::exists($sitemapsPath)) {
                File::makeDirectory($sitemapsPath, 0777, true, true);
                Log::info("Created directory: {$sitemapsPath}");
            }

            // Fetch all stories ordered by ID ascending
            $stories = Story::whereNull('deleted_at')->orderBy('id')->get();
            $totalStories = $stories->count();

            $currentSitemapIndex = 1; // Start with the first sitemap file
            $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($stories as $index => $story) {
                $url = $this->getNewsUrl($story);
                $lastmod = $story->updated_at->toAtomString();
                $sitemapContent .= "
    <url>
        <loc>{$url}</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>";

                // Check if the chunk size is reached or it's the last story
                if (($index + 1) % $chunkSize === 0 || $index === $totalStories - 1) {
                    $currentSitemapFile = 'sitemap_news_' . $currentSitemapIndex . '.xml';
                    File::put("{$sitemapsPath}/{$currentSitemapFile}", $sitemapContent . "\n</urlset>");
                    $sitemaps[] = "{$sitemapsPath}/{$currentSitemapFile}"; // Ensuring the path includes 'public'

                    // Reset sitemap content for the next chunk
                    $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                    $currentSitemapIndex++;
                }
            }

            // Update the sitemap index
            $this->updateSitemapIndex($sitemaps, $baseUrl, $sitemapsPath);

            Log::info('Sitemap generation completed.');
        } catch (\Exception $e) {
            Log::error('Error generating sitemap: ' . $e->getMessage());
        }
    }

    protected function getNewsUrl($news)
    {
        $baseUrl = 'https://bfirst.news';
        $id = $news->id ?? '';
        $title = $news->title ?? '';
        $formattedTitle = strtolower(preg_replace('/[^\w\s-]/', '', str_replace(' ', '-', $title)));
        return "{$baseUrl}/news/{$id}/{$formattedTitle}";
    }

    protected function updateSitemapIndex($sitemaps, $baseUrl, $sitemapsPath)
    {
        // Read existing sitemap index
        $existingSitemapIndex = '';
        $sitemapIndexFile = "{$sitemapsPath}/sitemap.xml";
        if (file_exists($sitemapIndexFile)) {
            $existingSitemapIndex = file_get_contents($sitemapIndexFile);
        }

        // Start building new sitemap index
        $sitemapIndexContent = '<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add static sitemap to the index if it exists and is not listed
        $staticSitemap = 'sitemap_static.xml';
        if (file_exists("{$sitemapsPath}/{$staticSitemap}")) {
            $sitemapIndexContent .= "
    <sitemap>
        <loc>{$baseUrl}/{$sitemapsPath}/{$staticSitemap}</loc>
        <lastmod>" . date('c', filemtime("{$sitemapsPath}/{$staticSitemap}")) . "</lastmod>
    </sitemap>";
        }

        // Add google news sitemap
        $googleNewsSitemap = 'sitemap_google_news.xml';
        if (file_exists("{$sitemapsPath}/{$googleNewsSitemap}")) {
            $sitemapIndexContent .= "
    <sitemap>
        <loc>{$baseUrl}/{$sitemapsPath}/{$googleNewsSitemap}</loc>
        <lastmod>" . date('c', filemtime("{$sitemapsPath}/{$googleNewsSitemap}")) . "</lastmod>
    </sitemap>";
        }

        foreach ($sitemaps as $sitemap) {
            // Add the dynamic sitemaps
            $sitemapIndexContent .= "
    <sitemap>
        <loc>{$baseUrl}/{$sitemap}</loc>
        <lastmod>" . date('c', filemtime($sitemap)) . "</lastmod>
    </sitemap>";
        }

        $sitemapIndexContent .= '
</sitemapindex>';

        // Write the updated sitemap index to the file
        File::put($sitemapIndexFile, $sitemapIndexContent);
    }
}
