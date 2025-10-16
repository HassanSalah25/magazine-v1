<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tenants.
     */
    public function viewAny(User $user): bool
    {
        // Check if user has role method (Spatie Laravel Permission)
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole(['super_admin', 'admin']) || $user->can('manage_tenants');
        }
        
        // Check for admin status fields
        return $user->is_admin ?? $user->is_super_admin ?? $user->is_saas_admin ?? false;
    }

    /**
     * Determine whether the user can view the tenant.
     */
    public function view(User $user, Tenant $tenant): bool
    {
        // Super admin can view all tenants
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->is_super_admin ?? false) {
            return true;
        }

        // User can view their own tenant
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
     * Determine whether the user can create tenants.
     */
    public function create(User $user): bool
    {
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole(['super_admin', 'admin']) || $user->can('create_tenant');
        }
        
        return $user->is_admin ?? $user->is_super_admin ?? $user->is_saas_admin ?? true;
    }

    /**
     * Determine whether the user can update the tenant.
     */
    public function update(User $user, Tenant $tenant): bool
    {
        // Super admin can update all tenants
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->is_super_admin ?? false) {
            return true;
        }

        // User can update their own tenant
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
     * Determine whether the user can delete the tenant.
     */
    public function delete(User $user, Tenant $tenant): bool
    {
        // Only super admin can delete tenants
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('super_admin');
        }
        
        return $user->is_super_admin ?? false;
    }

    /**
     * Determine whether the user can create tables for the tenant.
     */
    public function createTables(User $user, Tenant $tenant): bool
    {
        // Super admin can create tables for any tenant
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->is_super_admin ?? false) {
            return true;
        }

        // User can create tables for their own tenant
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
     * Determine whether the user can access tenant data.
     */
    public function accessData(User $user, Tenant $tenant): bool
    {
        // Super admin can access all tenant data
        if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
            return true;
        }
        
        if ($user->is_super_admin ?? false) {
            return true;
        }

        // User can access their own tenant data
        if ($user->tenant_id === $tenant->id) {
            return true;
        }

        // Check if user has explicit access to this tenant
        if (method_exists($user, 'tenants')) {
            return $user->tenants()->where('tenant_id', $tenant->id)->exists();
        }
        
        return false;
    }
}
