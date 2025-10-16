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
        Schema::table('scategories', function (Blueprint $table) {
            // Change video_link from string to text to accommodate longer HTML content
            $table->text('video_link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scategories', function (Blueprint $table) {
            // Revert back to string (VARCHAR 255)
            $table->string('video_link')->nullable()->change();
        });
    }
};