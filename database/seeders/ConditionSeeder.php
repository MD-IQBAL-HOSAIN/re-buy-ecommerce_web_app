<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            [
                'language_id' => 1,
                'name' => 'Brand New',
            ],
            [
                'language_id' => 1,
                'name' => 'Like New',
            ],
            [
                'language_id' => 1,
                'name' => 'Very Good',
            ],
            [
                'language_id' => 1,
                'name' => 'Good',
            ],
            [
                'language_id' => 1,
                'name' => 'Fair',
            ],
            [
                'language_id' => 1,
                'name' => 'Scratch',
            ],
            [
                'language_id' => 1,
                'name' => 'Refurbished',
            ],
            [
                'language_id' => 1,
                'name' => 'Acceptable',
            ],
        ];

        foreach ($conditions as $condition) {
            // Check if condition already exists by name
            $exists = Condition::where('name', $condition['name'])
                ->where('language_id', $condition['language_id'])
                ->exists();

            if (!$exists) {
                Condition::create([
                    'name' => $condition['name'],
                    'language_id' => $condition['language_id'],
                ]);
            }
        }
    }
}
