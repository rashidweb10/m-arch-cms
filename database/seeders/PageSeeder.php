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
                'layout' => 'landing',
                'is_active' => true,
                'company_id' => 1,
                'meta' => [
                    ['meta_key' => 'custom_css', 'meta_value' => ''],
                    ['meta_key' => 'custom_js', 'meta_value' => ''],
                ],
            ],
            [
                'slug' => 'home',
                'language' => 'en',
                'title' => 'Home',
                'content' => 'Welcome to the home page.',
                'seo_title' => 'Home - NHSST Thane',
                'seo_description' => 'Welcome to NHSST Thane - Home page.',
                'seo_keywords' => 'home, NHSST Thane',
                'layout' => 'home',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
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
            ],
            [
                'slug' => 'why-we',
                'language' => 'en',
                'title' => 'Why We',
                'content' => 'Details about our Why We.',
                'seo_title' => 'Why We - NHSST Thane',
                'seo_description' => 'Know more about our Why We.',
                'seo_keywords' => 'Why We, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'roadmap',
                'language' => 'en',
                'title' => 'Roadmap',
                'content' => 'This is the roadmap page content.',
                'seo_title' => 'Roadmap - NHSST Thane',
                'seo_description' => 'Discover the roadmap of NHSST Thane.',
                'seo_keywords' => 'roadmap, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'career',
                'language' => 'en',
                'title' => 'Career',
                'content' => 'Explore career opportunities at NHSST Thane.',
                'seo_title' => 'Career - NHSST Thane',
                'seo_description' => 'Join NHSST Thane and build your career.',
                'seo_keywords' => 'career, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'disclosure',
                'language' => 'en',
                'title' => 'Disclosure',
                'content' => 'View our disclosure policy.',
                'seo_title' => 'Disclosure - NHSST Thane',
                'seo_description' => 'Understand our disclosure policy.',
                'seo_keywords' => 'disclosure, NHSST Thane',
                'layout' => 'results',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'curriculum',
                'language' => 'en',
                'title' => 'Curriculum',
                'content' => 'Details about our curriculum.',
                'seo_title' => 'Curriculum - NHSST Thane',
                'seo_description' => 'Explore our curriculum details.',
                'seo_keywords' => 'curriculum, NHSST Thane',
                'layout' => 'curriculum',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'admission',
                'language' => 'en',
                'title' => 'Admission',
                'content' => 'Learn about the admission process.',
                'seo_title' => 'Admission - NHSST Thane',
                'seo_description' => 'Know more about our admission process.',
                'seo_keywords' => 'admission, NHSST Thane',
                'layout' => 'admission',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],
            [
                'slug' => 'results',
                'language' => 'en',
                'title' => 'Results',
                'content' => 'Learn about the results process.',
                'seo_title' => 'Results - NHSST Thane',
                'seo_description' => 'Know more about our results process.',
                'seo_keywords' => 'results, NHSST Thane',
                'layout' => 'results',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],  
            [
                'slug' => 'alumini',
                'language' => 'en',
                'title' => 'Alumini',
                'content' => 'Learn about the Alumini process.',
                'seo_title' => 'Alumini - NHSST Thane',
                'seo_description' => 'Know more about our Alumini process.',
                'seo_keywords' => 'Alumini, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ], 
            [
                'slug' => 'terms-and-conditions',
                'language' => 'en',
                'title' => 'Why We',
                'content' => 'Terms - Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industr',
                'seo_title' => 'Why We - NHSST Thane',
                'seo_description' => 'Know more about our Why We.',
                'seo_keywords' => 'Why We, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],   
            [
                'slug' => 'privacy-policy',
                'language' => 'en',
                'title' => 'Why We',
                'content' => 'Privacy - Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industr',
                'seo_title' => 'Why We - NHSST Thane',
                'seo_description' => 'Know more about our Why We.',
                'seo_keywords' => 'Why We, NHSST Thane',
                'layout' => 'default',
                'is_active' => true,
                'company_id' => 2,
                'meta' => [],
            ],                                         
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