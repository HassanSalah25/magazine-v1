<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TenantContextService;

abstract class TenantController extends Controller
{
    protected $tenantContext;

    public function __construct(TenantContextService $tenantContext)
    {
        $this->tenantContext = $tenantContext;
    }

    /**
     * Get the current tenant ID
     */
    protected function getCurrentTenantId(): ?string
    {
        return $this->tenantContext->getCurrentTenantId();
    }

    /**
     * Check if we're in a tenant context
     */
    protected function isTenantContext(): bool
    {
        return $this->tenantContext->isTenantContext();
    }

    /**
     * Get the current tenant
     */
    protected function getCurrentTenant()
    {
        return $this->tenantContext->getCurrentTenant();
    }

    /**
     * Apply tenant scope to a query
     */
    protected function applyTenantScope($query, $tenantIdColumn = 'tenant_id')
    {
        return $this->tenantContext->applyTenantScope($query, $tenantIdColumn);
    }
}
