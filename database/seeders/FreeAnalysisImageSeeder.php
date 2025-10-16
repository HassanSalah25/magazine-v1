<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FreeAnalysisImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the free-analysis directory if it doesn't exist
        $freeAnalysisDir = public_path('assets/front/img/free-analysis');
        if (!File::exists($freeAnalysisDir)) {
            File::makeDirectory($freeAnalysisDir, 0755, true);
        }

        // Define the default images to copy
        $defaultImages = [
            'hero-shape-1.png' => 'front/assets/img/home-11/hero/hero-shape-1.png',
            'hero-shape-2.png' => 'front/assets/img/home-11/hero/hero-shape-2.png',
            'hero-shape-3.png' => 'front/assets/img/home-11/hero/hero-shape-3.png',
            'hero-shape-4.png' => 'front/assets/img/home-11/hero/hero-shape-4.png',
            'hero-thumb.png' => 'front/assets/img/home-11/hero/hero-thumb.png',
            'about-1.jpg' => 'front/assets/img/home-11/step/about-1.jpg',
            'about-shape-1.jpg' => 'front/assets/img/home-11/step/about-shape-1.jpg',
            'about-shape-2.png' => 'front/assets/img/home-11/step/about-shape-2.png',
            'about-shape-3.png' => 'front/assets/img/home-11/step/about-shape-3.png',
            'about-shape-4.png' => 'front/assets/img/home-11/step/about-shape-4.png',
        ];

        // Copy each default image
        foreach ($defaultImages as $newName => $sourcePath) {
            $sourceFile = public_path($sourcePath);
            $destinationFile = $freeAnalysisDir . '/' . $newName;
            
            if (File::exists($sourceFile) && !File::exists($destinationFile)) {
                File::copy($sourceFile, $destinationFile);
                $this->command->info("Copied {$sourcePath} to free-analysis/{$newName}");
            } elseif (File::exists($destinationFile)) {
                $this->command->info("File free-analysis/{$newName} already exists, skipping...");
            } else {
                $this->command->warn("Source file {$sourcePath} not found, skipping...");
            }
        }

        $this->command->info('Free analysis default images setup completed!');
    }
}
