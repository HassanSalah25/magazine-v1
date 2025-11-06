<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\BasicExtra;
use App\Models\BasicSetting;
use App\Models\Language;
use App\Models\Section;
use Illuminate\Http\Request;

class LandingpageSectionsController extends Controller
{
    /**
     * Display the homepage sections.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $id)
    {

        $data['abs'] = BasicSetting::findOrFail($id);
        $data['abe'] = BasicExtended::findOrFail($id);
        $data['bex'] = BasicExtra::findOrFail($id);
        $data['langs'] = Language::all();
        $data['selectedLang'] = $request->input('language');
        $data['landingpage_id'] = $id;

        $sections = Section::whereNull('parent_id')
            ->where('page_type', 'landingpage' . $id)
            ->with(['parent'])
            ->get();

        return view('admin.landingpage_sections.index', $data, compact('sections'));
    }

    public function herosection(Request $request, $id)
    {

        $langs = Language::all();
        $selectedLang = $request->input('language');
        $data['landingpage_id'] = $id;
        $sections = Section::whereNotNull('parent_id')
            ->where('page_type', 'landingpage' . $id)
            ->with(['parent'])
            ->get();

        return view('admin.landingpage_sections.index', $data, compact('sections','selectedLang', 'langs'));
    }
}
