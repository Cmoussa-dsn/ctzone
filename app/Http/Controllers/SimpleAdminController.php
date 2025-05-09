<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SimpleAdminController extends Controller
{
    public function __construct()
    {
        // No constructor logic to avoid dependency injection issues
    }
    
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        
        return redirect()->route('admin.direct-dashboard');
    }
    
    public function dashboard()
    {
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role_id', 2)->count();
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Simple sales data
        $salesData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'orderCounts' => [5, 10, 15, 20, 25],
            'salesTotals' => [500, 1000, 1500, 2000, 2500]
        ];
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'salesData'
        ));
    }
} 