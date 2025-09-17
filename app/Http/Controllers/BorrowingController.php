<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['product', 'user'])->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('borrowings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date',
        ]);

        $borrowing = Borrowing::create($request->all());

        return redirect()->route('borrowings.index')->with('success', 'Borrowing record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['product', 'user']);
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        return view('borrowings.edit', compact('borrowing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after:borrow_date',
        ]);

        $borrowing->update($request->all());

        return redirect()->route('borrowings.index')->with('success', 'Borrowing record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Borrowing record deleted successfully.');
    }
}
