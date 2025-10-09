<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with(['item', 'item.category', 'item.subcategory', 'item.brand'])
            ->paginate(request('per_page', 10));
        
        return response()->json($loans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'borrower' => 'required|string|max:255',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if item is available for loan
        $item = \App\Models\Item::findOrFail($request->item_id);
        $currentStock = $item->stockMovements()
            ->select(DB::raw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock'))
            ->first()->net_stock ?? 0;
            
        if ($currentStock < 1) {
            return response()->json(['message' => 'Item not available for loan'], 422);
        }

        $loan = Loan::create($validator->validated());

        // Create a stock movement for the loaned item
        $stockMovement = new \App\Models\StockMovement();
        $stockMovement->item_id = $request->item_id;
        $stockMovement->type = 'keluar';
        $stockMovement->quantity = 1;
        $stockMovement->reference_type = 'peminjaman';
        $stockMovement->reference_id = $loan->id;
        $stockMovement->date = $request->loan_date;
        $stockMovement->description = 'Peminjaman barang: ' . $request->borrower;
        $stockMovement->save();

        return response()->json($loan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loan = Loan::with(['item', 'item.category', 'item.subcategory', 'item.brand'])->findOrFail($id);
        
        return response()->json($loan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loan = Loan::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'borrower' => 'required|string|max:255',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
            'status' => 'in:dipinjam,dikembalikan,terlambat',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loan->update($validator->validated());

        return response()->json($loan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);
        
        // If the loan is not returned, remove the stock movement
        if ($loan->status !== 'dikembalikan') {
            \App\Models\StockMovement::where('reference_type', 'peminjaman')
                ->where('reference_id', $loan->id)
                ->delete();
        }
        
        $loan->delete();

        return response()->json(['message' => 'Loan deleted successfully']);
    }
}
