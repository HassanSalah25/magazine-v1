<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
//        return cache()->remember("setting_{$key}", 3600, function () use ($key, $default) {
//            return optional(\App\Models\Setting::where('key', $key)->first())->value ?? $default;
//        });
        return optional(\App\Models\Setting::where('key', $key)->first())->value ?? $default;
    }
}

if (! function_exists('serviceCategory')) {
    function serviceCategory() {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        if($settings['service_category'] == 'on'){
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
