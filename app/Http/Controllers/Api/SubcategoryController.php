<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the subcategories.
     */
    public function index(): JsonResponse
    {
        $subcategories = Subcategory::with('category')->get();
        
        return response()->json([
            'data' => $subcategories
        ]);
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $subcategory = Subcategory::create($request->all());

        return response()->json([
            'message' => 'Subcategory created successfully',
            'data' => $subcategory->load('category')
        ], 201);
    }

    /**
     * Display the specified subcategory.
     */
    public function show(string $id): JsonResponse
    {
        $subcategory = Subcategory::with('category')->findOrFail($id);
        
        return response()->json([
            'data' => $subcategory
        ]);
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $subcategory = Subcategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $subcategory->update($request->all());

        return response()->json([
            'message' => 'Subcategory updated successfully',
            'data' => $subcategory->load('category')
        ]);
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        return response()->json([
            'message' => 'Subcategory deleted successfully'
        ]);
    }
}