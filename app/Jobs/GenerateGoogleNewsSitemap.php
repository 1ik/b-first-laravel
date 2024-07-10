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

class GenerateGoogleNewsSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        try {
            Log::info('Generating Google News sitemap.');

            $baseUrl = 'https://bfirst.news';
            $sitemapsPath = 'public/sitemaps';
            $sitemapFile = 'sitemap_google_news.xml';

            // Ensure the sitemaps directory exists
            if (!File::exists($sitemapsPath)) {
                File::makeDirectory($sitemapsPath, 0777, true, true);
                Log::info("Created directory: {$sitemapsPath}");
            }

            // Fetch stories from the last 48 hours
            $stories = Story::whereNull('deleted_at')
                ->where('created_at', '>=', Carbon::now()->subHours(48))
                ->orderBy('created_at', 'desc')
                ->get();

            $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';

            foreach ($stories as $story) {
                $url = $this->getNewsUrl($story);
                $publicationDate = $story->created_at->toAtomString();
                $sitemapContent .= "
    <url>
        <loc>{$url}</loc>
        <news:news>
            <news:publication>
                <news:name>Bangladesh First</news:name>
                <news:language>en</news:language>
            </news:publication>
            <news:title>{$story->title}</news:title>
            <news:publication_date>{$publicationDate}</news:publication_date>
            <news:geo_locations>Dhaka, Bangladesh</news:geo_locations>
        </news:news>
    </url>";
            }

            $sitemapContent .= "\n</urlset>";

            // Write the Google News sitemap to the file
            File::put("{$sitemapsPath}/{$sitemapFile}", $sitemapContent);

            Log::info('Google News sitemap generation completed.');
        } catch (\Exception $e) {
            Log::error('Error generating Google News sitemap: ' . $e->getMessage());
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
}
