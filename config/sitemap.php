<?php

use GuzzleHttp\RequestOptions;
use Spatie\Sitemap\Crawler\Profile;

return [

    /*
     * The generator will add this to the generated sitemap.xml as a <lastmod> field.
     */
    'add_last_modified_date' => true,

    /*
     * This option will determine if the sitemap generator should add an `<xhtml:link rel="alternate" hreflang="..."/>` for every alternate language.
     */
    'add_alternate_langs' => false,

    /*
     * The path where the sitemap will be written to disk.
     */
    'output_path' => public_path('sitemap.xml'),

    /*
     * The url that the sitemap will be accessible at.
     */
    'url' => null,

    /*
     * Whether the sitemap generator should use "pretty" URLs.
     */
    'use_pretty_urls' => false,
];

