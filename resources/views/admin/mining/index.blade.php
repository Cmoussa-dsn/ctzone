@extends('admin.layout')
@section('title', 'Mining Products')
@section('content')
    <div class="relative max-w-6xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-blue-700">Mining Products</h1>
                <a href="{{ route('admin.mining.create') }}" class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition font-semibold text-lg">
                    <i class="fas fa-plus"></i> Add Mining Product
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Algorithm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hashrate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power (W)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($miningProducts as $product)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $product->algorithm }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $product->hashrate }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $product->power_consumption }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-blue-700 font-bold">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock_quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.mining.edit', $product->id) }}" class="inline-block text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</a>
                                    <form action="{{ route('admin.mining.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this mining product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block text-red-600 hover:text-red-900 font-semibold bg-transparent border-none cursor-pointer">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No mining products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $miningProducts->links() }}
            </div>
        </div>
    </div>
@endsection 