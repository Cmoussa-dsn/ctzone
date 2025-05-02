<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $categories = Category::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function show(Category $category)
    {
        if (auth()->user()->role_id !== 1) {
            return redirect('/')->with('error', 'Unauthorized.');
        }
        return view('admin.categories.show', compact('category'));
    }
} 