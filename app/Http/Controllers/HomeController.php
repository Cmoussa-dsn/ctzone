<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Display the buy page with all PC products.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function buy()
    {
        $products = Product::with('category')->get();
        
        return view('buy', compact('products'));
    }

    // Build-related methods removed
}
