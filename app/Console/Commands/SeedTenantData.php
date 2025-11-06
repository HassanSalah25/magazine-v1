<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\TenantDataSeeder;

class SeedTenantData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed-data {--tenant= : Specific tenant ID to seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed tenant basic settings data from SQL files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting tenant data seeding...');
        
        $tenantId = $this->option('tenant');

        if ($tenantId) {
            $this->info("Seeding data for specific tenant: {$tenantId}");
            $this->seedSpecificTenant($tenantId);
        } else {
            $this->info('Seeding data for all tenants...');
            $this->seedAllTenants();
        }
        
        $this->info('Tenant data seeding completed!');
    }
    
    /**
     * Seed data for all tenants
     */
    private function seedAllTenants(): void
    {

        $seeder = new TenantDataSeeder();
        $seeder->setCommand($this);
        $seeder->run();
    }
    
    /**
     * Seed data for a specific tenant
     */
    private function seedSpecificTenant(string $tenantId): void
    {
        $seeder = new TenantDataSeeder();
        $seeder->setCommand($this);
        
        // Get the tenant data seeding method
        $reflection = new \ReflectionClass($seeder);
        $method = $reflection->getMethod('seedTenantData');
        $method->setAccessible(true);
        $method->invoke($seeder, $tenantId);
    }
}