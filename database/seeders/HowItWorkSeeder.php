<?php

namespace Database\Seeders;

use App\Models\HowItWork;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HowItWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $howItWorks = [
            ['id' => 1, 'language_id' => 1, 'title' => 'Select device', 'subtitle' => 'Select the device category, brand and model. Specify storage size and color.', 'image' => null],
            ['id' => 2, 'language_id' => 1, 'title' => 'Describe condition', 'subtitle' => 'Answer a few simple questions about the condition of your device to get an accurate offer.', 'image' => null],
            ['id' => 3, 'language_id' => 1, 'title' => 'Ship for free', 'subtitle' => 'Accept the offer, print your free shipping label and send us your device.', 'image' => null],
            ['id' => 4, 'language_id' => 1, 'title' => 'Get paid fast', 'subtitle' => 'After a brief inspection, you will receive payment within 48 hours via bank transfer or PayPal.', 'image' => null],
        ];

        foreach ($howItWorks as $item) {
            if (HowItWork::where('title', $item['title'])->exists()) {
                $this->command->info('Already seeded: ' . $item['title']);
            } else {
                HowItWork::create($item);
                $this->command->info('How It Work seeded: ' . $item['title']);
            }
        }
    }
}
