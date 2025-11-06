<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtra;
use App\Models\BasicSetting;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;

class OurstoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abex'] = $lang->basic_extra;

        return view('admin.our-story', $data);
    }

    public function update(Request $request, $langid)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $image2 = $request->image_2;
        $extImage2 = pathinfo($image2, PATHINFO_EXTENSION);

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

        $bex = BasicExtra::where('language_id', $langid)->firstOrFail();
        if ($request->filled('image')) {
            @unlink('assets/front/img/' . $bex->ourstory_page_image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/' . $filename);

            $bex->ourstory_page_image = $filename;
        }


        if ($request->filled('image_2')) {
            @unlink('assets/front/img/' . $bex->ourstory_page_image2);
            $filename = uniqid() .'.'. $extImage2;
            @copy($image2, 'assets/front/img/' . $filename);

            $bex->ourstory_page_image2 = $filename;
        }
        $bex->save();

        Session::flash('success', 'Contact page updated successfully!');
        return back();
    }
}
