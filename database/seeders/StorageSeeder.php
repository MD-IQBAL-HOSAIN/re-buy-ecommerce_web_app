<?php

namespace Database\Seeders;

use App\Models\Storage;
use Illuminate\Database\Seeder;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storages = [
            [
                'language_id' => 1,
                'capacity' => 64,
                'name' => 'GB',
            ],
            [
                'language_id' => 1,
                'capacity' => 128,
                'name' => 'GB',
            ],
            [
                'language_id' => 1,
                'capacity' => 256,
                'name' => 'GB',
            ],
            [
                'language_id' => 1,
                'capacity' => 512,
                'name' => 'GB',
            ],
            [
                'language_id' => 1,
                'capacity' => 1,
                'name' => 'TB',
            ],
            [
                'language_id' => 1,
                'capacity' => 1,
                'name' => 'PB',
            ],
        ];

        foreach ($storages as $storage) {
            // Check if this combination already exists
            $exists = Storage::where('capacity', $storage['capacity'])
                ->where('name', $storage['name'])
                ->where('language_id', $storage['language_id'])
                ->exists();

            if (!$exists) {
                Storage::create($storage);
            }
        }
    }
}

