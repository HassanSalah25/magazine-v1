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
        Schema::table('services', function (Blueprint $table) {
            $table->string('redirect_url')->nullable()->after('meta_description');
            $table->boolean('is_indexed')->nullable()->after('redirect_url');
            $table->dateTime('publish_data')->nullable()->after('is_indexed');
            $table->string('canonical')->nullable()->after('publish_data');
            $table->string('meta_title', 255)->nullable()->after('canonical');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->dropColumn('redirect_url');
            $table->dropColumn('is_indexed');
            $table->dropColumn('publish_data');
            $table->dropColumn('canonical');
            $table->dropColumn('meta_title');

        });
    }
};
