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
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\MiningController;
use App\Http\Controllers\AdminMiningProductController;
use App\Http\Controllers\ContactController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home-debug', function () {
    return view('home')->with('debug_links', [
        '/debug-contacts' => 'Debug Contacts Table',
        '/admin/contacts' => 'Admin Contacts Page'
    ]);
});
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

// Temporary route to check PC components
Route::get('/check-components/{type?}', function($type = null) {
    if ($type) {
        $components = \App\Models\Product::where('type', $type)->get();
        return response()->json([
            'count' => $components->count(),
            'components' => $components
        ]);
    }
    
    $types = ['processors', 'motherboards', 'graphics', 'memory', 'storage', 'power', 'cases', 'cooling'];
    $result = [];
    
    foreach ($types as $componentType) {
        $count = \App\Models\Product::where('type', $componentType)->count();
        $result[$componentType] = $count;
    }
    
    return response()->json($result);
});

// Add missing component categories route
Route::get('/setup-component-categories', function() {
    // Define all component categories needed for the PC builder
    $categories = [
        ['name' => 'Processors'],
        ['name' => 'Motherboards'],
        ['name' => 'Graphics Cards'],
        ['name' => 'Memory'],
        ['name' => 'Storage'],
        ['name' => 'Power Supplies'],
        ['name' => 'Cases'],
        ['name' => 'Cooling']
    ];
    
    $results = [];
    
    // Create categories only if they don't already exist
    foreach ($categories as $category) {
        $exists = \App\Models\Category::where('name', $category['name'])->exists();
        
        if (!$exists) {
            \App\Models\Category::create($category);
            $results[] = "Added category: " . $category['name'];
        } else {
            $results[] = "Category already exists: " . $category['name'];
        }
    }
    
    return response()->json([
        'message' => 'Component categories setup complete',
        'results' => $results
    ]);
});

// Set product types for existing products
Route::get('/setup-product-types', function() {
    $typeMap = [
        'processors' => ['processor', 'CPU', 'Core', 'Ryzen', 'Intel', 'AMD'],
        'motherboards' => ['motherboard', 'ROG', 'MSI', 'ASUS', 'B550', 'Z690'],
        'graphics' => ['graphic', 'GPU', 'RTX', 'Radeon', 'GeForce', 'RX'],
        'memory' => ['memory', 'RAM', 'DDR4', 'DDR5', 'Vengeance', 'Trident'],
        'storage' => ['storage', 'SSD', 'HDD', 'NVMe', 'Samsung', 'Seagate', 'Barracuda', 'EVO'],
        'power' => ['power', 'PSU', 'Supply', 'Watt', 'RM850', 'SuperNOVA'],
        'cases' => ['case', 'Tower', 'H510', '4000D'],
        'cooling' => ['cooling', 'Cooler', 'Liquid', 'Air', 'H100i', 'NH-D15', 'Noctua', 'Fan']
    ];
    
    $updated = [];
    $products = \App\Models\Product::whereNull('type')->get();
    
    foreach ($products as $product) {
        $foundType = null;
        
        // Check name against type keywords
        foreach ($typeMap as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($product->name, $keyword) !== false) {
                    $foundType = $type;
                    break 2;
                }
            }
        }
        
        if ($foundType) {
            $product->type = $foundType;
            $product->save();
            $updated[] = "Updated: " . $product->name . " → " . $foundType;
        }
    }
    
    return response()->json([
        'message' => 'Product types updated',
        'updated' => $updated,
        'count' => count($updated)
    ]);
});

// Assign correct categories to products based on their type
Route::get('/fix-product-categories', function() {
    // Type to category name mapping
    $categoryMap = [
        'processors' => 'Processors',
        'motherboards' => 'Motherboards',
        'graphics' => 'Graphics Cards',
        'memory' => 'Memory',
        'storage' => 'Storage',
        'power' => 'Power Supplies',
        'cases' => 'Cases',
        'cooling' => 'Cooling'
    ];
    
    // Make sure categories exist first
    foreach ($categoryMap as $categoryName) {
        \App\Models\Category::firstOrCreate(['name' => $categoryName]);
    }
    
    // Get category IDs
    $categories = [];
    foreach ($categoryMap as $type => $categoryName) {
        $category = \App\Models\Category::where('name', $categoryName)->first();
        if ($category) {
            $categories[$type] = $category->id;
        }
    }
    
    $updated = [];
    $products = \App\Models\Product::whereNotNull('type')->get();
    
    foreach ($products as $product) {
        $type = $product->type;
        
        if (isset($categories[$type])) {
            $oldCategoryId = $product->category_id;
            $product->category_id = $categories[$type];
            $product->save();
            
            $oldCategory = \App\Models\Category::find($oldCategoryId);
            $newCategory = \App\Models\Category::find($categories[$type]);
            
            $updated[] = "Updated: " . $product->name . " → Category: " . 
                ($oldCategory ? $oldCategory->name : 'Unknown') . " to " . 
                ($newCategory ? $newCategory->name : 'Unknown');
        }
    }
    
    return response()->json([
        'message' => 'Product categories updated',
        'updated' => $updated,
        'count' => count($updated)
    ]);
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
    
    // Custom PC Builds route
    Route::get('/profile/custom-builds', [ProfileController::class, 'customBuilds'])->name('profile.custom-builds');
    
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
            'type' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Log the type value
        \Illuminate\Support\Facades\Log::debug('Creating product with type: ' . ($request->type ?? 'null'));
        
        $product = \App\Models\Product::create($validated);
        
        // Log the created product
        \Illuminate\Support\Facades\Log::debug('Created product ID: ' . $product->id . ', Type: ' . ($product->type ?? 'null'));

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
                'type' => 'nullable|string',
            ]);
            
            // Log the type value before update
            \Illuminate\Support\Facades\Log::debug('Updating product ID: ' . $product->id);
            \Illuminate\Support\Facades\Log::debug('Current type: ' . ($product->type ?? 'null') . ', New type: ' . ($request->type ?? 'null'));
            
            $product->update($validated);
            
            // Log the type value after update
            \Illuminate\Support\Facades\Log::debug('Updated product type: ' . ($product->type ?? 'null'));
            
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
    
    // Mining Products
    Route::get('/mining', [AdminMiningProductController::class, 'index'])->name('mining.index');
    Route::get('/mining/create', [AdminMiningProductController::class, 'create'])->name('mining.create');
    Route::post('/mining', [AdminMiningProductController::class, 'store'])->name('mining.store');
    Route::get('/mining/{id}', [AdminMiningProductController::class, 'show'])->name('mining.show');
    Route::get('/mining/{id}/edit', [AdminMiningProductController::class, 'edit'])->name('mining.edit');
    Route::post('/mining/{id}/edit', [AdminMiningProductController::class, 'update'])->name('mining.update');
    Route::delete('/mining/{id}', [AdminMiningProductController::class, 'destroy'])->name('mining.destroy');
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

// Admin contact management routes
Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
Route::get('/admin/contacts/{contact}', [ContactController::class, 'adminShow'])->name('admin.contacts.show');
Route::post('/admin/contacts/{contact}/status', [ContactController::class, 'adminUpdateStatus'])->name('admin.contacts.update-status');

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

// Chatbot route
Route::post('/chatbot', [ChatbotController::class, 'processMessage'])->name('chatbot.process');
Route::post('/chatbot/clear', [ChatbotController::class, 'clearConversation'])->name('chatbot.clear');

// Mining routes
Route::prefix('mining')->name('mining.')->group(function () {
    Route::get('/', [MiningController::class, 'index'])->name('index');
    Route::get('/products', [MiningController::class, 'products'])->name('products');
    Route::get('/products/{id}', [MiningController::class, 'show'])->name('show');
    
    // Protected routes - require authentication
    Route::middleware('auth')->group(function () {
        Route::get('/calculator', [MiningController::class, 'calculator'])->name('calculator');
        Route::post('/calculate', [MiningController::class, 'calculateProfitability'])->name('calculate');
    });
});

// Debug route to check products
Route::get('/debug-products', function() {
    $products = \App\Models\Product::all();
    $byType = $products->groupBy('type');
    
    return response()->json([
        'total_products' => $products->count(),
        'products_by_type' => $byType->map(function($items, $type) {
            return [
                'type' => $type ?: '(empty)',
                'count' => $items->count(),
                'items' => $items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'type' => $item->type
                    ];
                })
            ];
        })
    ]);
});

// Debug route for specific product by ID
Route::get('/debug-product/{id}', function($id) {
    $product = \App\Models\Product::findOrFail($id);
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'type' => $product->type ?? '(null)',
        'raw_type_value' => var_export($product->type, true),
        'category_id' => $product->category_id,
        'category_name' => $product->category ? $product->category->name : null
    ]);
});

// One-time fix for product types in PC components
Route::get('/fix-component-types', function() {
    $productTypeMappings = [
        'processors' => ['processor', 'cpu', 'intel', 'amd', 'ryzen', 'core'],
        'motherboards' => ['motherboard', 'mainboard', 'asus', 'msi', 'gigabyte', 'asrock'],
        'graphics' => ['graphics', 'gpu', 'nvidia', 'geforce', 'rtx', 'radeon', 'amd'],
        'memory' => ['memory', 'ram', 'ddr4', 'ddr5', 'corsair', 'kingston', 'crucial'],
        'storage' => ['storage', 'ssd', 'hdd', 'nvme', 'samsung', 'western digital', 'seagate'],
        'power' => ['power', 'psu', 'supply', 'corsair', 'evga', 'seasonic'],
        'cases' => ['case', 'chassis', 'tower', 'nzxt', 'corsair', 'fractal'],
        'cooling' => ['cooling', 'cooler', 'fan', 'noctua', 'corsair', 'cooler master']
    ];

    $updated = [];
    $products = \App\Models\Product::all();
    
    foreach ($products as $product) {
        $name = strtolower($product->name);
        $matched = false;
        
        foreach ($productTypeMappings as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($name, $keyword) !== false) {
                    $product->type = $type;
                    $product->save();
                    $updated[] = "Updated {$product->id}: {$product->name} to type: {$type}";
                    $matched = true;
                    break 2;
                }
            }
        }
        
        if (!$matched && !empty($product->type)) {
            $updated[] = "Kept {$product->id}: {$product->name} with existing type: {$product->type}";
        }
    }
    
    return response()->json([
        'message' => 'Product types update complete',
        'updated' => $updated,
        'count' => count($updated)
    ]);
});

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/success', [ContactController::class, 'success'])->name('contact.success');

require __DIR__.'/auth.php';
