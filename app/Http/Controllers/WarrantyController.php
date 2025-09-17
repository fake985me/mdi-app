<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warranties = Warranty::with(['product', 'user'])->paginate(10);
        return view('warranties.index', compact('warranties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warranties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warranty_period' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $warranty = Warranty::create($request->all());

        return redirect()->route('warranties.index')->with('success', 'Warranty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warranty $warranty)
    {
        $warranty->load(['product', 'user']);
        return view('warranties.show', compact('warranty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warranty $warranty)
    {
        return view('warranties.edit', compact('warranty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warranty $warranty)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warranty_period' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $warranty->update($request->all());

        return redirect()->route('warranties.index')->with('success', 'Warranty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warranty $warranty)
    {
        $warranty->delete();

        return redirect()->route('warranties.index')->with('success', 'Warranty deleted successfully.');
    }
}
