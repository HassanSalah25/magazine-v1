<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            // Meta fields
            $table->text('free_analysis_meta_keywords')->nullable();
            $table->text('free_analysis_meta_description')->nullable();
            
            // Hero section fields
            $table->string('free_analysis_hero_subtitle')->nullable();
            $table->string('free_analysis_hero_title_1')->nullable();
            $table->string('free_analysis_hero_title_2')->nullable();
            $table->string('free_analysis_hero_title_3')->nullable();
            $table->text('free_analysis_hero_description')->nullable();
            $table->string('free_analysis_hero_button_1_text')->nullable();
            $table->string('free_analysis_hero_button_1_url')->nullable();
            $table->string('free_analysis_hero_button_2_text')->nullable();
            $table->string('free_analysis_hero_button_2_url')->nullable();
            $table->string('free_analysis_form_placeholder')->nullable();
            $table->string('free_analysis_form_button_text')->nullable();
            
            // Step section fields
            $table->string('free_analysis_step_subtitle')->nullable();
            $table->string('free_analysis_step_title')->nullable();
            $table->text('free_analysis_step_description')->nullable();
            $table->string('free_analysis_step_1_title')->nullable();
            $table->text('free_analysis_step_1_description')->nullable();
            
            // Color customization fields
            $table->string('free_analysis_primary_color')->default('#00a651');
            $table->string('free_analysis_secondary_color')->default('#007bff');
            $table->string('free_analysis_accent_color')->default('#ffc107');
            $table->string('free_analysis_text_color')->default('#333333');
            $table->string('free_analysis_background_color')->default('#ffffff');
            
            // Additional content fields
            $table->text('free_analysis_features_title')->nullable();
            $table->text('free_analysis_features_subtitle')->nullable();
            $table->text('free_analysis_feature_1_title')->nullable();
            $table->text('free_analysis_feature_1_description')->nullable();
            $table->text('free_analysis_feature_2_title')->nullable();
            $table->text('free_analysis_feature_2_description')->nullable();
            $table->text('free_analysis_feature_3_title')->nullable();
            $table->text('free_analysis_feature_3_description')->nullable();
            
            // Footer section
            $table->text('free_analysis_footer_text')->nullable();
            $table->text('free_analysis_footer_description')->nullable();
            
            // SEO and performance
            $table->boolean('free_analysis_enable_analytics')->default(true);
            $table->text('free_analysis_google_analytics_id')->nullable();
            $table->text('free_analysis_facebook_pixel_id')->nullable();
            
            // Page settings
            $table->boolean('free_analysis_show_breadcrumb')->default(true);
            $table->boolean('free_analysis_show_sidebar')->default(false);
            $table->string('free_analysis_page_layout')->default('full-width');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->dropColumn([
                'free_analysis_meta_keywords',
                'free_analysis_meta_description',
                'free_analysis_hero_subtitle',
                'free_analysis_hero_title_1',
                'free_analysis_hero_title_2',
                'free_analysis_hero_title_3',
                'free_analysis_hero_description',
                'free_analysis_hero_button_1_text',
                'free_analysis_hero_button_1_url',
                'free_analysis_hero_button_2_text',
                'free_analysis_hero_button_2_url',
                'free_analysis_form_placeholder',
                'free_analysis_form_button_text',
                'free_analysis_step_subtitle',
                'free_analysis_step_title',
                'free_analysis_step_description',
                'free_analysis_step_1_title',
                'free_analysis_step_1_description',
                'free_analysis_primary_color',
                'free_analysis_secondary_color',
                'free_analysis_accent_color',
                'free_analysis_text_color',
                'free_analysis_background_color',
                'free_analysis_features_title',
                'free_analysis_features_subtitle',
                'free_analysis_feature_1_title',
                'free_analysis_feature_1_description',
                'free_analysis_feature_2_title',
                'free_analysis_feature_2_description',
                'free_analysis_feature_3_title',
                'free_analysis_feature_3_description',
                'free_analysis_footer_text',
                'free_analysis_footer_description',
                'free_analysis_enable_analytics',
                'free_analysis_google_analytics_id',
                'free_analysis_facebook_pixel_id',
                'free_analysis_show_breadcrumb',
                'free_analysis_show_sidebar',
                'free_analysis_page_layout'
            ]);
        });
    }
};
