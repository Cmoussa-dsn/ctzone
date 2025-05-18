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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function buy(Request $request)
    {
        
        $priceRange = $request->input('price_range');
        $sortBy = $request->input('sort_by', 'featured');
        $category = $request->input('category', 'all');
        $search = $request->input('search');
        
        
        $categories = Category::all();
        
        
        $pcCategoryIds = $categories->whereIn('name', ['Gaming PCs', 'Office PCs'])->pluck('id')->toArray();
        
       
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
        
        // Apply search filter if provided
        if ($search) {
            $searchTerm = '%' . $search . '%';
            $preBuiltQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
            });
            
            $componentsQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                      ->orWhere('description', 'like', $searchTerm);
            });
        }
        
        if ($priceRange) {
            $prices = explode('-', $priceRange);
            if (count($prices) == 2) {
                $minPrice = (float) $prices[0];
                $maxPrice = (float) $prices[1];
                
                //eza max price 0 no limit yeene
                if ($maxPrice > 0) {
                    $preBuiltQuery->whereBetween('price', [$minPrice, $maxPrice]);
                    $componentsQuery->whereBetween('price', [$minPrice, $maxPrice]);
                } else {
                    $preBuiltQuery->where('price', '>=', $minPrice);
                    $componentsQuery->where('price', '>=', $minPrice);
                }
            }
        }
        
        
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
        
        
        $preBuiltPCs = $preBuiltQuery->get();
        $components = $componentsQuery->get();
        
        
        $allProducts = $preBuiltPCs->concat($components);
        
        return view('buy', compact('preBuiltPCs', 'components', 'allProducts', 'priceRange', 'sortBy', 'category'));
    }

    
}
