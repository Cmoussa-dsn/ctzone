<?php

namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardHelper
{
    /**
     * Get sales data for the dashboard chart
     * 
     * @param string $period Period to get data for (7days, 30days, 90days, year)
     * @return array
     */
    public static function getSalesData($period = '30days')
    {
        try {
            switch ($period) {
                case '7days':
                    $startDate = Carbon::now()->subDays(6)->startOfDay();
                    break;
                case '90days':
                    $startDate = Carbon::now()->subDays(89)->startOfDay();
                    break;
                case 'year':
                    $startDate = Carbon::now()->subYear()->startOfDay();
                    break;
                case '30days':
                default:
                    $startDate = Carbon::now()->subDays(29)->startOfDay();
            }
            
            $endDate = Carbon::now()->endOfDay();
            
            if ($period === 'year') {
                // Monthly aggregation for year view
                $dailySales = Order::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
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
                
                // Generate array of month-years
                $current = Carbon::now()->startOfMonth();
                $months = [];
                for ($i = 0; $i < 12; $i++) {
                    $month = Carbon::now()->subMonths($i)->format('Y-m');
                    $months[$month] = Carbon::now()->subMonths($i)->format('M Y');
                    $orderCounts[$month] = 0;
                    $salesTotals[$month] = 0;
                }
                
                // Fill in actual data
                foreach ($dailySales as $sale) {
                    $orderCounts[$sale->date] = $sale->order_count;
                    $salesTotals[$sale->date] = $sale->total_sales;
                }
                
                return [
                    'labels' => array_values($months),
                    'orderCounts' => array_values($orderCounts),
                    'salesTotals' => array_values($salesTotals)
                ];
            } else {
                // Daily aggregation for other views
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
                
                // Initialize with zeros for all days in the period
                $daysCount = $period === '7days' ? 7 : ($period === '30days' ? 30 : 90);
                for ($i = 0; $i < $daysCount; $i++) {
                    $date = Carbon::now()->subDays($daysCount - 1 - $i)->format('Y-m-d');
                    $dates[] = Carbon::now()->subDays($daysCount - 1 - $i)->format('M d');
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
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error generating sales data: ' . $e->getMessage());
            
            // Return empty data in case of error
            return [
                'labels' => [],
                'orderCounts' => [],
                'salesTotals' => []
            ];
        }
    }
} 