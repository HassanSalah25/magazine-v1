<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SaaSAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create SaaS Admin user
        User::create([
            'fname' => 'SaaS',
            'lname' => 'Admin',
            'email' => 'saas@admin.com',
            'username' => 'saas_admin',
            'password' => Hash::make('admin123'),
            'email_verified' => 'Yes',
            'is_tenant_owner' => false,
            'tenant_id' => null,
            'domain' => null,
            'status' => 1,
        ]);

        $this->command->info('SaaS Admin user created successfully!');
        $this->command->info('Email: saas@admin.com');
        $this->command->info('Password: admin123');
    }
}
