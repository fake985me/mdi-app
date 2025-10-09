<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->paginate(request('per_page', 10));
        
        return response()->json($subcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subcategory = Subcategory::create($validator->validated());

        return response()->json($subcategory, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcategory = Subcategory::with('category')->findOrFail($id);
        
        return response()->json($subcategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategory = Subcategory::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subcategory->update($validator->validated());

        return response()->json($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = Subcategory::findOrFail($id);
        
        // Check if subcategory has items
        if ($subcategory->items()->count() > 0) {
            return response()->json(['message' => 'Cannot delete subcategory with items'], 422);
        }
        
        $subcategory->delete();

        return response()->json(['message' => 'Subcategory deleted successfully']);
    }
    
    /**
     * Display a listing of the resource for guest users.
     */
    public function guestIndex()
    {
        $subcategories = Subcategory::with('category')->paginate(request('per_page', 10));
        
        return response()->json($subcategories);
    }
}
