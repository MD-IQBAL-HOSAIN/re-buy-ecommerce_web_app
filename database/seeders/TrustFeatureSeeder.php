<?php

namespace Database\Seeders;

use App\Models\TrustFeature;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrustFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'id' => 1,
                'language_id' => 1,
                'title' => '100% transparenter Prüfungsprozess',
            ],
            [
                'id' => 2,
                'language_id' => 1,
                'title' => 'DSGVO-konform & umweltfreundlich',
            ],
            [
                'id' => 3,
                'language_id' => 1,
                'title' => 'Keine versteckten Gebühren oder Abzüge',
            ],
            [
                'id' => 4,
                'language_id' => 1,
                'title' => 'Kostenloser Versand mit Sendungsverfolgung',
            ],
            [
                'id' => 5,
                'language_id' => 1,
                'title' => 'Sichere Datenlöschung garantiert',
            ],
            [
                'id' => 6,
                'language_id' => 1,
                'title' => 'Schnelle Auszahlung per Bank oder PayPal',
            ],
        ];

        foreach ($features as $item) {
            if (TrustFeature::where('title', $item['title'])->exists()) {
                $this->command->info('Already seeded: ' . $item['title']);
            } else {
                TrustFeature::create($item);
                $this->command->info('Trust Feature seeded: ' . $item['title']);
            }
        }
    }
}
