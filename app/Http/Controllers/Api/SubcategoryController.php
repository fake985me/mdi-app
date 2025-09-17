<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends ApiController
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
            $subcategories = Subcategory::with('category')->paginate($perPage);

            return $this->success(
                SubcategoryResource::collection($subcategories),
                'Subcategories retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve subcategories: ' . $e->getMessage());
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

        // Only super admins can create subcategories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:subcategories',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $subcategory = Subcategory::create($request->validated());

            return $this->success(
                new SubcategoryResource($subcategory->load('category')),
                'Subcategory created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create subcategory: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Subcategory $subcategory)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            $subcategory->load('category');
            return $this->success(
                new SubcategoryResource($subcategory),
                'Subcategory retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve subcategory: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can update subcategories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:subcategories,name,' . $subcategory->id,
                'description' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $subcategory->update($request->validated());

            return $this->success(
                new SubcategoryResource($subcategory->load('category')),
                'Subcategory updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update subcategory: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Subcategory $subcategory)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can delete subcategories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            // Check if subcategory has related products
            if ($subcategory->products()->count() > 0) {
                return $this->error('Cannot delete subcategory with associated products');
            }

            $subcategory->delete();

            return $this->success(
                null,
                'Subcategory deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to delete subcategory: ' . $e->getMessage());
        }
    }
}