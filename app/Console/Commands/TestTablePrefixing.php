<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TestTablePrefixing extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:test-prefixing {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Test table prefixing for tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Testing table prefixing for tenant ID: {$tenantId}");
        
        // Check if tenant exists
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found!");
            return 1;
        }
        
        $this->info("✓ Tenant found: {$tenant->id}");
        
        // Initialize tenant context
        tenancy()->initialize($tenant);
        
        $this->info("✓ Tenant context initialized");
        
        // Test table names
        try {
            $userTable = (new User)->getTable();
            $this->info("✓ User table name: {$userTable}");
            
            $productTable = (new Product)->getTable();
            $this->info("✓ Product table name: {$productTable}");
            
            // Test if we can query the tables
            $userCount = User::count();
            $this->info("✓ User count: {$userCount}");
            
            $productCount = Product::count();
            $this->info("✓ Product count: {$productCount}");
            
            // Test raw query to see what table is actually being used
            $rawQuery = DB::select("SELECT COUNT(*) as count FROM users");
            $this->info("✓ Raw query result: " . json_encode($rawQuery));
            
        } catch (\Exception $e) {
            $this->error("Error testing table prefixing: " . $e->getMessage());
            return 1;
        }
        
        // End tenant context
        tenancy()->end();
        $this->info("✓ Tenant context ended");
        
        $this->info("✅ Table prefixing test completed!");
        
        return 0;
    }
}