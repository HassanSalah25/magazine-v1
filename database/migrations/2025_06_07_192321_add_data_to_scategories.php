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
            //
            $table->string('slug', 255)->nullable()->after('serial_number');
            $table->string('redirect_url')->nullable()->after('slug');
            $table->boolean('is_indexed')->nullable()->after('redirect_url');
            $table->dateTime('publish_data')->nullable()->after('is_indexed');
            $table->string('canonical')->nullable()->after('publish_data');
            $table->string('meta_title', 255)->nullable()->after('canonical');
            $table->text('meta_keywords')->nullable()->after('meta_title');
            $table->text('meta_description')->nullable()->after('meta_keywords');
            $table->foreignId('parent_id')->nullable()->constrained('scategories')->after('meta_description');
            $table->binary('content')->nullable()->after('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scategories', function (Blueprint $table) {
            //
            $table->dropColumn('slug');
            $table->dropColumn('redirect_url');
            $table->dropColumn('is_indexed');
            $table->dropColumn('publish_data');
            $table->dropColumn('canonical');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_description');
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
            $table->dropColumn('content');
        });
    }
};
