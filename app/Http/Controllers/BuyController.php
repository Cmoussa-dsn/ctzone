<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BuyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display the buy page with products and categories
     */
    public function index()
    {
        try {
            $query = Product::query();
            
            // Filter by category if selected
            if (request()->has('category')) {
                $query->where('category_id', request('category'));
            }
            
            // Search by name if provided
            if (request()->has('search')) {
                $query->where('name', 'like', '%' . request('search') . '%');
            }
            
            $products = $query->with('category')->latest()->paginate(12);
            $categories = Category::all();
            
            return view('buy.index', compact('products', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in BuyController@index: ' . $e->getMessage());
            return back()->with('error', 'Unable to load products. Please try again.');
        }
    }

    /**
     * Show form to add a new product (admin only)
     */
    public function create()
    {
        try {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }
            
            $categories = Category::all();
            return view('buy.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in BuyController@create: ' . $e->getMessage());
            return back()->with('error', 'Unable to access create product page.');
        }
    }

    /**
     * Store a new product (admin only)
     */
    public function store(Request $request)
    {
        try {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            Product::create($validated);

            return redirect()->route('buy.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in BuyController@store: ' . $e->getMessage());
            return back()->with('error', 'Unable to create product.')->withInput();
        }
    }

    /**
     * Show form to edit a product (admin only)
     */
    public function edit(Product $product)
    {
        try {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }
            
            $categories = Category::all();
            return view('buy.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in BuyController@edit: ' . $e->getMessage());
            return back()->with('error', 'Unable to access edit product page.');
        }
    }

    /**
     * Update a product (admin only)
     */
    public function update(Request $request, Product $product)
    {
        try {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $path = $request->file('image')->store('products', 'public');
                $validated['image'] = $path;
            }

            $product->update($validated);

            return redirect()->route('buy.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error in BuyController@update: ' . $e->getMessage());
            return back()->with('error', 'Unable to update product.')->withInput();
        }
    }

    /**
     * Delete a product (admin only)
     */
    public function destroy(Product $product)
    {
        try {
            if (!Gate::allows('admin')) {
                abort(403, 'Unauthorized action.');
            }

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('buy.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in BuyController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete product.');
        }
    }
} 