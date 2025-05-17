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
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center text-gray-600">
                <a href="<?php echo e(route('home')); ?>" class="hover:text-indigo-600">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="<?php echo e(route('mining.index')); ?>" class="hover:text-indigo-600">Mining</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span><?php echo e($product->name); ?></span>
            </div>
        </div>
    </div>

    <!-- Product Detail Section -->
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row">
            <!-- Product Image -->
            <div class="lg:w-1/2 mb-8 lg:mb-0 lg:pr-8">
                <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                    <?php if($product->image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-96 object-contain p-8">
                    <?php else: ?>
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold mb-4"><?php echo e($product->name); ?></h1>
               

                <div class="text-3xl font-bold text-indigo-600 mb-6">$<?php echo e(number_format($product->price, 2)); ?></div>

                <div class="mb-8">
                    <p class="text-gray-700 mb-6"><?php echo e($product->description); ?></p>

                    <!-- Product Specs -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Specifications</h2>
                        
                        <?php if($product->hashrate != 'N/A'): ?>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-gray-500 text-sm">Hashrate</h3>
                                <p class="font-medium"><?php echo e($product->hashrate); ?></p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Algorithm</h3>
                                <p class="font-medium"><?php echo e($product->algorithm); ?></p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Power Consumption</h3>
                                <p class="font-medium"><?php echo e($product->power_consumption); ?>W</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Efficiency</h3>
                                <p class="font-medium">
                                    <?php if(is_numeric(str_replace(['TH/s', 'MH/s', 'GH/s'], '', $product->hashrate)) && floatval(str_replace(['TH/s', 'MH/s', 'GH/s'], '', $product->hashrate)) > 0): ?>
                                        <?php echo e(number_format($product->power_consumption / (float)str_replace(['TH/s', 'MH/s', 'GH/s'], '', $product->hashrate), 2)); ?> W/TH
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Daily Profit Estimate</h3>
                                <p class="font-medium">$<?php echo e(number_format($product->daily_profit_estimate, 2)); ?></p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Stock</h3>
                                <p class="font-medium"><?php echo e($product->stock_quantity); ?> units</p>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-gray-500 text-sm">Power Consumption</h3>
                                <p class="font-medium"><?php echo e($product->power_consumption); ?>W</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Stock</h3>
                                <p class="font-medium"><?php echo e($product->stock_quantity); ?> units</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="flex items-center mb-8">
                    <div class="mr-4">
                        <label for="quantity" class="sr-only">Quantity</label>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" onclick="decrementQuantity()" class="px-3 py-2 text-gray-500 hover:text-gray-700 focus:outline-none">-</button>
                            <input type="number" id="quantity" class="w-12 text-center border-none focus:ring-0" value="1" min="1" max="<?php echo e($product->stock_quantity); ?>">
                            <button type="button" onclick="incrementQuantity()" class="px-3 py-2 text-gray-500 hover:text-gray-700 focus:outline-none">+</button>
                        </div>
                    </div>
                    
                    <button 
                        type="button"
                        onclick="addToCart(<?php echo e($product->id); ?>)"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-semibold transition duration-300 flex items-center justify-center"
                        <?php echo e($product->stock_quantity == 0 ? 'disabled' : ''); ?>

                    >
                        <?php if($product->stock_quantity == 0): ?>
                            Out of Stock
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        <?php endif; ?>
                    </button>
                </div>
                
                <!-- Quick checkout button -->
                <div class="mb-6">
                    <button 
                        type="button"
                        onclick="buyNow(<?php echo e($product->id); ?>)"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-semibold transition duration-300 flex items-center justify-center"
                        <?php echo e($product->stock_quantity == 0 ? 'disabled' : ''); ?>

                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Buy Now
                    </button>
                </div>
                
                <!-- Add notification area for cart updates -->
                <div id="notification" class="hidden fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-md transition-all duration-300"></div>
                    
            </div>
        </div>
    </div>

    <!-- JavaScript for Cart Functionality -->
    <script>
        function incrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            const maxQuantity = <?php echo e($product->stock_quantity); ?>;
            
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        }
        
        function decrementQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }
        
        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value;
            
            fetch('<?php echo e(route('cart.add')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    product_type: 'mining'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Product added to cart!');
                } else {
                    showNotification('Error: ' + data.message, true);
                }
            })
            .catch(error => {
                showNotification('An error occurred while adding the product to cart.', true);
                console.error('Error:', error);
            });
        }
        
        function buyNow(productId) {
            // First add to cart
            const quantity = document.getElementById('quantity').value;
            
            fetch('<?php echo e(route('cart.add')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    product_type: 'mining'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Then redirect to cart page
                    window.location.href = '<?php echo e(route('cart.index')); ?>';
                } else {
                    showNotification('Error: ' + data.message, true);
                }
            })
            .catch(error => {
                showNotification('An error occurred while processing your request.', true);
                console.error('Error:', error);
            });
        }
        
        function showNotification(message, isError = false) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.remove('hidden');
            
            if (isError) {
                notification.classList.remove('bg-green-100', 'border-green-500', 'text-green-700');
                notification.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
            } else {
                notification.classList.remove('bg-red-100', 'border-red-500', 'text-red-700');
                notification.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
            }
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/mining/show.blade.php ENDPATH**/ ?>