<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;
use Validator;

class PricingsectionController extends Controller
{

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $lang_id = $lang->id;

        if ($request->filled('id')) {
            $data['abs'] = BS::where('language_id', $lang_id)->findOrFail($request->id);
            $data['landingpage_id'] = $request->id;
        } else {
            $data['abs'] = $lang->basic_setting;
            $data['landingpage_id'] = null;
        }

        $data['lang_id'] = $lang_id;

        return view('admin.home.pricing-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $rules = [
            'pricing_section_subtitle' => 'required|max:200',
            'pricing_section_title' => 'required|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        // 🧠 لو في landing page ID استخدمه
        if ($request->filled('id')) {
            $bs = BS::where('language_id', $langid)->findOrFail($request->id);
        } else {
            $bs = BS::where('language_id', $langid)->firstOrFail();
        }

        // ✍️ التحديث
        $bs->pricing_section_subtitle = $request->pricing_section_subtitle;
        $bs->pricing_section_title = $request->pricing_section_title;
        $bs->pricing_section_link = $request->pricing_section_link;
        $bs->save();

        Session::flash('success', 'Texts updated successfully!');
        return "success";
    }

}
