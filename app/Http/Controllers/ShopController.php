<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Display a listing of products for shopping.
     */
    public function index(): View
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('products.index', compact('products'));
    }

    /**
     * Display the product details.
     */
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }
} 