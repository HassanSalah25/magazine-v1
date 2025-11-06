<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Validator;
use Session;

class CtaController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $lang_id = $lang->id;

        if ($request->filled('id')) {
            $data['abs'] = BS::where('language_id', $lang_id)->findOrFail($request->id);
            $data['abe'] = BasicExtended::where('language_id', $lang_id)->findOrFail($request->id);
            $data['id'] = $request->id;
        } else {
            $data['abs'] = BS::where('language_id', $lang_id)->firstOrFail();
            $data['abe'] = BasicExtended::where('language_id', $lang_id)->firstOrFail();
            $data['id'] = null;
        }

        $data['lang_id'] = $lang_id;

        return view('admin.home.cta', $data);
    }

    public function update(Request $request, $langid)
    {
        $background = $request->background;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extBackground = pathinfo($background, PATHINFO_EXTENSION);

        $rules = [
            'cta_section_text' => 'required|max:80',
            'cta_section_button_text' => 'required|max:15',
            'cta_section_button_url' => 'required|max:255',
        ];

        if ($request->filled('background')) {
            $rules['background'] = [ ];
        }

        $request->validate($rules);

        if ($request->filled('id')) {
            $bs = BS::where('language_id', $langid)->findOrFail($request->id);
        } else {
            $bs = BS::where('language_id', $langid)->firstOrFail();
        }

        $bs->cta_section_text = $request->cta_section_text;
        $bs->cta_section_button_text = $request->cta_section_button_text;
        $bs->cta_section_button_url = $request->cta_section_button_url;

        if ($request->filled('background')) {
            @unlink('assets/front/img/' . $bs->cta_bg);
            $filename = uniqid() .'.'. $extBackground;
            @copy($background, 'assets/front/img/' . $filename);
            $bs->cta_bg = $filename;
        }

        $bs->save();

        Session::flash('success', 'Texts updated successfully!');
        return back();
    }
}
