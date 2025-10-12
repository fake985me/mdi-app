<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,id'
        ]);

        $locale = $request->locale;
        
        // Set the locale
        App::setLocale($locale);
        
        // Store the locale in session
        Session::put('language', $locale);
        
        // Also store in cookie for persistence across sessions
        return response()->json([
            'status' => 'success',
            'message' => 'Language changed successfully',
            'locale' => $locale
        ]);
    }
    
    public function getCurrentLanguage()
    {
        $locale = Session::get('language', App::getLocale());
        return response()->json([
            'locale' => $locale
        ]);
    }
}