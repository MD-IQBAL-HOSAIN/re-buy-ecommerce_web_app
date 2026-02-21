<?php

namespace Database\Seeders;

use App\Models\SellElectronics;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SellElectronicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellElectronics = [
            ['id' => 1, 'language_id' => 1, 'name' => '100% Secure', 'image' => null, 'description' => 'SSL encrypted & GDPR compliant', 'price' => 99.99],
            ['id' => 2, 'language_id' => 1, 'name' => 'Fast Payout', 'image' => null, 'description' => 'Within 48h after inspection', 'price' => 149.99],
            ['id' => 3, 'language_id' => 1, 'name' => 'Trusted by 50,000+', 'image' => null, 'description' => 'Happy customers', 'price' => 199.99],
        ];

        foreach ($sellElectronics as $item) {
            if (SellElectronics::where('name', $item['name'])->exists()) {
                $this->command->info('Already seeded: ' . $item['name']);
            } else {
                SellElectronics::create($item);
                $this->command->info('Sell Electronics seeded: ' . $item['name']);
            }
        }
    }
}
