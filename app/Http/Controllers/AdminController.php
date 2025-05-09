<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Apply middleware through the route instead
    }
    
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role_id', 2)->count();
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
            // Get sales data for the chart
            $salesData = $this->getSalesData();
            
            return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
                'recentOrders',
                'salesData'
        ));
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('AdminController error: ' . $e->getMessage());
            
            // For debugging, return a simple view with the error message
            return view('admin.error', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of all orders.
     *
     * @return \Illuminate\View\View
     */
    public function orders()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return View::make('admin.orders.index', compact('orders'));
    }
    
    /**
     * Update the status of an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        
        $order->status = $request->status;
        $order->save();
        
        return Redirect::route('admin.orders.index')
            ->with('success', 'Order status updated successfully');
    }
    
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::where('role_id', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return View::make('admin.users.index', compact('users'));
    }
    
    /**
     * Get sales data for the chart.
     *
     * @return array
     */
    private function getSalesData()
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
    
    /**
     * Get sales data as JSON for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesDataJson(Request $request)
    {
        try {
            $period = $request->input('period', '30days');
            
            switch ($period) {
                case '7days':
                    $startDate = Carbon::now()->subDays(6)->startOfDay();
                    break;
                case '30days':
                    $startDate = Carbon::now()->subDays(29)->startOfDay();
                    break;
                case '90days':
                    $startDate = Carbon::now()->subDays(89)->startOfDay();
                    break;
                case 'year':
                    $startDate = Carbon::now()->subYear()->startOfDay();
                    break;
                default:
                    $startDate = Carbon::now()->subDays(29)->startOfDay();
            }
            
            $endDate = Carbon::now()->endOfDay();
            
            if ($period === 'year') {
                // Monthly aggregation for year view
                $sales = Order::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total_price) as total_sales')
                )
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();
                
                $formattedSales = [];
                foreach ($sales as $sale) {
                    $date = Carbon::createFromFormat('Y-m', $sale->date);
                    $formattedSales[] = [
                        'date' => $date->format('M Y'),
                        'order_count' => $sale->order_count,
                        'total_sales' => $sale->total_sales
                    ];
                }
            } else {
                // Daily aggregation for other views
                $sales = Order::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total_price) as total_sales')
                )
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();
                
                $formattedSales = [];
                foreach ($sales as $sale) {
                    $date = Carbon::createFromFormat('Y-m-d', $sale->date);
                    $formattedSales[] = [
                        'date' => $date->format('M d'),
                        'order_count' => $sale->order_count,
                        'total_sales' => $sale->total_sales
                    ];
                }
            }
            
            return response()->json($formattedSales);
        } catch (\Exception $e) {
            Log::error('AdminController getSalesDataJson error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching sales data.'], 500);
        }
    }
}
