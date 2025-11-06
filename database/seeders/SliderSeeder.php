<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $originalSliders = Slider::whereNull('page_type')->get(); // نجيب الـ sliders الأصلية

        $pageTypes = ['landingpage1', 'landingpage2', 'landingpage3'];

        foreach ($originalSliders as $slider) {
            foreach ($pageTypes as $type) {
                $newSlider = $slider->replicate(); // انسخ
                $newSlider->page_type = $type;
                $newSlider->save();
            }
        }
    }
}
