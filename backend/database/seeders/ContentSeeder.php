<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\HeroSlide;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        HeroSlide::updateOrCreate(
            ['title' => 'Welcome to Barista Cafe'],
            [
                'title' => 'Welcome to Barista Cafe',
                'subtitle' => 'Your favourite coffee daily lives',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1920',
                'button_text' => 'Check Menu',
                'button_url' => '#menu',
                'is_active' => true,
                'order' => 1,
            ]
        );

        About::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'We Started Since 2009',
                'subtitle' => 'Best Cafe in Klang',
                'content' => 'The café had been in the town for as long as anyone could remember, and it had become a beloved institution among the locals. The café was run by a friendly and hospitable couple, Mr. and Mrs. Johnson, who took great pride in serving the best coffee in town.',
                'image' => 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=800',
                'founded_year' => 2009,
                'experience_years' => 15,
            ]
        );

        $teamData = [
            ['name' => 'Steve', 'position' => 'Boss', 'bio' => 'Leading our coffee revolution with passion.'],
            ['name' => 'Sandra', 'position' => 'Manager', 'bio' => 'Ensuring every customer has a perfect experience.'],
            ['name' => 'Jackson', 'position' => 'Senior Barista', 'bio' => 'Crafting the finest espresso for over 8 years.'],
            ['name' => 'Michelle', 'position' => 'Barista', 'bio' => 'Latte art specialist with a creative touch.'],
        ];

        foreach ($teamData as $index => $data) {
            TeamMember::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                    'is_active' => true,
                    'order' => $index + 1,
                ])
            );
        }

        $categories = [
            ['name' => 'Breakfast', 'slug' => 'breakfast', 'description' => 'Start your day right'],
            ['name' => 'Coffee', 'slug' => 'coffee', 'description' => 'Our signature blends'],
            ['name' => 'Desserts', 'slug' => 'desserts', 'description' => 'Sweet treats'],
        ];

        foreach ($categories as $index => $cat) {
            $category = MenuCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, [
                    'is_active' => true,
                    'order' => $index + 1,
                ])
            );

            if ($cat['slug'] === 'breakfast') {
                $items = [
                    ['name' => 'Pancakes', 'price' => 12.50, 'description' => 'Fresh brewed coffee and steamed milk'],
                    ['name' => 'Toasted Waffle', 'price' => 12.00, 'original_price' => 16.50, 'description' => 'Brewed coffee and steamed milk'],
                    ['name' => 'Fried Chips', 'price' => 15.00, 'is_featured' => true, 'description' => 'Rich Milk and Foam'],
                    ['name' => 'Banana Cakes', 'price' => 18.00, 'description' => 'Rich Milk and Foam'],
                ];
            } elseif ($cat['slug'] === 'coffee') {
                $items = [
                    ['name' => 'Latte', 'price' => 7.50, 'original_price' => 12.50, 'description' => 'Fresh brewed coffee and steamed milk'],
                    ['name' => 'White Coffee', 'price' => 5.90, 'is_featured' => true, 'description' => 'Brewed coffee and steamed milk'],
                    ['name' => 'Chocolate Milk', 'price' => 5.50, 'description' => 'Rich Milk and Foam'],
                    ['name' => 'Green Tea', 'price' => 7.50, 'description' => 'Premium Japanese green tea'],
                    ['name' => 'Dark Chocolate', 'price' => 7.25, 'description' => 'Rich Milk and Foam'],
                ];
            } else {
                $items = [
                    ['name' => 'Chocolate Cake', 'price' => 8.50, 'description' => 'Rich Belgian chocolate'],
                    ['name' => 'Cheesecake', 'price' => 9.00, 'is_featured' => true, 'description' => 'Creamy New York style'],
                    ['name' => 'Brownie', 'price' => 6.00, 'description' => 'Warm fudgy chocolate'],
                ];
            }

            foreach ($items as $itemIndex => $item) {
                MenuItem::updateOrCreate(
                    ['slug' => $item['name']],
                    array_merge($item, [
                        'category_id' => $category->id,
                        'slug' => strtolower(str_replace(' ', '-', $item['name'])),
                        'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400',
                        'is_active' => true,
                        'order' => $itemIndex + 1,
                    ])
                );
            }
        }

        $testimonials = [
            ['name' => 'Sarah', 'location' => 'KL', 'content' => 'Best coffee in town! The atmosphere is amazing.', 'rating' => 5],
            ['name' => 'John', 'location' => 'Petaling Jaya', 'content' => 'Love the pancakes and the latte art is beautiful.', 'rating' => 5],
            ['name' => 'Emily', 'location' => 'Subang', 'content' => 'Perfect spot for working. Great WiFi and coffee!', 'rating' => 4],
        ];

        foreach ($testimonials as $test) {
            Testimonial::updateOrCreate(
                ['name' => $test['name'], 'content' => $test['content']],
                array_merge($test, [
                    'is_approved' => true,
                    'is_active' => true,
                ])
            );
        }
    }
}
