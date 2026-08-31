<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'admin@vibewithaasif.com'],
            [
                'name' => 'Aasif Khan',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]
        );

        \App\Models\User::updateOrCreate(
            ['email' => 'aasifdhareja@gmail.com'],
            [
                'name' => 'Aasif Dhareja',
                'password' => \Illuminate\Support\Facades\Hash::make('Sona@78692'),
            ]
        );

        $posts = [
            [
                'title' => 'The Future of AI & Digital Lifestyle Trends in 2026',
                'category' => 'Technology',
                'is_active' => true,
                'image' => 'images/headers/header1.jpg',
            ],
            [
                'title' => 'Cyberpunk Aesthetics: Visual Storytelling & Neon Nights',
                'category' => 'Technology',
                'is_active' => true,
                'image' => 'images/headers/header2.jpg',
            ],
            [
                'title' => 'Modern Interior Living, Mindful Space & Creative Lifestyle',
                'category' => 'Health',
                'is_active' => true,
                'image' => 'images/headers/header3.jpg',
            ],
            [
                'title' => 'Alpine Journeys: Stargazing Under the Milky Way Peaks',
                'category' => 'Sports',
                'is_active' => true,
                'image' => 'images/headers/header4.jpg',
            ],
            [
                'title' => 'Synthwave Metropolis: The Pulse of Modern Urban Architecture',
                'category' => 'Business',
                'is_active' => true,
                'image' => 'images/headers/header5.jpg',
            ],
        ];

        foreach ($posts as $p) {
            $post = \App\Models\Post::firstOrCreate(
                ['title' => $p['title']],
                [
                    'user_id' => $user->id,
                    'category' => $p['category'],
                    'is_active' => $p['is_active'],
                ]
            );

            \App\Models\PostImage::firstOrCreate(
                [
                    'post_id' => $post->id,
                    'path' => $p['image'],
                ]
            );
        }
    }
}
