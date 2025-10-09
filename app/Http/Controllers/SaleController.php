<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['customer', 'items', 'items.item'])
            ->paginate(request('per_page', 10));
        
        return response()->json($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sale = Sale::create([
            'sale_number' => 'SO-' . date('Ymd') . '-' . rand(1000, 9999),
            'customer_id' => $request->customer_id,
            'date' => $request->date,
            'notes' => $request->notes,
            'total' => 0, // Will be calculated after items are added
        ]);

        return response()->json($sale, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with(['customer', 'items', 'items.item'])->findOrFail($id);
        
        return response()->json($sale);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sale = Sale::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sale->update($validator->validated());

        return response()->json($sale);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        
        // Delete related sale items
        $sale->items()->delete();
        
        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully']);
    }
    
    /**
     * Add an item to a sale.
     */
    public function addItem(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if enough stock is available
        $item = \App\Models\Item::findOrFail($request->item_id);
        $currentStock = $item->stockMovements()
            ->select(DB::raw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock'))
            ->first()->net_stock ?? 0;
            
        if ($currentStock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 422);
        }

        $saleItem = new SaleItem();
        $saleItem->sale_id = $sale->id;
        $saleItem->item_id = $request->item_id;
        $saleItem->quantity = $request->quantity;
        $saleItem->price = $request->price;
        $saleItem->subtotal = $request->quantity * $request->price;
        $saleItem->save();

        // Update the sale total
        $sale->total = $sale->items->sum('subtotal');
        $sale->save();

        // Create a stock movement for the sold items
        $stockMovement = new \App\Models\StockMovement();
        $stockMovement->item_id = $request->item_id;
        $stockMovement->type = 'keluar';
        $stockMovement->quantity = $request->quantity;
        $stockMovement->reference_type = 'penjualan';
        $stockMovement->reference_id = $sale->id;
        $stockMovement->date = $sale->date;
        $stockMovement->description = 'Penjualan barang';
        $stockMovement->save();

        return response()->json($saleItem, 201);
    }
    
    /**
     * Remove an item from a sale.
     */
    public function removeItem($id, $itemId)
    {
        $sale = Sale::findOrFail($id);
        $saleItem = SaleItem::where('sale_id', $sale->id)
            ->where('item_id', $itemId)
            ->firstOrFail();
            
        // Remove the stock movement associated with this sale item
        \App\Models\StockMovement::where('reference_type', 'penjualan')
            ->where('reference_id', $sale->id)
            ->where('item_id', $itemId)
            ->delete();
        
        $saleItem->delete();

        // Update the sale total
        $sale->total = $sale->items->sum('subtotal');
        $sale->save();

        return response()->json(['message' => 'Sale item removed successfully']);
    }
}
