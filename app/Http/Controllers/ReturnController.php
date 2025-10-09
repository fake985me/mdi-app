<?php

namespace App\Http\Controllers;

use App\Models\ReturnRecord;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $returns = ReturnRecord::with(['loan', 'loan.item', 'loan.item.category', 'loan.item.subcategory', 'loan.item.brand'])
            ->paginate(request('per_page', 10));
        
        return response()->json($returns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id' => 'required|exists:loans,id',
            'return_date' => 'required|date',
            'condition' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan = Loan::findOrFail($request->loan_id);
        
        // Check if loan is already returned
        if ($loan->status === 'dikembalikan') {
            return response()->json(['message' => 'Loan already returned'], 422);
        }

        $return = ReturnRecord::create($validator->validated());

        // Update loan status
        $loan->update([
            'status' => 'dikembalikan',
            'return_date' => $request->return_date
        ]);

        // Create a stock movement for the returned item
        $stockMovement = new \App\Models\StockMovement();
        $stockMovement->item_id = $loan->item_id;
        $stockMovement->type = 'masuk';
        $stockMovement->quantity = 1;
        $stockMovement->reference_type = 'pengembalian';
        $stockMovement->reference_id = $return->id;
        $stockMovement->date = $request->return_date;
        $stockMovement->description = 'Pengembalian barang dari pinjaman: ' . $loan->borrower;
        $stockMovement->save();

        return response()->json($return, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $return = ReturnRecord::with(['loan', 'loan.item', 'loan.item.category', 'loan.item.subcategory', 'loan.item.brand'])->findOrFail($id);
        
        return response()->json($return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $return = ReturnRecord::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'condition' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $return->update($validator->validated());

        return response()->json($return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $return = ReturnRecord::findOrFail($id);
        
        // Get the associated loan to access its details
        $loan = $return->loan;
        
        // Update loan status back to 'dipinjam'
        $loan->update([
            'status' => 'dipinjam',
            'return_date' => null
        ]);
        
        // Remove the stock movement for this return
        \App\Models\StockMovement::where('reference_type', 'pengembalian')
            ->where('reference_id', $return->id)
            ->delete();
        
        $return->delete();

        return response()->json(['message' => 'Return deleted successfully']);
    }
}
