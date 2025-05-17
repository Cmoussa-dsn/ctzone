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
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-gray-900 to-indigo-900 py-12">
        <div class="container mx-auto px-6">
            <h1 class="text-3xl font-bold text-white mb-2">Mining Equipment</h1>
            <p class="text-indigo-100">Browse our full range of cryptocurrency mining hardware and accessories</p>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container mx-auto px-6 py-12">
        <!-- Filter/Sort Controls -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-lg font-medium mb-2">Filters</h2>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="filterProducts('all')" class="filter-btn active px-4 py-2 bg-indigo-100 hover:bg-indigo-200 rounded-lg text-indigo-800 transition duration-300" data-filter="all">All</button>
                        <button type="button" onclick="filterProducts('ASIC')" class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-800 transition duration-300" data-filter="ASIC">ASIC Miners</button>
                        <button type="button" onclick="filterProducts('GPU')" class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-800 transition duration-300" data-filter="GPU">GPU Miners</button>
                        <button type="button" onclick="filterProducts('accessories')" class="filter-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-800 transition duration-300" data-filter="accessories">Accessories</button>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-medium mb-2">Sort By</h2>
                    <select class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Hashrate: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php $__currentLoopData = $miningProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-1" 
                 data-algorithm="<?php echo e($product->algorithm); ?>" 
                 data-type="<?php echo e($product->algorithm === 'N/A' ? 'accessories' : (strpos($product->algorithm, 'SHA-256') !== false ? 'ASIC' : 'GPU')); ?>">
                <div class="h-48 overflow-hidden">
                    <?php if($product->image): ?>
                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2"><?php echo e($product->name); ?></h3>
                    
                    <?php if($product->hashrate != 'N/A'): ?>
                    <div class="flex items-center mb-2">
                        <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                        <span class="text-gray-600"><?php echo e($product->hashrate); ?></span>
                    </div>
                    <div class="flex items-center mb-4">
                        <span class="text-gray-700 font-medium mr-2">Algorithm:</span>
                        <span class="text-gray-600"><?php echo e($product->algorithm); ?></span>
                    </div>
                    <?php else: ?>
                    <p class="text-gray-600 mb-4 line-clamp-2"><?php echo e($product->description); ?></p>
                    <?php endif; ?>
                    
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-indigo-600">$<?php echo e(number_format($product->price, 2)); ?></span>
                        <div class="flex space-x-2">
                            <button 
                                onclick="quickAddToCart(<?php echo e($product->id); ?>)"
                                class="p-2 bg-green-600 hover:bg-green-700 rounded-lg text-white transition duration-300 flex items-center justify-center <?php echo e($product->stock_quantity == 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                                <?php echo e($product->stock_quantity == 0 ? 'disabled' : ''); ?>

                                title="<?php echo e($product->stock_quantity == 0 ? 'Out of Stock' : 'Add to Cart'); ?>"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>
                            <a href="<?php echo e(route('mining.show', $product->id)); ?>" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-medium transition duration-300">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            <?php echo e($miningProducts->links()); ?>

        </div>
    </div>

    <!-- Mining Calculator Promo -->
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6">
            <div class="bg-indigo-700 rounded-xl overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-2/3 p-8 md:p-12 text-white">
                        <h2 class="text-2xl font-bold mb-4">Calculate Your Mining Profitability</h2>
                        <p class="text-indigo-100 mb-6">Use our mining calculator to estimate potential earnings based on your hardware and electricity costs.</p>
                        <a href="<?php echo e(route('mining.calculator')); ?>" class="inline-block px-6 py-3 bg-white text-indigo-700 hover:bg-indigo-50 rounded-lg font-semibold transition duration-300 flex items-center">
                            Try Calculator
                            <?php if(auth()->guard()->guest()): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm ml-1 text-indigo-500">(Login Required)</span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="md:w-1/3 bg-indigo-800 p-8 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add notification area for cart updates -->
    <div id="notification" class="hidden fixed top-4 right-4 z-50 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-md transition-all duration-300"></div>

    <!-- JavaScript for Quick Add to Cart -->
    <script>
        function quickAddToCart(productId) {
            fetch('<?php echo e(route('cart.add')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1,
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

    <!-- JavaScript for filtering products -->
    <script>
        // Filter products by type
        function filterProducts(filterType) {
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.dataset.filter === filterType) {
                    btn.classList.add('active', 'bg-indigo-100', 'text-indigo-800');
                    btn.classList.remove('bg-gray-100', 'text-gray-800');
                } else {
                    btn.classList.remove('active', 'bg-indigo-100', 'text-indigo-800');
                    btn.classList.add('bg-gray-100', 'text-gray-800');
                }
            });
            
            // Show/hide products based on filter
            document.querySelectorAll('.product-card').forEach(card => {
                if (filterType === 'all' || card.dataset.type === filterType) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        // Function to initialize filtering
        document.addEventListener('DOMContentLoaded', function() {
            // Set "All" as active by default
            filterProducts('all');
        });
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
<?php endif; ?><?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/mining/products.blade.php ENDPATH**/ ?>