<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DynamicSection;

class DynamicSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample dynamic sections
        DynamicSection::create([
            'name' => 'OPINIONS',
            'slug' => 'opinions',
            'type' => 'template_1',
            'title' => 'Opinions',
            'subtitle' => 'Latest opinions and insights',
            'description' => 'Opinions section with featured post and list of articles',
            'is_active' => true,
            'sort_order' => 1
        ]);

        DynamicSection::create([
            'name' => 'WORLD',
            'slug' => 'world',
            'type' => 'template_2',
            'title' => 'World',
            'subtitle' => 'Global news and updates',
            'description' => 'World news section with grid layout',
            'is_active' => true,
            'sort_order' => 2
        ]);
    }
}
