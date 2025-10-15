<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\LanguageController;

// Language switch routes
Route::post('/language/switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'getCurrentLanguage'])->name('language.current');

// Product route - needs to be defined before the catch-all route
Route::get('/product', [SpaController::class, 'product'])->name('product.index');
Route::get('/products', [SpaController::class, 'product'])->name('products.index');

Route::get('/{any?}', [SpaController::class, 'index'])->where('any', '.*');