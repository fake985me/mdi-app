<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SalesController extends Controller
{
    /**
     * Display a listing of the sales.
     */
    public function index(): JsonResponse
    {
        $sales = Sale::with(['createdBy'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $sales
        ]);
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_contact' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|exists:profiles,id',
        ]);

        $sale = Sale::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $sale
        ], 201);
    }

    /**
     * Display the specified sale.
     */
    public function show(string $id): JsonResponse
    {
        $sale = Sale::with(['createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $sale
        ]);
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $sale = Sale::findOrFail($id);

        $request->validate([
            'customer_name' => 'sometimes|nullable|string|max:255',
            'customer_contact' => 'sometimes|nullable|string|max:255',
            'total_amount' => 'sometimes|required|numeric|min:0',
            'notes' => 'sometimes|nullable|string',
            'created_by' => 'sometimes|nullable|exists:profiles,id',
        ]);

        $sale->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $sale
        ]);
    }

    /**
     * Remove the specified sale from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sale deleted successfully'
        ]);
    }
}
