<?php
namespace Database\Seeders;

use App\Models\BuySubcategory;
use App\Models\SellProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SellProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appleSubcategory   = BuySubcategory::where('name', 'Apple')->first();
        $samsungSubcategory = BuySubcategory::where('name', 'Samsung')->first();
        $xiaomiSubcategory  = BuySubcategory::where('name', 'Xiaomi')->first();
        $googleSubcategory  = BuySubcategory::where('name', 'Google')->first();

        $sellProducts = [
            [
                'short_name'  => 'Apple',
                'name'        => 'iPhone 15 Pro Max',
                'description' => 'Apple flagship with A17 Pro chip, titanium design, and advanced camera system.',
                'subcategory' => $appleSubcategory,
            ],
            [
                'short_name'  => 'Samsung Galaxy',
                'name'        => 'Galaxy S24 Ultra',
                'description' => 'Galaxy AI, 200MP camera, titanium frame, S Pen included.',
                'subcategory' => $samsungSubcategory,
            ],
            [
                'short_name'  => 'Xiaomi',
                'name'        => 'Xiaomi 14 Ultra',
                'description' => 'Leica optics, Snapdragon 8 Gen 3, and 5000mAh battery with fast charging.',
                'subcategory' => $xiaomiSubcategory,
            ],
            [
                'short_name'  => 'Google Pixel',
                'name'        => 'Google Pixel Pixel 8 Pro',
                'description' => 'Google AI camera features, clean Android experience, and premium build.',
                'subcategory' => $googleSubcategory,
            ],
        ];

        foreach ($sellProducts as $item) {
            if (! $item['subcategory']) {
                $this->command->info('Skipped (subcategory missing): ' . $item['name']);
                continue;
            }

            $slug = Str::slug($item['name']);

            $exists = SellProduct::where('slug', $slug)
                ->where('buy_subcategory_id', $item['subcategory']->id)
                ->exists();

            if ($exists) {
                $this->command->info('Already seeded: ' . $item['name']);
            } else {
                SellProduct::create([
                    'language_id'        => 1,
                    'buy_subcategory_id' => $item['subcategory']->id,
                    'name'               => $item['name'],
                    'short_name'         => $item['short_name'],
                    'slug'               => $slug,
                    'image'              => null,
                    'description'        => $item['description'],
                ]);
                $this->command->info('Sell Product seeded: ' . $item['name']);
            }
        }
    }
}
