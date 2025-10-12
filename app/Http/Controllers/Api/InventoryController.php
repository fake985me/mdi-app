<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InventoryController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): JsonResponse
    {
        $products = Product::with(['category', 'subcategory'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'current_stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image_url' => 'nullable|url',
            'status' => 'boolean',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'cost_price' => 'sometimes|required|numeric|min:0',
            'current_stock' => 'sometimes|required|integer|min:0',
            'minimum_stock' => 'sometimes|required|integer|min:0',
            'maximum_stock' => 'sometimes|required|integer|min:0',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'subcategory_id' => 'sometimes|nullable|exists:subcategories,id',
            'image_url' => 'sometimes|nullable|url',
            'status' => 'sometimes|boolean',
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $product
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
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
