<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\TenantContextService;

trait TenantAware
{
    /**
     * Boot the trait
     */
    protected static function bootTenantAware()
    {
        static::addGlobalScope(new \App\Scopes\TenantScope);
    }

    /**
     * Get the table name with tenant prefix
     */
    public function getTable()
    {
        $table = parent::getTable();
        
        if (tenancy()->initialized) {
            $tenant = tenancy()->tenant;
            // The tenant ID already includes 'tenant_' prefix, so just add underscore
            $prefix = $tenant->getKey() . '_';
            
            // Check if the table name already has the prefix to avoid double prefixing
            if (strpos($table, $prefix) === 0) {
                return $table; // Already prefixed
            }
            
            return $prefix . $table;
        }
        
        return $table;
    }

    /**
     * Get the connection name for the model
     */
    public function getConnectionName()
    {
        if (tenancy()->initialized) {
            return config('tenancy.database.central_connection');
        }
        
        return parent::getConnectionName();
    }

    /**
     * Get the tenant ID for this model
     */
    public function getTenantId()
    {
        if (tenancy()->initialized) {
            return tenancy()->tenant->getKey();
        }
        
        return null;
    }

    /**
     * Set the tenant ID for this model
     */
    public function setTenantId($tenantId)
    {
        if (property_exists($this, 'tenant_id')) {
            $this->tenant_id = $tenantId;
        }
        
        return $this;
    }
}
