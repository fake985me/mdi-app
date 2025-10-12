<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the warranties.
     */
    public function index(): JsonResponse
    {
        $warranties = Warranty::with(['product'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $warranties
        ]);
    }

    /**
     * Store a newly created warranty in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date|after:warranty_start_date',
            'warranty_terms' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'customer_contact' => 'nullable|string|max:255',
        ]);

        $warranty = Warranty::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $warranty
        ], 201);
    }

    /**
     * Display the specified warranty.
     */
    public function show(string $id): JsonResponse
    {
        $warranty = Warranty::with(['product'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $warranty
        ]);
    }

    /**
     * Update the specified warranty in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $warranty = Warranty::findOrFail($id);

        $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'warranty_start_date' => 'sometimes|required|date',
            'warranty_end_date' => 'sometimes|required|date|after:warranty_start_date',
            'warranty_terms' => 'sometimes|nullable|string',
            'customer_name' => 'sometimes|nullable|string|max:255',
            'customer_contact' => 'sometimes|nullable|string|max:255',
        ]);

        $warranty->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $warranty
        ]);
    }

    /**
     * Remove the specified warranty from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $warranty = Warranty::findOrFail($id);
        $warranty->delete();

        return response()->json([
            'success' => true,
            'message' => 'Warranty deleted successfully'
        ]);
    }
}
