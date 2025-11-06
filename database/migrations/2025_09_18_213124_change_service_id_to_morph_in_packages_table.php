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
        Schema::table('packages', function (Blueprint $table) {
            // Add morph columns
            $table->unsignedBigInteger('serviceable_id')->nullable()->after('service_id');
            $table->string('serviceable_type')->nullable()->after('serviceable_id');
            
            // Add index for better performance
            $table->index(['serviceable_id', 'serviceable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Drop morph columns
            $table->dropIndex(['serviceable_id', 'serviceable_type']);
            $table->dropColumn(['serviceable_id', 'serviceable_type']);
        });
    }
};
