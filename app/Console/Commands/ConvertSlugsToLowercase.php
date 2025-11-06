<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConvertSlugsToLowercase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slugs:convert-to-lowercase {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all existing slugs to lowercase in the database';

    /**
     * Tables and their slug columns to process
     * These are the actual tables that exist in the database with slug columns
     *
     * @var array
     */
    protected $tables = [
        'articles' => 'slug',
        'bcategories' => 'slug',
        'blogs' => 'slug',
        'courses' => 'slug',
        'donations' => 'slug',
        'event_categories' => 'slug',
        'events' => 'slug',
        'jobs' => 'slug',
        'pages' => 'slug',
        'pcategories' => 'slug',
        'portfolios' => 'slug',
        'products' => 'slug',
        'rss_posts' => 'slug',
        'scategories' => 'slug',
        'services' => 'slug',
        'tags' => 'slug',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
            $this->line('');
        } else {
            $this->info('🚀 Converting slugs to lowercase...');
            $this->line('');
        }

        $totalUpdated = 0;
        $totalTables = 0;
        $totalRecords = 0;

        foreach ($this->tables as $table => $column) {
            if (!Schema::hasTable($table)) {
                $this->warn("⚠️  Table '{$table}' does not exist, skipping...");
                continue;
            }

            if (!Schema::hasColumn($table, $column)) {
                $this->warn("⚠️  Column '{$column}' does not exist in table '{$table}', skipping...");
                continue;
            }

            $totalTables++;

            try {
                // Count total records with non-null slugs
                $totalSlugRecords = DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, '!=', '')
                    ->count();

                if ($totalSlugRecords == 0) {
                    $this->line("📊 Table '{$table}': No slug records found");
                    continue;
                }

                // Count records that need conversion (have uppercase letters)
                $recordsToUpdate = DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, '!=', '')
                    ->whereRaw("BINARY {$column} != BINARY LOWER({$column})")
                    ->count();

                $totalRecords += $totalSlugRecords;

                if ($recordsToUpdate == 0) {
                    $this->line("✅ Table '{$table}': All {$totalSlugRecords} slugs are already lowercase");
                    continue;
                }

                if ($isDryRun) {
                    $this->line("🔍 Table '{$table}': Would convert {$recordsToUpdate} out of {$totalSlugRecords} slugs to lowercase");
                    
                    // Show some examples of what would be changed
                    $examples = DB::table($table)
                        ->whereNotNull($column)
                        ->where($column, '!=', '')
                        ->whereRaw("BINARY {$column} != BINARY LOWER({$column})")
                        ->select('id', $column)
                        ->limit(3)
                        ->get();

                    foreach ($examples as $example) {
                        $original = $example->$column;
                        $converted = strtolower($original);
                        $this->line("   Example: '{$original}' → '{$converted}'");
                    }
                } else {
                    // Perform the actual conversion
                    $updated = DB::table($table)
                        ->whereNotNull($column)
                        ->where($column, '!=', '')
                        ->whereRaw("BINARY {$column} != BINARY LOWER({$column})")
                        ->update([$column => DB::raw("LOWER({$column})")]);

                    $this->line("✅ Table '{$table}': Converted {$updated} slugs to lowercase");
                    $totalUpdated += $updated;
                }

            } catch (\Exception $e) {
                $this->error("❌ Error processing table '{$table}': " . $e->getMessage());
                continue;
            }
        }

        $this->line('');
        
        if ($isDryRun) {
            $this->info("🔍 DRY RUN SUMMARY:");
            $this->line("   • Tables processed: {$totalTables}");
            $this->line("   • Total slug records: {$totalRecords}");
            $this->line("   • Run without --dry-run to perform actual conversion");
        } else {
            $this->info("🎉 CONVERSION COMPLETE:");
            $this->line("   • Tables processed: {$totalTables}");
            $this->line("   • Total slug records: {$totalRecords}");
            $this->line("   • Slugs converted: {$totalUpdated}");
        }

        $this->line('');
        $this->info('✨ All slugs are now lowercase!');
    }
}
