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
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl font-bold text-white mb-2">Mining Profitability Calculator</h1>
            <p class="text-indigo-100 max-w-2xl mx-auto">Estimate your potential earnings from cryptocurrency mining with our advanced calculator</p>
        </div>
    </div>

    <!-- Calculator Section -->
    <div class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <?php if(session('message')): ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p><?php echo e(session('message')); ?></p>
                </div>
            <?php endif; ?>
            <!-- Live Cryptocurrency Prices -->
            <div class="bg-gradient-to-r from-blue-900 to-indigo-900 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-white">Live Cryptocurrency Prices</h2>
                        <div class="flex items-center">
                            <?php if(isset($cryptoPrices['timestamp'])): ?>
                                <div class="text-sm text-blue-200 mr-4">Updated: <?php echo e(date('Y-m-d H:i:s', $cryptoPrices['timestamp'])); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/1.png" alt="Bitcoin" class="w-6 h-6 mr-2">
                                <span class="text-white font-medium">Bitcoin</span>
                            </div>
                            <div class="text-xl font-bold text-white">$<?php echo e(isset($cryptoPrices['BTC']) ? number_format($cryptoPrices['BTC'], 2) : '39,500.00'); ?></div>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/1027.png" alt="Ethereum" class="w-6 h-6 mr-2">
                                <span class="text-white font-medium">Ethereum</span>
                            </div>
                            <div class="text-xl font-bold text-white">$<?php echo e(isset($cryptoPrices['ETH']) ? number_format($cryptoPrices['ETH'], 2) : '2,000.00'); ?></div>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/2.png" alt="Litecoin" class="w-6 h-6 mr-2">
                                <span class="text-white font-medium">Litecoin</span>
                            </div>
                            <div class="text-xl font-bold text-white">$<?php echo e(isset($cryptoPrices['LTC']) ? number_format($cryptoPrices['LTC'], 2) : '80.00'); ?></div>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/131.png" alt="Dash" class="w-6 h-6 mr-2">
                                <span class="text-white font-medium">Dash</span>
                            </div>
                            <div class="text-xl font-bold text-white">$<?php echo e(isset($cryptoPrices['DASH']) ? number_format($cryptoPrices['DASH'], 2) : '30.00'); ?></div>
                        </div>
                        
                        <div class="bg-white bg-opacity-10 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/328.png" alt="Monero" class="w-6 h-6 mr-2">
                                <span class="text-white font-medium">Monero</span>
                            </div>
                            <div class="text-xl font-bold text-white">$<?php echo e(isset($cryptoPrices['XMR']) ? number_format($cryptoPrices['XMR'], 2) : '160.00'); ?></div>
                        </div>
                    </div>
                    
                    <?php if(isset($cryptoPrices['is_fallback'])): ?>
                        <div class="mt-4 p-3 bg-yellow-100 bg-opacity-20 rounded-lg text-center">
                            <span class="text-yellow-200">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Note: Using estimated prices. Live price data currently unavailable.
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Realistic Mining Information -->
            <div class="bg-indigo-50 rounded-xl p-6 mb-8">
                <h2 class="text-xl font-bold mb-4">Understanding Mining Profitability</h2>
                <p class="mb-4">Our calculator provides realistic estimates based on current network conditions and cryptocurrency prices. Mining profitability depends on several key factors:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-indigo-700 mb-2">Network Factors</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Network difficulty (changes regularly)</li>
                            <li>Block rewards (subject to halvings)</li>
                            <li>Transaction fees</li>
                            <li>Total network hashrate</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-indigo-700 mb-2">Hardware Factors</h3>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Mining hashrate</li>
                            <li>Power consumption</li>
                            <li>Electricity costs</li>
                            <li>Hardware efficiency (J/TH)</li>
                        </ul>
                    </div>
                </div>
                
                <p class="mt-4 text-sm text-gray-600">Note: Our calculator uses the current network difficulty and cryptocurrency prices. Actual results may vary as these factors change over time. Mining difficulty typically increases, which can reduce profitability.</p>
            </div>
            
            <!-- Calculator Form -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6">Calculate Your Mining Profitability</h2>
                    
                    <form id="mining-calculator-form">
                        <?php echo csrf_field(); ?>
                        <!-- Hardware Selection -->
                        <div class="mb-6">
                            <label for="hardware" class="block text-sm font-medium text-gray-700 mb-2">Mining Hardware</label>
                            <select id="hardware" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="custom">Custom Hardware</option>
                                <?php $__currentLoopData = $miningProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($product->hashrate != 'N/A'): ?>
                                        <option value="<?php echo e($product->id); ?>" 
                                                data-hashrate="<?php echo e(str_replace(['TH/s', 'MH/s'], '', $product->hashrate)); ?>"
                                                data-power="<?php echo e($product->power_consumption); ?>"
                                                data-algorithm="<?php echo e($product->algorithm); ?>">
                                            <?php echo e($product->name); ?> (<?php echo e($product->hashrate); ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Hashrate -->
                            <div>
                                <label for="hashrate" class="block text-sm font-medium text-gray-700 mb-2">Hashrate</label>
                                <div class="flex">
                                    <input type="number" id="hashrate" class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter hashrate" required>
                                    <select id="hashrate-unit" class="px-4 py-2 border border-gray-300 border-l-0 rounded-r-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                                        <option value="TH">TH/s</option>
                                        <option value="GH">GH/s</option>
                                        <option value="MH">MH/s</option>
                                        <option value="KH">KH/s</option>
                                    </select>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Hashrate is your mining speed</p>
                            </div>
                            
                            <!-- Power Consumption -->
                            <div>
                                <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Power Consumption</label>
                                <div class="flex">
                                    <input type="number" id="power" class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter power usage" required>
                                    <span class="px-4 py-2 border border-gray-300 border-l-0 rounded-r-lg bg-gray-50 flex items-center">Watts</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Power used by your mining hardware</p>
                            </div>
                            
                            <!-- Electricity Cost -->
                            <div>
                                <label for="electricity" class="block text-sm font-medium text-gray-700 mb-2">Electricity Cost</label>
                                <div class="flex">
                                    <span class="px-4 py-2 border border-gray-300 border-r-0 rounded-l-lg bg-gray-50 flex items-center">$</span>
                                    <input type="number" id="electricity" class="w-full px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="0.12" step="0.01" min="0" required>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Cost per kilowatt-hour (kWh)</p>
                            </div>
                            
                            <!-- Mining Algorithm -->
                            <div>
                                <label for="algorithm" class="block text-sm font-medium text-gray-700 mb-2">Algorithm</label>
                                <select id="algorithm" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="SHA-256">SHA-256 (Bitcoin)</option>
                                    <option value="Ethash">Ethash (Ethereum/ETC)</option>
                                    <option value="Scrypt">Scrypt (Litecoin)</option>
                                    <option value="X11">X11 (Dash)</option>
                                    <option value="RandomX">RandomX (Monero)</option>
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Mining algorithm used by your hardware</p>
                            </div>
                        </div>
                        
                        <!-- Pool Fee -->
                        <div class="mb-8">
                            <label for="pool-fee" class="block text-sm font-medium text-gray-700 mb-2">Pool Fee (%)</label>
                            <input type="number" id="pool-fee" class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="1" min="0" max="10" step="0.1">
                            <p class="text-sm text-gray-500 mt-1">Most mining pools charge 1-3% fee</p>
                        </div>
                        
                        <!-- Calculate Button -->
                        <div class="text-center">
                            <button type="button" id="calculate-btn" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300">
                                Calculate Profitability
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Results Section (Hidden by default, show after calculation) -->
            <div id="results-section" class="bg-white rounded-xl shadow-md overflow-hidden mb-12 hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6">Mining Profitability Results</h2>
                    
                    <!-- Live Price Banner -->
                    <div id="price-banner" class="bg-blue-50 p-4 rounded-lg mb-6 flex items-center justify-between">
                        <div>
                            <span class="font-medium text-blue-800">Using live cryptocurrency prices:</span>
                            <span id="crypto-price-display" class="ml-2 text-blue-900 font-bold">$0.00</span>
                            <span id="crypto-symbol-display" class="ml-1">BTC</span>
                        </div>
                        <div class="text-sm text-blue-600" id="price-updated-at"></div>
                    </div>
                    
                    <!-- Fallback Price Banner (shown when live prices are unavailable) -->
                    <div id="fallback-price-banner" class="bg-yellow-50 p-4 rounded-lg mb-6 hidden">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="font-medium text-yellow-800">Using estimated cryptocurrency prices. Live price data unavailable.</span>
                        </div>
                    </div>
                    
                    <!-- Results Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Daily Results -->
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium mb-4">Daily</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-indigo-600 text-sm">Revenue</p>
                                    <p class="font-bold" id="daily-revenue">$0.00</p>
                                </div>
                                <div>
                                    <p class="text-indigo-600 text-sm">Power Cost</p>
                                    <p class="font-bold" id="daily-power-cost">$0.00</p>
                                </div>
                                <div class="pt-2 border-t border-indigo-100">
                                    <p class="text-indigo-600 text-sm">Profit</p>
                                    <p class="font-bold text-xl" id="daily-profit">$0.00</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monthly Results -->
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium mb-4">Monthly</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-indigo-600 text-sm">Revenue</p>
                                    <p class="font-bold" id="monthly-revenue">$0.00</p>
                                </div>
                                <div>
                                    <p class="text-indigo-600 text-sm">Power Cost</p>
                                    <p class="font-bold" id="monthly-power-cost">$0.00</p>
                                </div>
                                <div class="pt-2 border-t border-indigo-100">
                                    <p class="text-indigo-600 text-sm">Profit</p>
                                    <p class="font-bold text-xl" id="monthly-profit">$0.00</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Yearly Results -->
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium mb-4">Yearly</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-indigo-600 text-sm">Revenue</p>
                                    <p class="font-bold" id="yearly-revenue">$0.00</p>
                                </div>
                                <div>
                                    <p class="text-indigo-600 text-sm">Power Cost</p>
                                    <p class="font-bold" id="yearly-power-cost">$0.00</p>
                                </div>
                                <div class="pt-2 border-t border-indigo-100">
                                    <p class="text-indigo-600 text-sm">Profit</p>
                                    <p class="font-bold text-xl" id="yearly-profit">$0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Crypto Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium mb-4">Cryptocurrency Rewards</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-gray-600 text-sm">Daily Mining Reward</p>
                                <p class="font-bold" id="daily-crypto">0.00000000 BTC</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Monthly Mining Reward</p>
                                <p class="font-bold" id="monthly-crypto">0.00000000 BTC</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Yearly Mining Reward</p>
                                <p class="font-bold" id="yearly-crypto">0.00000000 BTC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Disclaimer -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-12">
                <h3 class="text-lg font-medium text-yellow-800 mb-2">Important Disclaimer</h3>
                <p class="text-yellow-700 mb-4">Mining profitability is highly variable and depends on factors that change daily. Our calculator uses current data, but please consider:</p>
                <ul class="list-disc pl-5 space-y-2 text-yellow-700">
                    <li><strong>Network Difficulty:</strong> This increases over time as more miners join the network, reducing your share of rewards.</li>
                    <li><strong>Price Volatility:</strong> Cryptocurrency prices can change dramatically, affecting profitability instantly.</li>
                    <li><strong>Halving Events:</strong> Bitcoin and some other cryptocurrencies periodically cut rewards in half (roughly every 4 years for Bitcoin).</li>
                    <li><strong>Hardware Depreciation:</strong> Mining equipment loses value and effectiveness over time as newer, more efficient models are released.</li>
                    <li><strong>Additional Costs:</strong> This calculator doesn't account for cooling, maintenance, internet, or facility costs.</li>
                    <li><strong>Protocol Changes:</strong> Cryptocurrencies may change consensus mechanisms (like Ethereum's move to Proof of Stake), potentially making your hardware obsolete.</li>
                </ul>
                <div class="mt-4 p-3 bg-yellow-100 rounded-lg">
                    <p class="text-yellow-800 font-medium">Before investing in mining hardware, consider whether simply buying and holding the cryptocurrency might be more profitable in the long run.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Mining Products -->
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold mb-8 text-center">Featured Mining Hardware</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php $__currentLoopData = $miningProducts->where('featured', true)->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-1">
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
                        <div class="flex items-center mb-2">
                            <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                            <span class="text-gray-600"><?php echo e($product->hashrate); ?></span>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-2xl font-bold text-indigo-600">$<?php echo e(number_format($product->price, 2)); ?></span>
                            <a href="<?php echo e(route('mining.show', $product->id)); ?>" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-medium transition duration-300">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="text-center mt-8">
                <a href="<?php echo e(route('mining.products')); ?>" class="inline-block px-6 py-3 border border-indigo-600 hover:bg-indigo-50 rounded-lg text-indigo-600 font-semibold transition duration-300">Browse All Mining Products</a>
            </div>
        </div>
    </div>

    <!-- Calculator JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hardwareSelect = document.getElementById('hardware');
            const hashrateInput = document.getElementById('hashrate');
            const hashrateUnitSelect = document.getElementById('hashrate-unit');
            const powerInput = document.getElementById('power');
            const electricityInput = document.getElementById('electricity');
            const algorithmSelect = document.getElementById('algorithm');
            const poolFeeInput = document.getElementById('pool-fee');
            const calculateBtn = document.getElementById('calculate-btn');
            const resultsSection = document.getElementById('results-section');
            const refreshButton = document.getElementById('refresh-prices-button');
            
            // Function to refresh cryptocurrency prices every 5 minutes
            function setupPriceRefresh() {
                // Refresh prices every 5 minutes (300000 ms)
                setInterval(function() {
                    fetch('<?php echo e(route('mining.calculate')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            hashrate: 1,
                            hashrate_unit: 'TH',
                            power_consumption: 100,
                            electricity_cost: 0.1,
                            algorithm: 'SHA-256',
                            pool_fee: 1,
                            price_refresh_only: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.prices) {
                            // Update price display
                            if (data.prices.BTC) {
                                document.querySelector('[alt="Bitcoin"] + span + div').textContent = '$' + parseFloat(data.prices.BTC).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            if (data.prices.ETH) {
                                document.querySelector('[alt="Ethereum"] + span + div').textContent = '$' + parseFloat(data.prices.ETH).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            if (data.prices.LTC) {
                                document.querySelector('[alt="Litecoin"] + span + div').textContent = '$' + parseFloat(data.prices.LTC).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            if (data.prices.DASH) {
                                document.querySelector('[alt="Dash"] + span + div').textContent = '$' + parseFloat(data.prices.DASH).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            if (data.prices.XMR) {
                                document.querySelector('[alt="Monero"] + span + div').textContent = '$' + parseFloat(data.prices.XMR).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            
                            // Update timestamp
                            if (data.prices.timestamp) {
                                const timestampDisplay = document.querySelector('.text-blue-200');
                                if (timestampDisplay) {
                                    timestampDisplay.textContent = 'Updated: ' + new Date(data.prices.timestamp * 1000).toLocaleString();
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error refreshing prices:', error);
                    });
                }, 300000); // 5 minutes
            }
            
            // Start price refresh mechanism
            setupPriceRefresh();
            
            // Update form when hardware is selected
            hardwareSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (this.value !== 'custom') {
                    // Fill in values from the selected hardware
                    hashrateInput.value = selectedOption.dataset.hashrate;
                    powerInput.value = selectedOption.dataset.power;
                    algorithmSelect.value = selectedOption.dataset.algorithm;
                }
            });
            
            // Calculate button click handler
            calculateBtn.addEventListener('click', function() {
                // Get input values
                const hashrate = parseFloat(hashrateInput.value);
                const hashrateUnit = hashrateUnitSelect.value;
                const power = parseFloat(powerInput.value);
                const electricityCost = parseFloat(electricityInput.value);
                const algorithm = algorithmSelect.value;
                const poolFee = parseFloat(poolFeeInput.value);
                
                // Validate inputs
                if (isNaN(hashrate) || isNaN(power) || isNaN(electricityCost) || isNaN(poolFee)) {
                    alert('Please fill in all required fields with valid numbers.');
                    return;
                }
                
                // Show loading state
                calculateBtn.disabled = true;
                calculateBtn.textContent = 'Calculating...';
                
                // Call the backend API
                fetch('<?php echo e(route('mining.calculate')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        hashrate: hashrate,
                        hashrate_unit: hashrateUnit,
                        power_consumption: power,
                        electricity_cost: electricityCost,
                        algorithm: algorithm,
                        pool_fee: poolFee
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    calculateBtn.disabled = false;
                    calculateBtn.textContent = 'Calculate Profitability';
                    
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    
                    // Ensure all values are properly parsed as numbers to avoid string concatenation
                    const dailyRewardUsd = parseFloat(data.daily_reward_usd);
                    const dailyPowerCost = parseFloat(data.daily_power_cost);
                    const dailyProfit = parseFloat(data.daily_profit);
                    const monthlyPowerCost = parseFloat(data.monthly_power_cost);
                    const monthlyProfit = parseFloat(data.monthly_profit);
                    const yearlyPowerCost = parseFloat(data.yearly_power_cost);
                    const yearlyProfit = parseFloat(data.yearly_profit);
                    
                    // Update results section with formatted values
                    document.getElementById('daily-revenue').innerText = '$' + dailyRewardUsd.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('daily-power-cost').innerText = '$' + dailyPowerCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('daily-profit').innerText = '$' + dailyProfit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    
                    const monthlyRevenue = dailyRewardUsd * 30;
                    document.getElementById('monthly-revenue').innerText = '$' + monthlyRevenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('monthly-power-cost').innerText = '$' + monthlyPowerCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('monthly-profit').innerText = '$' + monthlyProfit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    
                    const yearlyRevenue = dailyRewardUsd * 365;
                    document.getElementById('yearly-revenue').innerText = '$' + yearlyRevenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('yearly-power-cost').innerText = '$' + yearlyPowerCost.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    document.getElementById('yearly-profit').innerText = '$' + yearlyProfit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    
                    document.getElementById('daily-crypto').innerText = data.daily_reward + ' ' + data.crypto_symbol;
                    document.getElementById('monthly-crypto').innerText = data.monthly_reward + ' ' + data.crypto_symbol;
                    document.getElementById('yearly-crypto').innerText = data.yearly_reward + ' ' + data.crypto_symbol;
                    
                    // Display live cryptocurrency price information
                    if (data.using_live_prices) {
                        document.getElementById('price-banner').classList.remove('hidden');
                        document.getElementById('fallback-price-banner').classList.add('hidden');
                        document.getElementById('crypto-price-display').innerText = '$' + parseFloat(data.crypto_price).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        document.getElementById('crypto-symbol-display').innerText = data.crypto_symbol;
                        document.getElementById('price-updated-at').innerText = 'Updated: ' + data.price_updated_at;
                    } else {
                        document.getElementById('price-banner').classList.add('hidden');
                        document.getElementById('fallback-price-banner').classList.remove('hidden');
                    }
                    
                    // Show results section
                    resultsSection.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during calculation. Please try again.');
                    calculateBtn.disabled = false;
                    calculateBtn.textContent = 'Calculate Profitability';
                });
            });
            
            // Add meta description about the realistic calculation
            document.querySelector('meta[name="description"]').content = 'Calculate your mining profitability with our accurate calculator. Takes into account network difficulty, block rewards, and more.';
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
<?php endif; ?> <?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/mining/calculator.blade.php ENDPATH**/ ?>