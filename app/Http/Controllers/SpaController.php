<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\LandingPageSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SpaController extends Controller
{
    public function index(Request $request, $any = null)
    {
        // Check if there's a static blade file for this route first
        if ($any) {
            // Check if a static blade file exists for this route
            $staticViewPath = public_path('views/' . $any . '.blade.php');
            if (File::exists($staticViewPath)) {
                // Return the static blade file instead of the SPA
                return view('views.' . $any);
            }
        } else {
            // Check for home page static file
            $homeStaticViewPath = public_path('views/home.blade.php');
            if (File::exists($homeStaticViewPath)) {
                return view('views.home');
            }
        }

        // For public routes that need to be handled by the SPA
        // Check if it's a page slug
        if ($any && $any !== 'api' && $any !== 'storage') {
            $page = Page::where('slug', $any)->where('is_active', true)->first();
            if ($page) {
                // Return the SPA view for Vue Router to handle
                return view('welcome', [
                    'currentLocale' => Session::get('language', App::getLocale())
                ]);
            }
            
            // If it's not a known page, check if we need to handle it differently
            // For now, return SPA view to let Vue Router handle 404
        } else {
            // Check if the home page exists as a custom page
            $homePage = Page::where('slug', 'home')->where('is_active', true)->first();
            if ($homePage) {
                // Return SPA view so Vue Router can handle the home page
                return view('welcome', [
                    'currentLocale' => Session::get('language', App::getLocale())
                ]);
            }
        }
        
        return view('welcome', [
            'currentLocale' => Session::get('language', App::getLocale())
        ]);
    }
    
    public function product(Request $request)
    {
        // Return the SPA view to let Vue Router handle the product page
        return view('welcome', [
            'currentLocale' => Session::get('language', App::getLocale())
        ]);
    }
}