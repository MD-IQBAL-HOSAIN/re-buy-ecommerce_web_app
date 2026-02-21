<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SystemSeeder::class,
            LanguageSeeder::class,
            PageSeeder::class,
            FaqSeeder::class,
            BuyCategorySeeder::class,
            BuySubcategorySeeder::class,
            ConditionSeeder::class,
            StorageSeeder::class,
            ProtectionServiceSeeder::class,
            ColorSeeder::class,
            AccessorySeeder::class,
            ProductSeeder::class,
            CMSSeeder::class,
            RefurbishedElectronicSeeder::class,
            SellElectronicsSeeder::class,
            HowItWorkSeeder::class,
            TrustFeatureSeeder::class,
            SellProductSeeder::class,
            QuestionSeeder::class,


        ]);
    }
}
