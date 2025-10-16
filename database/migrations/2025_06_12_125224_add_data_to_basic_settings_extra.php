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
            $table->string('faq_section')->default('0');
            $table->string('nav_tab_section')->default('0');
            $table->string('comparison_section')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            //
        });
    }
};
