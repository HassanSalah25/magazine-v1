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
            //
            $table->string('ourstory_page_image')->nullable();
            $table->string('ourstory_page_image2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            //
            $table->dropColumn('ourstory_page_image');
            $table->dropColumn('ourstory_page_image2');
        });
    }
};
