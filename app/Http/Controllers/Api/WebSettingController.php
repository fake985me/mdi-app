<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WebSettingController extends Controller
{
    /**
     * Display the web settings.
     */
    public function index()
    {
        $settings = WebSetting::first();
        
        if (!$settings) {
            // Create default settings if none exist
            $settings = WebSetting::create([
                'site_name' => 'Inventory Management System',
                'site_title' => 'Inventory Management System',
                'site_description' => 'Efficient inventory and finance management solution',
                'home_hero_title' => 'Welcome to Our Inventory Management System',
                'home_hero_description' => 'Efficiently manage your inventory, track stock levels, and monitor sales with our comprehensive solution.',
                'home_features' => json_encode([
                    [
                        'title' => 'Inventory Tracking',
                        'description' => 'Keep track of all your products with real-time inventory updates and alerts.',
                        'icon' => 'fas fa-boxes'
                    ],
                    [
                        'title' => 'Sales Analytics',
                        'description' => 'Monitor your sales performance with detailed reports and insightful charts.',
                        'icon' => 'fas fa-chart-line'
                    ],
                    [
                        'title' => 'Stock Movements',
                        'description' => 'Track all stock movements including purchases, sales, and transfers.',
                        'icon' => 'fas fa-sync-alt'
                    ]
                ]),
                'footer_text' => '© 2025 Inventory Management System. All rights reserved.',
                'social_links' => json_encode([
                    'facebook' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                    'linkedin' => '#'
                ]),
                'primary_color' => '#3b82f6',
                'secondary_color' => '#10b981'
            ]);
        }
        
        // Ensure JSON fields are properly decoded
        if (is_string($settings->home_features)) {
            $settings->home_features = json_decode($settings->home_features, true);
        }
        
        if (is_string($settings->social_links)) {
            $settings->social_links = json_decode($settings->social_links, true);
        }
        
        return response()->json([
            'data' => $settings
        ]);
    }

    /**
     * Update the web settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'string|max:255',
            'site_title' => 'string|max:255|nullable',
            'site_description' => 'string|nullable',
            'home_hero_title' => 'string|max:255',
            'home_hero_description' => 'string|nullable',
            'home_features' => 'array|nullable',
            'footer_text' => 'string|nullable',
            'social_links' => 'array|nullable',
            'primary_color' => 'string|max:7',
            'secondary_color' => 'string|max:7',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'favicon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'home_hero_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $settings = WebSetting::first();
        
        if (!$settings) {
            $settings = new WebSetting();
        }

        // Update text fields
        $settings->site_name = $request->input('site_name', $settings->site_name);
        $settings->site_title = $request->input('site_title', $settings->site_title);
        $settings->site_description = $request->input('site_description', $settings->site_description);
        $settings->home_hero_title = $request->input('home_hero_title', $settings->home_hero_title);
        $settings->home_hero_description = $request->input('home_hero_description', $settings->home_hero_description);
        $settings->footer_text = $request->input('footer_text', $settings->footer_text);
        $settings->primary_color = $request->input('primary_color', $settings->primary_color);
        $settings->secondary_color = $request->input('secondary_color', $settings->secondary_color);

        // Update JSON fields
        if ($request->has('home_features')) {
            $settings->home_features = json_encode($request->input('home_features'));
        }

        if ($request->has('social_links')) {
            $settings->social_links = json_encode($request->input('social_links'));
        }

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path) {
                Storage::delete($settings->logo_path);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $settings->logo_path = $path;
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon_path) {
                Storage::delete($settings->favicon_path);
            }
            
            $path = $request->file('favicon')->store('favicons', 'public');
            $settings->favicon_path = $path;
        }

        if ($request->hasFile('home_hero_image')) {
            // Delete old hero image if exists
            if ($settings->home_hero_image_path) {
                Storage::delete($settings->home_hero_image_path);
            }
            
            $path = $request->file('home_hero_image')->store('hero_images', 'public');
            $settings->home_hero_image_path = $path;
        }

        $settings->save();

        // Decode JSON fields for response
        $settings->home_features = json_decode($settings->home_features, true);
        $settings->social_links = json_decode($settings->social_links, true);

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => $settings
        ]);
    }
}
