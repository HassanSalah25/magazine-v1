<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:ensure-tables {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Ensure tenant tables exist with correct structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Ensuring tables exist for tenant ID: {$tenantId}");
        
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
        
        // Get the expected table prefix
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $suffix = config('tenancy.database.suffix', '');
        $expectedPrefix = $prefix . $tenant->getKey() . $suffix;
        
        $this->info("Expected table prefix: {$expectedPrefix}");
        
        // Check key tables
        $tablesToCheck = ['users', 'products', 'popups', 'settings', 'homes'];
        
        foreach ($tablesToCheck as $tableName) {
            $this->ensureTable($tableName, $expectedPrefix);
        }
        
        // End tenant context
        tenancy()->end();
        
        $this->info("✅ Tenant tables check completed!");
        
        return 0;
    }
    
    protected function ensureTable($tableName, $expectedPrefix)
    {
        try {
            // Check if table exists in tenant context
            if (Schema::hasTable($tableName)) {
                $this->info("✓ Table '{$tableName}' exists in tenant context");
                
                // Check if it has the correct prefix
                $actualTableName = DB::getTablePrefix() . $tableName;
                $this->info("  - Actual table name: {$actualTableName}");
                
                // Get record count
                $count = DB::table($tableName)->count();
                $this->info("  - Record count: {$count}");
                
            } else {
                $this->warn("⚠ Table '{$tableName}' does NOT exist in tenant context");
                
                // Try to create it by copying from central
                $this->createTableFromCentral($tableName);
            }
        } catch (\Exception $e) {
            $this->error("Error checking table '{$tableName}': " . $e->getMessage());
        }
    }
    
    protected function createTableFromCentral($tableName)
    {
        try {
            // Get table structure from central database
            $createTable = DB::connection('central')->select("SHOW CREATE TABLE `{$tableName}`");
            $createStatement = $createTable[0]->{'Create Table'};
            
            // Execute the CREATE TABLE statement in tenant context
            DB::statement($createStatement);
            
            $this->info("✓ Created table '{$tableName}' from central structure");
            
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
