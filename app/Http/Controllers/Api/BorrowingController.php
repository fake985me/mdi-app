<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index(): JsonResponse
    {
        $borrowings = Borrowing::with(['product', 'user', 'customer'])->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $borrowings
        ]);
    }

    /**
     * Store a newly created borrowing in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'expected_return_date' => 'required|date',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $borrowing = Borrowing::create($request->all());
        
        // Deduct quantity from product stock
        $product = Product::findOrFail($request->product_id);
        $product->decrement('current_stock', $request->quantity);

        return response()->json([
            'success' => true,
            'data' => $borrowing
        ], 201);
    }

    /**
     * Display the specified borrowing.
     */
    public function show(string $id): JsonResponse
    {
        $borrowing = Borrowing::with(['product', 'user', 'customer'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $borrowing
        ]);
    }

    /**
     * Update the specified borrowing in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $borrowing = Borrowing::findOrFail($id);

        $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'customer_id' => 'sometimes|required|exists:customers,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'expected_return_date' => 'sometimes|required|date',
            'actual_return_date' => 'nullable|date',
            'status' => 'sometimes|in:active,returned,overdue',
            'notes' => 'sometimes|nullable|string',
            'user_id' => 'sometimes|nullable|exists:users,id',
        ]);

        $borrowing->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $borrowing
        ]);
    }

    /**
     * Remove the specified borrowing from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $borrowing = Borrowing::findOrFail($id);

        // Return the borrowed quantity to stock if not already returned
        if ($borrowing->status !== 'returned') {
            $product = Product::findOrFail($borrowing->product_id);
            $product->increment('current_stock', $borrowing->quantity);
        }

        $borrowing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Borrowing record deleted successfully'
        ]);
    }
}
