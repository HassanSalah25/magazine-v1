<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting tenant data seeding...');
        
        // Get all tenants
        $tenants = DB::connection('central')->table('tenants')->get();
        
        if ($tenants->isEmpty()) {
            $this->command->warn('No tenants found in the central database.');
            return;
        }
        
        $this->command->info("Found {$tenants->count()} tenant(s) to seed.");
        
        foreach ($tenants as $tenant) {
            $this->command->info("Seeding data for tenant: {$tenant->id}");
            $this->seedTenantData($tenant->id);
        }
        
        $this->command->info('Tenant data seeding completed!');
    }

    /**
     * Seed data for a specific tenant
     */
    private function seedTenantData(string $tenantId): void
    {
        $tenantConnection = "{$tenantId}";
        // Check if tenant database exists and has the required tables
        if (!$this->tenantDatabaseExists($tenantConnection)) {
            $this->command->warn("Tenant database for {$tenantId} does not exist. Skipping...");
            return;
        }

        try {
            // Seed basic_settings table
            $this->seedBasicSettings($tenantConnection);
            
            // Seed basic_settings_extended table
            $this->seedBasicSettingsExtended($tenantConnection);
            
            // Seed basic_settings_extra table
            $this->seedBasicSettingsExtra($tenantConnection);
            
            $this->command->info("Successfully seeded data for tenant: {$tenantId}");
            
        } catch (\Exception $e) {
            $this->command->error("Failed to seed data for tenant {$tenantId}: " . $e->getMessage());
        }
    }

    /**
     * Check if tenant database exists
     */
    private function tenantDatabaseExists(string $connection): bool
    {
        try {
            DB::getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Seed basic_settings table
     */
    private function seedBasicSettings(string $connection): void
    {
        if (!Schema::hasTable("{$connection}_basic_settings")) {
            $this->command->warn("Table basic_settings does not exist in {$connection}");
            return;
        }

        $basicSettingsData = [
            [
                'id' => 1,
                'language_id' => 1,
                'favicon' => '684632972c67e.png',
                'logo' => '68463297248a7.png',
                'website_title' => null,
                'base_color' => null,
                'secondary_base_color' => null,
                'support_email' => 'email@web.com',
                'support_phone' => '0125252425',
                'breadcrumb' => '684632972d2ef.png',
                'footer_logo' => '6846b4cea9879.png',
                'footer_text' => 'Footer Text',
                'newsletter_text' => 'Newsletter',
                'copyright_text' => '<p>fdfdfdd</p>',
                'hero_bg' => '686ed215eb3db.png',
                'hero_section_title' => 'Repellendus Quis vo',
                'hero_section_bold_text' => null,
                'hero_section_text' => 'Repellendus Quis vo',
                'hero_section_button_text' => 'Quick View',
                'hero_section_button_url' => 'http://127.0.0.1:8000/admins/herosection/static?language=en',
                'hero_section_video_link' => null,
                'intro_bg' => '686ed64404c60.jpg',
                'intro_section_text' => 'Text WDSD',
                'intro_section_button_text' => 'Button Text',
                'intro_section_button_url' => 'http://127.0.0.1:8000/admins/introsection?language=en',
                'intro_section_video_link' => 'http://127.0.0.1:8000/admins/introsection?language=en',
                'intro_section_scrolling_text' => 'Digital Agency Solutions for Your Business',
                'intro_section_title' => 'Social marketing',
                'scrolling_text' => null,
                'service_section_title' => 'Full-Service2',
                'pricing_section_title' => 'How do you determine your hourly rates?',
                'pricing_section_link' => 'http://127.0.0.1:8000/admins/pricingsection?language=en',
                'pricing_section_subtitle' => 'Our hourly rates are based on the level of expertise required for each service, as well as the market rates for digital services in our area.',
                'service_section_subtitle' => 'Our work process may vary depending on the specific project and client needs',
                'approach_title' => 'Our Approach',
                'approach_subtitle' => 'Expertise in Strategy, Design and Development',
                'approach_button_text' => 'Learn More',
                'approach_button_url' => 'http://127.0.0.1:8000/admins/approach?language=en',
                'cta_bg' => '6846af663d671.jpg',
                'cta_section_text' => 'هل أنت مستعد للارتقاء بتجربة الشواء الخاصة بك؟',
                'cta_section_button_text' => 'كن مورداً2',
                'cta_section_button_url' => '#',
                'portfolio_section_title' => null,
                'portfolio_section_text' => null,
                'team_bg' => null,
                'team_section_title' => null,
                'team_section_subtitle' => null,
                'contact_form_title' => 'Get Quote',
                'contact_form_subtitle' => 'Get Quote',
                'quote_title' => 'Quote',
                'quote_subtitle' => 'Quote',
                'tawk_to_script' => null,
                'google_analytics_script' => null,
                'is_recaptcha' => 0,
                'google_recaptcha_site_key' => null,
                'google_recaptcha_secret_key' => null,
                'is_tawkto' => 1,
                'is_disqus' => 1,
                'disqus_script' => null,
                'is_analytics' => 1,
                'maintainance_mode' => 0,
                'maintainance_text' => null,
                'secret_path' => null,
                'is_appzi' => 0,
                'appzi_script' => null,
                'is_addthis' => 0,
                'addthis_script' => null,
                'service_title' => 'Service',
                'service_subtitle' => 'Service',
                'service_shape_image' => null,
                'portfolio_title' => 'Portfolio',
                'portfolio_subtitle' => 'Portfolio',
                'testimonial_title' => 'Testmonial2',
                'testimonial_subtitle' => 'Testmonial',
                'blog_section_title' => 'Blogs2',
                'blog_section_subtitle' => 'Blogg',
                'faq_title' => 'FAQ',
                'faq_subtitle' => 'FAQ',
                'blog_title' => 'Blog',
                'blog_subtitle' => 'Blog',
                'service_details_title' => 'Service',
                'portfolio_details_title' => 'Portfolio Details',
                'blog_details_title' => 'Blog Details',
                'gallery_title' => 'Gallery',
                'gallery_subtitle' => 'Gallery',
                'team_title' => 'Team',
                'team_subtitle' => 'Team',
                'contact_title' => 'Contact',
                'contact_subtitle' => 'Contact',
                'error_title' => 'Error Page',
                'error_subtitle' => 'Error Page',
                'is_quote' => 1,
                'event_title' => 'Event',
                'event_subtitle' => 'Event',
                'event_details_title' => 'Event Details',
                'cause_title' => 'Cause',
                'cause_subtitle' => 'Cause',
                'cause_details_title' => 'Cause Details',
                'home_version' => 'static',
                'feature_section' => 1,
                'intro_section' => 1,
                'service_section' => 1,
                'approach_section' => 1,
                'statistics_section' => 1,
                'portfolio_section' => 1,
                'testimonial_section' => 1,
                'team_section' => 1,
                'news_section' => 1,
                'call_to_action_section' => 1,
                'partner_section' => 1,
                'top_footer_section' => 1,
                'copyright_section' => 1,
                'newsletter_section' => 1,
                'faq_section_title' => null,
                'faq_section_text' => null,
                'faq_section_button_text' => null,
                'how_we_do_it_title' => null,
            ]
        ];

        // Clear existing data and insert new data
        DB::table("{$connection}_basic_settings")->truncate();
        DB::table("{$connection}_basic_settings")->insert($basicSettingsData);
        
        $this->command->info("Seeded basic_settings for tenant connection: {$connection}");
    }

    /**
     * Seed basic_settings_extended table
     */
    private function seedBasicSettingsExtended(string $connection): void
    {
        if (!Schema::hasTable("{$connection}_basic_settings_extended")) {
            $this->command->warn("Table basic_settings_extended does not exist in {$connection}");
            return;
        }

        $extendedSettingsData = [
            [
                'id' => 1,
                'language_id' => 1,
                'pricing_title' => 'Pricing',
                'pricing_subtitle' => 'Pricing',
                'cookie_alert_status' => 1,
                'cookie_alert_text' => null,
                'cookie_alert_button_text' => null,
                'to_mail' => null,
                'career_title' => 'Career',
                'career_subtitle' => 'Career',
                'event_calendar_title' => 'Event Calendar',
                'event_calendar_subtitle' => 'Event Calendar',
                'rss_title' => 'RSS',
                'rss_subtitle' => 'RSS',
                'rss_details_title' => 'Blog Details',
                'default_language_direction' => 'ltr',
                'home_meta_keywords' => null,
                'home_meta_description' => null,
                'services_meta_keywords' => null,
                'services_meta_description' => null,
                'packages_meta_keywords' => null,
                'packages_meta_description' => null,
                'portfolios_meta_keywords' => null,
                'portfolios_meta_description' => null,
                'team_meta_keywords' => null,
                'team_meta_description' => null,
                'career_meta_keywords' => null,
                'career_meta_description' => null,
                'calendar_meta_keywords' => null,
                'calendar_meta_description' => null,
                'gallery_meta_keywords' => null,
                'gallery_meta_description' => null,
                'faq_meta_keywords' => null,
                'faq_meta_description' => null,
                'blogs_meta_keywords' => null,
                'blogs_meta_description' => null,
                'rss_meta_keywords' => null,
                'rss_meta_description' => null,
                'contact_meta_keywords' => null,
                'contact_meta_description' => null,
                'quote_meta_keywords' => null,
                'quote_meta_description' => null,
                'is_facebook_pexel' => 0,
                'facebook_pexel_script' => null,
                'theme_version' => 'default',
                'hero_overlay_color' => null,
                'hero_overlay_opacity' => null,
                'statistics_overlay_color' => null,
                'statistics_overlay_opacity' => null,
                'team_overlay_color' => null,
                'team_overlay_opacity' => null,
                'cta_overlay_color' => null,
                'cta_overlay_opacity' => null,
                'intro_overlay_color' => null,
                'intro_overlay_opacity' => null,
                'pricing_overlay_color' => null,
                'pricing_overlay_opacity' => null,
                'breadcrumb_overlay_color' => null,
                'breadcrumb_overlay_opacity' => null,
                'from_mail' => null,
                'from_name' => null,
                'is_smtp' => 0,
                'smtp_host' => null,
                'smtp_port' => null,
                'encryption' => null,
                'smtp_username' => null,
                'smtp_password' => null,
                'popular_tags' => null,
                'hero_section_title_font_size' => 14,
                'hero_section_bold_text_font_size' => null,
                'hero_section_bold_text_color' => null,
                'hero_section_text_font_size' => 12,
                'hero_section_button_text_font_size' => 14,
                'statistics_bg' => '685a7c4acad8f.jpg',
                'product_title' => 'Product',
                'product_subtitle' => 'Product',
                'product_details_title' => 'Product Details',
                'cart_title' => 'Cart',
                'cart_subtitle' => 'Cart',
                'checkout_title' => 'Checkout',
                'checkout_subtitle' => 'Checkout',
                'package_background' => null,
                'intro_bg2' => '686ed6440615f.jpg',
                'products_meta_keywords' => null,
                'products_meta_description' => null,
                'cart_meta_keywords' => null,
                'cart_meta_description' => null,
                'checkout_meta_keywords' => null,
                'checkout_meta_description' => null,
                'login_meta_keywords' => null,
                'login_meta_description' => null,
                'register_meta_keywords' => null,
                'register_meta_description' => null,
                'forgot_meta_keywords' => null,
                'forgot_meta_description' => null,
                'events_meta_keywords' => null,
                'events_meta_description' => null,
                'causes_meta_keywords' => null,
                'causes_meta_description' => null,
                'pricing_section' => 1,
                'categories_section' => 1,
                'featured_products_section' => 1,
                'category_products_section' => 1,
                'hero_section_text2' => 'sds',
                'hero_section_text3' => 'adsds',
                'hero_bg2' => null,
                'free_analysis_meta_keywords' => 'free analysis, seo analysis, website analysis, seo tools',
                'free_analysis_meta_description' => 'Get a free comprehensive SEO analysis of your website. Analyze performance, meta tags, and get actionable insights.',
                'free_analysis_hero_subtitle' => 'Get Solid Solution',
                'free_analysis_hero_title_1' => 'Reliable &',
                'free_analysis_hero_title_2' => 'Secure',
                'free_analysis_hero_title_3' => 'IT Services.',
                'free_analysis_hero_description' => 'Best solutions for big data & Technology services',
                'free_analysis_hero_button_1_text' => 'Our all Services',
                'free_analysis_hero_button_1_url' => '/services',
                'free_analysis_hero_button_2_text' => 'Contact us',
                'free_analysis_hero_button_2_url' => '/contact',
                'free_analysis_form_placeholder' => 'Enter your website link',
                'free_analysis_form_button_text' => 'Analyze',
                'free_analysis_step_subtitle' => 'How we works',
                'free_analysis_step_title' => 'Transforming IT, One Step at a Time',
                'free_analysis_step_description' => 'Every business is unique, and so are our solutions. Here\'s how we tailor our expertise to your needs',
                'free_analysis_step_1_title' => 'Discovery',
                'free_analysis_step_1_description' => 'Leveraging our findings, we craft a comprehensive IT plan. This involves designing systems, networks, and software that align with your business goals.',
                'free_analysis_hero_shape_1' => 'front/assets/img/home-11/hero/hero-shape-1.png',
                'free_analysis_hero_shape_2' => 'front/assets/img/home-11/hero/hero-shape-2.png',
                'free_analysis_hero_shape_3' => 'front/assets/img/home-11/hero/hero-shape-3.png',
                'free_analysis_hero_shape_4' => 'front/assets/img/home-11/hero/hero-shape-4.png',
                'free_analysis_hero_thumb' => 'front/assets/img/home-11/hero/hero-thumb.png',
                'free_analysis_step_about_1' => 'front/assets/img/home-11/step/about-1.jpg',
                'free_analysis_step_shape_1' => 'front/assets/img/home-11/step/about-shape-1.jpg',
                'free_analysis_step_shape_2' => 'front/assets/img/home-11/step/about-shape-2.png',
                'free_analysis_step_shape_3' => 'front/assets/img/home-11/step/about-shape-3.png',
                'free_analysis_step_shape_4' => 'front/assets/img/home-11/step/about-shape-4.png',
                'free_analysis_primary_color' => '#00a651',
                'free_analysis_secondary_color' => '#007bff',
                'free_analysis_accent_color' => '#ffc107',
                'free_analysis_text_color' => '#333333',
                'free_analysis_background_color' => '#ffffff',
                'free_analysis_features_title' => null,
                'free_analysis_features_subtitle' => null,
                'free_analysis_feature_1_title' => null,
                'free_analysis_feature_1_description' => null,
                'free_analysis_feature_2_title' => null,
                'free_analysis_feature_2_description' => null,
                'free_analysis_feature_3_title' => null,
                'free_analysis_feature_3_description' => null,
                'free_analysis_footer_text' => null,
                'free_analysis_footer_description' => null,
                'free_analysis_enable_analytics' => 0,
                'free_analysis_google_analytics_id' => null,
                'free_analysis_facebook_pixel_id' => null,
                'free_analysis_show_breadcrumb' => 0,
                'free_analysis_show_sidebar' => 0,
                'free_analysis_page_layout' => 'full-width',
                'free_analysis_form_title' => null,
                'free_analysis_form_subtitle' => null,
                'free_analysis_form_label' => null,
                'free_analysis_form_help' => null,
                'free_analysis_feature_1_desc' => null,
                'free_analysis_feature_2_desc' => null,
                'free_analysis_feature_3_desc' => null,
                'free_analysis_feature_card_1_title' => null,
                'free_analysis_feature_card_1_desc' => null,
                'free_analysis_feature_card_2_title' => null,
                'free_analysis_feature_card_2_desc' => null,
                'free_analysis_feature_card_3_title' => null,
                'free_analysis_feature_card_3_desc' => null,
                'free_analysis_feature_card_4_title' => null,
                'free_analysis_feature_card_4_desc' => null,
                'free_analysis_feature_card_5_title' => null,
                'free_analysis_feature_card_5_desc' => null,
                'free_analysis_feature_card_6_title' => null,
                'free_analysis_feature_card_6_desc' => null,
            ]
        ];

        // Clear existing data and insert new data
        DB::table("{$connection}_basic_settings_extended")->truncate();
        DB::table("{$connection}_basic_settings_extended")->insert($extendedSettingsData);
        
        $this->command->info("Seeded basic_settings_extended for tenant connection: {$connection}");
    }

    /**
     * Seed basic_settings_extra table
     */
    private function seedBasicSettingsExtra(string $connection): void
    {
        if (!Schema::hasTable("{$connection}_basic_settings_extra")) {
            $this->command->warn("Table basic_settings_extra does not exist in {$connection}");
            return;
        }

        $extraSettingsData = [
            [
                'id' => 1,
                'language_id' => 1,
                'is_shop' => 1,
                'is_ticket' => 1,
                'is_user_panel' => 1,
                'base_currency_symbol' => null,
                'base_currency_symbol_position' => 'left',
                'base_currency_text' => null,
                'base_currency_text_position' => 'right',
                'base_currency_rate' => 0.00,
                'client_feedback_title' => '',
                'client_feedback_subtitle' => '',
                'course_title' => null,
                'course_subtitle' => null,
                'course_details_title' => null,
                'contact_addresses' => null,
                'contact_numbers' => null,
                'contact_mails' => null,
                'faq_category_status' => 1,
                'gallery_category_status' => 1,
                'package_category_status' => 1,
                'faq_section_title' => null,
                'faq_section_text' => null,
                'faq_section_button_text' => null,
                'faq_section_button_url' => null,
                'faq_bg' => null,
                'faq_bg2' => null,
                'faq_section' => 1,
                'nav_tab_section' => 1,
                'comparison_section' => 1,
                'nav_tab_section' => 1,
                'nav_tab' => '',
                'comparison_title' => null,
                'comparison_subtitle' => null,
                'comparison_col1_title' => null,
                'comparison_col1_features' => null,
                'comparison_col2_title' => null,
                'comparison_col2_features' => null,
                'comparison_col3_title' => null,
                'comparison_col3_features' => null,
                'comparison_css' => null,
                'course_title' => null,
                'course_subtitle' => null,
                'course_details_title' => null,
                'contact_addresses' => null,
                'contact_numbers' => null,
                'contact_mails' => null,
                // 'map_address' => null,
                'comparison_table' => null,
                'tags_meta_keywords' => null,
                'tags_meta_description' => null,
                'tags_title' => null,
                'tags_subtitle' => null,
                'comparison_title' => null,
                'comparison_subtitle' => null,
                'comparison_col1_title' => null,
                'comparison_col1_features' => null,
                'comparison_col2_title' => null,
                'comparison_col2_features' => null,
                'comparison_col3_title' => null,
                'comparison_col3_features' => null,
                'comparison_css' => null,
                'package_banner_image' => ,
            ]
        ];

        // Clear existing data and insert new data
        DB::table("{$connection}_basic_settings_extra")->truncate();
        DB::table("{$connection}_basic_settings_extra")->insert($extraSettingsData);
        
        $this->command->info("Seeded basic_settings_extra for tenant connection: {$connection}");
    }
}
