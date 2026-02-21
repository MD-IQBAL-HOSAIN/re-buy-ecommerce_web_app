<?php

namespace Database\Seeders;

use App\Models\RefurbishedElectronic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RefurbishedElectronicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $refurbishedElectronics = [
            ['id' => 1, 'language_id' => 1, 'name' => '100% Secure', 'image' => null, 'description' => 'SSL encrypted & GDPR compliant', 'price' => 99.99],
            ['id' => 2, 'language_id' => 1, 'name' => 'Fast Payout', 'image' => null, 'description' => 'Within 48h after inspection', 'price' => 149.99],
            ['id' => 3, 'language_id' => 1, 'name' => 'Trusted by 50,000+', 'image' => null, 'description' => 'Happy customers', 'price' => 199.99],
        ];

        foreach ($refurbishedElectronics as $item) {
            if (RefurbishedElectronic::where('name', $item['name'])->exists()) {
                $this->command->info('Already seeded: ' . $item['name']);
            } else {
                RefurbishedElectronic::create($item);
                $this->command->info('Refurbished Electronic seeded: ' . $item['name']);
            }
        }
    }
}
