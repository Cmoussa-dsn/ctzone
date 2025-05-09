<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BuildController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SimpleAdminController;

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
    
    // Admin routes - AVOID USING MIDDLEWARE
    Route::prefix('admin')->name('admin.')->group(function () {
        // Make sure every route checks for admin role directly
        Route::get('/', function () {
            if (Auth::check() && Auth::user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            }
            return redirect('/')->with('error', 'Unauthorized.');
        })->name('index');
        
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Sales data API route
        Route::get('/sales-data', [AdminDashboardController::class, 'getSalesDataJson'])->name('sales-data');
        
        // Orders
        Route::get('/orders', function () {
            if (Auth::check() && Auth::user()->role_id == 1) {
                $orders = \App\Models\Order::with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                    
                return view('admin.orders.index', compact('orders'));
            }
            
            return redirect('/')->with('error', 'Unauthorized.');
        })->name('orders.index');
        
        // Update order status
        Route::patch('/orders/{order}', function (\Illuminate\Http\Request $request, $orderId) {
            if (Auth::check() && Auth::user()->role_id == 1) {
                $order = \App\Models\Order::findOrFail($orderId);
                $request->validate([
                    'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
                ]);
                
                $order->status = $request->status;
                $order->save();
                
                return redirect()->route('admin.orders.index')
                    ->with('success', 'Order status updated successfully');
            }
            
            return redirect('/')->with('error', 'Unauthorized.');
        })->name('orders.update');
        
        // Users
        Route::get('/users', function () {
            if (Auth::check() && Auth::user()->role_id == 1) {
                $users = \App\Models\User::where('role_id', 2)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                    
                return view('admin.users.index', compact('users'));
            }
            
            return redirect('/')->with('error', 'Unauthorized.');
        })->name('users.index');
    });
});

// Product routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Products
    Route::get('/products', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $products = \App\Models\Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('products.index');
    
    Route::get('/products/create', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('categories'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('products.create');

    Route::post('/products', function (Illuminate\Http\Request $request) {
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
    })->name('products.store');
    
    Route::get('/products/{product}/edit', function ($productId) {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $product = \App\Models\Product::findOrFail($productId);
            $categories = \App\Models\Category::all();
            return view('admin.products.edit', compact('product', 'categories'));
        }
        return redirect('/')->with('error', 'Unauthorized.');
    })->name('products.edit');
    
    Route::post('/products/{product}/edit', function (Illuminate\Http\Request $request, $productId) {
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
    })->name('products.update');
    
    Route::delete('/products/{product}', function ($productId) {
        if (Auth::check() && Auth::user()->role_id == 1) {
            $product = \App\Models\Product::findOrFail($productId);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        }
        return redirect('/')->with('error', 'Unauthorized.');
    })->name('products.destroy');
    
    // Categories routes
    Route::get('/categories', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $categories = \App\Models\Category::withCount('products')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('categories.index');

    Route::get('/categories/create', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        return view('admin.categories.create');
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('categories.create');

    Route::post('/categories', function (Illuminate\Http\Request $request) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('categories.store');

    Route::get('/categories/{category}/edit', function ($categoryId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $category = \App\Models\Category::findOrFail($categoryId);
        return view('admin.categories.edit', compact('category'));
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('categories.edit');

    Route::put('/categories/{category}', function (Illuminate\Http\Request $request, $categoryId) {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $category = \App\Models\Category::findOrFail($categoryId);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    return redirect('/')->with('error', 'Unauthorized.');
    })->name('categories.update');

    Route::delete('/categories/{category}', function ($categoryId) {
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
    })->name('categories.destroy');
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

// Temporary test route for admin dashboard
Route::get('/admin-test', function () {
    return 'Admin Test Route Works!';
});

// Very direct admin dashboard without any middleware complexity
Route::get('/admin/no-middleware', function () {
    // Manual auth check - no middleware at all
    if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role_id != 1) {
        return redirect('/')->with('error', 'Unauthorized access.');
    }
    
    $totalOrders = \App\Models\Order::count();
    $totalProducts = \App\Models\Product::count();
    $totalUsers = \App\Models\User::where('role_id', 2)->count();
    $recentOrders = \App\Models\Order::with('user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    // Get real sales data using the helper class
    $salesData = \App\Helpers\DashboardHelper::getSalesData();
    
    return view('admin.dashboard', compact(
        'totalOrders',
        'totalProducts',
        'totalUsers',
        'recentOrders',
        'salesData'
    ));
})->name('admin.no-middleware');

// SIMPLIFIED ADMIN ROUTES - NO MIDDLEWARE
// Direct admin dashboard route
Route::get('/admin/dashboard', function () {
    $totalOrders = \App\Models\Order::count();
    $totalProducts = \App\Models\Product::count();
    $totalUsers = \App\Models\User::where('role_id', 2)->count();
    $recentOrders = \App\Models\Order::with('user')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        
    // Get real sales data using the helper class
    $salesData = \App\Helpers\DashboardHelper::getSalesData();
    
    return view('admin.dashboard', compact(
        'totalOrders',
        'totalProducts',
        'totalUsers',
        'recentOrders',
        'salesData'
    ));
})->name('admin.dashboard');

// Main admin entry point - no middleware
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->name('admin.welcome');

// Other admin routes without middleware
Route::prefix('admin')->name('admin.')->group(function () {
    // Orders
    Route::get('/orders', function () {
        $orders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    })->name('orders.index');
    
    // Products
    Route::get('/products', function () {
        $products = \App\Models\Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    })->name('products.index');
});

// Direct admin test route
Route::get('/admin-check', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        return "Admin check passed! You are authenticated as an admin.";
    }
    return "Not an admin user. Your role_id is: " . (Auth::check() ? Auth::user()->role_id : 'Not logged in');
})->name('admin.check');

// Simple admin dashboard
Route::get('/admin/dashboard-simple', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = \App\Models\User::where('role_id', 2)->count();
        $recentOrders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get real sales data using the helper class
        $salesData = \App\Helpers\DashboardHelper::getSalesData();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'salesData'
        ));
    }
    
    return "You need to be an admin to access this page.";
})->middleware('auth')->name('admin.dashboard-simple');

// Direct admin dashboard route without middleware
Route::get('/admin/direct-dashboard', function () {
    if (Auth::check() && Auth::user()->role_id == 1) {
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = \App\Models\User::where('role_id', 2)->count();
        $recentOrders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get real sales data using the helper class
        $salesData = \App\Helpers\DashboardHelper::getSalesData();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'salesData'
        ));
    }
    
    return redirect('/')->with('error', 'You need admin privileges to access this page.');
})->middleware('auth')->name('admin.direct-dashboard');

// Fallback route for admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/{path?}', function ($path = null) {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return "Admin area: " . ($path ? $path : 'home') . " - This is a fallback route. The specific controller may not be available.";
        }
        return redirect('/')->with('error', 'Unauthorized.');
    })->where('path', '.*')->name('admin.fallback');
});

// Simple controller route for admin
Route::get('/admin/simple', [SimpleAdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.simple');

require __DIR__.'/auth.php';
