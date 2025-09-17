<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    /**
     * Get dashboard statistics
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            return $this->error('Unauthorized', 401);
        }

        try {
            // Get statistics
            $stats = [
                'totalProducts' => Product::count(),
                'lowStockItems' => Product::where('stock_quantity', '<=', 10)->count(),
                'outOfStockItems' => Product::where('stock_quantity', 0)->count(),
                'totalCategories' => Category::count(),
                'totalBrands' => Brand::count(),
            ];

            // Get recent products
            $recentProducts = Product::with(['category', 'brand'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Prepare dashboard data
            $dashboardData = [
                'stats' => $stats,
                'recentProducts' => $recentProducts,
            ];

            return $this->success(
                $dashboardData,
                'Dashboard data retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve dashboard data: ' . $e->getMessage());
        }
    }
}