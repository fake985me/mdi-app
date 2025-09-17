<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // For now, just return a simple view
        return view('dashboard');
    }
}
