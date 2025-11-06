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
        Schema::table('partners', function (Blueprint $table) {
            $table->string('name')->nullable()->after('language_id');
            $table->text('description')->nullable()->after('name');
            $table->string('image_alt')->nullable()->after('image');
            $table->boolean('is_google_ads')->default(false)->after('serial_number');
            $table->string('google_ads_script')->nullable()->after('is_google_ads');
            $table->string('google_ads_placement')->nullable()->after('google_ads_script');
            $table->boolean('is_active')->default(true)->after('google_ads_placement');
            $table->timestamp('start_date')->nullable()->after('is_active');
            $table->timestamp('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'description', 
                'image_alt',
                'is_google_ads',
                'google_ads_script',
                'google_ads_placement',
                'is_active',
                'start_date',
                'end_date'
            ]);
        });
    }
};
