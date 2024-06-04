<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use App\Models\Story;
use Illuminate\Support\Facades\File;

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
        $this->info('Generating sitemaps...');

        $this->generateStaticSitemap();
        $this->generateDynamicSitemaps();

        $this->info('Sitemaps generated successfully.');
    }

    protected function generateStaticSitemap()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('https://bfirst.news/')
                ->setPriority(1.0)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/bangladesh')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/world')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/economy')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/feature')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/sports')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/tech')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/entertainment')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/education')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/interview')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/corporates')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/politics')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/latest')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/terms')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/privacy-policy')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/comments-policy')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/cookie-settings')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/accessibility')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/about-us')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()))
            ->add(Url::create('https://bfirst.news/contact-us')
                ->setPriority(0.8)
                ->setChangeFrequency('never')
                ->setLastModificationDate(now()));

        $sitemap->writeToFile(public_path('sitemaps/sitemap_static.xml'));
    }

    protected function generateDynamicSitemaps()
    {
        $sitemapFolder = public_path('sitemaps');
        if (!File::exists($sitemapFolder)) {
            File::makeDirectory($sitemapFolder, 0755, true);
        }

        $sitemapIndex = SitemapIndex::create();
        $chunkSize = 10000;
        $index = 1;

        $sitemapIndex->add("/sitemaps/sitemap_static.xml");

        Story::whereNull('deleted_at')->orderBy('id')->chunk($chunkSize, function ($stories) use ($sitemapFolder, $sitemapIndex, &$index) {
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
            $sitemapIndex->add("/sitemaps/{$sitemapFileName}");
            $index++;
        });


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
