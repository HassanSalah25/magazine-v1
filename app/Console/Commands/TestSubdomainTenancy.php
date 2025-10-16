<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Services\SaaSTenantService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestSubdomainTenancy extends Command
{
    protected $signature = 'tenant:test-subdomain';
    protected $description = 'Test subdomain-based multi-tenancy system';

    protected $saasTenantService;

    public function __construct(SaaSTenantService $saasTenantService)
    {
        parent::__construct();
        $this->saasTenantService = $saasTenantService;
    }

    public function handle()
    {
        $this->info('Testing Subdomain Multi-Tenancy System');
        $this->line('');

        // Create test tenants with domains
        $this->info('1. Creating test tenants with domains...');
        
        $tenant1 = $this->createTestTenant('tenant1', 'tenant1.localhost');
        $tenant2 = $this->createTestTenant('tenant2', 'tenant2.localhost');
        
        $this->line('');

        // Test tenant data isolation
        $this->info('2. Testing tenant data isolation...');
        $this->testTenantDataIsolation($tenant1, $tenant2);
        
        $this->line('');

        // Test subdomain routing
        $this->info('3. Testing subdomain routing...');
        $this->testSubdomainRouting();
        
        $this->line('');

        // Cleanup
        $this->info('4. Cleaning up test data...');
        $this->cleanupTestData([$tenant1, $tenant2]);
        
        $this->info('Subdomain tenancy test completed!');
    }

    protected function createTestTenant(string $tenantId, string $domain): Tenant
    {
        try {
            // Create tenant
            $tenant = Tenant::create(['id' => $tenantId]);
            
            // Create domain
            $tenant->domains()->create(['domain' => $domain]);
            
            // Create tenant tables
            $reflection = new \ReflectionClass($this->saasTenantService);
            $method = $reflection->getMethod('createTenantTables');
            $method->setAccessible(true);
            $method->invoke($this->saasTenantService, $tenant);
            
            $this->info("✓ Created tenant '{$tenantId}' with domain '{$domain}'");
            
            return $tenant;
        } catch (\Exception $e) {
            $this->error("✗ Failed to create tenant '{$tenantId}': " . $e->getMessage());
            throw $e;
        }
    }

    protected function testTenantDataIsolation(Tenant $tenant1, Tenant $tenant2): void
    {
        try {
            // Test tenant 1
            tenancy()->initialize($tenant1);
            
            $user1 = \App\Models\User::create([
                'fname' => 'User',
                'lname' => 'One',
                'email' => 'user1@tenant1.localhost',
                'password' => 'password',
                'username' => 'user1',
                'tenant_id' => 'tenant1',
                'domain' => 'tenant1.localhost',
                'is_tenant_owner' => true,
                'status' => 1,
                'email_verified' => 'yes',
            ]);
            
            $product1 = \App\Models\Product::create([
                'title' => 'Tenant 1 Product',
                'slug' => 'tenant-1-product',
                'language_id' => 1,
                'stock' => 10,
                'category_id' => 1,
                'current_price' => 99.99,
            ]);
            
            $this->info("✓ Created data for tenant1: User '{$user1->email}' and Product '{$product1->title}'");
            
            tenancy()->end();
            
            // Test tenant 2
            tenancy()->initialize($tenant2);
            
            $user2 = \App\Models\User::create([
                'fname' => 'User',
                'lname' => 'Two',
                'email' => 'user2@tenant2.localhost',
                'password' => 'password',
                'username' => 'user2',
                'tenant_id' => 'tenant2',
                'domain' => 'tenant2.localhost',
                'is_tenant_owner' => true,
                'status' => 1,
                'email_verified' => 'yes',
            ]);
            
            $product2 = \App\Models\Product::create([
                'title' => 'Tenant 2 Product',
                'slug' => 'tenant-2-product',
                'language_id' => 1,
                'stock' => 5,
                'category_id' => 1,
                'current_price' => 149.99,
            ]);
            
            $this->info("✓ Created data for tenant2: User '{$user2->email}' and Product '{$product2->title}'");
            
            tenancy()->end();
            
            // Verify data isolation
            $this->verifyDataIsolation($tenant1, $tenant2);
            
        } catch (\Exception $e) {
            $this->error("✗ Failed to test data isolation: " . $e->getMessage());
        }
    }

    protected function verifyDataIsolation(Tenant $tenant1, Tenant $tenant2): void
    {
        // Check tenant 1 data
        tenancy()->initialize($tenant1);
        $tenant1Users = \App\Models\User::count();
        $tenant1Products = \App\Models\Product::count();
        tenancy()->end();
        
        // Check tenant 2 data
        tenancy()->initialize($tenant2);
        $tenant2Users = \App\Models\User::count();
        $tenant2Products = \App\Models\Product::count();
        tenancy()->end();
        
        if ($tenant1Users === 1 && $tenant1Products === 1 && $tenant2Users === 1 && $tenant2Products === 1) {
            $this->info("✓ Data isolation verified: Each tenant has 1 user and 1 product");
        } else {
            $this->error("✗ Data isolation failed: Tenant1({$tenant1Users} users, {$tenant1Products} products), Tenant2({$tenant2Users} users, {$tenant2Products} products)");
        }
    }

    protected function testSubdomainRouting(): void
    {
        $this->info('To test subdomain routing, you can:');
        $this->line('');
        $this->line('1. Add these entries to your /etc/hosts file:');
        $this->line('   127.0.0.1 tenant1.localhost');
        $this->line('   127.0.0.1 tenant2.localhost');
        $this->line('');
        $this->line('2. Start your Laravel development server:');
        $this->line('   php artisan serve --host=0.0.0.0 --port=8000');
        $this->line('');
        $this->line('3. Visit these URLs in your browser:');
        $this->line('   http://tenant1.localhost:8000');
        $this->line('   http://tenant2.localhost:8000');
        $this->line('');
        $this->line('4. Or test with curl:');
        $this->line('   curl -H "Host: tenant1.localhost" http://localhost:8000');
        $this->line('   curl -H "Host: tenant2.localhost" http://localhost:8000');
    }

    protected function cleanupTestData(array $tenants): void
    {
        foreach ($tenants as $tenant) {
            try {
                $this->saasTenantService->deleteTenant($tenant->id);
                $this->info("✓ Cleaned up tenant '{$tenant->id}'");
            } catch (\Exception $e) {
                $this->error("✗ Failed to cleanup tenant '{$tenant->id}': " . $e->getMessage());
            }
        }
    }
}
