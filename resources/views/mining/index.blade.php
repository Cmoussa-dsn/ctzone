<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-gray-900 to-indigo-900 text-white">
        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
        <div class="container mx-auto px-6 py-24 md:py-32 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Cryptocurrency Mining Solutions</h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">Professional mining equipment, rigs, and accessories to maximize your crypto profits.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('mining.products') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300">Browse Equipment</a>
                    <a href="{{ route('mining.calculator') }}" class="px-6 py-3 bg-white hover:bg-gray-100 rounded-lg text-indigo-700 font-semibold transition duration-300 flex items-center">
                        Mining Calculator
                        @guest
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        @endguest
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Featured Mining Equipment</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Top-performing mining hardware selected by our experts for optimal hashrate and efficiency.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="h-48 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                    <div class="flex items-center mb-2">
                        <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                        <span class="text-gray-600">{{ $product->hashrate }}</span>
                    </div>
                    <div class="flex items-center mb-4">
                        <span class="text-gray-700 font-medium mr-2">Algorithm:</span>
                        <span class="text-gray-600">{{ $product->algorithm }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('mining.show', $product->id) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-800 font-medium transition duration-300">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('mining.products') }}" class="inline-block px-6 py-3 border border-indigo-600 hover:bg-indigo-50 rounded-lg text-indigo-600 font-semibold transition duration-300">View All Products</a>
        </div>
    </div>

    <!-- Mining Categories Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Mining Equipment Categories</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Explore our comprehensive range of mining hardware and accessories.</p>
            </div>

            <!-- ASIC Miners -->
            <div class="mb-16">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">ASIC Miners</h3>
                    <a href="{{ route('mining.products') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($asicMiners as $miner)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="h-40 overflow-hidden">
                            @if($miner->image)
                                <img src="{{ asset('storage/' . $miner->image) }}" alt="{{ $miner->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="text-lg font-bold mb-2">{{ $miner->name }}</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                                <span class="text-gray-600">{{ $miner->hashrate }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xl font-bold text-indigo-600">${{ number_format($miner->price, 2) }}</span>
                                <a href="{{ route('mining.show', $miner->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- GPU Miners -->
            <div class="mb-16">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">GPU Mining</h3>
                    <a href="{{ route('mining.products') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($gpuMiners as $miner)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="h-40 overflow-hidden">
                            @if($miner->image)
                                <img src="{{ asset('storage/' . $miner->image) }}" alt="{{ $miner->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="text-lg font-bold mb-2">{{ $miner->name }}</h4>
                            <div class="flex items-center mb-2">
                                <span class="text-gray-700 font-medium mr-2">Hashrate:</span>
                                <span class="text-gray-600">{{ $miner->hashrate }}</span>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xl font-bold text-indigo-600">${{ number_format($miner->price, 2) }}</span>
                                <a href="{{ route('mining.show', $miner->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Accessories -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">Mining Accessories</h3>
                    <a href="{{ route('mining.products') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($accessories as $accessory)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="h-40 overflow-hidden">
                            @if($accessory->image)
                                <img src="{{ asset('storage/' . $accessory->image) }}" alt="{{ $accessory->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h4 class="text-lg font-bold mb-2">{{ $accessory->name }}</h4>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $accessory->description }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xl font-bold text-indigo-600">${{ number_format($accessory->price, 2) }}</span>
                                <a href="{{ route('mining.show', $accessory->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Mining Calculator Promo -->
    <div class="container mx-auto px-6 py-16">
        <div class="bg-indigo-50 rounded-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-8 md:p-12">
                    <h2 class="text-3xl font-bold mb-4">Mining Profitability Calculator</h2>
                    <p class="text-gray-600 mb-6">Estimate your potential earnings from cryptocurrency mining. Enter your hardware specs, electricity costs, and see real-time profit projections.</p>
                    <div class="mb-8">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Real-time cryptocurrency price data</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Accurate power consumption calculations</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Daily, monthly, and yearly projections</span>
                        </div>
                    </div>
                    <a href="{{ route('mining.calculator') }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300 flex items-center">
                        Try Calculator
                        @guest
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm ml-1">(Login Required)</span>
                        @endguest
                    </a>
                </div>
                <div class="md:w-1/2 bg-indigo-800 p-8 md:p-12 text-white">
                    <div class="bg-indigo-700 rounded-xl p-6 mb-6">
                        <h3 class="text-xl font-bold mb-4">Sample Calculation</h3>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-indigo-200 text-sm">Hardware</p>
                                <p class="font-medium">Antminer S19 Pro</p>
                            </div>
                            <div>
                                <p class="text-indigo-200 text-sm">Hashrate</p>
                                <p class="font-medium">110 TH/s</p>
                            </div>
                            <div>
                                <p class="text-indigo-200 text-sm">Power</p>
                                <p class="font-medium">3,250W</p>
                            </div>
                            <div>
                                <p class="text-indigo-200 text-sm">Electricity Cost</p>
                                <p class="font-medium">$0.12/kWh</p>
                            </div>
                        </div>
                        <div class="border-t border-indigo-600 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-indigo-200">Daily Profit:</span>
                                <span class="font-bold">$5.75</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-indigo-200">Monthly Profit:</span>
                                <span class="font-bold">$172.50</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-indigo-200">Annual Profit:</span>
                                <span class="font-bold">$2,098.75</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-indigo-200">* Calculations are estimates based on current network difficulty and cryptocurrency prices. Actual results may vary.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="bg-gray-50">
        <div class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Why Choose CT ZONE for Mining</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We provide everything you need to build and maintain a successful mining operation.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Premium Equipment</h3>
                    <p class="text-gray-600">We offer only top-tier, reliable mining hardware from trusted manufacturers.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Expert Support</h3>
                    <p class="text-gray-600">Our knowledgeable team is available to help with setup, optimization, and troubleshooting.</p>
                </div>
                
                <div class="bg-white p-8 rounded-xl shadow-md text-center">
                    <div class="inline-block p-4 bg-indigo-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Competitive Pricing</h3>
                    <p class="text-gray-600">We offer the best prices in the industry with bulk discounts for larger orders.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</x-app-layout> 