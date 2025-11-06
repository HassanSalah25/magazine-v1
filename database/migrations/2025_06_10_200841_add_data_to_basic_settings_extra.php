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
            $table->string('tags_meta_keywords')->nullable();
            $table->string('tags_meta_description')->nullable();
            $table->string('tags_title')->nullable();
            $table->string('tags_subtitle')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            //
            $table->dropColumn('tags_meta_keywords');
            $table->dropColumn('tags_meta_description');
            $table->dropColumn('tags_title');
            $table->dropColumn('tags_subtitle');

        });
    }
};
