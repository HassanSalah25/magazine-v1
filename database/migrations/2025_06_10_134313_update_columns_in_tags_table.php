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
        Schema::table('tags', function (Blueprint $table) {
            $table->string('image', 255)->nullable();
            $table->integer('serial_number')->default(0);
            $table->tinyInteger('feature')->default(0);
            $table->text('meta_keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            //
            $table->dropColumn('main_image');
            $table->dropColumn('serial_number');
            $table->dropColumn('feature');
            $table->dropColumn('meta_keywords');
        });
    }
};
