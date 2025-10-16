<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\QuoteInput;
use App\Models\QuoteInputOption;

class QuoteBuilderSeeder extends Seeder
{
    public function run(): void
    {
        $lang = Language::where('is_default', 1)->first();
        if (!$lang) { 
            $this->command->warn('No default language found. Skipping quote builder seeding.');
            return; 
        }

        $this->command->info('Seeding quote builder inputs...');

        // 1. Company Name (Text Input)
        $companyName = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'company_name'
        ], [
            'type' => 1, // text
            'label' => 'Company Name',
            'placeholder' => 'Enter your company name',
            'required' => 1,
        ]);
        $this->command->info('✓ Created company name input');

        // 2. Contact Person (Text Input)
        $contactPerson = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'contact_person'
        ], [
            'type' => 1, // text
            'label' => 'Contact Person',
            'placeholder' => 'Enter contact person name',
            'required' => 1,
        ]);
        $this->command->info('✓ Created contact person input');

        // 3. Email (Text Input)
        $email = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'email'
        ], [
            'type' => 1, // text
            'label' => 'Email Address',
            'placeholder' => 'Enter your email address',
            'required' => 1,
        ]);
        $this->command->info('✓ Created email input');

        // 4. Phone (Text Input)
        $phone = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'phone'
        ], [
            'type' => 1, // text
            'label' => 'Phone Number',
            'placeholder' => 'Enter your phone number',
            'required' => 0,
        ]);
        $this->command->info('✓ Created phone input');

        // 5. Project Type (Select Input)
        $projectType = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'project_type'
        ], [
            'type' => 2, // select
            'label' => 'Project Type',
            'placeholder' => 'Select project type',
            'required' => 1,
        ]);
        
        // Clear existing options and create new ones
        $projectType->quote_input_options()->delete();
        $projectOptions = [
            'Website Development',
            'Mobile App Development',
            'E-commerce Platform',
            'Web Application',
            'API Development',
            'System Integration',
            'Digital Marketing',
            'SEO Services',
            'Other'
        ];
        
        foreach ($projectOptions as $option) {
            $projectType->quote_input_options()->create(['name' => $option]);
        }
        $this->command->info('✓ Created project type select with ' . count($projectOptions) . ' options');

        // 6. Budget Range (Select Input)
        $budgetRange = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'budget_range'
        ], [
            'type' => 2, // select
            'label' => 'Budget Range',
            'placeholder' => 'Select your budget range',
            'required' => 1,
        ]);
        
        $budgetRange->quote_input_options()->delete();
        $budgetOptions = [
            'Under $5000',
            '$5000 - $10000',
            '$10000 - $25000',
            '$25000 - $50000',
            '$50000 - $100000',
            'Over $100000',
            'To be discussed'
        ];
        
        foreach ($budgetOptions as $option) {
            $budgetRange->quote_input_options()->create(['name' => $option]);
        }
        $this->command->info('✓ Created budget range select with ' . count($budgetOptions) . ' options');

        // 7. Timeline (Select Input)
        $timeline = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'timeline'
        ], [
            'type' => 2, // select
            'label' => 'Project Timeline',
            'placeholder' => 'Select project timeline',
            'required' => 1,
        ]);
        
        $timeline->quote_input_options()->delete();
        $timelineOptions = [
            'ASAP (Rush)',
            '1-2 months',
            '2-3 months',
            '3-6 months',
            '6+ months',
            'Flexible'
        ];
        
        foreach ($timelineOptions as $option) {
            $timeline->quote_input_options()->create(['name' => $option]);
        }
        $this->command->info('✓ Created timeline select with ' . count($timelineOptions) . ' options');

        // 8. Required Features (Checkbox Input)
        $features = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'required_features'
        ], [
            'type' => 3, // checkbox
            'label' => 'Required Features',
            'placeholder' => '',
            'required' => 0,
        ]);
        
        $features->quote_input_options()->delete();
        $featureOptions = [
            'User Authentication',
            'Payment Integration',
            'Admin Dashboard',
            'Mobile Responsive',
            'SEO Optimization',
            'Content Management',
            'Database Integration',
            'API Development',
            'Third-party Integrations',
            'Analytics & Reporting',
            'Multi-language Support',
            'Security Features'
        ];
        
        foreach ($featureOptions as $option) {
            $features->quote_input_options()->create(['name' => $option]);
        }
        $this->command->info('✓ Created features checkbox with ' . count($featureOptions) . ' options');

        // 9. Technology Preferences (Checkbox Input)
        $technologies = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'technology_preferences'
        ], [
            'type' => 3, // checkbox
            'label' => 'Technology Preferences',
            'placeholder' => '',
            'required' => 0,
        ]);
        
        $technologies->quote_input_options()->delete();
        $techOptions = [
            'Laravel (PHP)',
            'React.js',
            'Vue.js',
            'Angular',
            'Node.js',
            'Python/Django',
            'WordPress',
            'Shopify',
            'MySQL',
            'PostgreSQL',
            'MongoDB',
            'AWS',
            'Google Cloud',
            'Docker',
            'No preference'
        ];
        
        foreach ($techOptions as $option) {
            $technologies->quote_input_options()->create(['name' => $option]);
        }
        $this->command->info('✓ Created technology preferences checkbox with ' . count($techOptions) . ' options');

        // 10. Project Description (Textarea)
        $projectDescription = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'project_description'
        ], [
            'type' => 4, // textarea
            'label' => 'Project Description',
            'placeholder' => 'Please describe your project in detail. Include goals, target audience, specific requirements, and any other relevant information.',
            'required' => 1,
        ]);
        $this->command->info('✓ Created project description textarea');

        // 11. Additional Requirements (Textarea)
        $additionalRequirements = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'additional_requirements'
        ], [
            'type' => 4, // textarea
            'label' => 'Additional Requirements',
            'placeholder' => 'Any additional requirements, constraints, or special considerations?',
            'required' => 0,
        ]);
        $this->command->info('✓ Created additional requirements textarea');

        // 12. File Upload (File Input)
        $fileUpload = QuoteInput::updateOrCreate([
            'language_id' => $lang->id,
            'name' => 'project_files'
        ], [
            'type' => 5, // file
            'label' => 'Project Files',
            'placeholder' => '',
            'required' => 0,
        ]);
        $this->command->info('✓ Created file upload input');

        $this->command->info('Quote builder seeding completed successfully!');
        $this->command->info('Created ' . QuoteInput::where('language_id', $lang->id)->count() . ' quote inputs.');
    }
}
