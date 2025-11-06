<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;

class FreeAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abe'] = $lang->basic_extended;

        return view('admin.free-analysis.index', $data);
    }

    public function update(Request $request, $langid)
    {
        $request->validate([
            'free_analysis_meta_keywords' => 'nullable|max:255',
            'free_analysis_meta_description' => 'nullable|max:255',
            'free_analysis_hero_subtitle' => 'nullable|max:255',
            'free_analysis_hero_title_1' => 'nullable|max:255',
            'free_analysis_hero_title_2' => 'nullable|max:255',
            'free_analysis_hero_title_3' => 'nullable|max:255',
            'free_analysis_hero_description' => 'nullable|max:500',
            'free_analysis_hero_button_1_text' => 'nullable|max:255',
            'free_analysis_hero_button_1_url' => 'nullable|max:255',
            'free_analysis_hero_button_2_text' => 'nullable|max:255',
            'free_analysis_hero_button_2_url' => 'nullable|max:255',
            'free_analysis_form_placeholder' => 'nullable|max:255',
            'free_analysis_form_button_text' => 'nullable|max:255',
            'free_analysis_step_subtitle' => 'nullable|max:255',
            'free_analysis_step_title' => 'nullable|max:255',
            'free_analysis_step_description' => 'nullable|max:500',
            'free_analysis_step_1_title' => 'nullable|max:255',
            'free_analysis_step_1_description' => 'nullable|max:500',
            // Color fields
            'free_analysis_primary_color' => 'nullable|regex:/^#[a-fA-F0-9]{6}$/',
            'free_analysis_secondary_color' => 'nullable|regex:/^#[a-fA-F0-9]{6}$/',
            'free_analysis_accent_color' => 'nullable|regex:/^#[a-fA-F0-9]{6}$/',
            'free_analysis_text_color' => 'nullable|regex:/^#[a-fA-F0-9]{6}$/',
            'free_analysis_background_color' => 'nullable|regex:/^#[a-fA-F0-9]{6}$/',
            // Additional content fields
            'free_analysis_features_title' => 'nullable|max:255',
            'free_analysis_features_subtitle' => 'nullable|max:255',
            'free_analysis_feature_1_title' => 'nullable|max:255',
            'free_analysis_feature_1_description' => 'nullable|max:500',
            'free_analysis_feature_2_title' => 'nullable|max:255',
            'free_analysis_feature_2_description' => 'nullable|max:500',
            'free_analysis_feature_3_title' => 'nullable|max:255',
            'free_analysis_feature_3_description' => 'nullable|max:500',
            // Footer fields
            'free_analysis_footer_text' => 'nullable|max:255',
            'free_analysis_footer_description' => 'nullable|max:500',
            // Analytics fields
            'free_analysis_google_analytics_id' => 'nullable|max:255',
            'free_analysis_facebook_pixel_id' => 'nullable|max:255',
            // Page settings
            'free_analysis_page_layout' => 'nullable|in:full-width,sidebar,centered',
            // Image fields (now accepting file paths from file manager)
            'free_analysis_hero_shape_1' => 'nullable|max:255',
            'free_analysis_hero_shape_2' => 'nullable|max:255',
            'free_analysis_hero_shape_3' => 'nullable|max:255',
            'free_analysis_hero_shape_4' => 'nullable|max:255',
            'free_analysis_hero_thumb' => 'nullable|max:255',
            'free_analysis_step_about_1' => 'nullable|max:255',
            'free_analysis_step_shape_1' => 'nullable|max:255',
            'free_analysis_step_shape_2' => 'nullable|max:255',
            'free_analysis_step_shape_3' => 'nullable|max:255',
            'free_analysis_step_shape_4' => 'nullable|max:255',
            // New dynamic fields
            'free_analysis_form_title' => 'nullable|max:255',
            'free_analysis_form_subtitle' => 'nullable|max:255',
            'free_analysis_form_label' => 'nullable|max:255',
            'free_analysis_form_help' => 'nullable|max:255',
            'free_analysis_feature_1_desc' => 'nullable|max:500',
            'free_analysis_feature_2_desc' => 'nullable|max:500',
            'free_analysis_feature_3_desc' => 'nullable|max:500',
            // Feature cards (6)
            'free_analysis_feature_card_1_title' => 'nullable|max:255',
            'free_analysis_feature_card_1_desc' => 'nullable|max:500',
            'free_analysis_feature_card_2_title' => 'nullable|max:255',
            'free_analysis_feature_card_2_desc' => 'nullable|max:500',
            'free_analysis_feature_card_3_title' => 'nullable|max:255',
            'free_analysis_feature_card_3_desc' => 'nullable|max:500',
            'free_analysis_feature_card_4_title' => 'nullable|max:255',
            'free_analysis_feature_card_4_desc' => 'nullable|max:500',
            'free_analysis_feature_card_5_title' => 'nullable|max:255',
            'free_analysis_feature_card_5_desc' => 'nullable|max:500',
            'free_analysis_feature_card_6_title' => 'nullable|max:255',
            'free_analysis_feature_card_6_desc' => 'nullable|max:500',
        ]);

        $be = BasicExtended::where('language_id', $langid)->firstOrFail();
        
        // Meta fields
        $be->free_analysis_meta_keywords = $request->free_analysis_meta_keywords;
        $be->free_analysis_meta_description = $request->free_analysis_meta_description;
        
        // Hero section fields
        $be->free_analysis_hero_subtitle = $request->free_analysis_hero_subtitle;
        $be->free_analysis_hero_title_1 = $request->free_analysis_hero_title_1;
        $be->free_analysis_hero_title_2 = $request->free_analysis_hero_title_2;
        $be->free_analysis_hero_title_3 = $request->free_analysis_hero_title_3;
        $be->free_analysis_hero_description = $request->free_analysis_hero_description;
        $be->free_analysis_hero_button_1_text = $request->free_analysis_hero_button_1_text;
        $be->free_analysis_hero_button_1_url = $request->free_analysis_hero_button_1_url;
        $be->free_analysis_hero_button_2_text = $request->free_analysis_hero_button_2_text;
        $be->free_analysis_hero_button_2_url = $request->free_analysis_hero_button_2_url;
        $be->free_analysis_form_placeholder = $request->free_analysis_form_placeholder;
        $be->free_analysis_form_button_text = $request->free_analysis_form_button_text;
        
        // Step section fields
        $be->free_analysis_step_subtitle = $request->free_analysis_step_subtitle;
        $be->free_analysis_step_title = $request->free_analysis_step_title;
        $be->free_analysis_step_description = $request->free_analysis_step_description;
        $be->free_analysis_step_1_title = $request->free_analysis_step_1_title;
        $be->free_analysis_step_1_description = $request->free_analysis_step_1_description;
        
        // Color fields
        $be->free_analysis_primary_color = $request->free_analysis_primary_color ?: '#00a651';
        $be->free_analysis_secondary_color = $request->free_analysis_secondary_color ?: '#007bff';
        $be->free_analysis_accent_color = $request->free_analysis_accent_color ?: '#ffc107';
        $be->free_analysis_text_color = $request->free_analysis_text_color ?: '#333333';
        $be->free_analysis_background_color = $request->free_analysis_background_color ?: '#ffffff';
        
        // Additional content fields
        $be->free_analysis_features_title = $request->free_analysis_features_title;
        $be->free_analysis_features_subtitle = $request->free_analysis_features_subtitle;
        $be->free_analysis_feature_1_title = $request->free_analysis_feature_1_title;
        $be->free_analysis_feature_1_description = $request->free_analysis_feature_1_description;
        $be->free_analysis_feature_2_title = $request->free_analysis_feature_2_title;
        $be->free_analysis_feature_2_description = $request->free_analysis_feature_2_description;
        $be->free_analysis_feature_3_title = $request->free_analysis_feature_3_title;
        $be->free_analysis_feature_3_description = $request->free_analysis_feature_3_description;
        
        // Footer fields
        $be->free_analysis_footer_text = $request->free_analysis_footer_text;
        $be->free_analysis_footer_description = $request->free_analysis_footer_description;
        
        // Analytics fields
        $be->free_analysis_enable_analytics = $request->has('free_analysis_enable_analytics');
        $be->free_analysis_google_analytics_id = $request->free_analysis_google_analytics_id;
        $be->free_analysis_facebook_pixel_id = $request->free_analysis_facebook_pixel_id;
        
        // Page settings
        $be->free_analysis_show_breadcrumb = $request->has('free_analysis_show_breadcrumb');
        $be->free_analysis_show_sidebar = $request->has('free_analysis_show_sidebar');
        $be->free_analysis_page_layout = $request->free_analysis_page_layout ?: 'full-width';
        
        // Handle image fields from file manager
        $imageFields = [
            'free_analysis_hero_shape_1',
            'free_analysis_hero_shape_2',
            'free_analysis_hero_shape_3',
            'free_analysis_hero_shape_4',
            'free_analysis_hero_thumb',
            'free_analysis_step_about_1',
            'free_analysis_step_shape_1',
            'free_analysis_step_shape_2',
            'free_analysis_step_shape_3',
            'free_analysis_step_shape_4'
        ];
        
        foreach ($imageFields as $field) {
            if ($request->filled($field)) {
                // The file manager returns the full path, store it as is
                $filePath = $request->input($field);
                $be->$field = $filePath;
            } else {
                $be->$field = null;
            }
        }
        
        // New dynamic fields
        $be->free_analysis_form_title = $request->free_analysis_form_title;
        $be->free_analysis_form_subtitle = $request->free_analysis_form_subtitle;
        $be->free_analysis_form_label = $request->free_analysis_form_label;
        $be->free_analysis_form_help = $request->free_analysis_form_help;
        $be->free_analysis_feature_1_desc = $request->free_analysis_feature_1_desc;
        $be->free_analysis_feature_2_desc = $request->free_analysis_feature_2_desc;
        $be->free_analysis_feature_3_desc = $request->free_analysis_feature_3_desc;
        // Feature cards (6)
        for ($i = 1; $i <= 6; $i++) {
            $titleField = "free_analysis_feature_card_{$i}_title";
            $descField = "free_analysis_feature_card_{$i}_desc";
            $be->$titleField = $request->$titleField;
            $be->$descField = $request->$descField;
        }
        
        $be->save();

        Session::flash('success', 'Free Analysis page content updated successfully!');
        return back();
    }
}
