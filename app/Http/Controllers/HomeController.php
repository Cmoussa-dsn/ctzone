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
     * Display the buy page with products separated into PCs and components.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function buy()
    {
        // Get all categories
        $categories = Category::all();
        
        // Find category IDs for PC categories (Gaming PCs and Office PCs)
        $pcCategoryIds = $categories->whereIn('name', ['Gaming PCs', 'Office PCs'])->pluck('id')->toArray();
        
        // Separate products into PCs and components
        $preBuiltPCs = Product::with('category')
            ->whereIn('category_id', $pcCategoryIds)
            ->get();
            
        $components = Product::with('category')
            ->whereNotIn('category_id', $pcCategoryIds)
            ->get();
        
        // Get all products for compatibility with existing code if needed
        $allProducts = Product::with('category')->get();
        
        return view('buy', compact('preBuiltPCs', 'components', 'allProducts'));
    }

    // Build-related methods removed
}
