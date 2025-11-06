<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\SaaSTenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ManageTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:tables 
                            {action : The action to perform (create|delete|list)}
                            {tenant_id? : The tenant ID (optional for list action)}';

    /**
     * The console command description.
     */
    protected $description = 'Manage tenant tables with prefixing';

    protected $tenantService;

    public function __construct(SaaSTenantService $tenantService)
    {
        parent::__construct();
        $this->tenantService = $tenantService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $tenantId = $this->argument('tenant_id');

        switch ($action) {
            case 'create':
                $this->createTenantTables($tenantId);
                break;
            case 'delete':
                $this->deleteTenantTables($tenantId);
                break;
            case 'list':
                $this->listTenantTables($tenantId);
                break;
            default:
                $this->error('Invalid action. Use: create, delete, or list');
                return 1;
        }

        return 0;
    }

    /**
     * Create tables for a tenant
     */
    protected function createTenantTables(?string $tenantId): void
    {
        if (!$tenantId) {
            $this->error('Tenant ID is required for create action');
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found");
            return;
        }

        try {
            $this->info("Creating tables for tenant: {$tenantId}");
            
            // Use reflection to call the protected method
            $reflection = new \ReflectionClass($this->tenantService);
            $method = $reflection->getMethod('createTenantTables');
            $method->setAccessible(true);
            $method->invoke($this->tenantService, $tenant);
            
            $this->info("Tables created successfully for tenant: {$tenantId}");
        } catch (\Exception $e) {
            $this->error("Failed to create tables: " . $e->getMessage());
        }
    }

    /**
     * Delete tables for a tenant
     */
    protected function deleteTenantTables(?string $tenantId): void
    {
        if (!$tenantId) {
            $this->error('Tenant ID is required for delete action');
            return;
        }

        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found");
            return;
        }

        try {
            $this->info("Deleting tables for tenant: {$tenantId}");
            
            // Use reflection to call the protected method
            $reflection = new \ReflectionClass($this->tenantService);
            $method = $reflection->getMethod('deleteTenantTables');
            $method->setAccessible(true);
            $method->invoke($this->tenantService, $tenant);
            
            $this->info("Tables deleted successfully for tenant: {$tenantId}");
        } catch (\Exception $e) {
            $this->error("Failed to delete tables: " . $e->getMessage());
        }
    }

    /**
     * List tables for a tenant or all tenants
     */
    protected function listTenantTables(?string $tenantId): void
    {
        if ($tenantId) {
            $this->listTablesForTenant($tenantId);
        } else {
            $this->listAllTenantTables();
        }
    }

    /**
     * List tables for a specific tenant
     */
    protected function listTablesForTenant(string $tenantId): void
    {
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found");
            return;
        }

        $prefix = config('tenancy.database.prefix', 'tenant_') . $tenantId;
        $tables = DB::connection('central')->select("SHOW TABLES LIKE '{$prefix}%'");
        
        $this->info("Tables for tenant {$tenantId}:");
        $this->table(['Table Name'], array_map(function($table) {
            return [array_values((array) $table)[0]];
        }, $tables));
    }

    /**
     * List tables for all tenants
     */
    protected function listAllTenantTables(): void
    {
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $tables = DB::connection('central')->select("SHOW TABLES LIKE '{$prefix}%'");
        
        $this->info("All tenant tables:");
        $this->table(['Table Name'], array_map(function($table) {
            return [array_values((array) $table)[0]];
        }, $tables));
    }
}
