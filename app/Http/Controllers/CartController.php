<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\MiningProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    
    public function index(): View
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')
            ->get();
            
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart', compact('cartItems', 'total'));
    }
    
    
    public function addToCart(Request $request): JsonResponse
    {
        $productType = $request->input('product_type', 'regular');
        
        if ($productType === 'mining') {
            $request->validate([
                'product_id' => 'required|exists:mining_products,id',
            ]);
            
            // Get the mining product
            $miningProduct = MiningProduct::findOrFail($request->product_id);
            
            // First check if there's a corresponding regular product
            $product = Product::where('name', $miningProduct->name)->first();
            
            // If not, create a temporary one to add to cart
            if (!$product) {
                $product = Product::create([
                    'name' => $miningProduct->name,
                    'description' => $miningProduct->description,
                    'price' => $miningProduct->price,
                    'stock_quantity' => $miningProduct->stock_quantity,
                    'image' => $miningProduct->image,
                    'category_id' => 1, // Assuming 1 is the mining category
                    'is_mining_product' => true,
                    'mining_product_id' => $miningProduct->id
                ]);
            }
            
            $productId = $product->id;
        } else {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);
            
            $productId = $request->product_id;
        }
        
        $userId = Auth::id();
        $quantity = $request->input('quantity', 1);
        
        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
            
        if ($cartItem) {
            // If item exists, update quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Quantity updated'
            ]);
        } else {
            // Create new cart item
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart'
            ]);
        }
    }
    
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(Request $request): JsonResponse
    {
        $request->validate([
            'cart_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = CartItem::findOrFail($request->cart_id);
        
        
        if ($cartItem->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated'
        ]);
    }
    
    /**
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromCart($id): RedirectResponse
    {
        $cartItem = CartItem::findOrFail($id);
        
        
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')
                ->with('error', 'Unauthorized action');
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart');
    }
}
