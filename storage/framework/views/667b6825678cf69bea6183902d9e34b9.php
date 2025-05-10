
<?php $__env->startSection('title', 'Mining Products'); ?>
<?php $__env->startSection('content'); ?>
    <div class="relative max-w-6xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-700">Mining Products</h1>
                <a href="<?php echo e(route('admin.mining.create')); ?>" class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition font-semibold text-lg">
                    <i class="fas fa-plus"></i> Add Mining Product
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Algorithm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hashrate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power (W)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $miningProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800"><?php echo e($product->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo e($product->algorithm); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo e($product->hashrate); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo e($product->power_consumption); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-blue-700 font-bold">$<?php echo e(number_format($product->price, 2)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($product->stock_quantity); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?php echo e(route('admin.mining.edit', $product->id)); ?>" class="inline-block text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</a>
                                    <form action="<?php echo e(route('admin.mining.destroy', $product->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this mining product?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-900 font-semibold bg-transparent border-none cursor-pointer">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No mining products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <?php echo e($miningProducts->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\charb\Downloads\modern_ct_zone (2)\modern_ct_zone\resources\views/admin/mining/index.blade.php ENDPATH**/ ?>