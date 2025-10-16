<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicSetting as BS;
use App\Models\HowWeDoItSection;
use App\Models\Language;
use Illuminate\Http\Request;
use Session;
use Validator;

class HowWeDoItController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->firstOrFail();
        $lang_id = $lang->id;

        if ($request->filled('id')) {
            $bs = BS::where('language_id', $lang_id)->findOrFail($request->id);
            $data['landingpage_id'] = $request->id;
        } else {
            $bs = BS::where('language_id', $lang_id)->firstOrFail();
            $data['landingpage_id'] = null;
        }

        $data['abs'] = $bs;
        $data['lang_id'] = $lang_id;

        // Get or create How We Do It section
        $howWeDoItSection = HowWeDoItSection::where('language_id', $lang_id)->first();
        if (!$howWeDoItSection) {
            $howWeDoItSection = HowWeDoItSection::create([
                'language_id' => $lang_id,
                'title' => 'How We Do It',
                'subtitle' => 'Advanced technology, trackable performance, top-rated talent, and data activation.',
                'tabs' => []
            ]);
        }

        $data['howWeDoItSection'] = $howWeDoItSection;
        $data['tabs'] = $howWeDoItSection->tabs ?? [];

        return view('admin.home.howwedoit.index', $data);
    }

    public function update(Request $request, $langid)
    {
        // Debug: Log the section update request
        
        $request->validate([
            'how_we_do_it_title' => 'required|max:100',
            'how_we_do_it_subtitle' => 'nullable|max:200',
        ]);

        $howWeDoItSection = HowWeDoItSection::where('language_id', $langid)->firstOrFail();
        $howWeDoItSection->title = $request->how_we_do_it_title;
        $howWeDoItSection->subtitle = $request->how_we_do_it_subtitle;
        $howWeDoItSection->save();

        Session::flash('success', 'Section updated successfully!');
        return back();
    }

    public function storeTab(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required',
            'image' => 'nullable|string|max:255',
        ]);

        $lang = Language::where('code', $request->tab_language)->firstOrFail();
        $lang_id = $lang->id;

        $howWeDoItSection = HowWeDoItSection::where('language_id', $lang_id)->firstOrFail();
        $tabs = $howWeDoItSection->tabs ?? [];

        // Add new tab
        $newTab = [
            'id' => uniqid(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'created_at' => now()->toDateTimeString(),
        ];

        $tabs[] = $newTab;
        $howWeDoItSection->tabs = $tabs;
        $howWeDoItSection->save();

        Session::flash('success', 'Tab added successfully!');
        return back();
    }

    public function updateTab(Request $request)
    {
        // Debug: Log the request data
        \Log::info('UpdateTab Request Data:', $request->all());
        \Log::info('Request URL:', $request->url());
        \Log::info('Request Method:', $request->method());
        \Log::info('All Input:', $request->all());
        \Log::info('Tab Language:', $request->input('tab_language'));
        \Log::info('Language (old):', $request->input('language'));
        
        $request->validate([
            'tab_id' => 'required',
            'title' => 'required|max:100',
            'content' => 'required',
            'image' => 'nullable|string|max:255',
        ]);

        // Handle both old and new field names for backward compatibility
        $languageCode = $request->input('tab_language') ?: $request->input('language');
        \Log::info('Using Language Code:', $languageCode);
        $lang = Language::where('code', $languageCode)->firstOrFail();
        $lang_id = $lang->id;

        $howWeDoItSection = HowWeDoItSection::where('language_id', $lang_id)->firstOrFail();
        $tabs = $howWeDoItSection->tabs ?? [];

        // Update specific tab
        $tabFound = false;
        foreach ($tabs as $key => $tab) {
            if ($tab['id'] == $request->tab_id) {
                $tabs[$key]['title'] = $request->title;
                $tabs[$key]['content'] = $request->content;
                $tabs[$key]['image'] = $request->image;
                $tabs[$key]['updated_at'] = now()->toDateTimeString();
                $tabFound = true;
                break;
            }
        }

        if (!$tabFound) {
            Session::flash('error', 'Tab not found!');
            return back();
        }

        $howWeDoItSection->tabs = $tabs;
        $howWeDoItSection->save();

        Session::flash('success', 'Tab updated successfully!');
        return back();
    }

    public function deleteTab(Request $request)
    {
        $request->validate([
            'tab_id' => 'required',
        ]);

        $lang = Language::where('code', $request->tab_language)->firstOrFail();
        $lang_id = $lang->id;

        $howWeDoItSection = HowWeDoItSection::where('language_id', $lang_id)->firstOrFail();
        $tabs = $howWeDoItSection->tabs ?? [];

        // Remove specific tab
        $tabs = array_filter($tabs, function($tab) use ($request) {
            return $tab['id'] != $request->tab_id;
        });

        $howWeDoItSection->tabs = array_values($tabs);
        $howWeDoItSection->save();

        Session::flash('success', 'Tab deleted successfully!');
        return back();
    }
}
