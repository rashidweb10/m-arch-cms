<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Articles about latest technology trends and innovations.',
                'meta_title' => 'Technology Blog',
                'meta_description' => 'Stay updated with the latest in technology and innovation.',
                'meta_keywords' => 'technology, innovation, tech trends',
                'status' => true,
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Tutorials and guides on web development best practices.',
                'meta_title' => 'Web Development Tutorials',
                'meta_description' => 'Learn web development with our comprehensive tutorials.',
                'meta_keywords' => 'web development, tutorials, programming',
                'status' => true,
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Everything about Laravel framework and PHP development.',
                'meta_title' => 'Laravel Development',
                'meta_description' => 'Master Laravel framework with our expert guides.',
                'meta_keywords' => 'laravel, php, framework',
                'status' => true,
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'Modern JavaScript development and frameworks.',
                'meta_title' => 'JavaScript Development',
                'meta_description' => 'Explore modern JavaScript and its frameworks.',
                'meta_keywords' => 'javascript, js, frontend',
                'status' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'User interface and user experience design principles.',
                'meta_title' => 'UI/UX Design Principles',
                'meta_description' => 'Learn UI/UX design to create better user experiences.',
                'meta_keywords' => 'ui, ux, design, user experience',
                'status' => true,
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Mobile app development for iOS and Android.',
                'meta_title' => 'Mobile App Development',
                'meta_description' => 'Build mobile apps for iOS and Android platforms.',
                'meta_keywords' => 'mobile, ios, android, apps',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }

        // Create hierarchical relationships
        $laravel = BlogCategory::where('slug', 'laravel')->first();
        $webDev = BlogCategory::where('slug', 'web-development')->first();

        if ($laravel && $webDev) {
            $laravel->update(['parent_id' => $webDev->id]);
        }

        $js = BlogCategory::where('slug', 'javascript')->first();
        if ($js && $webDev) {
            $js->update(['parent_id' => $webDev->id]);
        }
    }
}
