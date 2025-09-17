<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends ApiController
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
            $brands = Brand::paginate($perPage);

            return $this->success(
                BrandResource::collection($brands),
                'Brands retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve brands: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can create brands
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:brands',
                'description' => 'nullable|string',
            ]);

            $brand = Brand::create($request->validated());

            return $this->success(
                new BrandResource($brand),
                'Brand created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create brand: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Brand $brand)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            return $this->success(
                new BrandResource($brand),
                'Brand retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve brand: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Brand $brand)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can update brands
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
                'description' => 'nullable|string',
            ]);

            $brand->update($request->validated());

            return $this->success(
                new BrandResource($brand),
                'Brand updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update brand: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Brand $brand)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can delete brands
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            // Check if brand has related products
            if ($brand->products()->count() > 0) {
                return $this->error('Cannot delete brand with associated products');
            }

            $brand->delete();

            return $this->success(
                null,
                'Brand deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to delete brand: ' . $e->getMessage());
        }
    }
}