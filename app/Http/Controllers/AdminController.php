<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

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
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role_id', 2)->count();
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return View::make('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders'
        ));
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
}
