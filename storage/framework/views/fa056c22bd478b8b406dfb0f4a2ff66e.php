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
    <!-- Hero Banner -->
    <div class="relative">
        <div class="w-full h-96 bg-gradient-to-r from-blue-900 to-indigo-900"></div>
        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
        <div class="container mx-auto px-6 absolute inset-0 flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Build Your Dream PC</h1>
                <p class="text-xl mb-6">Customize every component to create your perfect system</p>
                <div class="flex space-x-4">
                    <a href="#builder" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">Start Building</a>
                    <a href="<?php echo e(route('buy')); ?>" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">View Pre-built PCs</a>
                </div>
            </div>
        </div>
    </div>

    <!-- PC Builder Section -->
    <section id="builder" class="py-12 md:py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Custom PC Builder</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Select your components below to build your custom PC. We'll assemble it, test it, and ship it to your doorstep.</p>
            </div>
            
            <form action="<?php echo e(route('pc-builder.store')); ?>" method="POST" class="max-w-4xl mx-auto">
                <?php echo csrf_field(); ?>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Component Selection Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <!-- Processor -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-microchip text-indigo-600 mr-2"></i>
                                Processor (CPU)
                            </h3>
                            <select name="processor" id="processor" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="processor">
                                <option value="">Select a Processor</option>
                                <?php $__currentLoopData = $components['processors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $processor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($processor->id); ?>" data-price="<?php echo e($processor->price); ?>">
                                        <?php echo e($processor->name); ?> - $<?php echo e(number_format($processor->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Motherboard -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-server text-indigo-600 mr-2"></i>
                                Motherboard
                            </h3>
                            <select name="motherboard" id="motherboard" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="motherboard">
                                <option value="">Select a Motherboard</option>
                                <?php $__currentLoopData = $components['motherboards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motherboard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($motherboard->id); ?>" data-price="<?php echo e($motherboard->price); ?>">
                                        <?php echo e($motherboard->name); ?> - $<?php echo e(number_format($motherboard->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Graphics Card -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-tv text-indigo-600 mr-2"></i>
                                Graphics Card
                            </h3>
                            <select name="graphics" id="graphics" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="graphics">
                                <option value="">Select a Graphics Card</option>
                                <?php $__currentLoopData = $components['graphics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $graphics): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($graphics->id); ?>" data-price="<?php echo e($graphics->price); ?>">
                                        <?php echo e($graphics->name); ?> - $<?php echo e(number_format($graphics->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Memory -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-memory text-indigo-600 mr-2"></i>
                                Memory (RAM)
                            </h3>
                            <select name="memory" id="memory" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="memory">
                                <option value="">Select Memory</option>
                                <?php $__currentLoopData = $components['memory']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($memory->id); ?>" data-price="<?php echo e($memory->price); ?>">
                                        <?php echo e($memory->name); ?> - $<?php echo e(number_format($memory->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Storage -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-hdd text-indigo-600 mr-2"></i>
                                Storage
                            </h3>
                            <select name="storage" id="storage" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="storage">
                                <option value="">Select Storage</option>
                                <?php $__currentLoopData = $components['storage']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $storage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($storage->id); ?>" data-price="<?php echo e($storage->price); ?>">
                                        <?php echo e($storage->name); ?> - $<?php echo e(number_format($storage->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Power Supply -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-bolt text-indigo-600 mr-2"></i>
                                Power Supply
                            </h3>
                            <select name="power" id="power" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="power">
                                <option value="">Select Power Supply</option>
                                <?php $__currentLoopData = $components['power']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $power): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($power->id); ?>" data-price="<?php echo e($power->price); ?>">
                                        <?php echo e($power->name); ?> - $<?php echo e(number_format($power->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Case -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-desktop text-indigo-600 mr-2"></i>
                                Case
                            </h3>
                            <select name="case" id="case" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="case">
                                <option value="">Select a Case</option>
                                <?php $__currentLoopData = $components['cases']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($case->id); ?>" data-price="<?php echo e($case->price); ?>">
                                        <?php echo e($case->name); ?> - $<?php echo e(number_format($case->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Cooling -->
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition duration-300">
                            <h3 class="text-lg font-medium mb-3 flex items-center">
                                <i class="fas fa-wind text-indigo-600 mr-2"></i>
                                Cooling
                            </h3>
                            <select name="cooling" id="cooling" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required data-component="cooling">
                                <option value="">Select Cooling</option>
                                <?php $__currentLoopData = $components['cooling']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cooling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cooling->id); ?>" data-price="<?php echo e($cooling->price); ?>">
                                        <?php echo e($cooling->name); ?> - $<?php echo e(number_format($cooling->price, 2)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Price Summary -->
                    <div class="border-t border-gray-200 bg-gray-50 p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold">Total Price:</h3>
                                <p class="text-sm text-gray-600">Includes assembly, testing, and 1-year warranty</p>
                            </div>
                            <div class="text-2xl font-bold text-indigo-600">$<span id="total-price">0.00</span></div>
                            <input type="hidden" name="total_price" id="total-price-input" value="0">
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="bg-gray-100 p-6 text-right">
                        <?php if(auth()->guard()->check()): ?>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">
                                Add to Cart
                            </button>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 inline-block">
                                Login to Continue
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Why Build With Us -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Why Build With CT ZONE</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We provide premium PC building services with expert assembly and rigorous testing</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                        <i class="fas fa-tools text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Expert Assembly</h3>
                    <p class="text-gray-600">Our technicians have years of experience building custom PCs with precision and care</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                        <i class="fas fa-check-circle text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Quality Testing</h3>
                    <p class="text-gray-600">Every PC undergoes extensive stress testing to ensure stability and performance</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                        <i class="fas fa-headset text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Premium Support</h3>
                    <p class="text-gray-600">Get dedicated technical support and a 1-year warranty on all custom builds</p>
                </div>
            </div>
        </div>
    </section>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const components = document.querySelectorAll('select[data-component]');
            const totalPriceElement = document.getElementById('total-price');
            const totalPriceInput = document.getElementById('total-price-input');
            
            function updateTotalPrice() {
                let total = 0;
                components.forEach(component => {
                    const selectedOption = component.options[component.selectedIndex];
                    if (selectedOption && selectedOption.dataset.price) {
                        total += parseFloat(selectedOption.dataset.price);
                    }
                });
                
                totalPriceElement.textContent = total.toFixed(2);
                totalPriceInput.value = total;
            }
            
            components.forEach(component => {
                component.addEventListener('change', updateTotalPrice);
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
<?php endif; ?> <?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/pc-builder.blade.php ENDPATH**/ ?>