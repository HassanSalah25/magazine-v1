<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class MigrateTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {tenant_id? : The tenant ID to migrate tables for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tenant tables using migrations with proper prefixing';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        if ($tenantId) {
            // Migrate for specific tenant
            $tenant = Tenant::find($tenantId);
            if (!$tenant) {
                $this->error("Tenant {$tenantId} not found.");
                return 1;
            }
            $this->migrateForTenant($tenant);
        } else {
            // Migrate for all tenants that don't have tables yet
            $this->migrateForAllTenants();
        }
        
        return 0;
    }
    
    /**
     * Migrate tables for a specific tenant
     */
    protected function migrateForTenant(Tenant $tenant): void
    {
        $this->info("Migrating tables for tenant: {$tenant->id}");
        
        // Check if tenant already has tables
        $existingTables = $this->getTenantTables($tenant);
        if (count($existingTables) > 0) {
            $this->warn("Tenant {$tenant->id} already has " . count($existingTables) . " tables.");
            if (!$this->confirm('Do you want to recreate them?')) {
                $this->info('Skipping tenant ' . $tenant->id);
                return;
            }
            
            // Drop existing tables
            $this->dropTenantTables($tenant);
        }
        
        // Set tenant context for migrations
        $this->setTenantContext($tenant);
        
        try {
            // Run migrations with tenant prefix
            $this->runTenantMigrations($tenant);
            
            $this->info("✅ Successfully migrated tables for tenant: {$tenant->id}");
        } catch (\Exception $e) {
            $this->error("Failed to migrate tables for tenant {$tenant->id}: " . $e->getMessage());
        }
    }
    
    /**
     * Migrate tables for all tenants that don't have tables
     */
    protected function migrateForAllTenants(): void
    {
        $tenants = Tenant::all();
        $this->info("Found " . count($tenants) . " tenants");
        
        foreach ($tenants as $tenant) {
            $existingTables = $this->getTenantTables($tenant);
            if (count($existingTables) === 0) {
                $this->migrateForTenant($tenant);
            } else {
                $this->info("Skipping tenant {$tenant->id} (already has " . count($existingTables) . " tables)");
            }
        }
    }
    
    /**
     * Set tenant context for migrations
     */
    protected function setTenantContext(Tenant $tenant): void
    {
        // Set the tenant context so migrations use the correct prefix
        tenancy()->initialize($tenant);
        
        // Set the table prefix for the current tenant
        $prefix = $tenant->id . '_';
        config(['tenancy.database.prefix' => $prefix]);
    }
    
    /**
     * Run migrations for tenant
     */
    protected function runTenantMigrations(Tenant $tenant): void
    {
        $this->info("Running migrations for tenant: {$tenant->id}");
        
        // Get all migration files
        $migrationPath = database_path('migrations');
        $migrationFiles = glob($migrationPath . '/*.php');
        
        $this->info("Found " . count($migrationFiles) . " migration files");
        
        // Run each migration manually with tenant prefix
        foreach ($migrationFiles as $migrationFile) {
            $this->runSingleMigration($migrationFile, $tenant);
        }
    }
    
    /**
     * Run a single migration file for tenant
     */
    protected function runSingleMigration(string $migrationFile, Tenant $tenant): void
    {
        $migrationName = basename($migrationFile, '.php');
        $this->info("Running migration: {$migrationName}");
        
        try {
            // Include the migration file
            require_once $migrationFile;
            
            // Get the class name from the file
            $className = $this->getMigrationClassName($migrationFile);
            
            if ($className && class_exists($className)) {
                $migration = new $className();
                
                // Set the connection to central with tenant prefix
                $migration->setConnection('central');
                
                // Run the migration
                $migration->up();
                
                $this->info("✅ Migration {$migrationName} completed");
            }
        } catch (\Exception $e) {
            $this->warn("⚠️  Migration {$migrationName} failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get migration class name from file
     */
    protected function getMigrationClassName(string $migrationFile): ?string
    {
        $content = file_get_contents($migrationFile);
        
        // Extract class name using regex
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
    
    /**
     * Get existing tables for tenant
     */
    protected function getTenantTables(Tenant $tenant): array
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
    protected function dropTenantTables(Tenant $tenant): void
    {
        $this->info("Dropping existing tables for tenant: {$tenant->id}");
        
        $tables = $this->getTenantTables($tenant);
        
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 0');
        
        foreach ($tables as $table) {
            DB::connection('central')->statement("DROP TABLE IF EXISTS `{$table}`");
            $this->info("Dropped table: {$table}");
        }
        
        DB::connection('central')->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}