<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupOrphanedTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:cleanup-orphaned {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up orphaned tenant tables that no longer have corresponding tenant records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning for orphaned tenant tables...');
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No tables will be deleted');
        }

        // Get all tenant records
        $tenants = Tenant::all();
        $validTenantIds = $tenants->pluck('id')->toArray();
        
        $this->info("Found {$tenants->count()} valid tenants");

        // Get all tables with tenant prefix
        $allTables = DB::connection('central')->select("SHOW TABLES LIKE 'tenant_%'");
        $orphanedTables = [];
        
        foreach ($allTables as $table) {
            $tableName = array_values((array) $table)[0];
            
            // Extract tenant ID from table name
            if (preg_match('/^tenant_(.+?)_/', $tableName, $matches)) {
                $tenantId = 'tenant_' . $matches[1];
                
                // Check if this tenant ID exists
                if (!in_array($tenantId, $validTenantIds)) {
                    $orphanedTables[] = $tableName;
                }
            }
        }

        if (empty($orphanedTables)) {
            $this->info('No orphaned tables found.');
            return 0;
        }

        $this->warn("Found " . count($orphanedTables) . " orphaned tables:");
        
        foreach ($orphanedTables as $table) {
            $this->line("- {$table}");
        }

        if ($dryRun) {
            $this->info('Dry run completed. Use --dry-run=false to actually delete these tables.');
            return 0;
        }

        if (!$this->confirm('Are you sure you want to delete these orphaned tables?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        // Disable foreign key checks temporarily
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 0');
        
        $deletedCount = 0;
        foreach ($orphanedTables as $table) {
            try {
                DB::connection('central')->statement("DROP TABLE IF EXISTS `{$table}`");
                $this->info("Deleted: {$table}");
                $deletedCount++;
                
                Log::info("Deleted orphaned tenant table: {$table}");
            } catch (\Exception $e) {
                $this->error("Failed to delete {$table}: " . $e->getMessage());
                Log::error("Failed to delete orphaned table {$table}: " . $e->getMessage());
            }
        }
        
        // Re-enable foreign key checks
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 1');

        $this->info("Successfully deleted {$deletedCount} orphaned tables.");
        
        return 0;
    }
}
