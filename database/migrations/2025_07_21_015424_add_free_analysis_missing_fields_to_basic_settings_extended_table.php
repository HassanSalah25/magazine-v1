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
            // Analysis Form Section
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_form_title')) {
                $table->text('free_analysis_form_title')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_form_subtitle')) {
                $table->text('free_analysis_form_subtitle')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_form_label')) {
                $table->text('free_analysis_form_label')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_form_help')) {
                $table->text('free_analysis_form_help')->nullable();
            }

            // Feature Descriptions under form
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_1_desc')) {
                $table->text('free_analysis_feature_1_desc')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_2_desc')) {
                $table->text('free_analysis_feature_2_desc')->nullable();
            }
            if (!Schema::hasColumn('basic_settings_extended', 'free_analysis_feature_3_desc')) {
                $table->text('free_analysis_feature_3_desc')->nullable();
            }

            // Feature Cards (6 cards)
            for ($i = 1; $i <= 6; $i++) {
                if (!Schema::hasColumn('basic_settings_extended', "free_analysis_feature_card_{$i}_title")) {
                    $table->text("free_analysis_feature_card_{$i}_title")->nullable();
                }
                if (!Schema::hasColumn('basic_settings_extended', "free_analysis_feature_card_{$i}_desc")) {
                    $table->text("free_analysis_feature_card_{$i}_desc")->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $fields = [
                'free_analysis_form_title',
                'free_analysis_form_subtitle',
                'free_analysis_form_label',
                'free_analysis_form_help',
                'free_analysis_feature_1_desc',
                'free_analysis_feature_2_desc',
                'free_analysis_feature_3_desc',
            ];
            for ($i = 1; $i <= 6; $i++) {
                $fields[] = "free_analysis_feature_card_{$i}_title";
                $fields[] = "free_analysis_feature_card_{$i}_desc";
            }
            foreach ($fields as $field) {
                if (Schema::hasColumn('basic_settings_extended', $field)) {
                    $table->dropColumn($field);
                }
            }
        });
    }
};
