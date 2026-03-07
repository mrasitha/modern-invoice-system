<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Settings table එකේ ඇති සියලුම දත්ත 'key' එක අනුව array එකක් ලෙස ගනියි
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'business_logo']);
        
        // 1. සාමාන්‍ය දත්ත Save කිරීම
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Logo එක Upload කිරීම
        if ($request->hasFile('business_logo')) {
            $path = $request->file('business_logo')->store('business', 'public');
            // පරණ Logo එක තිබුණොත් ඒක update කරන්න
            Setting::updateOrCreate(['key' => 'business_logo'], ['value' => $path]);
        }

        return back()->with('success', 'Settings and Logo updated successfully!');
    }
}