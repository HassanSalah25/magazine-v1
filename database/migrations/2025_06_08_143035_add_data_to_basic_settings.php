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
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->string('pricing_section_title')->nullable()->after('service_section_title');
            $table->string('pricing_section_subtitle')->nullable()->after('pricing_section_title');
            $table->string('pricing_section_link')->nullable()->after('pricing_section_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings', function (Blueprint $table) {
            $table->dropColumn('pricing_section_title');
            $table->dropColumn('pricing_section_subtitle');
            $table->dropColumn('pricing_section_link');
        });
    }
};
