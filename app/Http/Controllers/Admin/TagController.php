<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Http\Request;
use Session;
use Validator;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['tags'] = Tag::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;

        return view('admin.tag.index', $data);
    }

    public function create()
    {
        $data['tags'] = Tag::where('language_id', 0)->get();
        return view('admin.tag.create', $data);
    }

    public function edit($id)
    {
        $data['tag'] = Tag::findOrFail($id);
        return view('admin.tag.edit', $data);
    }


    public function store(Request $request)
    {
        $slug = $request->slug ?? make_slug($request->title);

        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $rules = [
            'language_id' => 'required',
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug) {
                    $tags = Tag::all();
                    foreach ($tags as $key => $tag) {
                        if (strtolower($slug) == strtolower($tag->slug)) {
                            $fail('The title field must be unique.');
                        }
                    }
                }
            ],
            'content' => 'required',
            'image' => 'required',
            'status' => 'required',
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

        $in = $request->except('_token');
        $in['language_id'] = $request->language_id;
        $in['slug'] = $slug;
        $in['status'] = $request->status;
        $in['meta_title'] = $request->meta_title;
        $in['meta_keywords'] = $request->meta_keywords;
        $in['meta_description'] = $request->meta_description;
        $in['canonical'] = $request->canonical;
        $in['content'] = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);

        if ($request->filled('image')) {
            $filename = uniqid() . '.' . $extImage;
            @copy($image, 'assets/front/img/tags/featured/' . $filename);
            $in['image'] = $filename;
        }

        Tag::create($in);

        Session::flash('success', 'Tag added successfully!');
        return "success";
    }

    public function images($portid)
    {
        $images = TagImage::select('image')->where('tag_id', $portid)->get();
        $convImages = [];

        foreach ($images as $key => $image) {
            $convImages[] = url("assets/front/img/tags/sliders/$image->image");
        }

        return $convImages;
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);
        $tag = Tag::findOrFail($request->tag_id);
        $tagId = $request->tag_id;

        $sliders = !empty($request->slider) ? explode(',', $request->slider) : [];
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);


        $client_image = $request->client_image;
        $extClientImage = pathinfo($client_image, PATHINFO_EXTENSION);

        $rules = [
            'slider' => 'required',
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug, $tagId) {
                    $tags = Tag::all();
                    foreach ($tags as $key => $tag) {
                        if ($tag->id != $tagId && strtolower($slug) == strtolower($tag->slug)) {
                            $fail('The title field must be unique.');
                        }
                    }
                }
            ],
            'client_name' => 'required|max:255',
            'client_image' => 'nullable',
            'tags' => 'required',
            'content' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
            'scategories' => 'required|array',
            'scategories.*' => 'exists:scategories,id',
        ];

        if ($request->filled('image')) {
            $rules['image'] = [];
        }
        if ($request->filled('client_image')) {
            $rules['client_image'] = [];
        }

        if ($request->filled('slider')) {
            $rules['slider'] = [];
        }

        $messages = [
            'scategories' => 'required|array',
            'scategories.*' => 'exists:scategories,id',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $tag = Tag::findOrFail($request->tag_id);
        $in['content'] = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);
        $in['slug'] = $slug;

        if ($request->filled('image')) {
            @unlink('assets/front/img/tags/featured/' . $tag->featured_image);
            $filename = uniqid() . '.' . $extImage;
            @copy($image, 'assets/front/img/tags/featured/' . $filename);
            $in['featured_image'] = $filename;
        }


        if ($request->filled('client_image')) {
            @unlink('assets/front/img/tags/featured/' . $tag->client_image);
            $clientFilename = uniqid() . '.' . $extClientImage;
            @copy($client_image, 'assets/front/img/tags/featured/' . $clientFilename);
            $in['client_image'] = $clientFilename;
        }

        $tag->fill($in)->save();

        $tag->scategories()->sync($request->input('scategories', []));

        // copy the sliders first
        $fileNames = [];
        foreach ($sliders as $key => $slider) {
            $extSlider = pathinfo($slider, PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extSlider;
            @copy($slider, 'assets/front/img/tags/sliders/' . $filename);
            $fileNames[] = $filename;
        }

        // delete & unlink previous slider images
        $pis = TagImage::where('tag_id', $tag->id)->get();
        foreach ($pis as $key => $pi) {
            @unlink('assets/front/img/tags/sliders/' . $pi->image);
            $pi->delete();
        }

        // store new slider images
        foreach ($fileNames as $key => $fileName) {
            $pi = new TagImage;
            $pi->tag_id = $tag->id;
            $pi->image = $fileName;
            $pi->save();
        }

        Session::flash('success', 'Tag updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $tag = Tag::findOrFail($request->tag_id);
        foreach ($tag->tag_images as $key => $pi) {
            @unlink('assets/front/img/tags/sliders/' . $pi->image);
            $pi->delete();
        }
        @unlink('assets/front/img/tags/featured/' . $tag->featured_image);

        $this->deleteFromMegaMenu($tag);

        $tag->delete();

        Session::flash('success', 'Tag deleted successfully!');
        return back();
    }

    public function deleteFromMegaMenu($tag)
    {
        // unset tag from megamenu for service_category = 1
        $megamenu = Megamenu::where('language_id', $tag->language_id)->where('category', 1)->where('type', 'tags');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            if (!empty($tag->service) && !empty($tag->service->scategory)) {
                $catId = $tag->service->scategory->id;
                if (is_array($menus) && array_key_exists("$catId", $menus)) {
                    if (in_array($tag->id, $menus["$catId"])) {
                        $index = array_search($tag->id, $menus["$catId"]);
                        unset($menus["$catId"]["$index"]);
                        $menus["$catId"] = array_values($menus["$catId"]);
                        if (count($menus["$catId"]) == 0) {
                            unset($menus["$catId"]);
                        }
                        $megamenu->menus = json_encode($menus);
                        $megamenu->save();
                    }
                }
            }
        }

        // unset tag from megamenu for service_category = 0
        $megamenu = Megamenu::where('language_id', $tag->language_id)->where('category', 0)->where('type', 'tags');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            if (is_array($menus)) {
                if (in_array($tag->id, $menus)) {
                    $index = array_search($tag->id, $menus);
                    unset($menus["$index"]);
                    $menus = array_values($menus);
                    $megamenu->menus = json_encode($menus);
                    $megamenu->save();
                }
            }
        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $tag = Tag::findOrFail($id);
            foreach ($tag->tag_images as $key => $pi) {
                @unlink('assets/front/img/tags/sliders/' . $pi->image);
                $pi->delete();
            }
        }

        foreach ($ids as $id) {
            $tag = Tag::findOrFail($id);
            @unlink('assets/front/img/tags/featured/' . $tag->featured_image);

            $this->deleteFromMegaMenu($tag);

            $tag->delete();
        }

        Session::flash('success', 'Tags deleted successfully!');
        return "success";
    }

    public function getservices($langid)
    {
        $services = Scategory::where('language_id', $langid)->get();

        return $services;
    }

    public function feature(Request $request)
    {
        $tag = Tag::find($request->tag_id);
        $tag->feature = $request->feature;
        $tag->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }
}

