<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageMeta;

class PageSeeder extends Seeder
{
    public function run()
    {
        // Array of pages to create
        $pages = [
            [
                'slug' => 'home',
                'language' => 'en',
                'title' => 'Home - Landing',
                'content' => 'Welcome to the landing page.',
                'seo_title' => 'Landing - NHSST Thane',
                'seo_description' => 'Welcome to NHSST Thane - Landing page.',
                'seo_keywords' => 'landing, NHSST Thane',
                'layout' => 'home',
                'is_active' => true,
                'company_id' => 1,
                'meta' => [
                    ['meta_key' => 'custom_css', 'meta_value' => ''],
                    ['meta_key' => 'custom_js', 'meta_value' => ''],
                ],
            ],
            [
                'slug' => 'about-us',
                'language' => 'en',
                'title' => 'About Us',
                'content' => 'This is the about us page content.',
                'seo_title' => 'About Us - NHSST Thane',
                'seo_description' => 'Learn more about NHSST Thane.',
                'seo_keywords' => 'about us, NHSST Thane',
                'layout' => 'about',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [
                    ['meta_key' => 'custom_css', 'meta_value' => '.about-us { font-size: 18px; }'],
                ],
            ]                                         
        ];

        // Loop through the pages and create them with metadata
        foreach ($pages as $pageData) {
            $metaData = $pageData['meta'];
            unset($pageData['meta']); // Remove meta data from the main array

            // Create the page
            $page = Page::create($pageData);

            // Add metadata for the page
            foreach ($metaData as $meta) {
                PageMeta::create([
                    'page_id' => $page->id,
                    'meta_key' => $meta['meta_key'],
                    'meta_value' => $meta['meta_value'],
                ]);
            }
        }
    }
}