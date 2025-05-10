<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - CT ZONE</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 via-white to-indigo-100 min-h-screen">
    <!-- Top Bar -->
    <header class="glass sticky top-0 z-10 flex items-center justify-between px-8 py-4 shadow-md">
        <div class="flex items-center gap-3">
            <i class="fas fa-microchip text-2xl text-green-600"></i>
            <span class="text-2xl font-bold text-gray-800 tracking-tight">CT ZONE Admin</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="hidden md:inline text-gray-700 font-medium"><?php echo e(Auth::user()->name ?? 'Admin'); ?></span>
            <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold text-lg">
                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?>

            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="ml-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Logout</button>
            </form>
        </div>
    </header>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-20 md:w-64 bg-white/80 glass shadow-lg flex flex-col py-8 px-2 md:px-4">
            <nav class="flex flex-col gap-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg transition <?php echo e(request()->routeIs('admin.dashboard') || request()->routeIs('admin.index') ? 'bg-green-500 text-white shadow' : 'text-gray-700 hover:bg-green-100'); ?>">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg transition <?php echo e(request()->routeIs('admin.products.*') ? 'bg-green-500 text-white shadow' : 'text-gray-700 hover:bg-green-100'); ?>">
                    <i class="fas fa-box"></i>
                    <span class="hidden md:inline">Products</span>
                </a>
                <a href="<?php echo e(route('admin.mining.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg transition <?php echo e(request()->routeIs('admin.mining.*') ? 'bg-green-500 text-white shadow' : 'text-gray-700 hover:bg-green-100'); ?>">
                    <i class="fas fa-microchip"></i>
                    <span class="hidden md:inline">Mining Products</span>
                </a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-lg transition <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-green-500 text-white shadow' : 'text-gray-700 hover:bg-green-100'); ?>">
                    <i class="fas fa-tags"></i>
                    <span class="hidden md:inline">Categories</span>
                </a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-12">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    
    <!-- Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html> <?php /**PATH C:\Users\charb\Downloads\modern_ct_zone (2)\modern_ct_zone\resources\views/admin/layout.blade.php ENDPATH**/ ?>