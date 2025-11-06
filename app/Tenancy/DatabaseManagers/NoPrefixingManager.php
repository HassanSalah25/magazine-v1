<?php

namespace App\Tenancy\DatabaseManagers;

use Stancl\Tenancy\Database\DatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class NoPrefixingManager extends DatabaseManager
{
    /**
     * Create database for tenant
     */
    public function createDatabase(TenantWithDatabase $tenant): bool
    {
        // We don't create separate databases, just return true
        return true;
    }

    /**
     * Delete database for tenant
     */
    public function deleteDatabase(TenantWithDatabase $tenant): bool
    {
        // We don't delete separate databases, just return true
        return true;
    }

    /**
     * Check if database exists for tenant
     */
    public function databaseExists(TenantWithDatabase $tenant): bool
    {
        // The "database" always exists since we use table prefixing
        return true;
    }
}
