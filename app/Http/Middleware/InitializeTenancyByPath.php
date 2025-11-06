<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath as BaseMiddleware;
use Stancl\Tenancy\Resolvers\PathTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByPath extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the path starts with /tenant/{tenant_id}/
        if ($this->isTenantPath($request)) {
            return $this->initializeTenancy($request, $next);
        }
        
        // For non-tenant paths, ensure we're in central context
        if (tenancy()->initialized) {
            tenancy()->end();
        }
        
        return $next($request);
    }

    /**
     * Check if the request path is a tenant path
     */
    protected function isTenantPath(Request $request): bool
    {
        $path = $request->path();
        return preg_match('/^tenant\/[^\/]+\//', $path) || preg_match('/^tenant\/[^\/]+$/', $path);
    }

    /**
     * Resolve tenant from the URL path
     */
    protected function resolveTenant(Request $request)
    {
        $path = $request->path();
        
        // Extract tenant ID from path like /tenant/tenant_z0fkn0cxiz/dashboard
        if (preg_match('/^tenant\/([^\/]+)/', $path, $matches)) {
            $tenantId = $matches[1];
            
            // Find tenant by ID
            $tenantModel = config('tenancy.tenant_model');
            return $tenantModel::find($tenantId);
        }
        
        return null;
    }

    /**
     * Initialize tenancy for the tenant
     */
    public function initializeTenancy($request, $next, ...$resolverArguments)
    {
        $tenant = $this->resolveTenant($request);
        
        if (!$tenant) {
            return $this->handleCentralRequest($request, $next);
        }

        $tenancy = app(Tenancy::class);
        $tenancy->initialize($tenant);
        
        return $next($request);
    }
}
