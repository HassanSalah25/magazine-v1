<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\BasicExtra;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;

class ComparisonController extends Controller

{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['abex'] = $lang->basic_extra;

        return view('admin.home.comparison', $data);
    }

    public function update(Request $request, $langid)
    {
        $be = BasicExtra::where('language_id', $langid)->firstOrFail();
        
        // Update structured comparison fields
        $be->comparison_title = $request->comparison_title;
        $be->comparison_subtitle = $request->comparison_subtitle;
        
        // Column 1 (SEO Wolves) fields
        $be->comparison_col1_title = $request->comparison_col1_title;
        $be->comparison_col1_features = json_decode($request->comparison_col1_features, true) ?: [];
        
        // Column 2 (Typical SEO agency) fields
        $be->comparison_col2_title = $request->comparison_col2_title;
        $be->comparison_col2_features = json_decode($request->comparison_col2_features, true) ?: [];
        
        // Column 3 (In-house SEO) fields
        $be->comparison_col3_title = $request->comparison_col3_title;
        $be->comparison_col3_features = json_decode($request->comparison_col3_features, true) ?: [];
        
        // Debug: Log what we're saving
        \Log::info('Comparison update data:', [
            'comparison_col1_features_raw' => $request->comparison_col1_features,
            'comparison_col1_features_decoded' => $be->comparison_col1_features,
            'comparison_col2_features_raw' => $request->comparison_col2_features,
            'comparison_col2_features_decoded' => $be->comparison_col2_features,
            'comparison_col3_features_raw' => $request->comparison_col3_features,
            'comparison_col3_features_decoded' => $be->comparison_col3_features,
        ]);
        
        $be->save();

        Session::flash('success', 'Comparison section updated successfully!');
        return "success";
    }
}
