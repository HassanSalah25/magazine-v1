<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Scategory;
use App\Models\Language;
use App\Models\Megamenu;
use Validator;
use Session;

class ScategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['scategorys'] = Scategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;
        $data['categories'] = Scategory::all();
        return view('admin.service.scategory.index', $data);
    }

    public function edit($id)
    {
        $data['scategory'] = Scategory::findOrFail($id);
        $data['categories'] = Scategory::all();
        return view('admin.service.scategory.edit', $data);
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
            'image' => 'nullable',
            'name' => 'required|max:255',
            'short_text' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];
        if ($request->filled('image')) {
            $rules['image'] = [     ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $scategory = new Scategory;
        $scategory->language_id = $request->language_id;
        $scategory->name = $request->name;
        $scategory->status = $request->status;
        $scategory->short_text = $request->short_text;
        $scategory->serial_number = $request->serial_number;
        $scategory->slug = $request->slug ?? $request->name;
        $scategory->redirect_url = $request->redirect_url;
        $scategory->is_indexed = $request->is_indexed;
        $scategory->publish_data = $request->publish_data;
        $scategory->canonical = $request->canonical;
        $scategory->meta_title = $request->meta_title;
        $scategory->meta_keywords = $request->meta_keywords;
        $scategory->meta_description = $request->meta_description;
        $scategory->parent_id = $request->parent_id;
        $scategory->content = $request->content;
        $scategory->video_link = $request->video_link;
        $scategory->process_list = $request->process_list;
        $scategory->caption = $request->caption;
        if ($request->filled('image')) {
            $filename = uniqid() .'.'. pathinfo($request->image, PATHINFO_EXTENSION);
            @copy($request->image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->image = $filename;
        }
        if ($request->filled('second_image')) {
            $filename = uniqid() .'.'. pathinfo($request->second_image, PATHINFO_EXTENSION);
            @copy($request->second_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->second_image = $filename;
        }
        if ($request->filled('third_image')) {
            $filename = uniqid() .'.'. pathinfo($request->third_image, PATHINFO_EXTENSION);
            @copy($request->third_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->third_image = $filename;
        }
        if ($request->filled('shape_image')) {
            $filename = uniqid() .'.'. pathinfo($request->shape_image, PATHINFO_EXTENSION);
            @copy($request->shape_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->shape_image = $filename;
        }

        $scategory->save();

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
            'short_text' => 'required',
            'serial_number' => 'required|integer',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [ ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $scategory = Scategory::findOrFail($request->scategory_id);
        $scategory->name = $request->name;
        $scategory->status = $request->status;
        $scategory->short_text = $request->short_text;
        $scategory->serial_number = $request->serial_number;
        $scategory->slug = $request->slug ?? $request->name;
        $scategory->redirect_url = $request->redirect_url;
        $scategory->is_indexed = $request->is_indexed;
        $scategory->publish_data = $request->publish_data;
        $scategory->canonical = $request->canonical;
        $scategory->meta_title = $request->meta_title;
        $scategory->meta_keywords = $request->meta_keywords;
        $scategory->meta_description = $request->meta_description;
        $scategory->parent_id = $request->parent_id;
        $scategory->content = $request->content;
        $scategory->video_link = $request->video_link;
        $scategory->process_list = $request->process_list;
        $scategory->caption = $request->caption;

        if ($request->filled('image')) {
            @unlink('assets/front/img/service_category_icons/' . $scategory->image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->image = $filename;
        }
        // Preserve existing image if no new image is provided
        // The image field is already set from the database, so no need to modify it
 
        if ($request->filled('second_image')) {
            @unlink('assets/front/img/service_category_icons/' . $scategory->second_image);
            $filename = uniqid() .'.'. pathinfo($request->second_image, PATHINFO_EXTENSION);
            @copy($request->second_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->second_image = $filename;
        }
        // Preserve existing second_image if no new second_image is provided
        
        if ($request->filled('third_image')) {
            @unlink('assets/front/img/service_category_icons/' . $scategory->third_image);
            $filename = uniqid() .'.'. pathinfo($request->third_image, PATHINFO_EXTENSION);
            @copy($request->third_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->third_image = $filename;
        }
        // Preserve existing third_image if no new third_image is provided
        
        if ($request->filled('shape_image') && $request->shape_image !== $scategory->shape_image) {
            if ($scategory->shape_image) {
                @unlink('assets/front/img/service_category_icons/' . $scategory->shape_image);
            }
            $filename = uniqid() .'.'. pathinfo($request->shape_image, PATHINFO_EXTENSION);
            @copy($request->shape_image, 'assets/front/img/service_category_icons/' . $filename);
            $scategory->shape_image = $filename;
        }
        // Preserve existing shape_image if no new shape_image is provided or if it's the same as existing

        $scategory->save();

        Session::flash('success', 'Category updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $scategory = Scategory::findOrFail($request->scategory_id);

        if ($scategory->services()->count() > 0) {
            Session::flash('warning', 'First, delete all the services under this category!');
            return back();
        }
        @unlink('assets/front/img/service_category_icons/' . $scategory->image);

        $this->deleteFromMegaMenu($scategory);

        $scategory->delete();

        Session::flash('success', 'Scategory deleted successfully!');
        return back();
    }

    public function deleteFromMegaMenu($scategory) {
        $megamenu = Megamenu::where('language_id', $scategory->language_id)->where('category', 1)->where('type', 'services');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            $catId = $scategory->id;
            if (is_array($menus) && array_key_exists("$catId", $menus)) {
                unset($menus["$catId"]);
                $megamenu->menus = json_encode($menus);
                $megamenu->save();
            }
        }
        $megamenu = Megamenu::where('language_id', $scategory->language_id)->where('category', 1)->where('type', 'portfolios');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            $catId = $scategory->id;
            if (is_array($menus) && array_key_exists("$catId", $menus)) {
                unset($menus["$catId"]);
                $megamenu->menus = json_encode($menus);
                $megamenu->save();
            }
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $scategory = Scategory::findOrFail($id);
            if ($scategory->services()->count() > 0) {
                Session::flash('warning', 'First, delete all the services under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $scategory = Scategory::findOrFail($id);
            @unlink('assets/front/img/service_category_icons/' . $scategory->image);

            $this->deleteFromMegaMenu($scategory);

            $scategory->delete();
        }

        Session::flash('success', 'Service categories deleted successfully!');
        return "success";
    }

    public function feature(Request $request)
    {
        $scategory = Scategory::find($request->scategory_id);
        $scategory->feature = $request->feature;
        $scategory->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }

    public function getScategories($langId)
    {
        $scategories = Scategory::where('language_id', $langId)
            ->where('status', 1)
            ->orderBy('serial_number', 'ASC')
            ->get();

        return response()->json($scategories);
    }
}
