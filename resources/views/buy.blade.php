<x-app-layout>
    <!-- Hero Banner -->
    <div class="relative">
        <img src="{{ asset('images/buyy.jpeg') }}" class="w-full h-96 object-cover brightness-75">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-indigo-900/70"></div>
        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
        <div class="container mx-auto px-6 absolute inset-0 flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Shop for PC Products</h1>
                <p class="text-xl mb-6">Browse our collection of high-quality computers and components designed for every need.</p>
                <div class="flex space-x-4">
                    <a href="#prebuilt" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">Pre-built PCs</a>
                    <a href="#components" class="bg-indigo-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-600 transition duration-300">Components</a>
                    <a href="{{ route('pc-builder') }}" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">Custom Build</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-6">
            <form id="filter-form" action="{{ route('buy') }}" method="GET" class="flex flex-wrap items-center justify-between">
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <h2 class="text-lg font-semibold text-gray-700">Filter Products</h2>
                </div>
                <div class="flex flex-wrap gap-4">
                    <select id="category-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">All Categories</option>
                        <option value="prebuilt">Pre-built PCs</option>
                        <option value="components">Components</option>
                    </select>
                    <select name="price_range" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                        <option value="">Price Range</option>
                        <option value="0-500" {{ isset($priceRange) && $priceRange == '0-500' ? 'selected' : '' }}>Under $500</option>
                        <option value="500-1000" {{ isset($priceRange) && $priceRange == '500-1000' ? 'selected' : '' }}>$500 - $1000</option>
                        <option value="1000-2000" {{ isset($priceRange) && $priceRange == '1000-2000' ? 'selected' : '' }}>$1000 - $2000</option>
                        <option value="2000-0" {{ isset($priceRange) && $priceRange == '2000-0' ? 'selected' : '' }}>$2000+</option>
                    </select>
                    <select name="sort_by" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                        <option value="featured" {{ (isset($sortBy) && $sortBy == 'featured') || !isset($sortBy) ? 'selected' : '' }}>Featured</option>
                        <option value="price-low" {{ isset($sortBy) && $sortBy == 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-high" {{ isset($sortBy) && $sortBy == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="newest" {{ isset($sortBy) && $sortBy == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Pre-built PCs Section -->
    <div id="prebuilt" class="container mx-auto px-6 py-16 section-container" data-category="prebuilt">
        <h2 class="text-3xl font-bold mb-10 text-center">Pre-built PCs</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($preBuiltPCs as $product)
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
                        @endphp
                        
                        <!-- First check if the product has a database image, if not fall back to the hardcoded mapping -->
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-56 object-cover">
                        @else
                            @php
                                $imageName = isset($productImages[$product->name]) ? $productImages[$product->name] : 'default-pc.jpg';
                            @endphp
                            <img src="{{ asset('images/' . $imageName) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-56 object-cover">
                        @endif
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
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Pre-built PCs Found</h3>
                    <p class="text-gray-500">We couldn't find any pre-built computers matching your criteria.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Components Section -->
    <div id="components" class="container mx-auto px-6 py-16 bg-gray-50 section-container" data-category="components">
        <h2 class="text-3xl font-bold mb-10 text-center">PC Components</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($components as $product)
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
                        @endphp
                        
                        <!-- First check if the product has a database image, if not fall back to the hardcoded mapping -->
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-48 object-cover">
                        @else
                            @php
                                $imageName = isset($productImages[$product->name]) ? $productImages[$product->name] : 'default-component.jpg';
                            @endphp
                            <img src="{{ asset('images/' . $imageName) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-48 object-cover">
                        @endif
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
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Components Found</h3>
                    <p class="text-gray-500">We couldn't find any PC components matching your criteria.</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('category-filter');
            const sections = document.querySelectorAll('.section-container');
            const filterForm = document.getElementById('filter-form');
            
            // Set initial category based on URL parameter if present
            const urlParams = new URLSearchParams(window.location.search);
            const categoryParam = urlParams.get('category');
            
            if (categoryParam) {
                categoryFilter.value = categoryParam;
                
                // Apply initial visibility
                sections.forEach(section => {
                    if (categoryParam === 'all' || section.dataset.category === categoryParam) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }
            
            categoryFilter.addEventListener('change', function() {
                const selectedValue = this.value;
                
                // Create hidden input for the category
                let categoryInput = filterForm.querySelector('input[name="category"]');
                if (!categoryInput) {
                    categoryInput = document.createElement('input');
                    categoryInput.type = 'hidden';
                    categoryInput.name = 'category';
                    filterForm.appendChild(categoryInput);
                }
                categoryInput.value = selectedValue;
                
                // Update UI immediately for better UX
                sections.forEach(section => {
                    if (selectedValue === 'all' || section.dataset.category === selectedValue) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
                
                // Scroll to the relevant section if not "all"
                if (selectedValue !== 'all') {
                    const targetSection = document.querySelector(`[data-category="${selectedValue}"]`);
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: 'smooth' });
                    }
                }
                
                // Submit the form to apply filters
                filterForm.submit();
            });
        });
        
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

    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</x-app-layout> 