<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $englishExists = \App\Models\Language::where('code', 'en')->exists();
        $germanExists = \App\Models\Language::where('code', 'de')->exists();

        // if (!$englishExists) {
        //     \App\Models\Language::create([
        //         'id' => 2,
        //         'code' => 'en',
        //         'name' => 'English',
        //         'status' => 'active',
        //     ]);
        // }

        if (!$germanExists) {
            \App\Models\Language::create([
                'id' => 1,
                'code' => 'de',
                'name' => 'Deutsch',
                'status' => 'active',
            ]);
        }

        // if ($englishExists && $germanExists) {
        if ($germanExists) {
            $this->command->info('Languages already exist.');
        }
    }
}
