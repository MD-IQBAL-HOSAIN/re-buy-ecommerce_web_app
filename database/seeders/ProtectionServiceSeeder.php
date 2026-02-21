<?php

namespace Database\Seeders;

use App\Models\ProtectionService;
use Illuminate\Database\Seeder;

class ProtectionServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'language_id' => 1,
                'name' => 'Express Shipping',
                'description' => 'Delivery within 24 hours',
                'price' => 9.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Extended Warranty',
                'description' => '12 months coverage for all items',
                'price' => 29.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Battery Replacement',
                'description' => 'Brand new battery',
                'price' => 49.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Priority Shipping',
                'description' => 'Receive within 24 hours',
                'price' => 14.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Screen Protection',
                'description' => 'Premium tempered glass included',
                'price' => 19.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Data Transfer',
                'description' => 'Transfer all your data safely',
                'price' => 24.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Device Insurance',
                'description' => '6 months accidental damage cover',
                'price' => 39.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Premium Support',
                'description' => '24/7 priority customer support',
                'price' => 9.99,

            ],
            [
                'language_id' => 1,
                'name' => 'Gift Wrapping',
                'description' => 'Beautiful gift packaging',
                'price' => 4.99,

            ],
        ];

        foreach ($services as $service) {
            $exists = ProtectionService::where('name', $service['name'])->exists();

            if (!$exists) {
                ProtectionService::create([
                    'language_id' => $service['language_id'],
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                ]);
            }
        }
    }
}
