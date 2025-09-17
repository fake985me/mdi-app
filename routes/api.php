<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WebSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes with rate limiting
Route::middleware(['auth:sanctum', 'api.throttle'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Products
    Route::apiResource('products', ProductController::class);
    
    // Categories
    Route::apiResource('categories', CategoryController::class);
    
    // Subcategories
    Route::apiResource('subcategories', SubcategoryController::class);
    
    // Brands
    Route::apiResource('brands', BrandController::class);
    
    // Web Settings
    Route::get('/web-settings', [WebSettingController::class, 'index']);
    Route::post('/web-settings', [WebSettingController::class, 'update']);
});

// Super admin protected routes with rate limiting
Route::middleware(['auth:sanctum', 'superadmin.api', 'api.throttle'])->group(function () {
    // These routes will be accessible only by super admins
});