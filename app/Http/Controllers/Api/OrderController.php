<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['user', 'items.product'])->get();
        
        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'order_number' => 'required|string|unique:orders,order_number',
            'total_amount' => 'required|numeric|min:0',
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'payment_method' => 'required|string',
            'status' => 'in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'in:pending,completed,failed,refunded'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::create($request->all());

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order->load(['user', 'items.product'])
        ], 201);
    }

    /**
     * Display the specified order.
     */
    public function show(string $id): JsonResponse
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        
        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'order_number' => 'sometimes|required|string|unique:orders,order_number,' . $id,
            'total_amount' => 'sometimes|required|numeric|min:0',
            'shipping_address' => 'array',
            'billing_address' => 'array',
            'payment_method' => 'string',
            'status' => 'in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'in:pending,completed,failed,refunded'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update($request->all());

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order->load(['user', 'items.product'])
        ]);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}