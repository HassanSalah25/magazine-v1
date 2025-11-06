<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTenantTablesSinglePrefix extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:create-single-prefix {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Create tenant tables with single prefix (no double prefixing)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Creating tables with single prefix for tenant ID: {$tenantId}");
        
        // Check if tenant exists
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found!");
            return 1;
        }
        
        $this->info("✓ Tenant found: {$tenant->id}");
        
        // Get the expected table prefix (single prefix only)
        $prefix = 'tenant_' . $tenant->getKey() . '_';
        $this->info("Expected table prefix: {$prefix}");
        
        // Get all tables from central database
        $centralTables = $this->getCentralTables();
        
        foreach ($centralTables as $tableName) {
            $this->createTenantTable($tableName, $prefix);
        }
        
        $this->info("✅ Tenant tables creation completed!");
        
        return 0;
    }
    
    protected function getCentralTables()
    {
        // Get tables from central database
        $tables = DB::connection('central')->select('SHOW TABLES');
        $tableNames = [];
        
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            // Skip system tables
            if (!in_array($tableName, ['migrations', 'password_resets', 'failed_jobs', 'tenants', 'domains', 'personal_access_tokens', 'cache', 'cache_locks', 'jobs', 'job_batches', 'sessions'])) {
                $tableNames[] = $tableName;
            }
        }
        
        return $tableNames;
    }
    
    protected function createTenantTable($tableName, $prefix)
    {
        try {
            $prefixedTableName = $prefix . $tableName;
            
            // Check if table already exists
            if (Schema::hasTable($prefixedTableName)) {
                $this->info("Table '{$prefixedTableName}' already exists");
                return;
            }
            
            // Get table structure from central database
            $createTable = DB::connection('central')->select("SHOW CREATE TABLE `{$tableName}`");
            $createStatement = $createTable[0]->{'Create Table'};
            
            // Replace table name in CREATE statement
            $createStatement = str_replace("CREATE TABLE `{$tableName}`", "CREATE TABLE `{$prefixedTableName}`", $createStatement);
            
            // Execute the CREATE TABLE statement
            DB::statement($createStatement);
            
            $this->info("✓ Created table '{$prefixedTableName}'");
            
            // Copy data from central to tenant table
            $centralData = DB::connection('central')->table($tableName)->get();
            if ($centralData->count() > 0) {
                foreach ($centralData as $row) {
                    DB::table($prefixedTableName)->insert((array) $row);
                }
                $this->info("  - Copied {$centralData->count()} records");
            }
            
        } catch (\Exception $e) {
            $this->error("Error creating table '{$tableName}': " . $e->getMessage());
        }
    }
}
