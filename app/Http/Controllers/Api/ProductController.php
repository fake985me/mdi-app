<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $perPage = $request->get('per_page', 10);
            $products = Product::with(['category', 'subcategory', 'brand'])
                ->paginate($perPage);

            return $this->success(
                ProductResource::collection($products),
                'Products retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve products: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $product = Product::create($request->validated());

            return $this->success(
                new ProductResource($product->load(['category', 'subcategory', 'brand'])),
                'Product created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $product->load(['category', 'subcategory', 'brand']);
            return $this->success(
                new ProductResource($product),
                'Product retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve product: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            // Handle SKU uniqueness validation for updates
            $validatedData = $request->validated();
            if (isset($validatedData['sku']) && $validatedData['sku'] !== $product->sku) {
                $request->validate([
                    'sku' => 'unique:products,sku',
                ]);
            }

            $product->update($validatedData);

            return $this->success(
                new ProductResource($product->load(['category', 'subcategory', 'brand'])),
                'Product updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $product->delete();

            return $this->success(
                null,
                'Product deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to delete product: ' . $e->getMessage());
        }
    }
}