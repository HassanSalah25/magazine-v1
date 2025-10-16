<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtended;
use App\Models\BasicExtra;
use App\Models\BasicSetting as BS;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;
use Validator;

class FaqsectionController extends Controller

{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['abex'] = $lang->basic_extra;

        return view('admin.home.faq-section', $data);
    }

    public function update(Request $request, $langid)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $image2 = $request->image_2;
        $extImage2 = pathinfo($image2, PATHINFO_EXTENSION);

        $rules = [
            'faq_section_title' => 'required|max:25',
            'faq_section_text' => 'required|max:80',
            'faq_section_button_text' => 'nullable|max:15',
            'faq_section_button_url' => 'nullable|max:255',
            'faq_section_video_link' => 'nullable',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [
                function ($attribute, $value, $fail) use ($extImage, $allowedExts) {
                    if (!in_array($extImage, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg image is allowed");
                    }
                }
            ];
        }

        if ($request->filled('image_2')) {
            $rules['image_2'] = [
                function ($attribute, $value, $fail) use ($extImage2, $allowedExts) {
                    if (!in_array($extImage2, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg image is allowed");
                    }
                }
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $bs = BasicExtra::where('language_id', $langid)->firstOrFail();
        $bs->faq_section_title = $request->faq_section_title;
        $bs->faq_section_text = $request->faq_section_text;
        $bs->faq_section_button_text = $request->faq_section_button_text;
        $bs->faq_section_button_url = $request->faq_section_button_url;

        if ($request->filled('image')) {
            @unlink('assets/front/img/' . $bs->faq_bg);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/' . $filename);

            $bs->faq_bg = $filename;
        }

        $bs->save();

        $be = BasicExtra::where('language_id', $langid)->firstOrFail();
        if ($request->filled('image_2')) {
            @unlink('assets/front/img/' . $be->faq_bg2);
            $filename = uniqid() .'.'. $extImage2;
            @copy($image2, 'assets/front/img/' . $filename);

            $be->faq_bg2 = $filename;
        }
        $be->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
