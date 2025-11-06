<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ConvertExistingSlugsToLowercase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Convert all existing slugs to lowercase in various tables
        $tables = [
            'articles' => 'slug',
            'blogs' => 'slug',
            'services' => 'slug',
            'portfolios' => 'slug',
            'products' => 'slug',
            'courses' => 'slug',
            'events' => 'slug',
            'jobs' => 'slug',
            'causes' => 'slug',
            'pages' => 'slug',
            'packages' => 'slug',
            'scategories' => 'slug',
            'bcategories' => 'slug',
            'pcategories' => 'slug',
            'ecategories' => 'slug',
            'ccategories' => 'slug',
            'gcategories' => 'slug',
            'jcategories' => 'slug',
            'fcategories' => 'slug',
            'kcategories' => 'slug',
        ];

        foreach ($tables as $table => $column) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                try {
                    DB::statement("UPDATE {$table} SET {$column} = LOWER({$column}) WHERE {$column} IS NOT NULL");
                } catch (Exception $e) {
                    // Table or column might not exist, continue
                    continue;
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration is not reversible as we can't determine the original case
        // of the slugs that were converted to lowercase
    }
}
