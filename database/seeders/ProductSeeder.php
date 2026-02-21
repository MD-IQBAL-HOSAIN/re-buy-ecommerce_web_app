<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\BuySubcategory;
use App\Models\Condition;
use App\Models\Color;
use App\Models\Storage;
use App\Models\ProtectionService;
use App\Models\Accessory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get related IDs
        $appleSubcategory = BuySubcategory::where('name', 'Apple')->first();
        $samsungSubcategory = BuySubcategory::where('name', 'Samsung')->first();
        $xiaomiSubcategory = BuySubcategory::where('name', 'Xiaomi')->first();

        $brandNewCondition = Condition::where('name', 'Brand New')->first();
        $likeNewCondition = Condition::where('name', 'Like New')->first();
        $refurbishedCondition = Condition::where('name', 'Refurbished')->first();

        // Get colors
        $colors = Color::all();
        $blackColor = Color::where('name', 'Black')->first();
        $whiteColor = Color::where('name', 'White')->first();
        $goldColor = Color::where('name', 'Gold')->first();
        $blueColor = Color::where('name', 'Blue')->first();

        // Get storages
        $storage128 = Storage::where('capacity', 128)->where('name', 'GB')->first();
        $storage256 = Storage::where('capacity', 256)->where('name', 'GB')->first();
        $storage512 = Storage::where('capacity', 512)->where('name', 'GB')->first();

        // Get protection services and accessories
        $protectionServices = ProtectionService::take(3)->get();
        $accessories = Accessory::take(2)->get();

        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'The most powerful iPhone ever with A17 Pro chip, titanium design, and advanced camera system.',
                'price' => 1299.99,
                'discount_price' => 100,
                'old_price' => 1399.99,
                'stock' => 50,
                'status' => 'active',
                'is_featured' => true,
                'subcategory' => $appleSubcategory,
                'condition' => $brandNewCondition,
                'colors' => [
                    ['color' => $goldColor, 'extra_price' => 50, 'stock' => 15],
                ],
                'storages' => [
                    ['storage' => $storage512, 'extra_price' => 512, 'stock' => 25],
                ],
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'Dynamic Island, Always-On display, and 48MP camera system.',
                'price' => 999.99,
                'discount_price' => 100,
                'old_price' => 1099.99,
                'stock' => 35,
                'status' => 'active',
                'is_featured' => true,
                'subcategory' => $appleSubcategory,
                'condition' => $likeNewCondition,
                'colors' => [
                    ['color' => $blueColor, 'extra_price' => 25, 'stock' => 15],
                ],
                'storages' => [
                    ['storage' => $storage256, 'extra_price' => 100, 'stock' => 15],
                ],
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Galaxy AI, 200MP camera, titanium frame, S Pen included.',
                'price' => 1199.99,
                'discount_price' => 200,
                'old_price' => 1399.99,
                'stock' => 40,
                'status' => 'active',
                'is_featured' => true,
                'subcategory' => $samsungSubcategory,
                'condition' => $brandNewCondition,
                'colors' => [
                    ['color' => $whiteColor, 'extra_price' => 0, 'stock' => 15],
                ],
                'storages' => [
                    ['storage' => $storage512, 'extra_price' => 150, 'stock' => 20],
                ],
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Snapdragon 8 Gen 2, 50MP camera, all-day battery.',
                'price' => 799.99,
                'discount_price' => 300,
                'stock' => 60,
                'old_price' => 1000.99,
                'status' => 'active',
                'is_featured' => false,
                'subcategory' => $samsungSubcategory,
                'condition' => $refurbishedCondition,
                'colors' => [
                    ['color' => $goldColor, 'extra_price' => 30, 'stock' => 30],
                ],
                'storages' => [
                    ['storage' => $storage256, 'extra_price' => 80, 'stock' => 20],
                ],
            ],
            [
                'name' => 'Xiaomi 14 Ultra',
                'description' => 'Leica optics, Snapdragon 8 Gen 3, 5000mAh battery with 90W charging.',
                'price' => 999.99,
                'discount_price' => 400,
                'stock' => 30,
                'old_price' => 1399.99,
                'status' => 'active',
                'is_featured' => true,
                'subcategory' => $xiaomiSubcategory,
                'condition' => $brandNewCondition,
                'colors' => [
                    ['color' => $whiteColor, 'extra_price' => 0, 'stock' => 15],
                ],
                'storages' => [
                    ['storage' => $storage512, 'extra_price' => 120, 'stock' => 15],
                ],
            ],
            [
                'name' => 'Xiaomi 13T Pro',
                'description' => 'MediaTek Dimensity 9200+, 144Hz display, 50MP Leica camera.',
                'price' => 549.99,
                'discount_price' => 100,
                'old_price' => 499.99,
                'stock' => 45,
                'status' => 'active',
                'is_featured' => false,
                'subcategory' => $xiaomiSubcategory,
                'condition' => $likeNewCondition,
                'colors' => [
                    ['color' => $blackColor, 'extra_price' => 0, 'stock' => 25],
                ],
                'storages' => [
                    ['storage' => $storage512, 'extra_price' => 100, 'stock' => 15],
                ],
            ],
        ];

        foreach ($products as $productData) {
            // Check if product already exists
            $exists = Product::where('name', $productData['name'])->exists();

            if (!$exists && $productData['subcategory'] && $productData['condition']) {
                // Create product
                $product = Product::create([
                    'buy_subcategory_id' => $productData['subcategory']->id,
                    'condition_id' => $productData['condition']->id,
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'discount_price' => $productData['discount_price'],
                    'stock' => $productData['stock'],
                    'old_price' => $productData['old_price'],
                    'status' => $productData['status'],
                    'is_featured' => $productData['is_featured'],
                ]);

                // Attach colors with pivot data
                foreach ($productData['colors'] as $colorData) {
                    if ($colorData['color']) {
                        $product->colors()->attach($colorData['color']->id, [
                            'extra_price' => $colorData['extra_price'],
                            'stock' => $colorData['stock'],
                        ]);
                    }
                }

                // Attach storages with pivot data
                foreach ($productData['storages'] as $storageData) {
                    if ($storageData['storage']) {
                        $product->storages()->attach($storageData['storage']->id, [
                            'extra_price' => $storageData['extra_price'],
                            'stock' => $storageData['stock'],
                        ]);
                    }
                }

                // Attach protection services
                if ($protectionServices->count() > 0) {
                    $product->protectionServices()->attach($protectionServices->pluck('id')->toArray());
                }

                // Attach accessories
                if ($accessories->count() > 0) {
                    $product->accessories()->attach($accessories->pluck('id')->toArray());
                }
            }
        }
    }
}
