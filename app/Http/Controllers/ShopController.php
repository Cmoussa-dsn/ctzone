<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    
    public function index(): View
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('products.index', compact('products'));
    }

    
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }
} 