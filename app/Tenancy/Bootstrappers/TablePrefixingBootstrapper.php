<?php

namespace App\Tenancy\Bootstrappers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Connection;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class TablePrefixingBootstrapper implements TenancyBootstrapper
{
    protected $database;
    protected $originalConnection;

    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    public function bootstrap(Tenant $tenant)
    {
        $this->originalConnection = $this->database->connection();
        
        // Set up table prefixing for the tenant
        $this->setupTablePrefixing($tenant);
    }

    public function revert()
    {
        // Revert to original connection
        if ($this->originalConnection) {
            $this->database->setDefaultConnection($this->originalConnection->getName());
        }
    }

    protected function setupTablePrefixing(Tenant $tenant)
    {
        $prefix = $this->getTablePrefix($tenant);
        
        // Override the connection to use table prefixing
        $connection = $this->database->connection();
        
        // Set up table prefixing by modifying the connection
        $this->setupConnectionWithPrefix($connection, $prefix);
    }

    protected function getTablePrefix(Tenant $tenant): string
    {
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $suffix = config('tenancy.database.suffix', '');
        
        return $prefix . $tenant->getKey() . $suffix;
    }

    protected function setupConnectionWithPrefix(Connection $connection, string $prefix)
    {
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
}
