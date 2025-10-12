<?php

use Illuminate\Http\Request;
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

// Authentication routes
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [App\Http\Controllers\AuthController::class, 'user'])->middleware('auth:sanctum');

// User management routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
    Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy']);
});

// Public routes - change to avoid conflict
Route::get('/public/pages/{slug}', [App\Http\Controllers\Api\PageController::class, 'getBySlug']);

Route::get('/public/home', [App\Http\Controllers\Api\PageController::class, 'getHomePage']);


// Public product routes for landing page

// All other routes are within auth middleware
Route::middleware('auth:sanctum')->group(function () {
    // Category routes
    Route::apiResource('categories', App\Http\Controllers\Api\CategoryController::class);
    
    // Subcategory routes
    Route::apiResource('subcategories', App\Http\Controllers\Api\SubcategoryController::class);
    
    // Product routes
    Route::apiResource('products', App\Http\Controllers\Api\ProductController::class);
    
    // Inventory routes
    Route::apiResource('inventory', App\Http\Controllers\Api\InventoryController::class);
    
    // Purchase routes
    Route::apiResource('purchases', App\Http\Controllers\Api\PurchaseController::class);
    
    // Sales routes
    Route::apiResource('sales', App\Http\Controllers\Api\SalesController::class);
    
    // Stock movement routes
    Route::apiResource('stock-movements', App\Http\Controllers\Api\StockMovementController::class);
    
    // Warranty routes
    Route::apiResource('warranties', App\Http\Controllers\Api\WarrantyController::class);
    
    // Borrowing routes
    Route::apiResource('borrowings', App\Http\Controllers\Api\BorrowingController::class);
    
    // Order routes
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
    
    // Order items routes
    Route::apiResource('order-items', App\Http\Controllers\Api\OrderItemController::class);
    
    // Template management routes
    Route::apiResource('templates', App\Http\Controllers\Api\TemplateController::class);
    Route::get('/templates/category/{category}', [App\Http\Controllers\Api\TemplateController::class, 'getByCategory']);
    Route::get('/templates-active', [App\Http\Controllers\Api\TemplateController::class, 'getActive']);
});

    // Page management routes (within the main auth middleware group)
    Route::get('/pages', [App\Http\Controllers\Api\PageController::class, 'index'])->name('pages.index');
    Route::post('/pages', [App\Http\Controllers\Api\PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}', [App\Http\Controllers\Api\PageController::class, 'show'])->name('pages.show');
    Route::put('/pages/{page}', [App\Http\Controllers\Api\PageController::class, 'update'])->name('pages.update');
    Route::patch('/pages/{page}', [App\Http\Controllers\Api\PageController::class, 'update'])->name('pages.update.patch');
    Route::delete('/pages/{page}', [App\Http\Controllers\Api\PageController::class, 'destroy'])->name('pages.destroy');

// Admin routes with role middleware
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('/admin/subcategories', [App\Http\Controllers\Api\SubcategoryController::class, 'index']);
    Route::get('/admin/orders', [App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/admin/pages', [App\Http\Controllers\Api\PageController::class, 'index']);
});  
  
  
// Public product routes  
  
// Public route for viewing products  
Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']); 
  
// Additional public routes  