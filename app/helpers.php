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
        
        // Static data for sales chart
        $salesData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'orderCounts' => [10, 15, 8, 25, 12, 20, 18],
            'salesTotals' => [1200, 1800, 950, 2500, 1400, 2200, 1900]
        ];
        
        return compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'salesData'
        );
    }
} 