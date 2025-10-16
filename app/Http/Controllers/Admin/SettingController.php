<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'email|max:255',
        ]);

        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting && $setting->type === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/settings'), $filename);
                $setting->value = $filename;
            } else {
                $setting->value = $value;
            }

            $setting->save();
            cache()->forget("setting_{$key}");
        }


        return back()->with('success', 'Settings updated!');
    }
}
