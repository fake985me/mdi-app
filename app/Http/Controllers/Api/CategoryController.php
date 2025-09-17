<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
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
            $categories = Category::paginate($perPage);

            return $this->success(
                CategoryResource::collection($categories),
                'Categories retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve categories: ' . $e->getMessage());
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

        // Only super admins can create categories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'description' => 'nullable|string',
            ]);

            $category = Category::create($request->validated());

            return $this->success(
                new CategoryResource($category),
                'Category created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            return $this->success(
                new CategoryResource($category),
                'Category retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve category: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can update categories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
            ]);

            $category->update($request->validated());

            return $this->success(
                new CategoryResource($category),
                'Category updated successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        // Only super admins can delete categories
        if (!$this->isSuperAdmin()) {
            return $this->error('Forbidden', 403);
        }

        try {
            // Check if category has related products
            if ($category->products()->count() > 0) {
                return $this->error('Cannot delete category with associated products');
            }

            $category->delete();

            return $this->success(
                null,
                'Category deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to delete category: ' . $e->getMessage());
        }
    }
}