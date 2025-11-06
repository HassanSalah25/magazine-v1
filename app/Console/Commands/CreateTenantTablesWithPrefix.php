<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTenantTablesWithPrefix extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:create-prefixed-tables {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Create tenant tables with correct prefix';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Creating prefixed tables for tenant ID: {$tenantId}");
        
        // Check if tenant exists
        // $tenant = Tenant::find($tenantId);
        // if (!$tenant) {
        //     $this->error("Tenant with ID {$tenantId} not found!");
        //     return 1;
        // }
        
        // $this->info("✓ Tenant found: {$tenant->id}");
        
        // Initialize tenant context
        // tenancy()->initialize($tenant);
        
        // $this->info("✓ Tenant context initialized");
        
        // Get the expected table prefix
        // $prefix = 'tenant_' . $tenant->getKey() . '_';
        // $this->info("Expected table prefix: {$prefix}");
        
        // Get all tables from central database
        $centralTables = $this->getCentralTables();
        foreach ($centralTables as $tableName) {
            $this->createTenantTable($tableName, 'tenant_');
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
            
            // Replace foreign key references to use prefixed table names
            $createStatement = $this->replaceForeignKeyReferences($createStatement, $prefix);
            
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
    
    /**
     * Replace foreign key references in CREATE TABLE statement
     */
    protected function replaceForeignKeyReferences($createStatement, $prefix)
    {
        // Get all tables from central database to find potential foreign key references
        $centralTables = $this->getCentralTables();
        
        foreach ($centralTables as $table) {
            // Replace references to other tables with prefixed versions
            $prefixedTable = $prefix . $table;
            $createStatement = str_replace("REFERENCES `{$table}`", "REFERENCES `{$prefixedTable}`", $createStatement);
        }
        
        return $createStatement;
    }
}
