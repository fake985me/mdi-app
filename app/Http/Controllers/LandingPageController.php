<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Get random products to display on the landing page
        $products = Product::inRandomOrder()->limit(6)->get();
        
        return view('landing', compact('products'));
    }
}
