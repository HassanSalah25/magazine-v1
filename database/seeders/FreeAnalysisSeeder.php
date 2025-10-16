<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BasicExtended;
use App\Models\Language;

class FreeAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::all();
        
        foreach ($languages as $language) {
            $basicExtended = BasicExtended::where('language_id', $language->id)->first();
            
            if ($basicExtended) {
                // Only update if the fields are null (not already set)
                if (is_null($basicExtended->free_analysis_meta_keywords)) {
                    $basicExtended->free_analysis_meta_keywords = 'free analysis, seo analysis, website analysis, seo tools';
                }
                
                if (is_null($basicExtended->free_analysis_meta_description)) {
                    $basicExtended->free_analysis_meta_description = 'Get a free comprehensive SEO analysis of your website. Analyze performance, meta tags, and get actionable insights.';
                }
                
                if (is_null($basicExtended->free_analysis_hero_subtitle)) {
                    $basicExtended->free_analysis_hero_subtitle = 'Get Solid Solution';
                }
                
                if (is_null($basicExtended->free_analysis_hero_title_1)) {
                    $basicExtended->free_analysis_hero_title_1 = 'Reliable &';
                }
                
                if (is_null($basicExtended->free_analysis_hero_title_2)) {
                    $basicExtended->free_analysis_hero_title_2 = 'Secure Managed';
                }
                
                if (is_null($basicExtended->free_analysis_hero_title_3)) {
                    $basicExtended->free_analysis_hero_title_3 = 'IT Services.';
                }
                
                if (is_null($basicExtended->free_analysis_hero_description)) {
                    $basicExtended->free_analysis_hero_description = 'Best solutions for big data & Technology services';
                }
                
                if (is_null($basicExtended->free_analysis_hero_button_1_text)) {
                    $basicExtended->free_analysis_hero_button_1_text = 'Our all Services';
                }
                
                if (is_null($basicExtended->free_analysis_hero_button_1_url)) {
                    $basicExtended->free_analysis_hero_button_1_url = '/services';
                }
                
                if (is_null($basicExtended->free_analysis_hero_button_2_text)) {
                    $basicExtended->free_analysis_hero_button_2_text = 'Contact us';
                }
                
                if (is_null($basicExtended->free_analysis_hero_button_2_url)) {
                    $basicExtended->free_analysis_hero_button_2_url = '/contact';
                }
                
                if (is_null($basicExtended->free_analysis_form_placeholder)) {
                    $basicExtended->free_analysis_form_placeholder = 'Enter your website link';
                }
                
                if (is_null($basicExtended->free_analysis_form_button_text)) {
                    $basicExtended->free_analysis_form_button_text = 'Analyze';
                }
                
                if (is_null($basicExtended->free_analysis_step_subtitle)) {
                    $basicExtended->free_analysis_step_subtitle = 'How we works';
                }
                
                if (is_null($basicExtended->free_analysis_step_title)) {
                    $basicExtended->free_analysis_step_title = 'Transforming IT, One Step at a Time';
                }
                
                if (is_null($basicExtended->free_analysis_step_description)) {
                    $basicExtended->free_analysis_step_description = 'Every business is unique, and so are our solutions. Here\'s how we tailor our expertise to your needs';
                }
                
                if (is_null($basicExtended->free_analysis_step_1_title)) {
                    $basicExtended->free_analysis_step_1_title = 'Discovery';
                }
                
                if (is_null($basicExtended->free_analysis_step_1_description)) {
                    $basicExtended->free_analysis_step_1_description = 'Leveraging our findings, we craft a comprehensive IT plan. This involves designing systems, networks, and software that align with your business goals.';
                }
                
                // Color fields
                if (is_null($basicExtended->free_analysis_primary_color)) {
                    $basicExtended->free_analysis_primary_color = '#00a651';
                }
                
                if (is_null($basicExtended->free_analysis_secondary_color)) {
                    $basicExtended->free_analysis_secondary_color = '#007bff';
                }
                
                if (is_null($basicExtended->free_analysis_accent_color)) {
                    $basicExtended->free_analysis_accent_color = '#ffc107';
                }
                
                if (is_null($basicExtended->free_analysis_text_color)) {
                    $basicExtended->free_analysis_text_color = '#333333';
                }
                
                if (is_null($basicExtended->free_analysis_background_color)) {
                    $basicExtended->free_analysis_background_color = '#ffffff';
                }
                
                // Additional content fields
                if (is_null($basicExtended->free_analysis_features_title)) {
                    $basicExtended->free_analysis_features_title = 'Why Choose Our SEO Analysis Tool?';
                }
                
                if (is_null($basicExtended->free_analysis_features_subtitle)) {
                    $basicExtended->free_analysis_features_subtitle = 'Comprehensive analysis with actionable insights';
                }
                
                if (is_null($basicExtended->free_analysis_feature_1_title)) {
                    $basicExtended->free_analysis_feature_1_title = 'Comprehensive Analysis';
                }
                
                if (is_null($basicExtended->free_analysis_feature_1_description)) {
                    $basicExtended->free_analysis_feature_1_description = 'Get detailed insights into your website\'s SEO performance, including meta tags, content analysis, and technical issues.';
                }
                
                if (is_null($basicExtended->free_analysis_feature_2_title)) {
                    $basicExtended->free_analysis_feature_2_title = 'Performance Metrics';
                }
                
                if (is_null($basicExtended->free_analysis_feature_2_description)) {
                    $basicExtended->free_analysis_feature_2_description = 'Analyze page speed, mobile responsiveness, and Core Web Vitals to improve user experience.';
                }
                
                if (is_null($basicExtended->free_analysis_feature_3_title)) {
                    $basicExtended->free_analysis_feature_3_title = 'Actionable Recommendations';
                }
                
                if (is_null($basicExtended->free_analysis_feature_3_description)) {
                    $basicExtended->free_analysis_feature_3_description = 'Receive specific, actionable recommendations to improve your website\'s search engine rankings.';
                }
                
                // Footer fields
                if (is_null($basicExtended->free_analysis_footer_text)) {
                    $basicExtended->free_analysis_footer_text = 'Ready to improve your website\'s SEO?';
                }
                
                if (is_null($basicExtended->free_analysis_footer_description)) {
                    $basicExtended->free_analysis_footer_description = 'Start your free analysis today and get detailed insights to boost your search engine rankings.';
                }
                
                // Analytics fields
                if (is_null($basicExtended->free_analysis_enable_analytics)) {
                    $basicExtended->free_analysis_enable_analytics = true;
                }
                
                if (is_null($basicExtended->free_analysis_google_analytics_id)) {
                    $basicExtended->free_analysis_google_analytics_id = '';
                }
                
                if (is_null($basicExtended->free_analysis_facebook_pixel_id)) {
                    $basicExtended->free_analysis_facebook_pixel_id = '';
                }
                
                // Page settings
                if (is_null($basicExtended->free_analysis_show_breadcrumb)) {
                    $basicExtended->free_analysis_show_breadcrumb = true;
                }
                
                if (is_null($basicExtended->free_analysis_show_sidebar)) {
                    $basicExtended->free_analysis_show_sidebar = false;
                }
                
                if (is_null($basicExtended->free_analysis_page_layout)) {
                    $basicExtended->free_analysis_page_layout = 'full-width';
                }
                
                // Set default image paths
                if (is_null($basicExtended->free_analysis_hero_shape_1)) {
                    $basicExtended->free_analysis_hero_shape_1 = 'front/assets/img/home-11/hero/hero-shape-1.png';
                }
                
                if (is_null($basicExtended->free_analysis_hero_shape_2)) {
                    $basicExtended->free_analysis_hero_shape_2 = 'front/assets/img/home-11/hero/hero-shape-2.png';
                }
                
                if (is_null($basicExtended->free_analysis_hero_shape_3)) {
                    $basicExtended->free_analysis_hero_shape_3 = 'front/assets/img/home-11/hero/hero-shape-3.png';
                }
                
                if (is_null($basicExtended->free_analysis_hero_shape_4)) {
                    $basicExtended->free_analysis_hero_shape_4 = 'front/assets/img/home-11/hero/hero-shape-4.png';
                }
                
                if (is_null($basicExtended->free_analysis_hero_thumb)) {
                    $basicExtended->free_analysis_hero_thumb = 'front/assets/img/home-11/hero/hero-thumb.png';
                }
                
                if (is_null($basicExtended->free_analysis_step_about_1)) {
                    $basicExtended->free_analysis_step_about_1 = 'front/assets/img/home-11/step/about-1.jpg';
                }
                
                if (is_null($basicExtended->free_analysis_step_shape_1)) {
                    $basicExtended->free_analysis_step_shape_1 = 'front/assets/img/home-11/step/about-shape-1.jpg';
                }
                
                if (is_null($basicExtended->free_analysis_step_shape_2)) {
                    $basicExtended->free_analysis_step_shape_2 = 'front/assets/img/home-11/step/about-shape-2.png';
                }
                
                if (is_null($basicExtended->free_analysis_step_shape_3)) {
                    $basicExtended->free_analysis_step_shape_3 = 'front/assets/img/home-11/step/about-shape-3.png';
                }
                
                if (is_null($basicExtended->free_analysis_step_shape_4)) {
                    $basicExtended->free_analysis_step_shape_4 = 'front/assets/img/home-11/step/about-shape-4.png';
                }
                
                // --- New dynamic fields ---
                if (is_null($basicExtended->free_analysis_form_title)) {
                    $basicExtended->free_analysis_form_title = 'تحليل موقعك الآن';
                }
                if (is_null($basicExtended->free_analysis_form_subtitle)) {
                    $basicExtended->free_analysis_form_subtitle = 'احصل على تحليل شامل ومجاني لموقعك الإلكتروني';
                }
                if (is_null($basicExtended->free_analysis_form_label)) {
                    $basicExtended->free_analysis_form_label = 'رابط موقعك الإلكتروني';
                }
                if (is_null($basicExtended->free_analysis_form_help)) {
                    $basicExtended->free_analysis_form_help = 'أدخل الرابط الكامل للموقع الذي تريد تحليله';
                }
                if (is_null($basicExtended->free_analysis_feature_1_desc)) {
                    $basicExtended->free_analysis_feature_1_desc = 'تحليل آمن 100%';
                }
                if (is_null($basicExtended->free_analysis_feature_2_desc)) {
                    $basicExtended->free_analysis_feature_2_desc = 'نتائج فورية';
                }
                if (is_null($basicExtended->free_analysis_feature_3_desc)) {
                    $basicExtended->free_analysis_feature_3_desc = 'جميع عناصر SEO';
                }
                // Feature cards (6)
                $featureCardDefaults = [
                    1 => ['سرعة الموقع', 'تحليل شامل لسرعة تحميل الموقع باستخدام Google PageSpeed Insights'],
                    2 => ['العلامات الوصفية', 'فحص العناوين والأوصاف والكلمات المفتاحية والعلامات الوصفية'],
                    3 => ['تحليل الروابط', 'فحص الروابط الداخلية والخارجية والروابط المعطلة'],
                    4 => ['تحليل الصور', 'فحص الصور والنصوص البديلة وأبعاد الصور'],
                    5 => ['هيكل العناوين', 'تحليل هيكل العناوين H1-H6 وتنظيم المحتوى'],
                    6 => ['وسائل التواصل', 'فحص علامات Open Graph وTwitter Cards'],
                ];
                for ($i = 1; $i <= 6; $i++) {
                    $titleField = "free_analysis_feature_card_{$i}_title";
                    $descField = "free_analysis_feature_card_{$i}_desc";
                    if (is_null($basicExtended->$titleField)) {
                        $basicExtended->$titleField = $featureCardDefaults[$i][0];
                    }
                    if (is_null($basicExtended->$descField)) {
                        $basicExtended->$descField = $featureCardDefaults[$i][1];
                    }
                }
                
                $basicExtended->save();
            }
        }
    }
}
