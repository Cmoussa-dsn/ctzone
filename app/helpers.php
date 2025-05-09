<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('getAdminDashboardData')) {
    /**
     * Get data for admin dashboard
     * 
     * @return array
     */
    function getAdminDashboardData() 
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role_id', 2)->count();
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get real sales data for the chart
        $salesData = getSalesDataForDashboard();
        
        return compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'salesData'
        );
    }
}

if (!function_exists('getSalesDataForDashboard')) {
    /**
     * Get sales data for the dashboard chart
     * 
     * @return array
     */
    function getSalesDataForDashboard()
    {
        // Get sales for the last 30 days
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(total_price) as total_sales')
        )
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', $endDate)
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Format the data for Chart.js
        $dates = [];
        $orderCounts = [];
        $salesTotals = [];
        
        // Initialize with zeros for all 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(29 - $i)->format('Y-m-d');
            $dates[] = Carbon::now()->subDays(29 - $i)->format('M d');
            $orderCounts[$date] = 0;
            $salesTotals[$date] = 0;
        }
        
        // Fill in actual data
        foreach ($dailySales as $sale) {
            $date = $sale->date;
            $orderCounts[$date] = $sale->order_count;
            $salesTotals[$date] = $sale->total_sales;
        }
        
        return [
            'labels' => $dates,
            'orderCounts' => array_values($orderCounts),
            'salesTotals' => array_values($salesTotals)
        ];
    }
} 