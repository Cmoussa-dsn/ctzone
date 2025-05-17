<?php $__env->startSection('title', 'Add Mining Product'); ?>
<?php $__env->startSection('content'); ?>
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-blue-700 mb-6">Add New Mining Product</h1>
            
            <!-- Product Type Selection for easier form filling -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Product Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="product_type_selector" value="miner" class="form-radio text-blue-600" checked>
                        <span class="ml-2">Mining Device</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="product_type_selector" value="accessory" class="form-radio text-blue-600">
                        <span class="ml-2">Accessory</span>
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Select "Accessory" for mining frames, PSUs, cooling systems, etc.</p>
            </div>
            
            <form action="<?php echo e(route('admin.mining.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="<?php echo e(old('price')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="<?php echo e(old('stock_quantity')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <?php $__errorArgs = ['stock_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Mining specific fields -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Algorithm</label>
                    <select name="algorithm" id="algorithm" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select an algorithm</option>
                        <?php $__currentLoopData = $algorithms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(old('algorithm') == $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['algorithm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Hashrate (with unit, e.g. "100 TH/s" or "N/A" for accessories)</label>
                    <input type="text" name="hashrate" id="hashrate" value="<?php echo e(old('hashrate')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <p class="text-sm text-gray-500 mt-1">For accessories, enter "N/A"</p>
                    <?php $__errorArgs = ['hashrate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Power Consumption (watts)</label>
                    <input type="number" name="power_consumption" id="power_consumption" value="<?php echo e(old('power_consumption')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <p class="text-sm text-gray-500 mt-1">For accessories with no power usage, enter 0</p>
                    <?php $__errorArgs = ['power_consumption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4" id="profit_estimate_field">
                    <label class="block text-gray-700 font-semibold mb-2">Daily Profit Estimate (USD)</label>
                    <input type="number" step="0.01" name="daily_profit_estimate" id="daily_profit_estimate" value="<?php echo e(old('daily_profit_estimate')); ?>" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Leave at 0 for accessories</p>
                    <?php $__errorArgs = ['daily_profit_estimate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center text-gray-700 font-semibold">
                        <input type="checkbox" name="featured" value="1" <?php echo e(old('featured') ? 'checked' : ''); ?> class="mr-2 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        Featured Product
                    </label>
                    <?php $__errorArgs = ['featured'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    <input type="file" name="image" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Add Product</button>
                    <a href="<?php echo e(route('admin.mining.index')); ?>" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productTypeSelector = document.querySelectorAll('input[name="product_type_selector"]');
            const algorithmField = document.getElementById('algorithm');
            const hashrateField = document.getElementById('hashrate');
            const powerConsumptionField = document.getElementById('power_consumption');
            const profitEstimateField = document.getElementById('daily_profit_estimate');
            
            // Function to set values for accessories
            function setupForAccessory() {
                // Set algorithm to N/A
                for (let i = 0; i < algorithmField.options.length; i++) {
                    if (algorithmField.options[i].value === 'N/A') {
                        algorithmField.selectedIndex = i;
                        break;
                    }
                }
                
                // Set hashrate to N/A
                hashrateField.value = 'N/A';
                
                // Set power consumption to 0 by default (can be changed)
                if (!powerConsumptionField.value) {
                    powerConsumptionField.value = '0';
                }
                
                // Set profit estimate to 0
                profitEstimateField.value = '0';
                
                // Hide profit estimate field (it will still be submitted)
                document.getElementById('profit_estimate_field').style.display = 'none';
            }
            
            // Function to reset fields for mining devices
            function setupForMiner() {
                // Reset algorithm if it was set to N/A
                if (algorithmField.value === 'N/A') {
                    algorithmField.selectedIndex = 0;
                }
                
                // Reset hashrate if it was N/A
                if (hashrateField.value === 'N/A') {
                    hashrateField.value = '';
                }
                
                // Show profit estimate field
                document.getElementById('profit_estimate_field').style.display = 'block';
            }
            
            // Add event listeners to radio buttons
            productTypeSelector.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'accessory') {
                        setupForAccessory();
                    } else {
                        setupForMiner();
                    }
                });
            });
            
            // Initialize based on selection
            if (document.querySelector('input[name="product_type_selector"]:checked').value === 'accessory') {
                setupForAccessory();
            }
        });
    </script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/admin/mining/create.blade.php ENDPATH**/ ?>