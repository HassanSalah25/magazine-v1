<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:create-tables {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Create tenant tables by copying from central database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Creating tables for tenant ID: {$tenantId}");
        
        // Check if tenant exists
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found!");
            return 1;
        }
        
        $this->info("✓ Tenant found: {$tenant->id}");
        
        // Initialize tenant context
        tenancy()->initialize($tenant);
        
        $this->info("✓ Tenant context initialized");
        
        // Get all tables from central database
        $centralTables = $this->getCentralTables();
        
        foreach ($centralTables as $tableName) {
            $this->createTenantTable($tableName);
        }
        
        // End tenant context
        tenancy()->end();
        
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
    
    protected function createTenantTable($tableName)
    {
        try {
            // Check if table already exists in tenant context
            if (Schema::hasTable($tableName)) {
                $this->info("Table '{$tableName}' already exists in tenant context");
                return;
            }
            
            // Get table structure from central database
            $createTable = DB::connection('central')->select("SHOW CREATE TABLE `{$tableName}`");
            $createStatement = $createTable[0]->{'Create Table'};
            
            // Execute the CREATE TABLE statement in tenant context
            DB::statement($createStatement);
            
            $this->info("✓ Created table '{$tableName}'");
            
            // Copy data from central to tenant table
            $centralData = DB::connection('central')->table($tableName)->get();
            if ($centralData->count() > 0) {
                foreach ($centralData as $row) {
                    DB::table($tableName)->insert((array) $row);
                }
                $this->info("  - Copied {$centralData->count()} records");
            }
            
        } catch (\Exception $e) {
            $this->error("Error creating table '{$tableName}': " . $e->getMessage());
        }
    }
}
