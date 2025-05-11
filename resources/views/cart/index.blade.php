@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            @foreach($cartItems as $item)
                <div class="flex items-center justify-between border-b py-4 {{ !$loop->last ? 'border-gray-200' : 'border-transparent' }}">
                    <div class="flex items-center space-x-4">
                        @if($item->product->image)
                            <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" 
                                class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-500 text-sm">No image</span>
                            </div>
                        @endif
                        
                        <div>
                            <h3 class="text-lg font-semibold">{{ $item->product->name }}</h3>
                            <p class="text-gray-600">${{ number_format($item->product->price, 2) }} each</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                max="{{ $item->product->stock_quantity }}"
                                class="w-20 rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">
                                Update
                            </button>
                        </form>

                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Remove
                            </button>
                        </form>

                        <span class="font-semibold">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 flex justify-between items-center">
                <div>
                    <span class="text-lg">Total:</span>
                    <span class="text-2xl font-bold ml-2">${{ number_format($total, 2) }}</span>
                </div>

                <div class="space-x-4">
                    <a href="{{ route('products.index') }}" 
                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                        Continue Shopping
                    </a>
                    <a href="{{ route('checkout.index') }}" 
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600 mb-4">Your cart is empty</p>
            <a href="{{ route('products.index') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection 