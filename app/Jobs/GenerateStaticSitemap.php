<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\File;

class GenerateStaticSitemap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
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
}
