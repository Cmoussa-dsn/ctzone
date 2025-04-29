<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display order history for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('orders.index', compact('orders'));
    }
    
    /**
     * Display a specific order with its items.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Check if the user owns this order
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return redirect()->route('orders.index')
                ->with('error', 'Unauthorized access');
        }
        
        $orderItems = $order->orderItems()->with('product')->get();
        
        return view('orders.show', compact('order', 'orderItems'));
    }
    
    /**
     * Process the checkout and create a new order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'fullName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);
        
        $userId = Auth::id();
        
        $cartItems = CartItem::where('user_id', $userId)
            ->with('product')
            ->get();
            
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        try {
            DB::beginTransaction();
            
            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);
            
            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }
            
            // Clear the cart
            CartItem::where('user_id', $userId)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your order: ' . $e->getMessage()
            ], 500);
        }
    }
}
