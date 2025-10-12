<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the order items.
     */
    public function index(): JsonResponse
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();
        
        return response()->json([
            'data' => $orderItems
        ]);
    }

    /**
     * Store a newly created order item in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $orderItem = OrderItem::create($request->all());

        return response()->json([
            'message' => 'Order item created successfully',
            'data' => $orderItem->load(['order', 'product'])
        ], 201);
    }

    /**
     * Display the specified order item.
     */
    public function show(string $id): JsonResponse
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);
        
        return response()->json([
            'data' => $orderItem
        ]);
    }

    /**
     * Update the specified order item in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $orderItem = OrderItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'order_id' => 'exists:orders,id',
            'product_id' => 'exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $orderItem->update($request->all());

        return response()->json([
            'message' => 'Order item updated successfully',
            'data' => $orderItem->load(['order', 'product'])
        ]);
    }

    /**
     * Remove the specified order item from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json([
            'message' => 'Order item deleted successfully'
        ]);
    }
}