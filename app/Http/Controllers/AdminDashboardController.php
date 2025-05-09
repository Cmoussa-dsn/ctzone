<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Helpers\DashboardHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Check if user is admin
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role_id != 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        
        try {
            $totalOrders = Order::count();
            $totalProducts = Product::count();
            $totalUsers = User::where('role_id', 2)->count();
            $recentOrders = Order::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
                
            // Get sales data for the chart using the helper
            $salesData = DashboardHelper::getSalesData();
            
            return view('admin.dashboard', compact(
                'totalOrders',
                'totalProducts',
                'totalUsers',
                'recentOrders',
                'salesData'
            ));
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('AdminDashboardController error: ' . $e->getMessage());
            
            // For debugging, return a simple view with the error message
            return view('admin.error', ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Get sales data as JSON for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesDataJson(Request $request)
    {
        // Check if user is admin
        if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role_id != 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        try {
            $period = $request->input('period', '30days');
            
            // Use the helper class to get formatted sales data
            $salesData = DashboardHelper::getSalesData($period);
            
            // Format data for JSON response
            $formattedSales = [];
            $labels = $salesData['labels'];
            $orderCounts = $salesData['orderCounts'];
            $salesTotals = $salesData['salesTotals'];
            
            for ($i = 0; $i < count($labels); $i++) {
                $formattedSales[] = [
                    'date' => $labels[$i],
                    'order_count' => $orderCounts[$i],
                    'total_sales' => $salesTotals[$i]
                ];
            }
            
            return response()->json($formattedSales);
        } catch (\Exception $e) {
            Log::error('AdminDashboardController getSalesDataJson error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching sales data.'], 500);
        }
    }
} 