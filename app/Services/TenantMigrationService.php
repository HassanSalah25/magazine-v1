<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class TenantMigrationService
{
    /**
     * Create tenant tables using migrations
     */
    public function createTenantTables(Tenant $tenant): void
    {
        try {
            // Check if tenant already has tables
            $existingTables = $this->getTenantTables($tenant);
            if (count($existingTables) > 0) {
                throw new \Exception("Tenant {$tenant->id} already has tables. Cannot recreate.");
            }
            
            // Set tenant context
            tenancy()->initialize($tenant);
            
            // Use Artisan command to run migrations with tenant context
            $this->runMigrationsWithArtisan($tenant);
            
            \Log::info("Successfully created tenant tables using migrations for tenant: {$tenant->id}");
            
        } catch (\Exception $e) {
            \Log::error("Failed to create tenant tables for tenant {$tenant->id}: " . $e->getMessage());
            throw $e;
        } finally {
            // End tenancy context
            tenancy()->end();
        }
    }
    
    /**
     * Run migrations using Artisan command
     */
    protected function runMigrationsWithArtisan(Tenant $tenant): void
    {
        \Log::info("Running core tables migration for tenant: {$tenant->id}");
        
        // Run the specific core tables migration
        $this->runCoreTablesMigration($tenant);
    }
    
    /**
     * Run the core tables migration for tenant
     */
    protected function runCoreTablesMigration(Tenant $tenant): void
    {
        try {
            // Set the table prefix for the tenant
            $prefix = $tenant->id . '_';
            
            \Log::info("Set table prefix '{$prefix}' for tenant: {$tenant->id}");
            
            // Run the migration directly with the tenant context
            $this->runMigrationDirectly($tenant, $prefix);
            
            \Log::info("✅ Core tables migration completed for tenant: {$tenant->id}");
            
        } catch (\Exception $e) {
            \Log::error("❌ Core tables migration failed for tenant {$tenant->id}: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Run migration directly with tenant prefix
     */
    protected function runMigrationDirectly(Tenant $tenant, string $prefix): void
    {
        // Create tables directly with tenant prefix
        $this->createTenantTablesDirectly($tenant, $prefix);
    }
    
    /**
     * Create tenant tables directly with prefix - ALL MAIN DATABASE TABLES
     */
    protected function createTenantTablesDirectly(Tenant $tenant, string $prefix): void
    {
        \Log::info("Creating ALL main database tables for tenant with prefix: {$prefix}");
        
        // Get all tables from main database (excluding system tables and existing tenant tables)
        $mainTables = $this->getMainDatabaseTables();
        
        \Log::info("Found " . count($mainTables) . " tables to migrate for tenant: {$tenant->id}");
        
        $createdCount = 0;
        $skippedCount = 0;
        
        foreach ($mainTables as $tableName) {
            try {
                $this->createTableWithPrefix($tableName, $prefix, $tenant);
                $createdCount++;
                \Log::info("✅ Created table: {$prefix}{$tableName}");
            } catch (\Exception $e) {
                $skippedCount++;
                \Log::warning("⚠️  Skipped table {$tableName}: " . $e->getMessage());
            }
        }
        
        \Log::info("✅ Migration completed for tenant {$tenant->id}: {$createdCount} tables created, {$skippedCount} skipped");
    }
    
    /**
     * Get all main database tables (excluding system and tenant tables)
     */
    protected function getMainDatabaseTables(): array
    {
        $tables = \DB::connection('central')->select('SHOW TABLES');
        $tableNames = [];
        
        // System tables to exclude
        $excludeTables = [
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
        
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            
            // Skip system tables and existing tenant tables
            if (!in_array($tableName, $excludeTables) && !str_starts_with($tableName, 'tenant_')) {
                $tableNames[] = $tableName;
            }
        }
        
        return $tableNames;
    }
    
    /**
     * Create a single table with tenant prefix
     */
    protected function createTableWithPrefix(string $originalTable, string $prefix, Tenant $tenant): void
    {
        // Get the original table structure
        $createTable = \DB::connection('central')->select("SHOW CREATE TABLE `{$originalTable}`");
        $createStatement = $createTable[0]->{'Create Table'};
        
        // Replace table name with prefixed version
        $prefixedTable = $prefix . $originalTable;
        $createStatement = str_replace("CREATE TABLE `{$originalTable}`", "CREATE TABLE `{$prefixedTable}`", $createStatement);
        
        // Replace foreign key references to use prefixed table names
        $createStatement = $this->replaceForeignKeyReferences($createStatement, $prefix);
        
        // Replace constraint names to avoid conflicts
        $createStatement = $this->replaceConstraintNames($createStatement, $prefix);
        
        // Create the table
        \DB::connection('central')->statement($createStatement);
    }
    
    /**
     * Remove foreign key references from CREATE TABLE statement
     */
    protected function replaceForeignKeyReferences(string $createStatement, string $prefix): string
    {
        // Remove all foreign key constraints from the CREATE statement
        $patterns = [
            // Standard foreign key patterns
            '/,\s*FOREIGN KEY\s*\([^)]+\)\s*REFERENCES\s*`[^`]+`\s*\([^)]*\)\s*(ON\s+(DELETE|UPDATE)\s+(CASCADE|SET NULL|RESTRICT|NO ACTION))?/i',
            // Foreign key with constraint name
            '/,\s*CONSTRAINT\s+`[^`]+`\s*FOREIGN KEY\s*\([^)]+\)\s*REFERENCES\s*`[^`]+`\s*\([^)]*\)\s*(ON\s+(DELETE|UPDATE)\s+(CASCADE|SET NULL|RESTRICT|NO ACTION))?/i',
            // Simple foreign key references
            '/,\s*FOREIGN KEY\s*\([^)]+\)\s*REFERENCES\s*`[^`]+`/i',
            // Constraint with foreign key
            '/,\s*CONSTRAINT\s+`[^`]+`\s*FOREIGN KEY\s*\([^)]+\)\s*REFERENCES\s*`[^`]+`/i'
        ];
        
        foreach ($patterns as $pattern) {
            $createStatement = preg_replace($pattern, '', $createStatement);
        }
        
        // Clean up any double commas that might be left
        $createStatement = preg_replace('/,\s*,/', ',', $createStatement);
        
        // Clean up trailing comma before closing parenthesis
        $createStatement = preg_replace('/,\s*\)/', ')', $createStatement);
        
        return $createStatement;
    }
    
    /**
     * Replace constraint names to avoid conflicts
     */
    protected function replaceConstraintNames(string $createStatement, string $prefix): string
    {
        // Find all constraint names in the CREATE statement
        preg_match_all('/CONSTRAINT `([^`]+)`/', $createStatement, $matches);
        
        foreach ($matches[1] as $constraintName) {
            $prefixedConstraintName = $prefix . $constraintName;
            
            // Truncate constraint name if it's too long (MySQL limit is 64 characters)
            if (strlen($prefixedConstraintName) > 64) {
                $truncatedName = substr($prefixedConstraintName, 0, 64);
                \Log::info("Truncated constraint name from {$prefixedConstraintName} to {$truncatedName}");
                $prefixedConstraintName = $truncatedName;
            }
            
            $createStatement = str_replace("CONSTRAINT `{$constraintName}`", "CONSTRAINT `{$prefixedConstraintName}`", $createStatement);
        }
        
        return $createStatement;
    }

    /**
     * Run migrations for tenant (legacy method)
     */
    protected function runTenantMigrations(Tenant $tenant): void
    {
        $migrationPath = database_path('migrations');
        $migrationFiles = File::glob($migrationPath . '/*.php');
        
        // Sort migration files by timestamp
        sort($migrationFiles);
        
    
        foreach ($migrationFiles as $migrationFile) {
            $this->runSingleMigration($migrationFile, $tenant);
        }
    }
    
    /**
     * Run a single migration for tenant
     */
    protected function runSingleMigration(string $migrationFile, Tenant $tenant): void
    {
        $migrationName = basename($migrationFile, '.php');
        
        try {
            // Get the migration class
            $className = $this->getMigrationClassName($migrationFile);
            
            if (!$className || !class_exists($className)) {
                \Log::warning("Could not find migration class in: {$migrationFile}");
                return;
            }
            
            // Create migration instance
            $migration = new $className();
            
            // Set connection to central database
            $migration->setConnection('central');
            
            // Run the migration
            $migration->up();
            
            \Log::info("✅ Migration {$migrationName} completed for tenant: {$tenant->id}");
            
        } catch (\Exception $e) {
            \Log::warning("⚠️  Migration {$migrationName} failed for tenant {$tenant->id}: " . $e->getMessage());
            // Continue with other migrations even if one fails
        }
    }
    
    /**
     * Get migration class name from file
     */
    protected function getMigrationClassName(string $migrationFile): ?string
    {
        $content = file_get_contents($migrationFile);
        
        // Extract class name using regex - look for class definition
        if (preg_match('/class\s+(\w+)\s+extends\s+Migration/', $content, $matches)) {
            return $matches[1];
        }
        
        // Alternative pattern for different migration formats
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            return $matches[1];
        }
        
        // For the specific core tables migration
        if (strpos($migrationFile, 'create_tenant_core_tables') !== false) {
            return 'CreateTenantCoreTables';
        }
        
        return null;
    }
    
    /**
     * Get existing tables for tenant
     */
    public function getTenantTables(Tenant $tenant): array
    {
        $prefix = $tenant->id . '_';
        $tables = DB::connection('central')->select("SHOW TABLES LIKE '{$prefix}%'");
        
        $tableNames = [];
        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }
        
        return $tableNames;
    }
    
    /**
     * Drop all tables for tenant
     */
    public function dropTenantTables(Tenant $tenant): void
    {
        $tables = $this->getTenantTables($tenant);
        
        if (count($tables) === 0) {
            \Log::info("No tables found for tenant: {$tenant->id}");
            return;
        }
        
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 0');
        
        foreach ($tables as $table) {
            DB::connection('central')->statement("DROP TABLE IF EXISTS `{$table}`");
            \Log::info("Dropped table: {$table}");
        }
        
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 1');
        
        \Log::info("Dropped " . count($tables) . " tables for tenant: {$tenant->id}");
    }
    
    /**
     * Check if tenant has tables
     */
    public function tenantHasTables(Tenant $tenant): bool
    {
        return count($this->getTenantTables($tenant)) > 0;
    }
    
    /**
     * Get migration status for tenant
     */
    public function getMigrationStatus(Tenant $tenant): array
    {
        $tables = $this->getTenantTables($tenant);
        $migrationPath = database_path('migrations');
        $migrationFiles = File::glob($migrationPath . '/*.php');
        
        return [
            'tenant_id' => $tenant->id,
            'tables_count' => count($tables),
            'migrations_count' => count($migrationFiles),
            'has_tables' => count($tables) > 0,
            'tables' => $tables
        ];
    }
}
