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
        
        Route::get('/dashboard', function () {
            if (Auth::check() && Auth::user()->role_id == 1) {
                try {
                    $totalOrders = \App\Models\Order::count();
                    $totalProducts = \App\Models\Product::count();
                    $totalUsers = \App\Models\User::where('role_id', 2)->count();
                    $recentOrders = \App\Models\Order::with('user')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                    
                    // Get sales data for the chart
                    $salesData = [
                        'labels' => [],
                        'orderCounts' => [],
                        'salesTotals' => []
                    ];
                    
                    // Calculate last 30 days of data
                    $startDate = \Carbon\Carbon::now()->subDays(29)->startOfDay();
                    $endDate = \Carbon\Carbon::now()->endOfDay();
                    
                    $dailySales = \App\Models\Order::select(
                        \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
                        \Illuminate\Support\Facades\DB::raw('COUNT(*) as order_count'),
                        \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total_sales')
                    )
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
                    
                    // Initialize with zeros for all 30 days
                    for ($i = 0; $i < 30; $i++) {
                        $date = \Carbon\Carbon::now()->subDays(29 - $i)->format('Y-m-d');
                        $salesData['labels'][] = \Carbon\Carbon::now()->subDays(29 - $i)->format('M d');
                        $salesData['orderCounts'][$date] = 0;
                        $salesData['salesTotals'][$date] = 0;
                    }
                    
                    // Fill in actual data
                    foreach ($dailySales as $sale) {
                        $date = $sale->date;
                        $salesData['orderCounts'][$date] = $sale->order_count;
                        $salesData['salesTotals'][$date] = $sale->total_sales;
                    }
                    
                    $salesData['orderCounts'] = array_values($salesData['orderCounts']);
                    $salesData['salesTotals'] = array_values($salesData['salesTotals']);
                    
                    return view('admin.dashboard', compact(
                        'totalOrders',
                        'totalProducts',
                        'totalUsers',
                        'recentOrders',
                        'salesData'
                    ));
                } catch (\Exception $e) {
                    // Log the exception message
                    \Illuminate\Support\Facades\Log::error('Admin dashboard error: ' . $e->getMessage());
                    
                    // For debugging, return a simple view with the error message
                    return view('admin.error', ['message' => $e->getMessage()]);
                }
            }
            
            return redirect('/')->with('error', 'Unauthorized.');
        })->name('dashboard');
        
        // Sales data API route with closure
        Route::get('/sales-data', function(\Illuminate\Http\Request $request) {
            if (Auth::check() && Auth::user()->role_id == 1) {
                try {
                    $period = $request->input('period', '30days');
                    
                    switch ($period) {
                        case '7days':
                            $startDate = \Carbon\Carbon::now()->subDays(6)->startOfDay();
                            break;
                        case '30days':
                            $startDate = \Carbon\Carbon::now()->subDays(29)->startOfDay();
                            break;
                        case '90days':
                            $startDate = \Carbon\Carbon::now()->subDays(89)->startOfDay();
                            break;
                        case 'year':
                            $startDate = \Carbon\Carbon::now()->subYear()->startOfDay();
                            break;
                        default:
                            $startDate = \Carbon\Carbon::now()->subDays(29)->startOfDay();
                    }
                    
                    $endDate = \Carbon\Carbon::now()->endOfDay();
                    
                    if ($period === 'year') {
                        // Monthly aggregation for year view
                        $sales = \App\Models\Order::select(
                            \Illuminate\Support\Facades\DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
                            \Illuminate\Support\Facades\DB::raw('COUNT(*) as order_count'),
                            \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total_sales')
                        )
                        ->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                        
                        $formattedSales = [];
                        foreach ($sales as $sale) {
                            $date = \Carbon\Carbon::createFromFormat('Y-m', $sale->date);
                            $formattedSales[] = [
                                'date' => $date->format('M Y'),
                                'order_count' => $sale->order_count,
                                'total_sales' => $sale->total_sales
                            ];
                        }
                    } else {
                        // Daily aggregation for other views
                        $sales = \App\Models\Order::select(
                            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
                            \Illuminate\Support\Facades\DB::raw('COUNT(*) as order_count'),
                            \Illuminate\Support\Facades\DB::raw('SUM(total_price) as total_sales')
                        )
                        ->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate)
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                        
                        $formattedSales = [];
                        foreach ($sales as $sale) {
                            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $sale->date);
                            $formattedSales[] = [
                                'date' => $date->format('M d'),
                                'order_count' => $sale->order_count,
                                'total_sales' => $sale->total_sales
                            ];
                        }
                    }
                    
                    return response()->json($formattedSales);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Admin getSalesDataJson error: ' . $e->getMessage());
                    return response()->json(['error' => 'An error occurred while fetching sales data.'], 500);
                }
            }
            
            return response()->json(['error' => 'Unauthorized'], 403);
        })->name('sales-data');
        
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
    
    // Use the global helper function
    extract(getAdminDashboardData());
    
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
        
    // Static sales data
    $salesData = [
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        'orderCounts' => [10, 15, 8, 25, 12, 20, 18],
        'salesTotals' => [1200, 1800, 950, 2500, 1400, 2200, 1900]
    ];
    
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
            
        // Simple sales data
        $salesData = [
            'labels' => ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
            'orderCounts' => [5, 10, 8, 12, 15],
            'salesTotals' => [500, 1000, 800, 1200, 1500]
        ];
        
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
            
        // Simple sales data
        $salesData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'orderCounts' => [5, 10, 15, 20, 25],
            'salesTotals' => [500, 1000, 1500, 2000, 2500]
        ];
        
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
