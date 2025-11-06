<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing service_id data to morph relation
        DB::table('packages')
            ->whereNotNull('service_id')
            ->update([
                'serviceable_id' => DB::raw('service_id'),
                'serviceable_type' => 'App\\Models\\Service'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear morph data
        DB::table('packages')
            ->where('serviceable_type', 'App\\Models\\Service')
            ->update([
                'serviceable_id' => null,
                'serviceable_type' => null
            ]);
    }
};
