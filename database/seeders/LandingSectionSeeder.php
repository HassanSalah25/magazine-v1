<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class LandingSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sections = [
            ['id' => 1, 'name' => 'Hero Section', 'status' => null, 'route' => 'admin.homepagesection.herosection'],
            ['id' => 2, 'name' => 'Intro Section', 'status' => 'intro_section', 'route' => 'admin.introsection.index'],
            ['id' => 3, 'name' => 'Feature Section', 'status' => 'feature_section', 'route' => 'admin.feature.index'],
            ['id' => 4, 'name' => 'Approach Section', 'status' => 'approach_section', 'route' => 'admin.approach.index'],
            ['id' => 5, 'name' => 'Service Section', 'status' => 'service_section', 'route' => 'admin.servicesection.index'],
            ['id' => 6, 'name' => 'Product Section', 'status' => 'featured_products_section', 'route' => null],
            ['id' => 7, 'name' => 'Pricing Section', 'status' => 'pricing_section', 'route' => 'admin.pricingsection.index'],
            ['id' => 8, 'name' => 'Portfolio Section', 'status' => 'portfolio_section', 'route' => 'admin.portfoliosection.index'],
            ['id' => 9, 'name' => 'Statistics Section', 'status' => 'statistics_section', 'route' => 'admin.statistics.index'],
            ['id' => 10, 'name' => 'Comparison Section', 'status' => 'comparison_section', 'route' => 'admin.comparison.index'],
            ['id' => 11, 'name' => 'Nav & Tab Section', 'status' => 'nav_tab_section', 'route' => 'admin.nav_tab.index'],
            ['id' => 12, 'name' => 'Faq Section', 'status' => 'faq_section', 'route' => 'admin.faqsection.index'],
            ['id' => 13, 'name' => 'Testimonials Section', 'status' => 'testimonial_section', 'route' => 'admin.testimonial.index'],
            ['id' => 14, 'name' => 'Call to Action Section', 'status' => 'call_to_action_section', 'route' => 'admin.cta.index'],
            ['id' => 15, 'name' => 'Team Section', 'status' => 'team_section', 'route' => 'admin.member.index'],
            ['id' => 16, 'name' => 'Blog Section', 'status' => 'news_section', 'route' => 'admin.blogsection.index'],
            ['id' => 17, 'name' => 'Partners Section', 'status' => 'partner_section', 'route' => 'admin.partner.index'],
            ['id' => 18, 'parent_id' => 1, 'name' => 'Static Version', 'status' => '0', 'route' => 'admin.herosection.static'],
            ['id' => 19, 'parent_id' => 1, 'name' => 'Slider Version', 'status' => '0', 'route' => 'admin.slider.index'],
            ['id' => 20, 'parent_id' => 1, 'name' => 'Video Version', 'status' => '1', 'route' => 'admin.herosection.video'],
            ['id' => 21, 'name' => 'How We Do It Section', 'status' => 'how_we_do_it_section', 'route' => 'admin.howwedoit.index'],
        ];
        Section::query()->truncate();

        foreach ($sections as $section) {
            Section::updateOrCreate($section);
        }
    }
}
