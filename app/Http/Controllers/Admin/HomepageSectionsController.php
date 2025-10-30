<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\BasicExtra;
use App\Models\BasicSetting;
use App\Models\Language;
use App\Models\Section;
use App\Models\DynamicSection;
use Illuminate\Http\Request;

class HomepageSectionsController extends Controller
{
    /**
     * Display the homepage sections.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $data['abs'] = BasicSetting::first();
        $data['abe'] = BasicExtended::first();
        $data['bex'] = BasicExtra::first();
        $data['langs'] = Language::all();
        $data['selectedLang'] = $request->input('language');

        $sections = Section::whereNull('parent_id')
            ->where('page_type', 'homepage')
            ->with(['parent'])
            ->get();

        // Get dynamic sections
        $dynamicSections = DynamicSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.homepage_sections.index', $data, compact('sections', 'dynamicSections'));
    }

    public function herosection(Request $request)
    {

        $langs = Language::all();
        $selectedLang = $request->input('language');

        $sections = Section::where('parent_id', 1)
            ->with(['parent'])
            ->get();

        return view('admin.homepage_sections.index', compact('sections','selectedLang', 'langs'));
    }
}
