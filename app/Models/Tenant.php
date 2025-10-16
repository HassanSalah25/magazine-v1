<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDomains, HasDatabase;

    /**
     * Get the owner of the tenant.
     */
    public function owner()
    {
        return $this->hasOne('App\Models\User', 'tenant_id', 'id')->where('is_tenant_owner', true);
    }

    /**
     * Get all users in this tenant.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'tenant_id', 'id');
    }
}
