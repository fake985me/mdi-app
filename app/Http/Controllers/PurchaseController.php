<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'items', 'items.item'])
            ->paginate(request('per_page', 10));
        
        return response()->json($purchases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $purchase = Purchase::create([
            'purchase_number' => 'PO-' . date('Ymd') . '-' . rand(1000, 9999),
            'supplier_id' => $request->supplier_id,
            'date' => $request->date,
            'notes' => $request->notes,
            'total' => 0, // Will be calculated after items are added
        ]);

        return response()->json($purchase, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['supplier', 'items', 'items.item'])->findOrFail($id);
        
        return response()->json($purchase);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $purchase->update($validator->validated());

        return response()->json($purchase);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::findOrFail($id);
        
        // Delete related purchase items
        $purchase->items()->delete();
        
        $purchase->delete();

        return response()->json(['message' => 'Purchase deleted successfully']);
    }
    
    /**
     * Add an item to a purchase.
     */
    public function addItem(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $purchaseItem = new PurchaseItem();
        $purchaseItem->purchase_id = $purchase->id;
        $purchaseItem->item_id = $request->item_id;
        $purchaseItem->quantity = $request->quantity;
        $purchaseItem->price = $request->price;
        $purchaseItem->subtotal = $request->quantity * $request->price;
        $purchaseItem->save();

        // Update the purchase total
        $purchase->total = $purchase->items->sum('subtotal');
        $purchase->save();

        // Create a stock movement for the purchased items
        $stockMovement = new \App\Models\StockMovement();
        $stockMovement->item_id = $request->item_id;
        $stockMovement->type = 'masuk';
        $stockMovement->quantity = $request->quantity;
        $stockMovement->reference_type = 'pembelian';
        $stockMovement->reference_id = $purchase->id;
        $stockMovement->date = $purchase->date;
        $stockMovement->description = 'Pembelian barang';
        $stockMovement->save();

        return response()->json($purchaseItem, 201);
    }
    
    /**
     * Remove an item from a purchase.
     */
    public function removeItem($id, $itemId)
    {
        $purchase = Purchase::findOrFail($id);
        $purchaseItem = PurchaseItem::where('purchase_id', $purchase->id)
            ->where('item_id', $itemId)
            ->firstOrFail();
            
        // Remove the stock movement associated with this purchase item
        \App\Models\StockMovement::where('reference_type', 'pembelian')
            ->where('reference_id', $purchase->id)
            ->where('item_id', $itemId)
            ->delete();
        
        $purchaseItem->delete();

        // Update the purchase total
        $purchase->total = $purchase->items->sum('subtotal');
        $purchase->save();

        return response()->json(['message' => 'Purchase item removed successfully']);
    }
}
