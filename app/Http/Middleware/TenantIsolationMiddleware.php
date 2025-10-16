<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tenant;

class TenantIsolationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only apply tenant isolation for tenant-related operations
        if ($this->isTenantOperation($request)) {
            $this->enforceTenantIsolation($request);
        }

        return $next($request);
    }

    /**
     * Check if the request is a tenant operation
     */
    protected function isTenantOperation(Request $request): bool
    {
        $path = $request->path();
        
        // Check if the request is for tenant operations
        return str_contains($path, 'tenant') || 
               str_contains($path, 'saas') ||
               $request->routeIs('tenant.*') ||
               $request->routeIs('saas.*');
    }

    /**
     * Enforce tenant isolation
     */
    protected function enforceTenantIsolation(Request $request): void
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthorized: Authentication required for tenant operations');
        }

        // Check if user has tenant permissions
        $user = auth()->user();
        if (!$this->userCanManageTenants($user)) {
            abort(403, 'Forbidden: Insufficient permissions for tenant operations');
        }

        // Validate tenant ID if provided
        $tenantId = $request->route('tenant_id') ?? $request->input('tenant_id');
        if ($tenantId) {
            $this->validateTenantAccess($tenantId);
        }

        // Log tenant operations for audit
        $this->logTenantOperation($request);
    }

    /**
     * Validate tenant access
     */
    protected function validateTenantAccess(string $tenantId): void
    {
        // Validate tenant ID format
        if (!preg_match('/^tenant_[a-zA-Z0-9]{10}$/', $tenantId)) {
            abort(400, 'Invalid tenant ID format');
        }

        // Check if tenant exists
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        // Check if user has access to this specific tenant
        if (!$this->userHasTenantAccess($tenant)) {
            abort(403, 'Forbidden: No access to this tenant');
        }
    }

    /**
     * Check if user has access to the tenant
     */
    protected function userHasTenantAccess(Tenant $tenant): bool
    {
        $user = auth()->user();
        
        // Super admin can access all tenants
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->is_super_admin ?? false) {
            return true;
        }

        // Check if user is the tenant owner
        if ($user->tenant_id === $tenant->id) {
            return true;
        }

        // Check if user has explicit access to this tenant
        if (method_exists($user, 'tenants')) {
            return $user->tenants()->where('tenant_id', $tenant->id)->exists();
        }
        
        return false;
    }

    /**
     * Log tenant operations for audit
     */
    protected function logTenantOperation(Request $request): void
    {
        $logData = [
            'user_id' => auth()->id(),
            'tenant_id' => $request->route('tenant_id') ?? $request->input('tenant_id'),
            'action' => $request->method() . ' ' . $request->path(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
            'request_data' => $request->except(['password', 'password_confirmation'])
        ];

        Log::channel('audit')->info('Tenant operation accessed', $logData);
    }

    /**
     * Check if user can manage tenants
     */
    protected function userCanManageTenants($user): bool
    {
        // Check if user has role method (Spatie Laravel Permission)
        if (method_exists($user, 'can') && $user->can('manage_tenants')) {
            return true;
        }
        
        // Check for admin status fields
        if ($user->is_admin ?? $user->is_super_admin ?? $user->is_saas_admin ?? false) {
            return true;
        }
        
        // Default: allow any authenticated user (you can change this)
        return true;
    }
}
