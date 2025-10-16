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
            Schema::table('basic_settings_extra', function (Blueprint $table) {
                $table->longText('nav_tab')->change(); // You can also use ->mediumText() if it's super huge
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            $table->string('nav_tab', 255)->change(); // Rollback to original
        });
    }
};
