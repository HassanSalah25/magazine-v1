<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantMigrationService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaaSTenantService
{
    /**
     * Create a new tenant with a user and create tenant tables
     */
    public function createTenantWithUser(array $userData, string $domain = null): array
    {
        // Generate unique tenant ID
        $tenantId = 'tenant_' . Str::random(10);
        
        // Generate subdomain - use custom if provided, otherwise auto-generate
        $currentDomain = $this->getCurrentDomain();
        $domain = $tenantId . '.' . $currentDomain;
        
        // Create the tenant
        $tenant = Tenant::create([
            'id' => $tenantId,
        ]);

        // Create domain for the tenant
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // Create tenant tables using migrations
        $this->createTenantTablesWithMigrations($tenant);
        
        // Audit log the tenant creation
        $this->auditLog('tenant_created', $tenant, [
            'user_data' => $userData,
            'domain' => $domain
        ]);

        // Create the user directly in the prefixed table without tenancy initialization
        $userTable = $tenant->id . '_users';
        
        // Use raw SQL to insert into the prefixed table
        DB::connection('central')->table($userTable)->insert([
            'fname' => $userData['fname'] ?? '',
            'lname' => $userData['lname'] ?? '',
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'username' => $userData['username'] ?? $userData['email'],
            'tenant_id' => $tenantId,
            'domain' => $domain,
            'is_tenant_owner' => true,
            'status' => 1,
            'email_verified' => 'yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Get the created user
        $user = DB::connection('central')->table($userTable)->where('email', $userData['email'])->first();

        return [
            'tenant' => $tenant,
            'user' => $user,
            'domain' => $domain
        ];
    }

    /**
     * Create tenant tables using migrations
     */
    protected function createTenantTablesWithMigrations(Tenant $tenant): void
    {
        try {
            // Validate tenant ownership and authorization
            $this->validateTenantCreation($tenant);
            
            // Use migration service to create tables
            $migrationService = new TenantMigrationService();
            $migrationService->createTenantTables($tenant);
            
            \Log::info("Created tenant tables using migrations for tenant: {$tenant->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to create tenant tables for tenant {$tenant->id}: " . $e->getMessage());
            throw new \Exception("Failed to create tenant tables: " . $e->getMessage());
        }
    }

    /**
     * Create tenant tables with prefix (legacy method - kept for backward compatibility)
     */
    protected function createTenantTables(Tenant $tenant): void
    {
        try {
            // Validate tenant ownership and authorization
            $this->validateTenantCreation($tenant);
            
            $prefix = $this->getTablePrefix($tenant);
            
            // Get all tables from central database
            $tables = $this->getCentralTables();
            
            foreach ($tables as $table) {
                // Skip system tables and tenant management tables
                if ($this->shouldSkipTable($table)) {
                    continue;
                }
                
                // Create table with proper tenant isolation
                $this->createTableWithPrefix($table, $prefix, $tenant);
            }
            
            \Log::info("Created tenant tables with prefix: {$prefix} for tenant: {$tenant->id}");
        } catch (\Exception $e) {
            \Log::error("Failed to create tenant tables for tenant {$tenant->id}: " . $e->getMessage());
            throw new \Exception("Failed to create tenant tables: " . $e->getMessage());
        }
    }

    /**
     * Verify that tables exist in tenant database
     */
    protected function verifyTablesExist(Tenant $tenant): void
    {
        $tables = DB::select('SHOW TABLES');
        $tableCount = count($tables);
        
        if ($tableCount < 10) {
            throw new \Exception("Not enough tables created in tenant database. Found: {$tableCount}");
        }
        
        \Log::info("Tenant database has {$tableCount} tables");
    }

    /**
     * Clone central database data to tenant database
     */
    protected function cloneCentralDataToTenant(Tenant $tenant): void
    {
        // Get all tables from central databa   se
        $centralTables = $this->getCentralDatabaseTables();
        
        foreach ($centralTables as $table) {
            // Skip tenant-specific tables and system tables
            if (in_array($table, ['tenants', 'domains', 'users', 'migrations', 'password_resets', 'failed_jobs'])) {
                continue;
            }
            
            try {
                // Check if table exists in tenant database
                $tableExists = DB::select("SHOW TABLES LIKE '{$table}'");
                if (empty($tableExists)) {
                    \Log::warning("Table {$table} does not exist in tenant database, skipping...");
                    continue;
                }
                
                // Check if table already has data (from seeders)
                $existingData = DB::table($table)->count();
                if ($existingData > 0) {
                    \Log::info("Table {$table} already has {$existingData} records, skipping data cloning...");
                    continue;
                }
                
                // Get data from central database
                $data = DB::connection('central')->table($table)->get();
              
                if ($data->isNotEmpty()) {
                    // Convert to array and insert data into tenant database
                    $dataArray = $data->map(function ($item) {
                        return (array) $item;
                    })->toArray();
                    
                    if (!empty($dataArray)) {
                        DB::table($table)->insert($dataArray);
                        \Log::info("Cloned {$data->count()} records to table {$table}");
                    }
                }
            } catch (\Exception $e) {
                // Log error but continue with other tables
                \Log::warning("Failed to clone table {$table}: " . $e->getMessage());
                continue;
            }
        }
    }

    /**
     * Get all table names from central database
     */
    protected function getCentralDatabaseTables(): array
    {
        $tables = DB::connection('central')->select('SHOW TABLES');
        $tableNames = [];
        
        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }
        
        return $tableNames;
    }

    /**
     * Add user to existing tenant
     */
    public function addUserToTenant(string $tenantId, array $userData): User
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        $user = User::create([
            'fname' => $userData['fname'] ?? '',
            'lname' => $userData['lname'] ?? '',
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'username' => $userData['username'] ?? $userData['email'],
            'tenant_id' => $tenantId,
            'domain' => $tenant->domains()->first()->domain,
            'is_tenant_owner' => false,
            'status' => 1,
            'email_verified' => 'yes',
        ]);

        return $user;
    }

    /**
     * Get tenant by domain
     */
    public function getTenantByDomain(string $domain): ?Tenant
    {
        return Tenant::whereHas('domains', function ($query) use ($domain) {
            $query->where('domain', $domain);
        })->first();
    }

    /**
     * Update tenant domain
     */
    public function updateTenantDomain(string $tenantId, string $newDomain): bool
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        // Update domain
        $tenant->domains()->update(['domain' => $newDomain]);
        
        // Update all users in this tenant
        User::where('tenant_id', $tenantId)->update(['domain' => $newDomain]);
        
        return true;
    }

    /**
     * Delete tenant and all associated data
     */
    public function deleteTenant(string $tenantId): bool
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        try {
            // Delete tenant tables
            $this->deleteTenantTables($tenant);
            
            // Delete all users in tenant
            User::where('tenant_id', $tenantId)->delete();
            
            // Delete tenant
            $tenant->delete();
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete tenant: " . $e->getMessage());
        }
    }

    /**
     * Copy database structure from central to tenant database
     */
    protected function copyDatabaseStructure(Tenant $tenant): void
    {
        try {
            // Get the central database name
            $centralDbName = env('DB_DATABASE', 'wolves_dashboard_db');
            $username = env('DB_USERNAME', 'root');
            $password = env('DB_PASSWORD', '');
            $host = env('DB_HOST', '127.0.0.1');
            $port = env('DB_PORT', '3306');
            
            // Use a simpler approach - copy structure using Laravel's DB facade
            $this->copyDatabaseStructureUsingLaravel($tenant, $centralDbName);
            
            \Log::info("Database structure copied successfully");
        } catch (\Exception $e) {
            \Log::error("Failed to copy database structure: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Copy database structure using Laravel's DB facade (structure only, no data)
     */
    protected function copyDatabaseStructureUsingLaravel(Tenant $tenant, string $centralDbName): void
    {
        // Get all tables from central database
        $tables = DB::connection('central')->select('SHOW TABLES');
        
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            
            // Skip system tables and tenant-specific tables
            if (in_array($tableName, ['migrations', 'password_resets', 'failed_jobs', 'tenants', 'domains', 'users'])) {
                continue;
            }
            
            try {
                // Get table structure only (no data)
                $createTable = DB::connection('central')->select("SHOW CREATE TABLE `{$tableName}`");
                $createStatement = $createTable[0]->{'Create Table'};
                
                // Create table in tenant database (structure only)
                DB::statement($createStatement);
                
                \Log::info("Created table structure: {$tableName}");
            } catch (\Exception $e) {
                \Log::warning("Failed to create table {$tableName}: " . $e->getMessage());
                continue;
            }
        }
        
        // Create essential tables for tenant
        $this->createEssentialTenantTables($tenant);
    }

    /**
     * Create essential tables for tenant (users, migrations, etc.)
     */
    protected function createEssentialTenantTables(Tenant $tenant): void
    {
        try {
            // Create users table structure
            $usersTable = DB::connection('central')->select("SHOW CREATE TABLE `users`");
            $usersStatement = $usersTable[0]->{'Create Table'};
            DB::statement($usersStatement);
            
            // Create migrations table
            DB::statement("
                CREATE TABLE `migrations` (
                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                    `migration` varchar(255) NOT NULL,
                    `batch` int(11) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            
            \Log::info("Created essential tenant tables");
        } catch (\Exception $e) {
            \Log::warning("Failed to create essential tables: " . $e->getMessage());
        }
    }

    /**
     * Switch to tenant database
     */
    protected function switchToTenantDatabase(Tenant $tenant): void
    {
        DB::purge('mysql');
        config(['database.connections.mysql.database' => $tenant->tenancy_db_name]);
        DB::reconnect('mysql');
    }

    /**
     * Switch back to central database
     */
    protected function switchToCentralDatabase(): void
    {
        DB::purge('mysql');
        config(['database.connections.mysql.database' => env('DB_DATABASE', 'wolves_dashboard_db')]);
        DB::reconnect('mysql');
    }

    /**
     * Get the current domain for subdomain generation
     */
    protected function getCurrentDomain(): string
    {
        // Get domain from request if available
        if (request()->hasHeader('Host')) {
            $host = request()->header('Host');
            // Remove port if present
            $domain = explode(':', $host)[0];
            return $domain;
        }
        
        // Fallback to environment or config
        $domain = env('APP_DOMAIN', 'localhost');
        
        // If running on localhost, use a more descriptive domain
        if ($domain === 'localhost' || $domain === '127.0.0.1') {
            $domain = 'wolves.localhost';
        }
        
        return $domain;
    }

    /**
     * Get table prefix for tenant
     */
    protected function getTablePrefix(Tenant $tenant): string
    {
        // The tenant ID already includes the 'tenant_' prefix, so we just need to add the underscore
        $tenantId = $tenant->getKey();
        $suffix = config('tenancy.database.suffix', '');
        
        return $tenantId . '_' . $suffix;
    }

    /**
     * Get all tables from central database
     */
    protected function getCentralTables(): array
    {
        $tables = DB::connection('central')->select('SHOW TABLES');
        $tableNames = [];
        
        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }
        
        return $tableNames;
    }

    /**
     * Check if table should be skipped
     */
    protected function shouldSkipTable(string $table): bool
    {
        $skipTables = [
            'migrations',
            'password_resets',
            'failed_jobs',
            'tenants',
            'domains',
            'personal_access_tokens',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'sessions',
            'tenant_management'
        ];
        
        return in_array($table, $skipTables);
    }

    /**
     * Create table with prefix
     */
    protected function createTableWithPrefix(string $originalTable, string $prefix, Tenant $tenant): void
    {
        try {
            // Validate that the prefix matches the tenant
            $this->validateTablePrefix($prefix, $tenant);
            
            // Check if table already exists to prevent conflicts
            $prefixedTable = $prefix . $originalTable;
            if ($this->tableExists($prefixedTable)) {
                \Log::warning("Table {$prefixedTable} already exists, skipping creation");
                return;
            }
            
            // Get table structure
            $createTable = DB::connection('central')->select("SHOW CREATE TABLE `{$originalTable}`");
            $createStatement = $createTable[0]->{'Create Table'};
            
            // Replace foreign key references BEFORE replacing table name
            // This prevents double-prefixing issues
            $createStatement = $this->replaceForeignKeyReferences($createStatement, $prefix);
            
            // Replace constraint names to avoid conflicts
            $createStatement = $this->replaceConstraintNames($createStatement, $prefix);
            
            // Replace table name with prefixed version
            $createStatement = str_replace("CREATE TABLE `{$originalTable}`", "CREATE TABLE `{$prefixedTable}`", $createStatement);
            
            // Create the table
            DB::connection('central')->statement($createStatement);
            
            \Log::info("Created table: {$prefixedTable} for tenant: {$tenant->id}");
        } catch (\Exception $e) {
            \Log::warning("Failed to create table {$originalTable} with prefix {$prefix} for tenant {$tenant->id}: " . $e->getMessage());
        }
    }


    /**
     * Replace foreign key references in CREATE TABLE statement
     */
    protected function replaceForeignKeyReferences(string $createStatement, string $prefix): string
    {
        // Get all tables from central database to find potential foreign key references
        $centralTables = $this->getCentralTables();
        
        // Process foreign key replacements in a single pass to avoid double-prefixing
        $replacements = [];
        
        foreach ($centralTables as $table) {
            $prefixedTable = $prefix . $table;
            
            // Handle different foreign key reference patterns
            $patterns = [
                "REFERENCES `{$table}`",
                "REFERENCES `{$table}` (`id`)",
                "REFERENCES `{$table}` (`id`) ON DELETE CASCADE",
                "REFERENCES `{$table}` (`id`) ON DELETE SET NULL",
                "REFERENCES `{$table}` (`id`) ON UPDATE CASCADE",
                "REFERENCES `{$table}` (`id`) ON UPDATE SET NULL"
            ];
            
            foreach ($patterns as $pattern) {
                $prefixedPattern = str_replace("`{$table}`", "`{$prefixedTable}`", $pattern);
                
                // Only add to replacements if the pattern exists and hasn't been replaced yet
                if (strpos($createStatement, $pattern) !== false && strpos($createStatement, $prefixedPattern) === false) {
                    $replacements[$pattern] = $prefixedPattern;
                }
            }
        }
        
        // Apply all replacements at once
        foreach ($replacements as $pattern => $replacement) {
            $createStatement = str_replace($pattern, $replacement, $createStatement);
            \Log::info("Replaced foreign key reference: {$pattern} -> {$replacement}");
        }
        
        // Additional regex-based replacement for any missed foreign key references
        $createStatement = $this->replaceForeignKeyReferencesWithRegex($createStatement, $prefix);
        
        return $createStatement;
    }

    /**
     * Replace foreign key references using regex for comprehensive coverage
     */
    protected function replaceForeignKeyReferencesWithRegex(string $createStatement, string $prefix): string
    {
        // Get all tables from central database
        $centralTables = $this->getCentralTables();
        
        foreach ($centralTables as $table) {
            $prefixedTable = $prefix . $table;
            
            // Only replace if the table reference is not already prefixed
            $pattern = '/REFERENCES `' . preg_quote($table, '/') . '`/';
            $replacement = "REFERENCES `{$prefixedTable}`";
            
            // Check if the table reference is already prefixed (contains tenant_)
            if (preg_match($pattern, $createStatement)) {
                // Only replace if it's not already a tenant table
                if (!preg_match('/REFERENCES `tenant_[^`]+_' . preg_quote($table, '/') . '`/', $createStatement)) {
                    $createStatement = preg_replace($pattern, $replacement, $createStatement);
                }
            }
        }
        
        return $createStatement;
    }

    /**
     * Replace constraint names to avoid conflicts
     */
    protected function replaceConstraintNames(string $createStatement, string $prefix): string
    {
        // Find all constraint names in the CREATE statement
        preg_match_all('/CONSTRAINT `([^`]+)`/', $createStatement, $matches);
        
        foreach ($matches[1] as $constraintName) {
            $prefixedConstraintName = $prefix . $constraintName;
            
            // Truncate constraint name if it's too long (MySQL limit is 64 characters)
            if (strlen($prefixedConstraintName) > 64) {
                $truncatedName = substr($prefixedConstraintName, 0, 64);
                \Log::info("Truncated constraint name from {$prefixedConstraintName} to {$truncatedName}");
                $prefixedConstraintName = $truncatedName;
            }
            
            $createStatement = str_replace("CONSTRAINT `{$constraintName}`", "CONSTRAINT `{$prefixedConstraintName}`", $createStatement);
            \Log::info("Replaced constraint name: {$constraintName} -> {$prefixedConstraintName}");
        }
        
        return $createStatement;
    }

    /**
     * Cleanup tenant if creation fails
     */
    protected function cleanupTenant(Tenant $tenant): void
    {
        try {
            // Delete tenant tables
            $this->deleteTenantTables($tenant);
            
            // Delete tenant users
            User::where('tenant_id', $tenant->id)->delete();
            
            // Delete tenant
            $tenant->delete();
        } catch (\Exception $e) {
            // Log error but don't throw
            \Log::error("Failed to cleanup tenant: " . $e->getMessage());
        }
    }

    /**
     * Delete tenant tables with prefix
     */
    protected function deleteTenantTables(Tenant $tenant): void
    {
        try {
            $prefix = $this->getTablePrefix($tenant);
            
            // Get all tables with this prefix
            $tables = DB::connection('central')->select("SHOW TABLES LIKE '{$prefix}%'");
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                DB::connection('central')->statement("DROP TABLE IF EXISTS `{$tableName}`");
                \Log::info("Dropped table: {$tableName}");
            }
        } catch (\Exception $e) {
            \Log::error("Failed to delete tenant tables: " . $e->getMessage());
        }
    }

    /**
     * Validate tenant creation authorization
     */
    protected function validateTenantCreation(Tenant $tenant): void
    {
        // Check if user is authenticated and authorized to create tenants
        if (!auth()->check()) {
            throw new \Exception("Unauthorized: User must be authenticated to create tenant tables");
        }

        $user = auth()->user();

        // Basic authorization check - user must be authenticated
        // You can add more specific checks here based on your requirements
        if (!$user) {
            throw new \Exception("Unauthorized: User not found");
        }

        // Check if user is a super admin or has tenant creation permissions
        if (!$this->userCanCreateTenants($user)) {
            throw new \Exception("Unauthorized: User does not have permission to create tenant tables");
        }

        // Validate tenant ID format
        if (!preg_match('/^tenant_[a-zA-Z0-9]{10}$/', $tenant->id)) {
            throw new \Exception("Invalid tenant ID format: {$tenant->id}");
        }

        // Check if tenant already has tables (prevent duplicate creation)
        $existingTables = $this->getTenantTables($tenant);
        if (count($existingTables) > 0) {
            throw new \Exception("Tenant {$tenant->id} already has tables. Cannot recreate.");
        }

        \Log::info("Tenant creation validated for tenant: {$tenant->id} by user: " . auth()->id());
    }

    /**
     * Validate table prefix matches tenant
     */
    protected function validateTablePrefix(string $prefix, Tenant $tenant): void
    {
        $expectedPrefix = $this->getTablePrefix($tenant);
        
        if ($prefix !== $expectedPrefix) {
            throw new \Exception("Table prefix mismatch. Expected: {$expectedPrefix}, Got: {$prefix}");
        }

        // Ensure prefix contains tenant ID
        if (strpos($prefix, $tenant->id) === false) {
            throw new \Exception("Table prefix does not contain tenant ID: {$tenant->id}");
        }
    }

    /**
     * Check if table exists
     */
    protected function tableExists(string $tableName): bool
    {
        try {
            $result = DB::connection('central')->select("SHOW TABLES LIKE '{$tableName}'");
            return count($result) > 0;
        } catch (\Exception $e) {
            \Log::error("Error checking if table exists: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get existing tables for a tenant
     */
    protected function getTenantTables(Tenant $tenant): array
    {
        try {
            $prefix = $this->getTablePrefix($tenant);
            $tables = DB::connection('central')->select("SHOW TABLES LIKE '{$prefix}%'");
            
            $tableNames = [];
            foreach ($tables as $table) {
                $tableNames[] = array_values((array) $table)[0];
            }
            
            return $tableNames;
        } catch (\Exception $e) {
            \Log::error("Error getting tenant tables: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Audit log for tenant operations
     */
    protected function auditLog(string $action, Tenant $tenant, array $data = []): void
    {
        $logData = [
            'action' => $action,
            'tenant_id' => $tenant->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
            'data' => $data
        ];

        \Log::channel('audit')->info("Tenant operation: {$action}", $logData);
    }

    /**
     * Check if user can create tenants
     */
    protected function userCanCreateTenants($user): bool
    {
        // For now, allow any authenticated user to create tenants
        // You can customize this logic based on your requirements
        
        // Check if user has a specific role or permission
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole(['super_admin', 'admin']) || $user->can('create_tenant');
        }
        
        // Check if user has a specific field indicating admin status
        if (property_exists($user, 'is_admin') && $user->is_admin) {
            return true;
        }
        
        // Check if user has a specific field indicating super admin status
        if (property_exists($user, 'is_super_admin') && $user->is_super_admin) {
            return true;
        }
        
        // For SaaS admin users, allow tenant creation
        if (property_exists($user, 'is_saas_admin') && $user->is_saas_admin) {
            return true;
        }
        
        // Default: allow any authenticated user (you can change this)
        return true;
    }
}
