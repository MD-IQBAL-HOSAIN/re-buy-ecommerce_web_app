<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seo = \App\Models\Seo::where('script', 'like', '%SEO script test OK%')->first();

        if (!$seo) {
            $seo = new \App\Models\Seo();
            $seo->script = "<script>\n  console.log('SEO script test OK');\n</script>";
            $seo->status = 'active';
            $seo->save();
        } else {
            $this->command->info('SEO seed already exists, skipped seeding.');
        }
    }
}
