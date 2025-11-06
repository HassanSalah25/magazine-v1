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
            // Color customization fields
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_primary_color')) {
                $table->string('free_analysis_primary_color')->default('#00a651');
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_secondary_color')) {
                $table->string('free_analysis_secondary_color')->default('#007bff');
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_accent_color')) {
                $table->string('free_analysis_accent_color')->default('#ffc107');
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_text_color')) {
                $table->string('free_analysis_text_color')->default('#333333');
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_background_color')) {
                $table->string('free_analysis_background_color')->default('#ffffff');
            }
            
            // Additional content fields
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_features_title')) {
                $table->text('free_analysis_features_title')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_features_subtitle')) {
                $table->text('free_analysis_features_subtitle')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_1_title')) {
                $table->text('free_analysis_feature_1_title')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_1_description')) {
                $table->text('free_analysis_feature_1_description')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_2_title')) {
                $table->text('free_analysis_feature_2_title')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_2_description')) {
                $table->text('free_analysis_feature_2_description')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_3_title')) {
                $table->text('free_analysis_feature_3_title')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_3_description')) {
                $table->text('free_analysis_feature_3_description')->nullable();
            }
            
            // Footer section
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_footer_text')) {
                $table->text('free_analysis_footer_text')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_footer_description')) {
                $table->text('free_analysis_footer_description')->nullable();
            }
            
            // SEO and performance
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_enable_analytics')) {
                $table->boolean('free_analysis_enable_analytics')->default(true);
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_google_analytics_id')) {
                $table->text('free_analysis_google_analytics_id')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_facebook_pixel_id')) {
                $table->text('free_analysis_facebook_pixel_id')->nullable();
            }
            
            // Page settings
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_show_breadcrumb')) {
                $table->boolean('free_analysis_show_breadcrumb')->default(true);
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_show_sidebar')) {
                $table->boolean('free_analysis_show_sidebar')->default(false);
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_page_layout')) {
                $table->string('free_analysis_page_layout')->default('full-width');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $columns = [
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
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('basic_settings_extended', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
