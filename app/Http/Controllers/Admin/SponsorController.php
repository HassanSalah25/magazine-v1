<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Language;
use Validator;
use Session;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        
        $data['partners'] = Partner::where('language_id', $lang_id)
            ->orderBy('serial_number', 'ASC')
            ->get();
        $data['lang_id'] = $lang_id;
        
        return view('admin.sponsors.index', $data);
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
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
            $rules['image'] = [];
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

        $partner = new Partner;
        $partner->language_id = $request->language_id;
        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->url = $request->url;
        $partner->serial_number = $request->serial_number;
        $partner->image_alt = $request->image_alt;
        $partner->is_active = $request->has('is_active') ? true : false;
        $partner->is_google_ads = $request->has('is_google_ads') ? true : false;
        $partner->google_ads_script = $request->google_ads_script;
        $partner->google_ads_placement = $request->google_ads_placement;
        $partner->start_date = $request->start_date;
        $partner->end_date = $request->end_date;

        if ($request->filled('image')) {
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/partners/' . $filename);
            $partner->image = $filename;
        }

        $partner->save();

        Session::flash('success', 'Sponsor added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $data['partner'] = Partner::findOrFail($id);
        return view('admin.sponsors.edit', $data);
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
            $rules['image'] = [];
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

        $partner->save();

        Session::flash('success', 'Sponsor updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $partner = Partner::findOrFail($request->partner_id);
        @unlink('assets/front/img/partners/' . $partner->image);
        $partner->delete();

        Session::flash('success', 'Sponsor deleted successfully!');
        return back();
    }

    public function toggleStatus(Request $request)
    {
        $partner = Partner::findOrFail($request->id);
        $partner->is_active = !$partner->is_active;
        $partner->save();

        return response()->json(['status' => $partner->is_active ? 'active' : 'inactive']);
    }
}
