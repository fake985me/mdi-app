<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\StockMovement;
use App\Models\SaleItem;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard data.
     */
    public function index()
    {
        $data = [
            'total_items' => Item::count(),
            'total_stock' => StockMovement::select(
                DB::raw('item_id, SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock')
            )
            ->groupBy('item_id')
            ->havingRaw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) > 0')
            ->sum('net_stock'),
            'total_sales' => Sale::sum('total'),
            'total_sales_count' => Sale::count(),
        ];
        
        return response()->json($data);
    }

    /**
     * Get chart data for dashboard.
     */
    public function getChartData()
    {
        // Candlestick chart data for stock
        $stockData = $this->getStockCandlestickData();
        
        // Pie chart data for top selling items
        $topSellingItems = $this->getTopSellingItems();
        
        // Line chart data for sales
        $salesTrend = $this->getSalesTrend();
        
        return response()->json([
            'stock_candlestick' => $stockData,
            'top_selling_items' => $topSellingItems,
            'sales_trend' => $salesTrend,
        ]);
    }
    
    /**
     * Get stock candlestick data.
     */
    private function getStockCandlestickData()
    {
        // Get stock movements grouped by item
        $stockMovements = StockMovement::with('item')
            ->select(
                'item_id',
                DB::raw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) as net_stock')
            )
            ->groupBy('item_id')
            ->havingRaw('SUM(CASE WHEN type = "masuk" THEN quantity ELSE -quantity END) > 0')
            ->limit(10) // Limit to 10 items for performance
            ->get();
        
        $data = [];
        foreach ($stockMovements as $movement) {
            $item = $movement->item;
            $currentStock = $movement->net_stock;
            
            // For candlestick, we need open, high, low, close values
            // We'll use: open = 0, high = current stock * 1.2, low = current stock * 0.8, close = current stock
            $data[] = [
                'item_name' => $item ? $item->name : 'Unknown',
                'open' => 0,
                'high' => $currentStock * 1.2,
                'low' => $currentStock * 0.8,
                'close' => $currentStock,
            ];
        }
        
        return $data;
    }
    
    /**
     * Get top selling items for pie chart.
     */
    private function getTopSellingItems()
    {
        $topItems = SaleItem::with('item')
            ->select('item_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($topItems as $item) {
            $labels[] = $item->item ? $item->item->name : 'Unknown';
            $data[] = $item->total_sold;
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
    
    /**
     * Get sales trend for line chart.
     */
    private function getSalesTrend()
    {
        // Get monthly sales data for the last 12 months
        $salesData = Sale::select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('date', '>=', Carbon::now()->subYear())
            ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('YEAR(date)'), 'asc')
            ->orderBy(DB::raw('MONTH(date)'), 'asc')
            ->get();
        
        $months = [];
        $data = [];
        
        // Generate 12 months of data
        $startDate = Carbon::now()->subYear()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i);
            $monthKey = $month->format('Y-m');
            $months[] = $month->format('M Y');
            
            $sale = $salesData->firstWhere(function ($item) use ($monthKey) {
                return ($item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT)) === $monthKey;
            });
            
            $data[] = $sale ? (float) $sale->total_sales : 0;
        }
        
        return [
            'labels' => $months,
            'data' => $data,
        ];
    }
}
