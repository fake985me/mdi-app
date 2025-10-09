<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/charts', [DashboardController::class, 'getChartData']);
    
    // User management (Superadmin only)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::put('/users/{user}/assign-role', [UserController::class, 'assignRole']);
    });
    
    // Item management
    Route::apiResource('items', ItemController::class);
    Route::post('/items/{id}/images', [ItemController::class, 'uploadImage']);
    Route::delete('/items/{id}/images/{image}', [ItemController::class, 'deleteImage']);
    
    // Category management
    Route::apiResource('categories', CategoryController::class);
    
    // Subcategory management
    Route::apiResource('subcategories', SubcategoryController::class);
    
    // Brand management
    Route::apiResource('brands', BrandController::class);
    
    // Stock management
    Route::apiResource('stock-movements', StockMovementController::class);
    Route::get('/stock/{item}', [StockMovementController::class, 'getStock']);
    
    // Purchase management
    Route::apiResource('purchases', PurchaseController::class);
    Route::post('/purchases/{id}/items', [PurchaseController::class, 'addItem']);
    Route::delete('/purchases/{id}/items/{item}', [PurchaseController::class, 'removeItem']);
    
    // Sale management
    Route::apiResource('sales', SaleController::class);
    Route::post('/sales/{id}/items', [SaleController::class, 'addItem']);
    Route::delete('/sales/{id}/items/{item}', [SaleController::class, 'removeItem']);
    
    // Loan management
    Route::apiResource('loans', LoanController::class);
    
    // Return management
    Route::apiResource('returns', ReturnController::class);
    
    // Warranty management
    Route::apiResource('warranties', WarrantyController::class);
    
    // Setting management
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'store']);
    Route::put('/settings/{key}', [SettingController::class, 'update']);
    Route::delete('/settings/{key}', [SettingController::class, 'destroy']);
});

// Public guest routes
Route::prefix('guest')->group(function () {
    Route::get('/items', [ItemController::class, 'guestIndex']);
    Route::get('/items/{id}', [ItemController::class, 'guestShow']);
    Route::get('/categories', [CategoryController::class, 'guestIndex']);
    Route::get('/subcategories', [SubcategoryController::class, 'guestIndex']);
    Route::get('/brands', [BrandController::class, 'guestIndex']);
    
    // Guest page settings
    Route::get('/settings', [SettingController::class, 'guestSettings']);
});