<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicExtended;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\Statistic;
use App\Models\Language;
use Session;
use Validator;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $lang_id = $lang->id;

        $query = Statistic::where('language_id', $lang_id);

        if ($request->filled('id')) {
            $query->where('page_id', $request->id);
            $data['landingpage_id'] = $request->id;
            $data['abe'] = BasicExtended::where('language_id', $lang_id)->findOrFail($request->id);
        } else {
            $query->whereNull('page_id');
            $data['landingpage_id'] = null;
            $data['abe'] = $lang->basic_extended;
        }

        $data['statistics'] = $query->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;
        $data['selLang'] = $lang;

        return view('admin.home.statistics.index', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];


        $query = Statistic::where('language_id', $request->language_id);

        if ($request->filled('page_id')) {
            $query->where('page_id', $request->page_id);
        } else {
            $query->whereNull('page_id');
        }

        $count = $query->count();
        if ($count == 4) {
            Session::flash('warning', 'You cannot add more than 4 statistics!');
            return "success";
        }

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:20',
            'quantity' => 'required|integer',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $statistic = new Statistic;
        $statistic->language_id = $request->language_id;
        $statistic->icon = $request->icon;
        $statistic->title = $request->title;
        $statistic->quantity = $request->quantity;
        $statistic->serial_number = $request->serial_number;
        $statistic->page_id = $request->id ?? null;
        $statistic->service_id = $request->service_id ?? null;
        $statistic->save();

        Session::flash('success', 'New statistic added successfully!');
        return "success";
    }

    public function edit($id)
    {
        $data['statistic'] = Statistic::findOrFail($id);
        if (!empty($data['statistic']->language)) {
            $data['selLang'] = $data['statistic']->language;
        }
        $data['services'] = Service::where('language_id', $data['statistic']->language_id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.home.statistics.edit', $data);
    }

    public function update(Request $request)
    {
        $rules = [
            'title' => 'required|max:20',
            'quantity' => 'required|integer',
            'serial_number' => 'required|integer',
        ];

        $request->validate($rules);

        $statistic = Statistic::findOrFail($request->statisticid);
        $statistic->icon = $request->icon;
        $statistic->title = $request->title;
        $statistic->quantity = $request->quantity;
        $statistic->serial_number = $request->serial_number;
        $statistic->service_id = $request->service_id ?? null;
        $statistic->save();

        Session::flash('success', 'Statistic updated successfully!');
        return back();
    }

    public function upload(Request $request, $langid)
    {
        $image = $request->background_image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $rules = [];

        if ($request->filled('background_image')) {
            $rules['background_image'] = [ ];
        }

        $request->validate($rules);

        if ($request->filled('background_image')) {

            if ($request->filled('id')) {
                $be = BasicExtended::where('language_id', $langid)->findOrFail($request->id);
            } else {
                $be = BasicExtended::where('language_id', $langid)->firstOrFail();
            }

            @unlink('assets/front/img/' . $be->statistics_bg);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/' . $filename);

            $be->statistics_bg = $filename;
            $be->save();

        }

        $request->session()->flash('success', 'Statistics section background image');
        return back();
    }

    public function delete(Request $request)
    {

        $statistic = Statistic::findOrFail($request->statisticid);
        $statistic->delete();

        Session::flash('success', 'Statistic deleted successfully!');
        return back();
    }
}
