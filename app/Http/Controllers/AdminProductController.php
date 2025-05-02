<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function show(Product $product)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        return view('admin.products.show', compact('product'));
    }
} 