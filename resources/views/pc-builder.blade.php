<x-app-layout>
    <!-- Hero Banner -->
    <div class="relative">
        <div class="w-full h-96 bg-gradient-to-r from-blue-900 to-indigo-900"></div>
        <div class="container mx-auto px-6 absolute inset-0 flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl font-bold mb-4">Build Your Dream PC</h1>
                <p class="text-xl mb-6">Customize every component to create your perfect system</p>
                <div class="flex space-x-4">
                    <a href="#builder" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">Start Building</a>
                    <a href="{{ route('buy') }}" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">View Pre-built PCs</a>
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
            
            <form action="{{ route('pc-builder.store') }}" method="POST" class="max-w-4xl mx-auto">
                @csrf
                
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
                                @foreach($components['processors'] as $processor)
                                    <option value="{{ $processor->id }}" data-price="{{ $processor->price }}">
                                        {{ $processor->name }} - ${{ number_format($processor->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['motherboards'] as $motherboard)
                                    <option value="{{ $motherboard->id }}" data-price="{{ $motherboard->price }}">
                                        {{ $motherboard->name }} - ${{ number_format($motherboard->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['graphics'] as $graphics)
                                    <option value="{{ $graphics->id }}" data-price="{{ $graphics->price }}">
                                        {{ $graphics->name }} - ${{ number_format($graphics->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['memory'] as $memory)
                                    <option value="{{ $memory->id }}" data-price="{{ $memory->price }}">
                                        {{ $memory->name }} - ${{ number_format($memory->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['storage'] as $storage)
                                    <option value="{{ $storage->id }}" data-price="{{ $storage->price }}">
                                        {{ $storage->name }} - ${{ number_format($storage->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['power'] as $power)
                                    <option value="{{ $power->id }}" data-price="{{ $power->price }}">
                                        {{ $power->name }} - ${{ number_format($power->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['cases'] as $case)
                                    <option value="{{ $case->id }}" data-price="{{ $case->price }}">
                                        {{ $case->name }} - ${{ number_format($case->price, 2) }}
                                    </option>
                                @endforeach
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
                                @foreach($components['cooling'] as $cooling)
                                    <option value="{{ $cooling->id }}" data-price="{{ $cooling->price }}">
                                        {{ $cooling->name }} - ${{ number_format($cooling->price, 2) }}
                                    </option>
                                @endforeach
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
                        @auth
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">
                                Add to Cart
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 inline-block">
                                Login to Continue
                            </a>
                        @endauth
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

    @push('scripts')
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
    @endpush
</x-app-layout> 