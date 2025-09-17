<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CsvService;
use Illuminate\Http\Request;

class ProductImportExportController extends Controller
{
    protected $csvService;
    
    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
    }
    
    /**
     * Show the import form
     */
    public function showImportForm()
    {
        return view('products.import');
    }
    
    /**
     * Import products from a CSV file
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
        
        $result = $this->csvService->importFromCsv($request->file('csv_file'), Product::class);
        
        return redirect()->back()->with('import_result', $result);
    }
    
    /**
     * Export products to a CSV file
     */
    public function export()
    {
        $columns = ['name', 'description', 'sku', 'price', 'stock_quantity', 'category_id', 'subcategory_id', 'brand_id'];
        $filename = $this->csvService->exportToCsv(Product::class, $columns);
        
        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend(true);
    }
}
