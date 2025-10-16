<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Validator;
use Session;

class HerosectionController extends Controller
{
    public function static(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;

        if( $request->id != null) {
            $data['abs'] = BS::where('language_id', $lang->id)->findOrFail($request->id);
            $data['abe'] = BasicExtended::where('language_id', $lang->id)->findOrFail($request->id);
        } else {
           $data['abs'] = $lang->basic_setting;
           $data['abe'] = $lang->basic_extended;
       }

        return view('admin.home.hero.static', $data);
    }

    public function update(Request $request, $langid)
    {
        $image = $request->image;
        $image2 = $request->image2;
        $allowedExts = ['jpg', 'png', 'jpeg', 'svg'];
        $extImage = pathinfo($image, PATHINFO_EXTENSION);
        $extImage2 = pathinfo($image2, PATHINFO_EXTENSION);

        // 💡 Rules
        $rules = [
            'hero_section_title' => 'nullable',
            'hero_section_title_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_text' => 'nullable',
            'hero_section_text_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_button_text' => 'nullable',
            'hero_section_button_text_font_size' => 'required|integer|digits_between:1,3',
            'hero_section_button_url' => 'nullable',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [];
        }

        if ($request->filled('image2')) {
            $rules['image2'] = [ ];
        }

        // 📌 Get current model instance
        if ($request->id) {
            $be = BasicExtended::where('language_id', $langid)->findOrFail($request->id);
            $bs = BS::where('language_id', $langid)->findOrFail($request->id);
        } else {
            $be = BasicExtended::where('language_id', $langid)->firstOrFail();
            $bs = BS::where('language_id', $langid)->firstOrFail();
        }

        $version = $be->theme_version;

        // 🔄 Add version-based rules
        if (in_array($version, ['gym', 'car', 'cleaning'])) {
            $rules['hero_section_bold_text'] = 'nullable';
            $rules['hero_section_bold_text_font_size'] = 'required|integer|digits_between:1,3';
        }

        if ($version === 'cleaning') {
            $rules['hero_section_bold_text_color'] = 'required';
            $rules['hero_section_text_font_size'] = 'nullable';
        }

        // ✅ Validate
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        // ✍️ Update BS
        $bs->hero_section_title = $request->hero_section_title;
        $bs->hero_section_button_text = $request->hero_section_button_text;
        $bs->hero_section_button_url = $request->hero_section_button_url;

        if (in_array($version, ['gym', 'car', 'cleaning'])) {
            $bs->hero_section_bold_text = $request->hero_section_bold_text;
        }

        if ($version !== 'cleaning') {
            $bs->hero_section_text = $request->hero_section_text;
        }

        if ($request->filled('image')) {
            @unlink('assets/front/img/' . $bs->hero_bg);
            $filename = uniqid() . '.' . $extImage;
            @copy($image, 'assets/front/img/' . $filename);
            $bs->hero_bg = $filename;
        }

        $bs->save();

        // ✍️ Update BE
        $be->hero_section_title_font_size = $request->hero_section_title_font_size;
        $be->hero_section_button_text_font_size = $request->hero_section_button_text_font_size;
        $be->hero_section_text2 = $request->hero_section_text2;
        $be->hero_section_text3 = $request->hero_section_text3;

        if (in_array($version, ['gym', 'car', 'cleaning'])) {
            $be->hero_section_bold_text_font_size = $request->hero_section_bold_text_font_size;
        }

        if ($version === 'cleaning') {
            $be->hero_section_bold_text_color = $request->hero_section_bold_text_color;
        }

        if ($version !== 'cleaning') {
            $be->hero_section_text_font_size = $request->hero_section_text_font_size;
        }

        if ($request->filled('image2')) {
            @unlink('assets/front/img/' . $be->hero_bg2);
            $filename2 = uniqid() . '.' . $extImage2;
            @copy($image2, 'assets/front/img/' . $filename2);
            $be->hero_bg2 = $filename2;
        }

        $be->save();

        Session::flash('success', 'Informations updated successfully!');
        return 'success';
    }


    public function video(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;

        if ($request->filled('id')) {
            $data['abs'] = BS::findOrFail($request->id);
            $data['landingpage_id'] = $request->id;
        } else {
            $data['abs'] = $lang->basic_setting;
            $data['landingpage_id'] = null;
        }

        return view('admin.home.hero.video', $data);
    }


    public function videoupdate(Request $request, $langid)
    {
        $rules = [
            'video_link' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        if ($request->filled('id')) {
            $bs = BS::findOrFail($request->id);
        } else {
            $bs = BS::where('language_id', $langid)->firstOrFail();
        }

        $videoLink = $request->video_link;
        if (strpos($videoLink, "&") !== false) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }

        $bs->hero_section_video_link = $videoLink;
        $bs->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
