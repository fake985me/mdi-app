<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the purchases.
     */
    public function index(): JsonResponse
    {
        $purchases = Purchase::with(['createdBy'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $purchases
        ]);
    }

    /**
     * Store a newly created purchase in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|exists:profiles,id',
        ]);

        $purchase = Purchase::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $purchase
        ], 201);
    }

    /**
     * Display the specified purchase.
     */
    public function show(string $id): JsonResponse
    {
        $purchase = Purchase::with(['createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $purchase
        ]);
    }

    /**
     * Update the specified purchase in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);

        $request->validate([
            'supplier_name' => 'sometimes|required|string|max:255',
            'supplier_contact' => 'sometimes|nullable|string|max:255',
            'total_amount' => 'sometimes|required|numeric|min:0',
            'notes' => 'sometimes|nullable|string',
            'created_by' => 'sometimes|nullable|exists:profiles,id',
        ]);

        $purchase->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $purchase
        ]);
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase deleted successfully'
        ]);
    }
}
