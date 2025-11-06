<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        // With table prefixing, we don't need to apply tenant_id filtering
        // The table prefixing already provides data isolation
        // This scope is kept for compatibility but doesn't add any filters
    }

    /**
     * Extend the query builder with the needed functions.
     */
    public function extend(Builder $builder)
    {
        $this->addWithoutTenant($builder);
        $this->addWithTenant($builder);
    }

    /**
     * Add the without-tenant extension to the builder.
     */
    protected function addWithoutTenant(Builder $builder)
    {
        $builder->macro('withoutTenant', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the with-tenant extension to the builder.
     */
    protected function addWithTenant(Builder $builder)
    {
        $builder->macro('withTenant', function (Builder $builder, $tenantId = null) {
            $tenantId = $tenantId ?: (tenancy()->initialized ? tenancy()->tenant->getKey() : null);
            
            if ($tenantId) {
                return $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenantId);
            }
            
            return $builder;
        });
    }
}
