<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Getting Started with Laravel 11',
                'slug' => 'getting-started-with-laravel-11',
                'excerpt' => 'Learn the basics of Laravel 11 and build your first application.',
                'content' => '<p>Laravel 11 brings exciting new features and improvements. In this comprehensive guide, we\'ll walk through setting up a new Laravel project and explore the key features that make Laravel one of the most popular PHP frameworks.</p><h2>Installation</h2><p>First, make sure you have PHP 8.1+ and Composer installed. Then run:</p><pre><code>composer create-project laravel/laravel my-app</code></pre><h2>Key Features</h2><ul><li>Improved performance</li><li>Better developer experience</li><li>Enhanced security</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'Laravel 11 Tutorial - Getting Started',
                'meta_description' => 'Complete guide to getting started with Laravel 11 framework.',
                'meta_keywords' => 'laravel, php, framework, tutorial',
                'categories' => ['laravel', 'web-development'],
            ],
            [
                'title' => 'Modern JavaScript ES6+ Features',
                'slug' => 'modern-javascript-es6-features',
                'excerpt' => 'Explore the powerful features introduced in ES6 and beyond.',
                'content' => '<p>JavaScript has evolved significantly with ES6 and later versions. Let\'s dive into the most important features that every modern JavaScript developer should know.</p><h2>Arrow Functions</h2><p>Arrow functions provide a concise syntax for writing function expressions:</p><pre><code>const add = (a, b) => a + b;</code></pre><h2>Destructuring</h2><p>Destructuring allows you to unpack values from arrays or properties from objects:</p><pre><code>const [a, b] = [1, 2];</code></pre>',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'meta_title' => 'Modern JavaScript ES6+ Features Guide',
                'meta_description' => 'Learn the latest JavaScript features and improve your coding skills.',
                'meta_keywords' => 'javascript, es6, programming',
                'categories' => ['javascript', 'web-development'],
            ],
            [
                'title' => 'Building Responsive UIs with Tailwind CSS',
                'slug' => 'building-responsive-uis-with-tailwind-css',
                'excerpt' => 'Master responsive design with Tailwind CSS utility classes.',
                'content' => '<p>Tailwind CSS is a utility-first CSS framework that helps you build modern, responsive user interfaces quickly. Unlike traditional CSS frameworks, Tailwind doesn\'t provide pre-built components but gives you low-level utility classes.</p><h2>Getting Started</h2><p>Install Tailwind via npm:</p><pre><code>npm install -D tailwindcss</code></pre><h2>Responsive Design</h2><p>Use responsive prefixes to apply styles at different breakpoints:</p><pre><code><div class="w-full md:w-1/2 lg:w-1/3"></code></pre>',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'meta_title' => 'Responsive UI Design with Tailwind CSS',
                'meta_description' => 'Learn to build responsive user interfaces using Tailwind CSS.',
                'meta_keywords' => 'tailwind, css, responsive, ui',
                'categories' => ['ui-ux-design', 'web-development'],
            ],
            [
                'title' => 'React Native vs Flutter: Choosing the Right Framework',
                'slug' => 'react-native-vs-flutter-choosing-right-framework',
                'excerpt' => 'Compare React Native and Flutter to decide which framework suits your project.',
                'content' => '<p>When it comes to cross-platform mobile development, React Native and Flutter are two of the most popular choices. Both allow you to build native mobile apps using a single codebase, but they have different approaches and trade-offs.</p><h2>React Native</h2><p>React Native uses JavaScript and React. If you\'re already familiar with web development, you\'ll feel right at home.</p><h2>Flutter</h2><p>Flutter uses Dart and provides its own UI toolkit. It offers excellent performance and a rich set of pre-built widgets.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'meta_title' => 'React Native vs Flutter Comparison',
                'meta_description' => 'Compare React Native and Flutter to choose the best framework for your mobile app.',
                'meta_keywords' => 'react native, flutter, mobile development',
                'categories' => ['mobile-development', 'technology'],
            ],
            [
                'title' => 'Docker for PHP Developers',
                'slug' => 'docker-for-php-developers',
                'excerpt' => 'Learn how to use Docker to streamline your PHP development workflow.',
                'content' => '<p>Docker has revolutionized how we develop and deploy applications. For PHP developers, Docker provides a consistent environment across different machines and simplifies the deployment process.</p><h2>Why Docker?</h2><ul><li>Consistent environments</li><li>Easy scaling</li><li>Simplified deployment</li></ul><h2>Basic Setup</h2><p>Create a Dockerfile for your PHP application:</p><pre><code>FROM php:8.1-apache\nCOPY . /var/www/html\nRUN docker-php-ext-install mysqli</code></pre>',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'meta_title' => 'Docker Tutorial for PHP Developers',
                'meta_description' => 'Learn Docker to improve your PHP development workflow.',
                'meta_keywords' => 'docker, php, development',
                'categories' => ['technology', 'web-development'],
            ],
            [
                'title' => 'Introduction to GraphQL',
                'slug' => 'introduction-to-graphql',
                'excerpt' => 'Understand GraphQL and how it differs from REST APIs.',
                'content' => '<p>GraphQL is a query language for APIs that allows clients to request exactly the data they need. Unlike REST APIs, GraphQL gives clients the power to specify what data they want.</p><h2>Key Benefits</h2><ul><li>Fetch exactly what you need</li><li>Single endpoint</li><li>Strongly typed schema</li></ul><h2>Basic Query</h2><pre><code>{\n  user(id: "1") {\n    name\n    email\n  }\n}</code></pre>',
                'status' => 'draft',
                'published_at' => null,
                'meta_title' => 'GraphQL Introduction',
                'meta_description' => 'Learn the basics of GraphQL and modern API design.',
                'meta_keywords' => 'graphql, api, query language',
                'categories' => ['technology', 'web-development'],
            ],
        ];

        foreach ($blogs as $blogData) {
            $categories = $blogData['categories'];
            unset($blogData['categories']);

            $blog = Blog::create($blogData);

            // Attach categories
            $categoryIds = BlogCategory::whereIn('slug', $categories)->pluck('id');
            $blog->categories()->attach($categoryIds);
        }
    }
}
