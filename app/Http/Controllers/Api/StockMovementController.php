<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the stock movements.
     */
    public function index(): JsonResponse
    {
        $movements = StockMovement::with(['product', 'createdBy'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $movements
        ]);
    }

    /**
     * Store a newly created stock movement in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type' => 'required|in:incoming,outgoing,purchase,sale,borrow,return',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|exists:profiles,id',
        ]);

        $movement = StockMovement::create($request->all());

        // Update product stock based on movement type
        $product = Product::findOrFail($request->product_id);
        if ($request->movement_type === 'incoming') {
            $product->increment('current_stock', $request->quantity);
        } elseif ($request->movement_type === 'outgoing') {
            $product->decrement('current_stock', $request->quantity);
        }

        return response()->json([
            'success' => true,
            'data' => $movement
        ], 201);
    }

    /**
     * Display the specified stock movement.
     */
    public function show(string $id): JsonResponse
    {
        $movement = StockMovement::with(['product', 'createdBy'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $movement
        ]);
    }

    /**
     * Update the specified stock movement in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $movement = StockMovement::findOrFail($id);

        $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'movement_type' => 'sometimes|required|in:incoming,outgoing,purchase,sale,borrow,return',
            'quantity' => 'sometimes|required|integer|min:1',
            'unit_price' => 'sometimes|nullable|numeric|min:0',
            'total_amount' => 'sometimes|nullable|numeric|min:0',
            'notes' => 'sometimes|nullable|string',
            'created_by' => 'sometimes|nullable|exists:profiles,id',
        ]);

        $movement->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $movement
        ]);
    }

    /**
     * Remove the specified stock movement from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $movement = StockMovement::findOrFail($id);
        $movement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock movement deleted successfully'
        ]);
    }
}
