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
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            // Comparison section fields
            $table->string('comparison_title')->nullable();
            $table->string('comparison_subtitle')->nullable();
            
            // Column 1 fields
            $table->string('comparison_col1_title')->nullable();
            $table->json('comparison_col1_features')->nullable(); // Array of features with checkmarks
            
            // Column 2 fields
            $table->string('comparison_col2_title')->nullable();
            $table->json('comparison_col2_features')->nullable(); // Array of features with checkmarks/x marks
            
            // Column 3 fields
            $table->string('comparison_col3_title')->nullable();
            $table->json('comparison_col3_features')->nullable(); // Array of features with checkmarks/x marks
            
            // CSS field
            $table->text('comparison_css')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            $table->dropColumn([
                'comparison_title',
                'comparison_subtitle',
                'comparison_col1_title',
                'comparison_col1_features',
                'comparison_col2_title',
                'comparison_col2_features',
                'comparison_col3_title',
                'comparison_col3_features',
                'comparison_css'
            ]);
        });
    }
};
