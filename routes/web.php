<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\LanguageController;

// Language switch routes
Route::post('/language/switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'getCurrentLanguage'])->name('language.current');

Route::get('/{any?}', [SpaController::class, 'index'])->where('any', '.*');