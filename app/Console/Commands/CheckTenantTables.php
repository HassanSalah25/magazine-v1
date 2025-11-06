<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckTenantTables extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tenant:check-tables {tenant_id}';

    /**
     * The console command description.
     */
    protected $description = 'Check if tenant tables exist and show their data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        $this->info("Checking tables for tenant ID: {$tenantId}");
        
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
        
        // Check key tables
        $tablesToCheck = ['users', 'products', 'popups', 'settings', 'homes'];
        
        foreach ($tablesToCheck as $tableName) {
            $this->checkTable($tableName);
        }
        
        // End tenant context
        tenancy()->end();
        
        $this->info("✅ Table check completed!");
        
        return 0;
    }
    
    protected function checkTable($tableName)
    {
        try {
            $exists = Schema::hasTable($tableName);
            $this->info("Table '{$tableName}': " . ($exists ? 'EXISTS' : 'NOT EXISTS'));
            
            if ($exists) {
                $count = DB::table($tableName)->count();
                $this->info("  - Records: {$count}");
                
                if ($count > 0) {
                    $sample = DB::table($tableName)->limit(2)->get();
                    $this->info("  - Sample data: " . json_encode($sample->toArray()));
                }
            }
        } catch (\Exception $e) {
            $this->error("Error checking table '{$tableName}': " . $e->getMessage());
        }
    }
}
