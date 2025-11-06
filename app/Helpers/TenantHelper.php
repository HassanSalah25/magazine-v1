<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class TenantHelper
{
    /**
     * Generate a tenant-aware URL
     */
    public static function tenantUrl($route, $parameters = [], $tenantId = null)
    {
        $tenantId = $tenantId ?: (tenancy()->initialized ? tenancy()->tenant->getKey() : null);
        
        if ($tenantId) {
            // Prepend tenant prefix to the route
            $tenantRoute = 'tenant.' . $route;
            return route($tenantRoute, array_merge(['tenant_id' => $tenantId], $parameters));
        }
        
        return route($route, $parameters);
    }

    /**
     * Generate a tenant-aware asset URL
     */
    public static function tenantAsset($path, $tenantId = null)
    {
        $tenantId = $tenantId ?: (tenancy()->initialized ? tenancy()->tenant->getKey() : null);
        
        if ($tenantId) {
            // Add tenant context to asset path
            return asset('tenant/' . $tenantId . '/' . ltrim($path, '/'));
        }
        
        return asset($path);
    }

    /**
     * Check if current route is a tenant route
     */
    public static function isTenantRoute(): bool
    {
        $currentRoute = Route::currentRouteName();
        return $currentRoute && strpos($currentRoute, 'tenant.') === 0;
    }

    /**
     * Get tenant ID from current route
     */
    public static function getTenantIdFromRoute(): ?string
    {
        $route = Route::current();
        if ($route && isset($route->parameters['tenant_id'])) {
            return $route->parameters['tenant_id'];
        }
        
        return null;
    }

    /**
     * Generate a link to switch between tenant and central views
     */
    public static function getCentralUrl($route, $parameters = [])
    {
        return route($route, $parameters);
    }

    /**
     * Generate a link to tenant view
     */
    public static function getTenantUrl($route, $parameters = [], $tenantId = null)
    {
        return self::tenantUrl($route, $parameters, $tenantId);
    }
}
