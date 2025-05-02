<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuildController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/buy', [HomeController::class, 'buy'])->name('buy');
Route::get('/pc-builder', [BuildController::class, 'pcBuilder'])->name('pc-builder');
Route::post('/pc-builder/store', [BuildController::class, 'store'])->name('pc-builder.store');

// Simple test route
Route::get('/test-build', function() {
    return "Test build route working!";
});

// Test route for component testing
Route::get('/test-component', function() {
    return view('test-component');
});

// Dashboard (default Laravel)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile routes (default Laravel)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
        Route::patch('/orders/{order}', [AdminController::class, 'updateOrderStatus'])->name('orders.update');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        
        // Product management
        Route::resource('products', ProductController::class);
    });
});

// Password Reset Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Add a simple /admin route
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        return view('admin.welcome');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.welcome');

Route::get('/admin/products', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $products = \App\Models\Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.index');

// Edit product form
Route::get('/admin/products/{product}/edit', function ($productId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $product = \App\Models\Product::findOrFail($productId);
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.edit');

// Update product
Route::post('/admin/products/{product}/edit', function (Illuminate\Http\Request $request, $productId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $product = \App\Models\Product::findOrFail($productId);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.update');

// Delete product
Route::delete('/admin/products/{product}', function ($productId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $product = \App\Models\Product::findOrFail($productId);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.destroy');

// Add product form
Route::get('/admin/products/create', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.create');

// Store new product
Route::post('/admin/products', function (Illuminate\Http\Request $request) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        \App\Models\Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.products.store');

// Category management routes
Route::get('/admin/categories', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $categories = \App\Models\Category::withCount('products')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.index');

Route::get('/admin/categories/create', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        return view('admin.categories.create');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.create');

Route::post('/admin/categories', function (Illuminate\Http\Request $request) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.store');

Route::get('/admin/categories/{category}/edit', function ($categoryId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $category = \App\Models\Category::findOrFail($categoryId);
        return view('admin.categories.edit', compact('category'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.edit');

Route::put('/admin/categories/{category}', function (Illuminate\Http\Request $request, $categoryId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $category = \App\Models\Category::findOrFail($categoryId);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.update');

Route::delete('/admin/categories/{category}', function ($categoryId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $category = \App\Models\Category::findOrFail($categoryId);
        
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated products');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
})->middleware('auth')->name('admin.categories.destroy');

require __DIR__.'/auth.php';
