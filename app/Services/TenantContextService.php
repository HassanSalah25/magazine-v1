<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Stancl\Tenancy\Tenancy;

class TenantContextService
{
    /**
     * Get the current tenant ID
     */
    public function getCurrentTenantId(): ?string
    {
        if (tenancy()->initialized) {
            return tenancy()->tenant->getKey();
        }
        
        return null;
    }

    /**
     * Check if we're in a tenant context
     */
    public function isTenantContext(): bool
    {
        return tenancy()->initialized;
    }

    /**
     * Get the current tenant
     */
    public function getCurrentTenant()
    {
        if (tenancy()->initialized) {
            return tenancy()->tenant;
        }
        
        return null;
    }

    /**
     * Apply tenant scope to a query builder
     */
    public function applyTenantScope($query, $tenantIdColumn = 'tenant_id')
    {
        $tenantId = $this->getCurrentTenantId();
        
        if ($tenantId) {
            return $query->where($tenantIdColumn, $tenantId);
        }
        
        return $query;
    }

    /**
     * Get tenant-aware table name
     */
    public function getTenantTableName($tableName): string
    {
        if ($this->isTenantContext()) {
            $tenant = $this->getCurrentTenant();
            // The tenant ID already includes 'tenant_' prefix, so just add underscore
            $suffix = config('tenancy.database.suffix', '');
            
            return $tenant->getKey() . '_' . $tableName;
        }
        
        return $tableName;
    }

    /**
     * Check if we should use tenant scoping for a model
     */
    public function shouldUseTenantScoping($model): bool
    {
        // Check if model uses TenantAware trait
        $traits = class_uses_recursive($model);
        return in_array(\App\Traits\TenantAware::class, $traits);
    }
}
