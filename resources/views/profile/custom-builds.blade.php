<x-app-layout>
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-6 py-10">
            <h1 class="text-3xl font-bold">Your Custom PC Builds</h1>
            <p class="mt-2">View and manage your custom-built PC configurations.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="flex mb-6">
            <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:text-indigo-800 transition flex items-center mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Profile
            </a>
            <a href="{{ route('pc-builder') }}" class="text-indigo-600 hover:text-indigo-800 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Build New PC
            </a>
        </div>

        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-4">In Your Cart</h2>
            @if($cartCustomPCs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($cartCustomPCs as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="{{ asset('images/default-pc.jpg') }}" 
                                    alt="{{ $item->product->name }}" 
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    In Cart
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ $item->product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-600 font-bold">${{ number_format($item->product->price, 2) }}</span>
                                    <a href="{{ route('cart.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                        View in Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">You don't have any custom PCs in your cart.</p>
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-4">Your Purchased Builds</h2>
            @if($orderCustomPCs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($orderCustomPCs as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="{{ asset('images/default-pc.jpg') }}" 
                                    alt="{{ $item->product->name }}" 
                                    class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                    {{ ucfirst($item->order->status) }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ $item->product->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-indigo-600 font-bold">${{ number_format($item->product->price, 2) }}</span>
                                    <a href="{{ route('orders.show', $item->order) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                        View Order
                                    </a>
                                </div>
                                <div class="mt-2 text-sm text-gray-500">
                                    Ordered: {{ $item->order->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">You haven't purchased any custom PCs yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 