<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter Section -->
                    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
                        <div class="flex gap-4 items-center">
                            <form action="{{ route('buy.index') }}" method="GET" class="flex gap-4">
                                <select name="category" class="rounded-md border-gray-300">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="search" placeholder="Search products..." 
                                    value="{{ request('search') }}"
                                    class="rounded-md border-gray-300">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Search
                                </button>
                            </form>
                        </div>
                        @if(auth()->user() && auth()->user()->role_id == 1)
                            <a href="{{ route('buy.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                Add New Product
                            </a>
                        @endif
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                        class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $product->category->name }}</p>
                                    <p class="text-gray-800 mb-2">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-sm text-gray-500 mb-4">Stock: {{ $product->stock_quantity }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        @if(auth()->user() && auth()->user()->role_id == 1)
                                            <div class="flex gap-2">
                                                <a href="{{ route('buy.edit', $product) }}" 
                                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                                    Edit
                                                </a>
                                                <form action="{{ route('buy.destroy', $product) }}" method="POST" 
                                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        @if($product->stock_quantity > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600">
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-red-500">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 