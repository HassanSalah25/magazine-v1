<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            ['name' => 'Blog Carousel Management', 'status' => 'blog_carousel_section', 'route' => 'admin.carousel.index'],
            ['name' => 'Featured Blog Slider', 'status' => 'featured_blog_slider_section', 'route' => 'admin.featured.slider.index'],
            ['name' => 'Dynamic Sections', 'status' => 'dynamic_sections', 'route' => 'admin.dynamic-sections.index'],
        ];


        Section::query()->truncate();
        foreach ($sections as $section) {
            $created = Section::updateOrCreate($section);
        }
    }
}
