@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Our Products</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image</span>
                    </div>
                @endif
                
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 mb-2 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-gray-500">Stock: {{ $product->stock_quantity }}</span>
                    </div>
                    
                    @if($product->stock_quantity > 0)
                        <form action="{{ route('cart.add', ['product' => $product->id]) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="flex items-center gap-2 mb-3">
                                <label for="quantity" class="text-sm">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                    class="w-20 rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>
                            <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full mt-4 bg-gray-400 text-white font-semibold py-2 px-4 rounded cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection 