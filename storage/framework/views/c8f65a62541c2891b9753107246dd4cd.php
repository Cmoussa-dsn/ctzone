<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container">
        <div class="order-header">
            <a href="<?php echo e(route('orders.index')); ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h1 class="page-title">Order Details</h1>
        </div>
        
        <div class="order-info-card">
            <div class="order-meta">
                <div class="order-number">
                    <h2>Order #<?php echo e($order->id); ?></h2>
                    <span class="order-date">Placed on <?php echo e($order->created_at->format('F d, Y')); ?></span>
                </div>
                <div class="order-status">
                    <span class="status-badge status-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span>
                </div>
            </div>
        </div>
        
        <div class="order-content">
            <div class="order-items">
                <h3>Order Items</h3>
                <div class="items-list">
                    <?php $__currentLoopData = $orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item-card">
                            <div class="item-image">
                                <img src="<?php echo e($item->product->image ? asset('storage/' . $item->product->image) : asset('images/default-pc.jpg')); ?>" alt="<?php echo e($item->product->name); ?>">
                            </div>
                            <div class="item-details">
                                <h4 class="item-name"><?php echo e($item->product->name); ?></h4>
                                <p class="item-price">$<?php echo e(number_format($item->price, 2)); ?> × <?php echo e($item->quantity); ?></p>
                                <p class="item-total"><?php echo e(number_format($item->price * $item->quantity, 2)); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>$<?php echo e(number_format($order->total_price, 2)); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$<?php echo e(number_format($order->total_price, 2)); ?></span>
                    </div>
                </div>
                
                <div class="order-actions">
                    <a href="<?php echo e(route('buy')); ?>" class="btn">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .order-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .back-link {
            display: flex;
            align-items: center;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            margin-right: 20px;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        .page-title {
            font-size: 1.8rem;
            color: #333;
            font-weight: 600;
            margin: 0;
        }
        
        .order-info-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .order-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-number h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .order-date {
            color: #666;
            font-size: 0.9rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }
        
        .status-pending {
            background-color: #f39c12;
        }
        
        .status-processing {
            background-color: #3498db;
        }
        
        .status-shipped {
            background-color: #2ecc71;
        }
        
        .status-delivered {
            background-color: #27ae60;
        }
        
        .status-cancelled {
            background-color: #e74c3c;
        }
        
        .order-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .order-items, .order-summary {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .order-items h3, .order-summary h3 {
            font-size: 1.3rem;
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .items-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .item-card {
            display: flex;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .item-image {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .item-name {
            font-size: 1.1rem;
            font-weight: 500;
            margin: 0 0 5px 0;
        }
        
        .item-price {
            color: #666;
            font-size: 0.9rem;
            margin: 0 0 5px 0;
        }
        
        .item-total {
            font-weight: 600;
            margin: 0;
        }
        
        .summary-card {
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row.total {
            font-weight: 600;
            font-size: 1.2rem;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            border-bottom: none;
        }
        
        .order-actions {
            margin-top: 30px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        @media (max-width: 768px) {
            .order-content {
                grid-template-columns: 1fr;
            }
            
            .order-meta {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .order-status {
                margin-top: 15px;
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/orders/show.blade.php ENDPATH**/ ?>