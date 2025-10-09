<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warranties = Warranty::with(['item', 'item.category', 'item.subcategory', 'item.brand'])
            ->paginate(request('per_page', 10));
        
        return response()->json($warranties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $warranty = Warranty::create([
            'warranty_number' => 'WR-' . date('Ymd') . '-' . rand(1000, 9999),
            'item_id' => $request->item_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'terms' => $request->terms,
            'status' => 'aktif',
            'notes' => $request->notes,
        ]);

        return response()->json($warranty, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warranty = Warranty::with(['item', 'item.category', 'item.subcategory', 'item.brand'])->findOrFail($id);
        
        return response()->json($warranty);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warranty = Warranty::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'terms' => 'nullable|string',
            'status' => 'in:aktif,kadaluarsa,klaim',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $warranty->update($validator->validated());

        return response()->json($warranty);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warranty = Warranty::findOrFail($id);
        $warranty->delete();

        return response()->json(['message' => 'Warranty deleted successfully']);
    }
}
