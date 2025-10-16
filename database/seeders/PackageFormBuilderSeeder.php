<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\PackageInput;
use App\Models\PackageInputOption;

class PackageFormBuilderSeeder extends Seeder
{
    public function run(): void
    {
        $lang = Language::where('is_default', 1)->first();
        if (!$lang) { return; }

        // Text input
        $name = PackageInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'company_name'
        ], [
            'type' => 1,
            'label' => 'Company Name',
            'placeholder' => 'Enter your company name',
            'required' => 1,
        ]);

        // Select input with options
        $plan = PackageInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'target_market'
        ], [
            'type' => 2,
            'label' => 'Target Market',
            'placeholder' => 'Select market',
            'required' => 1,
        ]);
        $plan->package_input_options()->delete();
        foreach (['Local','National','International'] as $opt) {
            $plan->package_input_options()->create(['name' => $opt]);
        }

        // Checkbox input
        $features = PackageInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'features'
        ], [
            'type' => 3,
            'label' => 'Needed Features',
            'placeholder' => '',
            'required' => 0,
        ]);
        $features->package_input_options()->delete();
        foreach (['Blog','Shop','Booking'] as $opt) {
            $features->package_input_options()->create(['name' => $opt]);
        }

        // Textarea
        PackageInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'project_brief'
        ], [
            'type' => 4,
            'label' => 'Project Brief',
            'placeholder' => 'Tell us more...',
            'required' => 0,
        ]);

        // File upload (zip)
        PackageInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'assets_zip'
        ], [
            'type' => 5,
            'label' => 'Assets (zip)',
            'placeholder' => '',
            'required' => 0,
        ]);
    }
}


