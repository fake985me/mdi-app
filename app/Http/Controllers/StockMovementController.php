<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockMovements = StockMovement::with(['item', 'item.category', 'item.subcategory', 'item.brand'])
            ->paginate(request('per_page', 10));
        
        return response()->json($stockMovements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stockMovement = StockMovement::create($validator->validated());

        return response()->json($stockMovement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stockMovement = StockMovement::with(['item', 'item.category', 'item.subcategory', 'item.brand'])
            ->findOrFail($id);
        
        return response()->json($stockMovement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stockMovement->update($validator->validated());

        return response()->json($stockMovement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->delete();

        return response()->json(['message' => 'Stock movement deleted successfully']);
    }
    
    /**
     * Get the current stock for an item.
     */
    public function getStock($itemId)
    {
        $item = \App\Models\Item::findOrFail($itemId);
        
        $netStock = $item->stockMovements()
            ->select(DB::raw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock'))
            ->first()->net_stock ?? 0;
        
        return response()->json(['item_id' => $itemId, 'current_stock' => $netStock]);
    }
}
