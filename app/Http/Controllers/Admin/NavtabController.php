<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicExtra;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;

class NavtabController extends Controller


{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $data['lang_id'] = $lang->id;
        $data['abs'] = $lang->basic_setting;
        $data['abe'] = $lang->basic_extended;
        $data['abex'] = $lang->basic_extra;

        return view('admin.home.nav_tab', $data);
    }

    public function update(Request $request, $langid)
    {

        $be = BasicExtra::where('language_id', $langid)->firstOrFail();
        $be->nav_tab = json_encode(array_values($request->points));
        $be->save();

        Session::flash('success', 'Informations updated successfully!');
        return "success";
    }
}
