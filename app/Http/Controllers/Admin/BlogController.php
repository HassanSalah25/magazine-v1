<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Rules\LowercaseSlug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Bcategory;
use App\Models\Language;
use App\Models\Blog;
use App\Models\Megamenu;
use Validator;
use Session;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        $data['blogs'] = Blog::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->get();
        $data['tags'] = Tag::where('status', 1)->where('language_id', $lang_id)->get();

        return view('admin.blog.blog.index', $data);
    }

    public function edit($id)
    {
        $data['blog'] = Blog::findOrFail($id);
        $data['bcats'] = Bcategory::where('language_id', $data['blog']->language_id)->where('status', 1)->get();
        $data['tags'] = Tag::where('status', 1)->where('language_id', $data['blog']->language_id)->get();
        return view('admin.blog.blog.edit', $data);
    }

    public function store(Request $request)
    {
        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION);

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        // Use custom slug if provided, otherwise generate from title
        $slug = $request->filled('slug') ? make_slug($request->slug) : make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'image' => 'required',
            'title' => 'required|max:255',
            'slug' => [
                'required',
                'max:255',
                'unique:blogs,slug',
                new LowercaseSlug,
            ],
            'category' => 'required',
            'content' => 'required',
            'serial_number' => 'required|integer',
        ];
        if ($request->filled('image')) {
            $rules['image'] = [ ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $blog = new Blog;
        $blog->language_id = $request->language_id;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->bcategory_id = $request->category;
        $blog->content = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);
        $blog->meta_keywords = $request->meta_keywords;
        $blog->meta_description = $request->meta_description;
        $blog->serial_number = $request->serial_number;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->redirect_url = $request->redirect_url;
        $blog->is_indexed = $request->is_indexed;
        $blog->publish_data = $request->publish_data;
        $blog->canonical = $request->canonical;
        $blog->alt_image = $request->alt_image;

        if ($request->filled('image')) {
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/blogs/' . $filename);
            $blog->main_image = $filename;
        }

        $blog->save();


        $blog->tags()->sync($request->tags);

        Session::flash('success', 'Blog added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $blog = Blog::findOrFail($request->blog_id);
        $blogId = $request->blog_id;
        
        // Use custom slug if provided, otherwise generate from title
        $slug = $request->filled('slug') ? make_slug($request->slug) : make_slug($request->title);

        $image = $request->image;
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $extImage = pathinfo($image, PATHINFO_EXTENSION); 

        $rules = [
            'title' => 'required|max:255',
            'slug' => [
                'required',
                'max:255', 
                
                function ($attribute, $value, $fail) use ($slug, $blogId) {
                    $blogs = Blog::all();
                    foreach ($blogs as $key => $blog) {
                        if ($blog->id != $blogId && strtolower($slug) == strtolower($blog->slug)) {
                            $fail('The slug field must be unique.');
                        }
                    }  
                } 
            ],
            'category' => 'required',
            'content' => 'required', 
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

        $blog = Blog::findOrFail($request->blog_id);
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->bcategory_id = $request->category;
        $blog->content = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->content);
        $blog->meta_keywords = $request->meta_keywords;
        $blog->meta_description = $request->meta_description;
        $blog->serial_number = $request->serial_number;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->redirect_url = $request->redirect_url;
        $blog->is_indexed = $request->is_indexed;
        $blog->publish_data = $request->publish_data;
        $blog->canonical = $request->canonical;
        $blog->alt_image = $request->alt_image;

        if ($request->filled('image')) {
            @unlink('assets/front/img/blogs/' . $blog->main_image);
            $filename = uniqid() .'.'. $extImage;
            @copy($image, 'assets/front/img/blogs/' . $filename);
            $blog->main_image = $filename;
        }

        $blog->save();

        $blog->tags()->sync($request->tags);

        Session::flash('success', 'Blog updated successfully!');
        return "success";
    }

    public function deleteFromMegaMenu($blog) {
        // unset service from megamenu for service_category = 1
        $megamenu = Megamenu::where('language_id', $blog->language_id)->where('category', 1)->where('type', 'blogs');
        if ($megamenu->count() > 0) {
            $megamenu = $megamenu->first();
            $menus = json_decode($megamenu->menus, true);
            $catId = $blog->bcategory->id;
            if (is_array($menus) && array_key_exists("$catId", $menus)) {
                if (in_array($blog->id, $menus["$catId"])) {
                    $index = array_search($blog->id, $menus["$catId"]);
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

    public function delete(Request $request)
    {

        $blog = Blog::findOrFail($request->blog_id);
        @unlink('assets/front/img/blogs/' . $blog->main_image);

        $this->deleteFromMegaMenu($blog);

        $blog->delete();

        Session::flash('success', 'Blog deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $blog = Blog::findOrFail($id);
            @unlink('assets/front/img/blogs/' . $blog->main_image);

            $this->deleteFromMegaMenu($blog);

            $blog->delete();
        }

        Session::flash('success', 'Blogs deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $bcategories = Bcategory::where('language_id', $langid)->get();

        return $bcategories;
    }

    public function sidebar(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->sidebar = $request->sidebar;
        $blog->save();

        if ($request->sidebar == 1) {
            Session::flash('success', 'Enabled successfully!');
        } else {
            Session::flash('success', 'Disabled successfully!');
        }

        return back();
    }

    public function carousel(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->show_in_carousel = $request->show_in_carousel;
        $blog->save();

        if ($request->show_in_carousel == 1) {
            Session::flash('success', 'Blog added to carousel successfully!');
        } else {
            Session::flash('success', 'Blog removed from carousel successfully!');
        }

        return back();
    }

    public function hotNow(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->show_in_hot_now = $request->show_in_hot_now;
        $blog->save();

        if ($request->show_in_hot_now == 1) {
            Session::flash('success', 'Blog added to Hot Now successfully!');
        } else {
            Session::flash('success', 'Blog removed from Hot Now successfully!');
        }

        return back();
    }

    public function updateCarouselOrder(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->carousel_order = $request->carousel_order;
        $blog->save();

        Session::flash('success', 'Carousel order updated successfully!');
        return back();
    }

    public function featuredSlider(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->show_in_featured_slider = $request->show_in_featured_slider;
        $blog->save();

        if ($request->show_in_featured_slider == 1) {
            Session::flash('success', 'Blog added to featured slider successfully!');
        } else {
            Session::flash('success', 'Blog removed from featured slider successfully!');
        }

        return back();
    }

    public function updateFeaturedSliderOrder(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->featured_slider_order = $request->featured_slider_order;
        $blog->save();

        Session::flash('success', 'Featured slider order updated successfully!');
        return back();
    }

    public function carouselManagement(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        
        // Get blogs that are enabled for carousel
        $data['carousel_blogs'] = Blog::where('language_id', $lang_id)
            ->where('show_in_carousel', 1)
            ->orderBy('carousel_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
            
        // Get blogs that are enabled for featured slider
        $data['featured_slider_blogs'] = Blog::where('language_id', $lang_id)
            ->where('show_in_featured_slider', 1)
            ->orderBy('featured_slider_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
            
        // Get all blogs for selection
        $data['all_blogs'] = Blog::where('language_id', $lang_id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.blog.carousel.index', $data);
    }
}
