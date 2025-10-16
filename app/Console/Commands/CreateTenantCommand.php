<?php

namespace App\Console\Commands;

use App\Services\SaaSTenantService;
use Illuminate\Console\Command;

class CreateTenantCommand extends Command
{
    protected $signature = 'tenant:create 
                            {--name= : Owner name}
                            {--email= : Owner email}
                            {--password= : Owner password}
                            {--domain= : Custom domain}';

    protected $description = 'Create a new tenant with owner user';

    protected $saasService;

    public function __construct(SaaSTenantService $saasService)
    {
        parent::__construct();
        $this->saasService = $saasService;
    }

    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Owner name');
        $email = $this->option('email') ?: $this->ask('Owner email');
        $password = $this->option('password') ?: $this->secret('Owner password');
        $domain = $this->option('domain');

        if (!$name || !$email || !$password) {
            $this->error('Name, email, and password are required!');
            return 1;
        }

        $this->info('Creating tenant...');
        $this->info('Name: ' . $name);
        $this->info('Email: ' . $email);
        $this->info('Domain: ' . ($domain ?: 'Auto-generated'));

        try {
            $result = $this->saasService->createTenantWithUser([
                'fname' => explode(' ', $name)[0] ?? '',
                'lname' => explode(' ', $name)[1] ?? '',
                'email' => $email,
                'password' => $password,
            ], $domain);

            $this->info('✅ Tenant created successfully!');
            $this->info('Tenant ID: ' . $result['tenant']->id);
            $this->info('Domain: ' . $result['domain']);
            $this->info('Owner: ' . $result['user']->email);

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to create tenant: ' . $e->getMessage());
            return 1;
        }
    }
}
