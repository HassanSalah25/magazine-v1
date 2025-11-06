<?php

namespace Database\Seeders;

use App\Models\BasicExtended;
use App\Models\BasicExtra;
use App\Models\BasicSetting;
use App\Models\Section;
use Illuminate\Database\Seeder;

class CloneBasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. BasicSetting
        $originalSetting = BasicSetting::first();
        if ($originalSetting) {
            for ($i = 0; $i < 3; $i++) {
                $new = $originalSetting->replicate();
                $new->save();
            }
        }

        // 2. BasicExtended
        $originalExtended = BasicExtended::first();
        if ($originalExtended) {
            for ($i = 0; $i < 3; $i++) {
                $new = $originalExtended->replicate();
                $new->save();
            }
        }

        // 3. BasicExtra
        $originalExtra = BasicExtra::first();
        if ($originalExtra) {
            for ($i = 0; $i < 3; $i++) {
                $new = $originalExtra->replicate();
                $new->save();
            }
        }
    }
}
