<?php

namespace Database\Seeders;

use App\Models\BasicExtra;
use App\Models\Language;
use Illuminate\Database\Seeder;

class ComparisonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = Language::all();
        
        foreach ($languages as $language) {
            $abex = BasicExtra::where('language_id', $language->id)->first();
            
            if ($abex) {
                // Update comparison section data
                $abex->comparison_section = 1;
                $abex->comparison_title = 'Unlock a 20% increase in ROI with our award-winning enterprise SEO solutions';
                $abex->comparison_subtitle = 'Compare our comprehensive approach with typical agencies and in-house solutions';
                
                // Column 1 (SEO Wolves) data
                $abex->comparison_col1_title = 'SEO Wolves';
                $abex->comparison_col1_features = [
                    ['text' => 'Dedicated account manager with an in-house team to develop and implement assets', 'type' => 'check'],
                    ['text' => 'All-in-one platform for optimizing, measuring, and reporting SEO\'s ROI', 'type' => 'check'],
                    ['text' => 'Built from your business objectives, market changes, and overall marketing efforts', 'type' => 'check'],
                    ['text' => 'In-house project management software, 24/7 help desk, and direct client phone line', 'type' => 'check']
                ];
                
                // Column 2 (Typical SEO agency) data
                $abex->comparison_col2_title = 'Typical SEO agency';
                $abex->comparison_col2_features = [
                    ['text' => 'Dedicated account manager that\'ll need your time to develop and implement assets', 'type' => 'check'],
                    ['text' => 'Third-party toolkit for tracking SEO\'s performance with subscription costs passed to you', 'type' => 'cross'],
                    ['text' => 'Copy-and-paste checklist for optimizing your site and (hopefully) delivering results', 'type' => 'cross']
                ];
                
                // Column 3 (In-house SEO) data
                $abex->comparison_col3_title = 'In-house SEO';
                $abex->comparison_col3_features = [
                    ['text' => 'One or more team members searching for the time to optimize 200+ ranking factors', 'type' => 'cross'],
                    ['text' => 'Free and paid tools for auditing, monitoring, and measuring rankings and traffic', 'type' => 'cross'],
                    ['text' => 'S.M.A.R.T. goals, but difficult to achieve with limited resources, time, and skillsets', 'type' => 'check'],
                    ['text' => 'Varied with documentation gaps leading to project delays and wasted budget.', 'type' => 'cross']
                ];
                
                $abex->save();
            }
        }
    }
}