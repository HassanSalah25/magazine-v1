<?php

namespace App\Tenancy\DatabaseManagers;

use Stancl\Tenancy\Database\DatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class CustomTablePrefixingManager extends DatabaseManager
{
    /**
     * Get the table prefix for a tenant
     */
    public function getTablePrefix(TenantWithDatabase $tenant): string
    {
        return 'tenant_' . $tenant->getKey() . '_';
    }

    /**
     * Create database for tenant
     */
    public function createDatabase(TenantWithDatabase $tenant): bool
    {
        // For table prefixing, we don't create a separate database
        // We just ensure the tenant context is set up
        return true;
    }

    /**
     * Delete database for tenant
     */
    public function deleteDatabase(TenantWithDatabase $tenant): bool
    {
        // For table prefixing, we don't delete a separate database
        return true;
    }

    /**
     * Check if database exists for tenant
     */
    public function databaseExists(TenantWithDatabase $tenant): bool
    {
        // For table prefixing, the "database" always exists
        return true;
    }
}
