<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockMovements = StockMovement::with(['product', 'user'])->paginate(10);
        return view('stock-movements.index', compact('stockMovements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock-movements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'movement_date' => 'required|date',
        ]);

        $stockMovement = StockMovement::create($request->all());

        return redirect()->route('stock-movements.index')->with('success', 'Stock movement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        $stockMovement->load(['product', 'user']);
        return view('stock-movements.show', compact('stockMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        return view('stock-movements.edit', compact('stockMovement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'movement_date' => 'required|date',
        ]);

        $stockMovement->update($request->all());

        return redirect()->route('stock-movements.index')->with('success', 'Stock movement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        $stockMovement->delete();

        return redirect()->route('stock-movements.index')->with('success', 'Stock movement deleted successfully.');
    }
}
