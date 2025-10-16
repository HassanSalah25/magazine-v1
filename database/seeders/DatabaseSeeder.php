<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\LandingSectionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PackageFormBuilderSeeder::class,
            PackageWithRelationsSeeder::class,
            QuoteBuilderSeeder::class,
            TenantDataSeeder::class,
        ]);

    }
}
