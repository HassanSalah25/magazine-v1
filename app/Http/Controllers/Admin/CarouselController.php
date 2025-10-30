<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class CarouselController extends Controller
{
    public function index(Request $request)
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
            
        // Get all blogs for selection
        $data['all_blogs'] = Blog::where('language_id', $lang_id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.blog.carousel.index', $data);
    }

    public function toggle(Request $request)
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

    public function updateOrder(Request $request)
    {
        $blog = Blog::find($request->blog_id);
        $blog->carousel_order = $request->carousel_order;
        $blog->save();

        Session::flash('success', 'Carousel order updated successfully!');
        return back();
    }
}