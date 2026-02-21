<?php

namespace Database\Seeders;

use App\Models\BuyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BuyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
            ],
            [
                'name' => 'Smartphone',
                'slug' => 'smartphone',
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
            ],
            [
                'name' => 'Audio',
                'slug' => 'audio',
            ],
            [
                'name' => 'Wearables',
                'slug' => 'wearables',
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
            ],
            [
                'name' => 'Cameras',
                'slug' => 'cameras',
            ],
        ];

        foreach ($categories as $category) {
            $exists = BuyCategory::where('slug', $category['slug'])->exists();

            if ($exists) {
                $this->command->info("Category '{$category['name']}' already seeded.");
            } else {
                BuyCategory::create([
                    'language_id' => 1,
                    'name' => $category['name'],
                    'slug' => $category['slug'],
                    'image' => null,
                    'status' => 'active',
                ]);
                $this->command->info("Category '{$category['name']}' created successfully.");
            }
        }
    }
}
