<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class FeaturedSliderController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        
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

        return view('admin.blog.featured-slider.index', $data);
    }

    public function toggle(Request $request)
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

    public function updateOrder(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->featured_slider_order = $request->featured_slider_order;
        $blog->save();

        Session::flash('success', 'Featured slider order updated successfully!');
        return back();
    }
}