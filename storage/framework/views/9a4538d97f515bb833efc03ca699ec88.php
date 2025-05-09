

<?php $__env->startSection('title', 'All Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Orders</h1>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>

    <div class="glass p-6 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <?php if($orders->count() > 0): ?>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#<?php echo e($order->id); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($order->user->name); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$<?php echo e(number_format($order->total_price, 2)); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php if($order->status == 'delivered'): ?> bg-green-100 text-green-800 
                                        <?php elseif($order->status == 'processing'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($order->status == 'shipped'): ?> bg-indigo-100 text-indigo-800
                                        <?php elseif($order->status == 'cancelled'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form action="<?php echo e(route('admin.orders.update', $order->id)); ?>" method="POST" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <select name="status" class="text-sm rounded-lg border-gray-300 mr-2">
                                            <option value="pending" <?php if($order->status == 'pending'): ?> selected <?php endif; ?>>Pending</option>
                                            <option value="processing" <?php if($order->status == 'processing'): ?> selected <?php endif; ?>>Processing</option>
                                            <option value="shipped" <?php if($order->status == 'shipped'): ?> selected <?php endif; ?>>Shipped</option>
                                            <option value="delivered" <?php if($order->status == 'delivered'): ?> selected <?php endif; ?>>Delivered</option>
                                            <option value="cancelled" <?php if($order->status == 'cancelled'): ?> selected <?php endif; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-600 transition">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="mt-4">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Orders Yet</h3>
                    <p class="text-gray-500">There are no orders to display at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\charb\Downloads\modern_ct_zone (2)\modern_ct_zone\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>