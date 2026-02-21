<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessories = [
            [
                'language_id' => 1,
                'name' => 'Basic Bundle',
                'description' => "✓ USB-C Cable<br>✓ Power Adapter",
                'price' => 24.99,
                'previous_price' => 34.99,
            ],
            [
                'language_id' => 1,
                'name' => 'Standard Bundle',
                'description' => "✓ USB-C Cable<br>✓ Power Adapter<br>✓ Protective Case",
                'price' => 39.99,
                'previous_price' => 54.99,
            ],
            [
                'language_id' => 1,
                'name' => 'Premium Bundle',
                'description' => "✓ USB-C Cable<br>✓ Power Adapter<br>✓ Protective Case<br>✓ Power Bank",
                'price' => 69.99,
                'previous_price' => 94.99,
            ],
        ];

        foreach ($accessories as $accessory) {
            $exists = Accessory::where('name', $accessory['name'])->exists();

            if (!$exists) {
                Accessory::create([
                    'language_id' => $accessory['language_id'],
                    'name' => $accessory['name'],
                    'description' => $accessory['description'],
                    'price' => $accessory['price'],
                    'previous_price' => $accessory['previous_price'],
                ]);
            }
        }
    }
}
