<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): JsonResponse
    {
        $query = Product::query();
        
        // Add relationships based on authentication
        if (auth()->check()) {
            // Authenticated users get all products with full relationships
            $products = $query->with(['category', 'subcategory'])->get();
        } else {
            // Unauthenticated users get limited data (e.g., only in-stock items)
            $products = $query->with(['category', 'subcategory'])
                ->where('current_stock', '>', 0)  // Only show items in stock
                ->get();
        }
        
        return response()->json([
            'data' => $products
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image_url' => 'nullable|string',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product->load('category')
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);
        
        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'current_stock' => 'sometimes|required|integer|min:0',
            'minimum_stock' => 'sometimes|required|integer|min:0',
            'maximum_stock' => 'sometimes|required|integer|min:0',
            'cost_price' => 'sometimes|required|numeric|min:0',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'category_id' => 'sometimes|exists:categories,id',
            'subcategory_id' => 'sometimes|nullable|exists:subcategories,id',
            'image_url' => 'sometimes|nullable|string',
            'status' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->load('category')
        ]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
    
    /**
     * Display a listing of products for landing page (public).
     */
    public function landingIndex(): JsonResponse
    {
        $products = Product::with(['category', 'subcategory'])
            ->where('current_stock', '>', 0) // Only show products in stock
            ->limit(12) // Limit to 12 products for landing page
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}