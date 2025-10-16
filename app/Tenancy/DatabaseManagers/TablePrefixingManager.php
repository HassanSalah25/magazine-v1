<?php

namespace App\Tenancy\DatabaseManagers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Contracts\TenantDatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class TablePrefixingManager implements TenantDatabaseManager
{
    protected $connection;

    public function __construct()
    {
        $this->connection = config('tenancy.database.central_connection');
    }

    /**
     * Create tenant tables with prefix
     */
    public function createDatabase(TenantWithDatabase $tenant): bool
    {
        $prefix = $this->getTablePrefix($tenant);
        
        try {
            // Get all tables from central database
            $tables = $this->getCentralTables();
            
            foreach ($tables as $table) {
                // Skip system tables and tenant management tables
                if ($this->shouldSkipTable($table)) {
                    continue;
                }
                
                $this->createTableWithPrefix($table, $prefix);
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to create tenant tables: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete tenant tables with prefix
     */
    public function deleteDatabase(TenantWithDatabase $tenant): bool
    {
        $prefix = $this->getTablePrefix($tenant);
        
        try {
            // Get all tables with this prefix
            $tables = $this->getTenantTables($prefix);
            
            foreach ($tables as $table) {
                DB::connection($this->connection)->statement("DROP TABLE IF EXISTS `{$table}`");
            }
            
            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to delete tenant tables: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if tenant database exists
     */
    public function databaseExists(TenantWithDatabase $tenant): bool
    {
        $prefix = $this->getTablePrefix($tenant);
        $tables = $this->getTenantTables($prefix);
        
        return count($tables) > 0;
    }

    /**
     * Get table prefix for tenant
     */
    protected function getTablePrefix(TenantWithDatabase $tenant): string
    {
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $suffix = config('tenancy.database.suffix', '');
        
        return $prefix . $tenant->getKey() . $suffix;
    }

    /**
     * Get all tables from central database
     */
    protected function getCentralTables(): array
    {
        $tables = DB::connection($this->connection)->select('SHOW TABLES');
        $tableNames = [];
        
        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }
        
        return $tableNames;
    }

    /**
     * Get all tables with specific prefix
     */
    protected function getTenantTables(string $prefix): array
    {
        $tables = DB::connection($this->connection)->select("SHOW TABLES LIKE '{$prefix}%'");
        $tableNames = [];
        
        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }
        
        return $tableNames;
    }

    /**
     * Check if table should be skipped
     */
    protected function shouldSkipTable(string $table): bool
    {
        $skipTables = [
            'migrations',
            'password_resets',
            'failed_jobs',
            'tenants',
            'domains',
            'personal_access_tokens',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'sessions'
        ];
        
        return in_array($table, $skipTables);
    }

    /**
     * Create table with prefix
     */
    protected function createTableWithPrefix(string $originalTable, string $prefix): void
    {
        try {
            // Get table structure
            $createTable = DB::connection($this->connection)->select("SHOW CREATE TABLE `{$originalTable}`");
            $createStatement = $createTable[0]->{'Create Table'};
            
            // Replace table name with prefixed version
            $prefixedTable = $prefix . $originalTable;
            $createStatement = str_replace("CREATE TABLE `{$originalTable}`", "CREATE TABLE `{$prefixedTable}`", $createStatement);
            
            // Create the table
            DB::connection($this->connection)->statement($createStatement);
            
            \Log::info("Created table: {$prefixedTable}");
        } catch (\Exception $e) {
            \Log::warning("Failed to create table {$originalTable} with prefix {$prefix}: " . $e->getMessage());
        }
    }
}
