<?php

namespace App\Http\Controllers\Admin;

use App\Models\BasicExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Testimonial;
use App\Models\BasicSetting as BS;
use Validator;
use Session;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $lang_id = $lang->id;

        $query = Testimonial::where('language_id', $lang_id);

        if ($request->filled('id')) {
            $query->where('page_id', $request->id);
            $data['landingpage_id'] = $request->id;
            $data['abs'] = BS::where('language_id', $lang_id)->findOrFail($request->id);
            $data['abex'] = BasicExtra::where('language_id', $lang_id)->findOrFail($request->id);
        } else {
            $query->whereNull('page_id');
            $data['landingpage_id'] = null;
            $data['abs'] = $lang->basic_setting;
            $data['abex'] = $lang->basic_extra;
        }

        $data['testimonials'] = $query->orderBy('id', 'DESC')->get();
        $data['lang_id'] = $lang_id;

        return view('admin.home.testimonial.index', $data);
    }

    public function edit($id)
    {
        $data['testimonial'] = Testimonial::findOrFail($id);
        return view('admin.home.testimonial.edit', $data);
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
            'image' => 'required',
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = new Testimonial;
        $testimonial->language_id = $request->language_id;
        $testimonial->comment = $request->comment;
        $testimonial->name = $request->name;
        $testimonial->rank = $request->rank;
        $testimonial->image = $request->testimonial_image;
        $testimonial->serial_number = $request->serial_number;

        if ($request->filled('page_id')) {
            $testimonial->page_id = $request->page_id;
        }

        if ($request->filled('image')) {
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/testimonials/' . $filename);
            $testimonial->image = $filename;
        }

        $testimonial->save();

        Session::flash('success', 'Testimonial added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $rules = [
            'comment' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'serial_number' => 'required|integer',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        $testimonial->comment = $request->comment;
        $testimonial->name = $request->name;
        $testimonial->rank = $request->rank;
        $testimonial->serial_number = $request->serial_number;

        if ($request->filled('image')) {
            @unlink('assets/front/img/testimonials/' . $testimonial->image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/testimonials/' . $filename);
            $testimonial->image = $filename;
        }
        $testimonial->save();

        Session::flash('success', 'Testimonial updated successfully!');
        return "success";
    }

    public function textupdate(Request $request, $langid)
    {
        $image = $request->testimonial_section_image;
        $allowedExts = ['jpg', 'png', 'jpeg', 'svg'];
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $request->validate([
            'testimonial_section_title' => 'required|max:25',
            'testimonial_section_subtitle' => 'required|max:80',
            'testimonial_section_image' => 'nullable',
        ]);

        // Basic Setting update
        if ($request->filled('page_id')) {
            $bs = BS::where('language_id', $langid)->findOrFail($request->page_id);
            $bex = BasicExtra::where('language_id', $langid)->findOrFail($request->page_id);
        } else {
            $bs = BS::where('language_id', $langid)->firstOrFail();
            $bex = BasicExtra::where('language_id', $langid)->firstOrFail();
        }

        $bs->testimonial_title = $request->testimonial_section_title;
        $bs->testimonial_subtitle = $request->testimonial_section_subtitle;
        $bs->save();
        if ($request->filled('testimonial_section_image')) {
            @unlink('assets/front/img/testimonials/' . $bex->testimonial_section_image);
            $filename = uniqid() . '.' . $extImage;
            @copy($image, 'assets/front/img/testimonials/' . $filename);
            $bex->testimonial_section_image = $filename;
        }

        $bex->save();

        Session::flash('success', 'Text updated successfully!');
        return back();
    }


    public function delete(Request $request)
    {
        $testimonial = Testimonial::findOrFail($request->testimonial_id);
        @unlink('assets/front/img/testimonials/' . $testimonial->image);
        $testimonial->delete();

        Session::flash('success', 'Testimonial deleted successfully!');
        return back();
    }
}
