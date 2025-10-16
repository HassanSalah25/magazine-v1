<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogFaq;
use Illuminate\Http\Request;
use Validator;
use Session;

class BlogFaqController extends Controller
{
    public function index($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        $data['blog'] = $blog;
        $data['faqs'] = BlogFaq::where('blog_id', $blogId)->orderBy('serial_number', 'ASC')->get();
        
        return view('admin.blog.faq.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'blog_id' => 'required|exists:blogs,id',
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = new BlogFaq;
        $faq->blog_id = $request->blog_id;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'FAQ added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'faq_id' => 'required|exists:blog_faqs,id',
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = BlogFaq::findOrFail($request->faq_id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'FAQ updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $faq = BlogFaq::findOrFail($request->faq_id);
        $faq->delete();

        Session::flash('success', 'FAQ deleted successfully!');
        return redirect()->back();
    }
}
