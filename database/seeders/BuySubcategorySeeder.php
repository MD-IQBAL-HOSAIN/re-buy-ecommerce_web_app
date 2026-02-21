<?php

namespace Database\Seeders;

use App\Models\BuySubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuySubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Smartphone brands under buy_category_id = 2
        $smartphoneBrands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
            ],
            [
                'name' => 'Xiaomi',
                'slug' => 'xiaomi',
            ],
            [
                'name' => 'Realme',
                'slug' => 'realme',
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
            ],
            [
                'name' => 'OnePlus',
                'slug' => 'oneplus',
            ],
            [
                'name' => 'Oppo',
                'slug' => 'oppo',
            ],
            [
                'name' => 'Vivo',
                'slug' => 'vivo',
            ],
            [
                'name' => 'Google',
                'slug' => 'google',
            ],
            [
                'name' => 'Huawei',
                'slug' => 'huawei',
            ],
            [
                'name' => 'Motorola',
                'slug' => 'motorola',
            ],
            [
                'name' => 'Nokia',
                'slug' => 'nokia',
            ],
        ];

        foreach ($smartphoneBrands as $brand) {
            $exists = BuySubcategory::where('slug', $brand['slug'])
                ->where('buy_category_id', 2)
                ->exists();

            if ($exists) {
                $this->command->info("Subcategory '{$brand['name']}' already seeded.");
            } else {
                BuySubcategory::create([
                    'buy_category_id' => 2,
                    'name' => $brand['name'],
                    'slug' => $brand['slug'],
                    'image' => null,
                    'status' => 'active',
                ]);
                $this->command->info("Subcategory '{$brand['name']}' created successfully.");
            }
        }
    }
}
