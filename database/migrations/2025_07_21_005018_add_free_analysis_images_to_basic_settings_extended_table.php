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
            // Hero section images
            $table->string('free_analysis_hero_shape_1')->nullable();
            $table->string('free_analysis_hero_shape_2')->nullable();
            $table->string('free_analysis_hero_shape_3')->nullable();
            $table->string('free_analysis_hero_shape_4')->nullable();
            $table->string('free_analysis_hero_thumb')->nullable();
            
            // Step section images
            $table->string('free_analysis_step_about_1')->nullable();
            $table->string('free_analysis_step_shape_1')->nullable();
            $table->string('free_analysis_step_shape_2')->nullable();
            $table->string('free_analysis_step_shape_3')->nullable();
            $table->string('free_analysis_step_shape_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extended', function (Blueprint $table) {
            $table->dropColumn([
                'free_analysis_hero_shape_1',
                'free_analysis_hero_shape_2',
                'free_analysis_hero_shape_3',
                'free_analysis_hero_shape_4',
                'free_analysis_hero_thumb',
                'free_analysis_step_about_1',
                'free_analysis_step_shape_1',
                'free_analysis_step_shape_2',
                'free_analysis_step_shape_3',
                'free_analysis_step_shape_4'
            ]);
        });
    }
};
