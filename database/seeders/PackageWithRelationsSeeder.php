<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Package;

class PackageWithRelationsSeeder extends Seeder
{
    public function run(): void
    {
        $lang = Language::where('is_default', 1)->first();
        if (!$lang) { return; }

        // Example categories/services; skip if tables absent
        $scategory = null;
        $service = null;
        
        if (class_exists('App\\Models\\ServiceCategory')) {
            $scategory = \App\Models\ServiceCategory::first();
        }
        
        if (class_exists('App\\Models\\Service')) {
            $service = \App\Models\Service::first();
        }

        // Home-only package
        Package::updateOrCreate(
            ['title' => 'Home Starter', 'language_id' => $lang->id],
            [
                'price' => 49.00,
                'description' => "SEO audit, basic optimizations\nEmail support",
                'serial_number' => 1,
                'feature' => 1, // show on home
                'order_status' => 1,
            ]
        );

        // Package related to service category (scategory)
        if ($scategory) {
            Package::updateOrCreate(
                ['title' => 'Category Pro', 'language_id' => $lang->id, 'serviceable_type' => get_class($scategory), 'serviceable_id' => $scategory->id],
                [
                    'price' => 99.00,
                    'description' => "Advanced features for category",
                    'serial_number' => 2,
                    'order_status' => 1,
                ]
            );
        }

        // Package related to specific service
        if ($service) {
            Package::updateOrCreate(
                ['title' => 'Service Growth', 'language_id' => $lang->id, 'serviceable_type' => get_class($service), 'serviceable_id' => $service->id],
                [
                    'price' => 149.00,
                    'description' => "Growth plan tied to specific service",
                    'serial_number' => 3,
                    'order_status' => 1,
                ]
            );
        }
    }
}


