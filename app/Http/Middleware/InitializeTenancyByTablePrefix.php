<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Tenancy;

class InitializeTenancyByTablePrefix extends InitializeTenancyByDomain
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // First, try to resolve tenant by domain
        $tenant = $this->resolveTenant($request);
        
        if (!$tenant) {
            return $this->handleCentralRequest($request, $next);
        }

        // Initialize tenancy with table prefixing
        $this->initializeTenancy($tenant);

        return $next($request);
    }

    /**
     * Resolve tenant from request
     */
    protected function resolveTenant(Request $request): ?\Stancl\Tenancy\Contracts\Tenant
    {
        $domain = $request->getHost();
        
        // Check if this is a central domain
        $centralDomains = config('tenancy.central_domains', []);
        if (in_array($domain, $centralDomains)) {
            return null;
        }

        // Try to resolve tenant by domain
        $resolver = app(DomainTenantResolver::class);
        return $resolver->resolve($request);
    }

    /**
     * Initialize tenancy with table prefixing
     */
    protected function initializeTenancy(\Stancl\Tenancy\Contracts\Tenant $tenant): void
    {
        $tenancy = app(Tenancy::class);
        $tenancy->initialize($tenant);
        
        // Set up table prefixing for the tenant
        $this->setupTablePrefixing($tenant);
    }

    /**
     * Set up table prefixing for the tenant
     */
    protected function setupTablePrefixing(\Stancl\Tenancy\Contracts\Tenant $tenant): void
    {
        $prefix = $this->getTablePrefix($tenant);
        
        // Store the prefix in the tenant context
        $tenant->setAttribute('table_prefix', $prefix);
        
        // Override the database connection to use table prefixing
        $this->overrideDatabaseConnection($prefix);
    }

    /**
     * Get table prefix for tenant
     */
    protected function getTablePrefix(\Stancl\Tenancy\Contracts\Tenant $tenant): string
    {
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $suffix = config('tenancy.database.suffix', '');
        
        return $prefix . $tenant->getKey() . $suffix;
    }

    /**
     * Override database connection to use table prefixing
     */
    protected function overrideDatabaseConnection(string $prefix): void
    {
        $connection = app('db')->connection();
        
        // Override the table method to add prefix
        $connection->macro('table', function ($table, $as = null) use ($prefix) {
            $prefixedTable = $prefix . $table;
            return $this->query()->from($prefixedTable, $as);
        });
        
        // Override the getTablePrefix method
        $connection->macro('getTablePrefix', function () use ($prefix) {
            return $prefix;
        });
    }

    /**
     * Handle central domain requests
     */
    protected function handleCentralRequest(Request $request, Closure $next)
    {
        // For central domains, ensure we're not in tenant context
        if (tenancy()->initialized) {
            tenancy()->end();
        }
        
        return $next($request);
    }
}
