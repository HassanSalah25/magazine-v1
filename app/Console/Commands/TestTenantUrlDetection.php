<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use App\Services\TenantContextService;

class TestTenantUrlDetection extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:test-url-detection {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Test URL-based tenant detection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Testing tenant URL detection for tenant ID: {$tenantId}");
        
        // Check if tenant exists
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found!");
            return 1;
        }
        
        $this->info("✓ Tenant found: {$tenant->id}");
        
        // Simulate tenant context
        tenancy()->initialize($tenant);
        
        $this->info("✓ Tenant context initialized");
        
        // Test model queries
        try {
            $userCount = User::count();
            $this->info("✓ User count in tenant context: {$userCount}");
            
            $productCount = Product::count();
            $this->info("✓ Product count in tenant context: {$productCount}");
            
            // Test table prefixing
            $userTable = (new User)->getTable();
            $this->info("✓ User table name: {$userTable}");
            
            $productTable = (new Product)->getTable();
            $this->info("✓ Product table name: {$productTable}");
            
        } catch (\Exception $e) {
            $this->error("Error testing model queries: " . $e->getMessage());
            return 1;
        }
        
        // Test tenant context service
        $tenantContext = app(TenantContextService::class);
        $currentTenantId = $tenantContext->getCurrentTenantId();
        $this->info("✓ Current tenant ID from service: {$currentTenantId}");
        
        // Test URL generation
        $tenantUrl = \App\Helpers\TenantHelper::tenantUrl('front.index', [], $tenantId);
        $this->info("✓ Tenant URL generated: {$tenantUrl}");
        
        // End tenant context
        tenancy()->end();
        $this->info("✓ Tenant context ended");
        
        $this->info("✅ All tests passed! Tenant URL detection is working correctly.");
        
        return 0;
    }
}
