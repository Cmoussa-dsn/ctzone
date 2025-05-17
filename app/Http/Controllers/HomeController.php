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
    public function buy(Request $request)
    {
        // Get filter parameters
        $priceRange = $request->input('price_range');
        $sortBy = $request->input('sort_by', 'featured');
        $category = $request->input('category', 'all');
        
        // Get all categories
        $categories = Category::all();
        
        // Find category IDs for PC categories (Gaming PCs and Office PCs)
        $pcCategoryIds = $categories->whereIn('name', ['Gaming PCs', 'Office PCs'])->pluck('id')->toArray();
        
        // Initialize queries for pre-built PCs and components
        $preBuiltQuery = Product::with('category')
            ->whereIn('category_id', $pcCategoryIds)
            ->where(function($query) {
                $query->whereNull('type')
                      ->orWhere('type', '!=', 'custom_pc');
            });
            
        $componentsQuery = Product::with('category')
            ->whereNotIn('category_id', $pcCategoryIds)
            ->where(function($query) {
                $query->whereNull('type')
                      ->orWhere('type', '!=', 'custom_pc');
            });
        
        // Apply price range filter
        if ($priceRange) {
            $prices = explode('-', $priceRange);
            if (count($prices) == 2) {
                $minPrice = (float) $prices[0];
                $maxPrice = (float) $prices[1];
                
                // If maxPrice is 0, it means no upper limit (e.g., "2000+")
                if ($maxPrice > 0) {
                    $preBuiltQuery->whereBetween('price', [$minPrice, $maxPrice]);
                    $componentsQuery->whereBetween('price', [$minPrice, $maxPrice]);
                } else {
                    $preBuiltQuery->where('price', '>=', $minPrice);
                    $componentsQuery->where('price', '>=', $minPrice);
                }
            }
        }
        
        // Apply sorting
        switch ($sortBy) {
            case 'price-low':
                $preBuiltQuery->orderBy('price', 'asc');
                $componentsQuery->orderBy('price', 'asc');
                break;
            case 'price-high':
                $preBuiltQuery->orderBy('price', 'desc');
                $componentsQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $preBuiltQuery->orderBy('created_at', 'desc');
                $componentsQuery->orderBy('created_at', 'desc');
                break;
            case 'featured':
            default:
                // For featured, we can use a combination of factors or just default sorting
                $preBuiltQuery->orderBy('price', 'desc'); // As a simple implementation
                $componentsQuery->orderBy('price', 'desc');
                break;
        }
        
        // Execute queries
        $preBuiltPCs = $preBuiltQuery->get();
        $components = $componentsQuery->get();
        
        // Get all filtered products for compatibility with existing code if needed
        $allProducts = $preBuiltPCs->concat($components);
        
        return view('buy', compact('preBuiltPCs', 'components', 'allProducts', 'priceRange', 'sortBy', 'category'));
    }

    // Build-related methods removed
}
