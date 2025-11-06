<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Language;
use Validator;
use Session;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        if($request->filled('id')) {
            $data['partners'] = Partner::where('language_id', $lang_id)
                ->where('page_id', null)
                ->orderBy('id', 'DESC')->get();
        } else {
            $data['partners'] = Partner::where('language_id', $lang_id)
                ->where('page_id', $request->id)
                ->orderBy('id', 'DESC')->get();
        }

        $data['lang_id'] = $lang_id;
        return view('admin.home.partner.index', $data);
    }

    public function edit($id)
    {
        $data['partner'] = Partner::findOrFail($id);
        return view('admin.home.partner.edit', $data);
    }


    public function store(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'required',
            'url' => 'required|max:255',
            'serial_number' => 'required|integer',
            'is_active' => 'boolean',
            'is_google_ads' => 'boolean',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [ ];
        }

        if ($request->is_google_ads) {
            $rules['google_ads_script'] = 'required|string';
            $rules['google_ads_placement'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $partner = new Partner;
        $partner->language_id = $request->language_id;
        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->url = $request->url;
        $partner->serial_number = $request->serial_number;
        $partner->image_alt = $request->image_alt;
        $partner->mobile_image_alt = $request->mobile_image_alt;
        $partner->is_active = $request->has('is_active') ? true : false;
        $partner->is_google_ads = $request->has('is_google_ads') ? true : false;
        $partner->google_ads_script = $request->google_ads_script;
        $partner->google_ads_placement = $request->google_ads_placement;
        $partner->start_date = $request->start_date;
        $partner->end_date = $request->end_date;

        if ($request->filled('id')) {
            $partner->page_id = $request->id;
        }

        if ($request->filled('image')) {
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/partners/' . $filename);
            $partner->image = $filename;
        }

        if ($request->filled('mobile_image')) {
            $mobileImage = $request->mobile_image;
            $extMobileImage = pathinfo($mobileImage, PATHINFO_EXTENSION);
            $mobileFilename = uniqid() .'.'. $extMobileImage;
            @copy($mobileImage, 'assets/front/img/partners/' . $mobileFilename);
            $partner->mobile_image = $mobileFilename;
        }

        $partner->save();

        Session::flash('success', 'Partner added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $rules = [
            'name' => 'required|string|max:255',
            'url' => 'required|max:255',
            'serial_number' => 'required|integer',
            'is_active' => 'boolean',
            'is_google_ads' => 'boolean',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [     ];
        }

        if ($request->is_google_ads) {
            $rules['google_ads_script'] = 'required|string';
            $rules['google_ads_placement'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $partner = Partner::findOrFail($request->partner_id);
        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->url = $request->url;
        $partner->serial_number = $request->serial_number;
        $partner->image_alt = $request->image_alt;
        $partner->mobile_image_alt = $request->mobile_image_alt;
        $partner->is_active = $request->has('is_active') ? true : false;
        $partner->is_google_ads = $request->has('is_google_ads') ? true : false;
        $partner->google_ads_script = $request->google_ads_script;
        $partner->google_ads_placement = $request->google_ads_placement;
        $partner->start_date = $request->start_date;
        $partner->end_date = $request->end_date;

        if ($request->filled('image')) {
            @unlink('assets/front/img/partners/' . $partner->image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/partners/' . $filename);
            $partner->image = $filename;
        }

        if ($request->filled('mobile_image')) {
            if ($partner->mobile_image) {
                @unlink('assets/front/img/partners/' . $partner->mobile_image);
            }
            $mobileImage = $request->mobile_image;
            $extMobileImage = pathinfo($mobileImage, PATHINFO_EXTENSION);
            $mobileFilename = uniqid() .'.'. $extMobileImage;
            @copy($mobileImage, 'assets/front/img/partners/' . $mobileFilename);
            $partner->mobile_image = $mobileFilename;
        }

        $partner->save();

        Session::flash('success', 'Partner updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $partner = Partner::findOrFail($request->partner_id);
        @unlink('assets/front/img/partners/' . $partner->image);
        if ($partner->mobile_image) {
            @unlink('assets/front/img/partners/' . $partner->mobile_image);
        }
        $partner->delete();

        Session::flash('success', 'Partner deleted successfully!');
        return back();
    }
}
