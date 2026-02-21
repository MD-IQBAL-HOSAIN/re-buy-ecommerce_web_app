<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'language_id' => 1,
                'name' => 'Black',
                'code' => '#000000',
            ],
            [
                'language_id' => 1,
                'name' => 'White',
                'code' => '#FFFFFF',
            ],
            [
                'language_id' => 1,
                'name' => 'Silver',
                'code' => '#C0C0C0',
            ],
            [
                'language_id' => 1,
                'name' => 'Gold',
                'code' => '#FFD700',
            ],
            [
                'language_id' => 1,
                'name' => 'Rose Gold',
                'code' => '#B76E79',
            ]
        ];

        foreach ($colors as $color) {
            $exists = Color::where('name', $color['name'])->exists();

            if (!$exists) {
                Color::create([
                    'language_id' => $color['language_id'],
                    'name' => $color['name'],
                    'code' => $color['code'],
                ]);
            }
        }
    }
}
