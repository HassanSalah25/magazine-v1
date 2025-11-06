<?php

namespace App\Tenancy\Bootstrappers;

use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Schema\Builder;

class TenantMigrationBootstrapper implements TenancyBootstrapper
{
    /** @var DatabaseManager */
    protected $database;

    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    public function bootstrap(Tenant $tenant)
    {
        // Set the table prefix for the tenant
        $prefix = $tenant->id . '_';
        
        // Configure the central connection to use the tenant prefix
        config(['database.connections.central.prefix' => $prefix]);
        
        // Update the schema builder to use the prefixed connection
        $this->database->connection('central')->getSchemaBuilder()->setTablePrefix($prefix);
        
        \Log::info("Set table prefix '{$prefix}' for tenant: {$tenant->id}");
    }

    public function revert()
    {
        // Remove the table prefix
        config(['database.connections.central.prefix' => '']);
        
        // Reset the schema builder
        $this->database->connection('central')->getSchemaBuilder()->setTablePrefix('');
        
        \Log::info("Removed table prefix for tenant context");
    }
}
