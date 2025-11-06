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
            $table->string('faq_section_title')->nullable();
            $table->string('faq_section_text')->nullable();
            $table->string('faq_section_button_text')->nullable();
            $table->string('faq_section_button_url')->nullable();
            $table->string('faq_bg')->nullable();
            $table->string('faq_bg2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            $table->dropColumn('faq_section_title');
            $table->dropColumn('faq_section_text');
            $table->dropColumn('faq_section_button_text');
            $table->dropColumn('faq_section_button_url');
            $table->dropColumn('faq_bg');
            $table->dropColumn('faq_bg2');
        });
    }
};
