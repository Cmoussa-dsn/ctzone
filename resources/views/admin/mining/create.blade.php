@extends('admin.layout')
@section('title', 'Add Mining Product')
@section('content')
    <div class="max-w-xl mx-auto">
        <div class="glass p-8 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold text-blue-700 mb-6">Add New Mining Product</h1>
            
            <!-- Product Type Selection for easier form filling -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Product Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="product_type_selector" value="miner" class="form-radio text-blue-600" checked>
                        <span class="ml-2">Mining Device</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="product_type_selector" value="accessory" class="form-radio text-blue-600">
                        <span class="ml-2">Accessory</span>
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Select "Accessory" for mining frames, PSUs, cooling systems, etc.</p>
            </div>
            
            <form action="{{ route('admin.mining.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mining specific fields -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Algorithm</label>
                    <select name="algorithm" id="algorithm" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Select an algorithm</option>
                        @foreach($algorithms as $value => $label)
                            <option value="{{ $value }}" {{ old('algorithm') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('algorithm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Hashrate (with unit, e.g. "100 TH/s" or "N/A" for accessories)</label>
                    <input type="text" name="hashrate" id="hashrate" value="{{ old('hashrate') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <p class="text-sm text-gray-500 mt-1">For accessories, enter "N/A"</p>
                    @error('hashrate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Power Consumption (watts)</label>
                    <input type="number" name="power_consumption" id="power_consumption" value="{{ old('power_consumption') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                    <p class="text-sm text-gray-500 mt-1">For accessories with no power usage, enter 0</p>
                    @error('power_consumption')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4" id="profit_estimate_field">
                    <label class="block text-gray-700 font-semibold mb-2">Daily Profit Estimate (USD)</label>
                    <input type="number" step="0.01" name="daily_profit_estimate" id="daily_profit_estimate" value="{{ old('daily_profit_estimate') }}" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Leave at 0 for accessories</p>
                    @error('daily_profit_estimate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center text-gray-700 font-semibold">
                        <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="mr-2 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        Featured Product
                    </label>
                    @error('featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    <input type="file" name="image" class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-between items-center">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">Add Product</button>
                    <a href="{{ route('admin.mining.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productTypeSelector = document.querySelectorAll('input[name="product_type_selector"]');
            const algorithmField = document.getElementById('algorithm');
            const hashrateField = document.getElementById('hashrate');
            const powerConsumptionField = document.getElementById('power_consumption');
            const profitEstimateField = document.getElementById('daily_profit_estimate');
            
            // Function to set values for accessories
            function setupForAccessory() {
                // Set algorithm to N/A
                for (let i = 0; i < algorithmField.options.length; i++) {
                    if (algorithmField.options[i].value === 'N/A') {
                        algorithmField.selectedIndex = i;
                        break;
                    }
                }
                
                // Set hashrate to N/A
                hashrateField.value = 'N/A';
                
                // Set power consumption to 0 by default (can be changed)
                if (!powerConsumptionField.value) {
                    powerConsumptionField.value = '0';
                }
                
                // Set profit estimate to 0
                profitEstimateField.value = '0';
                
                // Hide profit estimate field (it will still be submitted)
                document.getElementById('profit_estimate_field').style.display = 'none';
            }
            
            // Function to reset fields for mining devices
            function setupForMiner() {
                // Reset algorithm if it was set to N/A
                if (algorithmField.value === 'N/A') {
                    algorithmField.selectedIndex = 0;
                }
                
                // Reset hashrate if it was N/A
                if (hashrateField.value === 'N/A') {
                    hashrateField.value = '';
                }
                
                // Show profit estimate field
                document.getElementById('profit_estimate_field').style.display = 'block';
            }
            
            // Add event listeners to radio buttons
            productTypeSelector.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'accessory') {
                        setupForAccessory();
                    } else {
                        setupForMiner();
                    }
                });
            });
            
            // Initialize based on selection
            if (document.querySelector('input[name="product_type_selector"]:checked').value === 'accessory') {
                setupForAccessory();
            }
        });
    </script>
@endsection 