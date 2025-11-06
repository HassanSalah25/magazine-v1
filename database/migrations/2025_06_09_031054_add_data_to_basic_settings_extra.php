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
            $table->string('our_story_meta_keywords')->nullable()->after('push_notification_icon');
            $table->string('our_story_meta_description')->nullable()->after('our_story_meta_keywords');
            $table->string('our_story_title')->nullable()->after('our_story_meta_description');
            $table->string('our_story_subtitle')->nullable()->after('our_story_title');
            $table->string('our_story_image')->nullable()->after('our_story_subtitle');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_settings_extra', function (Blueprint $table) {
            //
            $table->dropColumn('our_story_meta_keywords');
            $table->dropColumn('our_story_meta_description');
            $table->dropColumn('our_story_title');
            $table->dropColumn('our_story_subtitle');
            $table->dropColumn('our_story_image');
        });
    }
};
