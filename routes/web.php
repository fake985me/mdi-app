<?php

use Illuminate\Support\Facades\Route;

// Route all non-API requests to the Vue app
// API routes are defined in routes/api.php
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api\/).*');
