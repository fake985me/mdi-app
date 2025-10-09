<?php

namespace App\Http\Controllers;

use App\Models\PageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = PageSetting::all();
        
        return response()->json($settings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|unique:page_settings,key',
            'value' => 'required|string',
            'type' => 'in:text,json,boolean,number',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $setting = PageSetting::create($validator->validated());

        return response()->json($setting, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $key)
    {
        $setting = PageSetting::where('key', $key)->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'value' => 'required|string',
            'type' => 'in:text,json,boolean,number',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $setting->update($validator->validated());

        return response()->json($setting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($key)
    {
        $setting = PageSetting::where('key', $key)->firstOrFail();
        $setting->delete();

        return response()->json(['message' => 'Setting deleted successfully']);
    }
    
    /**
     * Display guest settings.
     */
    public function guestSettings()
    {
        $settings = PageSetting::all();
        
        // Convert settings to key-value pairs
        $settingsArray = [];
        foreach ($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }
        
        return response()->json($settingsArray);
    }
}
