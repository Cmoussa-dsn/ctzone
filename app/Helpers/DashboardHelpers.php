<?php

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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