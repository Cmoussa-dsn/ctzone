<x-app-layout>
    <!-- Hero Banner -->
    <div class="relative">
        <img src="{{ asset('images/buyy.jpeg') }}" class="w-full h-96 object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-indigo-900/70"></div>
        <div class="container mx-auto px-6 absolute inset-0 flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl font-bold mb-4">Premium Pre-built PCs</h1>
                <p class="text-xl mb-6">Browse our collection of high-quality pre-built computers designed for every need.</p>
                <div class="flex space-x-4">
                    <a href="#products" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">View All</a>
                    <a href="{{ route('pc-builder') }}" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">Custom Build</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap items-center justify-between">
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-gray-700">Filter Products</h2>
                </div>
                <div class="flex flex-wrap gap-4">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Categories</option>
                        <option value="gaming">Gaming PCs</option>
                        <option value="office">Office PCs</option>
                        <option value="custom">Custom Builds</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Price Range</option>
                        <option value="0-500">Under $500</option>
                        <option value="500-1000">$500 - $1000</option>
                        <option value="1000-2000">$1000 - $2000</option>
                        <option value="2000+">$2000+</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="newest">Newest</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div id="products" class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold mb-10 text-center">Our Pre-built PCs</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($products as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg transition-transform hover:-translate-y-1 hover:shadow-xl duration-300">
                    <div class="relative">
                        @php
                            $productImages = [
                                'Gaming PC' => 'i713thgen4070.jpg',
                                'Gaming PC Pro' => 'ryzen75800x4080.jpg',
                                'Office PC' => 'i512thgen.jpg',
                                'Office PC Basic' => 'i312th1650.jpg',
                                'RTX 4080' => 'Gigabyte_889523033975.jpg',
                                'Intel Core i9' => 'i99thgen.jpg',
                                'RAM Kit' => 'Kingston_740617331875.jpg',
                                'Gaming Monitor' => 'levant-odyssey-g3-g32a-ls24ag320nmxzn-530529286-300x214.webp',
                                'Mechanical Keyboard' => 'software.jpg',
                                'Gaming Mouse' => 'ASUS.jpeg'
                            ];
                            
                            $imageName = isset($productImages[$product->name]) ? $productImages[$product->name] : 'default-pc.jpg';
                        @endphp
                        
                        <img src="{{ asset('images/' . $imageName) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-56 object-cover">
                        @if($product->stock_quantity < 5 && $product->stock_quantity > 0)
                            <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">Limited Stock</span>
                        @elseif($product->stock_quantity == 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Out of Stock</span>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                            <span class="text-lg font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">{{ $product->category->name }}</p>
                        <p class="text-gray-700 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">View Details</a>
                            
                            @auth
                                <button 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 {{ $product->stock_quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    onclick="addToCart({{ $product->id }})"
                                    {{ $product->stock_quantity == 0 ? 'disabled' : '' }}
                                >
                                    {{ $product->stock_quantity == 0 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">Login to Buy</a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Products Found</h3>
                    <p class="text-gray-500">We couldn't find any products matching your criteria.</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        function addToCart(productId) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Create a notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out';
                    notification.innerHTML = '<div class="flex items-center"><svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Product added to cart!</div>';
                    document.body.appendChild(notification);
                    
                    // Automatically remove after 3 seconds
                    setTimeout(() => {
                        notification.classList.add('opacity-0');
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 3000);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to cart.');
            });
        }
    </script>
    @endpush
</x-app-layout> 