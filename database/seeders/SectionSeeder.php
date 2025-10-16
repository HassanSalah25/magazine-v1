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
            ['name' => 'Hero Section', 'status' => null, 'route' => 'admin.landingpagesection.herosection'],
            ['name' => 'Intro Section', 'status' => 'intro_section', 'route' => 'admin.introsection.index'],
            ['name' => 'Feature Section', 'status' => 'feature_section', 'route' => 'admin.feature.index'],
            ['name' => 'Approach Section', 'status' => 'approach_section', 'route' => 'admin.approach.index'],
            ['name' => 'Service Section', 'status' => 'service_section', 'route' => 'admin.servicesection.index'],
            ['name' => 'Product Section', 'status' => 'featured_products_section', 'route' => null],
            ['name' => 'Pricing Section', 'status' => 'pricing_section', 'route' => 'admin.pricingsection.index'],
            ['name' => 'Portfolio Section', 'status' => 'portfolio_section', 'route' => 'admin.portfoliosection.index'],
            ['name' => 'Statistics Section', 'status' => 'statistics_section', 'route' => 'admin.statistics.index'],
            ['name' => 'Comparison Section', 'status' => 'comparison_section', 'route' => 'admin.comparison.index'],
            ['name' => 'Nav & Tab Section', 'status' => 'nav_tab_section', 'route' => 'admin.nav_tab.index'],
            ['name' => 'Faq Section', 'status' => 'faq_section', 'route' => 'admin.faqsection.index'],
            ['name' => 'Testimonials Section', 'status' => 'testimonial_section', 'route' => 'admin.testimonial.index'],
            ['name' => 'Call to Action Section', 'status' => 'call_to_action_section', 'route' => 'admin.cta.index'],
            ['name' => 'Team Section', 'status' => 'team_section', 'route' => 'admin.member.index'],
            ['name' => 'Blog Section', 'status' => 'news_section', 'route' => 'admin.blogsection.index'],
            ['name' => 'Partners Section', 'status' => 'partner_section', 'route' => 'admin.partner.index'],
        ];

        $heroChildren = [
            ['name' => 'Static Version', 'status' => '0', 'route' => 'admin.herosection.static'],
            ['name' => 'Slider Version', 'status' => '0', 'route' => 'admin.slider.index'],
            ['name' => 'Video Version', 'status' => '1', 'route' => 'admin.herosection.video'],
        ];


        $pageTypes = ['landingpage1', 'landingpage2', 'landingpage3'];

        foreach ($pageTypes as $pageType) {
            // Insert main sections
            $insertedHero = null;

            foreach ($sections as $section) {
                $data = $section;
                $data['page_type'] = $pageType;

                // Create and get instance
                $created = Section::create($data);

                // Save the Hero Section's new ID
                if ($created->name === 'Hero Section') {
                    $insertedHero = $created->id;
                }
            }

            // Now insert Hero child versions with correct parent_id
            foreach ($heroChildren as $child) {
                $childData = $child;
                $childData['page_type'] = $pageType;
                $childData['parent_id'] = $insertedHero;

                Section::create($childData);
            }
        }
    }
}
