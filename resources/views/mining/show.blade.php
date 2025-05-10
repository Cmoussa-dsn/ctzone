<x-app-layout>
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('mining.index') }}" class="hover:text-indigo-600">Mining</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span>{{ $product->name }}</span>
            </div>
        </div>
    </div>

    <!-- Product Detail Section -->
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col lg:flex-row">
            <!-- Product Image -->
            <div class="lg:w-1/2 mb-8 lg:mb-0 lg:pr-8">
                <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-contain p-8">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                <div class="flex items-center mb-4">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <span class="ml-2 text-gray-600">(14 reviews)</span>
                </div>

                <div class="text-3xl font-bold text-indigo-600 mb-6">${{ number_format($product->price, 2) }}</div>

                <div class="mb-8">
                    <p class="text-gray-700 mb-6">{{ $product->description }}</p>

                    <!-- Product Specs -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Specifications</h2>
                        
                        @if($product->hashrate != 'N/A')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-gray-500 text-sm">Hashrate</h3>
                                <p class="font-medium">{{ $product->hashrate }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Algorithm</h3>
                                <p class="font-medium">{{ $product->algorithm }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Power Consumption</h3>
                                <p class="font-medium">{{ $product->power_consumption }}W</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Efficiency</h3>
                                <p class="font-medium">{{ number_format($product->power_consumption / (float)str_replace(['TH/s', 'MH/s'], '', $product->hashrate), 2) }} W/TH</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Daily Profit Estimate</h3>
                                <p class="font-medium">${{ number_format($product->daily_profit_estimate, 2) }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Stock</h3>
                                <p class="font-medium">{{ $product->stock_quantity }} units</p>
                            </div>
                        </div>
                        @else
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-gray-500 text-sm">Power Consumption</h3>
                                <p class="font-medium">{{ $product->power_consumption }}W</p>
                            </div>
                            <div>
                                <h3 class="text-gray-500 text-sm">Stock</h3>
                                <p class="font-medium">{{ $product->stock_quantity }} units</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Add to Cart -->
                <div class="flex items-center mb-8">
                    <div class="mr-4">
                        <label for="quantity" class="sr-only">Quantity</label>
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button class="px-3 py-2 text-gray-500 hover:text-gray-700 focus:outline-none">-</button>
                            <input type="number" id="quantity" class="w-12 text-center border-none focus:ring-0" value="1" min="1">
                            <button class="px-3 py-2 text-gray-500 hover:text-gray-700 focus:outline-none">+</button>
                        </div>
                    </div>
                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-semibold transition duration-300">
                        Add to Cart
                    </button>
                </div>

                <!-- Shipping & Return Info -->
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>Free shipping worldwide on orders over $5000</p>
                    </div>
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>30-day return policy</p>
                    </div>
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p>1-year warranty included</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profitability Calculator -->
    @if($product->hashrate != 'N/A')
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl font-bold mb-8 text-center">Calculate Profitability</h2>
            
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="electricity-cost" class="block text-sm font-medium text-gray-700 mb-2">Electricity Cost ($/kWh)</label>
                            <input type="number" id="electricity-cost" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="0.12" step="0.01" min="0">
                        </div>
                        <div>
                            <label for="btc-price" class="block text-sm font-medium text-gray-700 mb-2">BTC Price ($)</label>
                            <input type="number" id="btc-price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="39500" step="100" min="0">
                        </div>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium mb-4">{{ $product->name }} - {{ $product->hashrate }}</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <p class="text-indigo-600 text-sm">Daily Revenue</p>
                                <p class="font-bold">${{ number_format($product->daily_profit_estimate + (($product->power_consumption / 1000) * 24 * 0.12), 2) }}</p>
                            </div>
                            <div>
                                <p class="text-indigo-600 text-sm">Power Cost</p>
                                <p class="font-bold">${{ number_format(($product->power_consumption / 1000) * 24 * 0.12, 2) }}/day</p>
                            </div>
                            <div>
                                <p class="text-indigo-600 text-sm">Daily Profit</p>
                                <p class="font-bold">${{ number_format($product->daily_profit_estimate, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-indigo-600 text-sm">Monthly Profit</p>
                                <p class="font-bold">${{ number_format($product->daily_profit_estimate * 30, 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="font-medium mb-2">ROI (Return on Investment)</h4>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                @php
                                    $daysToROI = $product->price / $product->daily_profit_estimate;
                                    $roiPercentage = min(100, ($product->daily_profit_estimate * 365 / $product->price) * 100);
                                @endphp
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $roiPercentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">Estimated payback period: {{ round($daysToROI) }} days</p>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('mining.calculator') }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300 flex items-center justify-center">
                            Advanced Calculator
                            @guest
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm ml-1">(Login Required)</span>
                            @endguest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Related Products -->
    <div class="container mx-auto px-6 py-12">
        <h2 class="text-2xl font-bold mb-8">Related Products</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $relatedProduct)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-transform duration-300 hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    @if($relatedProduct->image)
                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-2">{{ $relatedProduct->name }}</h3>
                    
                    @if($relatedProduct->hashrate != 'N/A')
                    <div class="flex items-center mb-2">
                        <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                        <span class="text-gray-600">{{ $relatedProduct->hashrate }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xl font-bold text-indigo-600">${{ number_format($relatedProduct->price, 2) }}</span>
                        <a href="{{ route('mining.show', $relatedProduct->id) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-800 font-medium transition duration-300">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout> 