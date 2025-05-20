<x-app-layout>
    <!-- Cart Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-6 py-10">
            <h1 class="text-3xl font-bold">Your Shopping Cart</h1>
            <p class="mt-2">Review your items and proceed to checkout when ready.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        @if($cartItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <h2 class="text-xl font-semibold mb-4">Cart Items ({{ $cartItems->count() }})</h2>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="flex flex-col sm:flex-row py-4 items-center">
                                    <div class="w-full sm:w-24 h-24 mb-4 sm:mb-0">
                                        @if($item->product->type == 'custom_pc')
                                            <img src="{{ asset('images/default-pc.jpg') }}" 
                                                alt="{{ $item->product->name }}" 
                                                class="w-full h-full object-cover rounded">
                                        @else
                                            <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/default-pc.jpg') }}" 
                                                alt="{{ $item->product->name }}" 
                                                class="w-full h-full object-cover rounded">
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 px-4">
                                        <h3 class="font-semibold text-lg">{{ $item->product->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($item->product->description, 60) }}</p>
                                        
                                        @if($item->product->type == 'custom_pc' && session()->has('custom_pc'))
                                            <div class="mt-2 text-xs text-gray-500">
                                                <p>Custom PC with selected components</p>
                                            </div>
                                        @endif
                                        
                                        @if($item->product->is_mining_product)
                                            <div class="mt-2 text-xs text-gray-500">
                                                <p>Mining product</p>
                                            </div>
                                        @endif
                                        
                                        <p class="text-indigo-600 font-semibold mt-1">${{ number_format($item->product->price, 2) }}</p>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 mt-4 sm:mt-0">
                                        <div class="flex items-center border border-gray-300 rounded-md">
                                            <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-l-md transition" 
                                                onclick="updateQuantity({{ $item->id }}, -1)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="px-3 py-1">{{ $item->quantity }}</span>
                                            <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 rounded-r-md transition" 
                                                onclick="updateQuantity({{ $item->id }}, 1)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <a href="{{ route('cart.remove', $item->id) }}" 
                                            class="ml-2 text-red-500 hover:text-red-700 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('buy') }}" class="text-indigo-600 hover:text-indigo-800 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span>${{ number_format($total * 0.1, 2) }}</span>
                            </div>
                            <div class="border-t pt-3 mt-3">
                                <div class="flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span id="total-price" class="text-indigo-600">${{ number_format($total * 1.1, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="openCheckoutModal()" 
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div id="checkout-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-screen overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold">Checkout</h2>
                            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Steps Indicator -->
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex flex-col items-center">
                                <div class="step-circle active" data-step="1">1</div>
                                <span class="text-sm mt-1">Contact</span>
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2">
                                <div class="step-line" id="line-1-2"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="step-circle" data-step="2">2</div>
                                <span class="text-sm mt-1">Shipping</span>
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2">
                                <div class="step-line" id="line-2-3"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="step-circle" data-step="3">3</div>
                                <span class="text-sm mt-1">Payment</span>
                            </div>
                            <div class="flex-1 h-1 bg-gray-200 mx-2">
                                <div class="step-line" id="line-3-4"></div>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="step-circle" data-step="4">4</div>
                                <span class="text-sm mt-1">Complete</span>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="step-content active" id="step-1">
                            <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" id="fullName" placeholder="Enter your full name" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="email" placeholder="Enter your email address" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" placeholder="Enter your phone number" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="pt-4">
                                    <button onclick="nextStep(2)" 
                                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300">
                                        Continue to Shipping
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="step-content hidden" id="step-2">
                            <h3 class="text-xl font-semibold mb-4">Shipping Address</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" id="address" placeholder="Enter your street address" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" id="city" placeholder="Enter your city" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                        <input type="text" id="state" placeholder="Enter your state/province" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </div>
                                <div>
                                    <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code</label>
                                    <input type="text" id="zip" placeholder="Enter your zip/postal code" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="pt-4 flex justify-between">
                                    <button onclick="prevStep(1)" 
                                        class="py-3 px-6 border border-gray-300 bg-white text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition duration-300">
                                        Back
                                    </button>
                                    <button onclick="nextStep(3)" 
                                        class="py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300">
                                        Continue to Payment
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="step-content hidden" id="step-3">
                            <h3 class="text-xl font-semibold mb-4">Payment Method</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                        <input type="radio" name="payment" value="card" class="hidden" checked>
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span>Credit Card</span>
                                        </div>
                                        <div class="absolute top-2 right-2 w-4 h-4 bg-indigo-600 rounded-full payment-indicator"></div>
                                    </label>
                                    <label class="relative p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                        <input type="radio" name="payment" value="paypal" class="hidden">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            <span>PayPal</span>
                                        </div>
                                        <div class="absolute top-2 right-2 w-4 h-4 bg-indigo-600 rounded-full payment-indicator hidden"></div>
                                    </label>
                                    <label class="relative p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                        <input type="radio" name="payment" value="cod" class="hidden">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            <span>Cash on Delivery</span>
                                        </div>
                                        <div class="absolute top-2 right-2 w-4 h-4 bg-indigo-600 rounded-full payment-indicator hidden"></div>
                                    </label>
                                </div>
                                
                                <div class="pt-4 flex justify-between">
                                    <button onclick="prevStep(2)" 
                                        class="py-3 px-6 border border-gray-300 bg-white text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition duration-300">
                                        Back
                                    </button>
                                    <button onclick="confirmOrder()" 
                                        class="py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300">
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Order Complete -->
                        <div class="step-content hidden" id="step-4">
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Thank You!</h3>
                                <p class="text-gray-600 mb-1">Your order has been placed successfully.</p>
                                <p id="order-number" class="text-indigo-600 font-semibold mb-6"></p>
                                <button onclick="viewOrders()" 
                                    class="py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300">
                                    View Orders
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">It looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('buy') }}" 
                    class="inline-block py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition duration-300">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
    
    <style>
        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .step-circle.active {
            background-color: #4f46e5;
            color: white;
        }
        
        .step-circle.completed {
            background-color: #4f46e5;
            color: white;
        }
        
        .step-line {
            height: 100%;
            width: 0;
            background-color: #4f46e5;
            transition: width 0.5s ease;
        }
        
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
        }
    </style>
    
    @push('scripts')
    <script>
        // Modal functionality
        function openCheckoutModal() {
            document.getElementById('checkout-modal').classList.remove('hidden');
            document.getElementById('checkout-modal').classList.add('flex');
        }
        
        function closeModal() {
            document.getElementById('checkout-modal').classList.add('hidden');
            document.getElementById('checkout-modal').classList.remove('flex');
        }
        
        // Steps navigation
        function nextStep(step) {
            // Hide all step contents
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            
            // Update step circles
            document.querySelectorAll('.step-circle').forEach((circle, index) => {
                if (index + 1 < step) {
                    circle.classList.add('completed');
                    circle.classList.add('active');
                } else if (index + 1 === step) {
                    circle.classList.add('active');
                } else {
                    circle.classList.remove('active');
                }
            });
            
            // Update step lines
            for (let i = 1; i < step; i++) {
                document.getElementById(`line-${i}-${i+1}`).style.width = '100%';
            }
            
            // Show current step content
            document.getElementById('step-' + step).classList.remove('hidden');
            document.getElementById('step-' + step).classList.add('active');
        }
        
        function prevStep(step) {
            nextStep(step);
        }
        
        // Update quantity
        function updateQuantity(cartId, change) {
            const quantityElement = event.target.closest('.border').querySelector('span');
            const currentQty = parseInt(quantityElement.textContent);
            const newQty = currentQty + change;
            
            if (newQty < 1) {
                return;
            }
            
            fetch('{{ route('cart.update-quantity') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: newQty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the UI
                    quantityElement.textContent = newQty;
                    // Reload the page to update the total
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the quantity.');
            });
        }
        
        // Payment option selection
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Hide all indicators
                document.querySelectorAll('.payment-indicator').forEach(indicator => {
                    indicator.classList.add('hidden');
                });
                
                // Show indicator for selected option
                this.closest('label').querySelector('.payment-indicator').classList.remove('hidden');
            });
        });
        
        // Place order
        function confirmOrder() {
            // Collect form data
            const orderData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                state: document.getElementById('state').value,
                zip: document.getElementById('zip').value,
                paymentMethod: document.querySelector('input[name="payment"]:checked').value
            }
            
            fetch('{{ route('checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('order-number').textContent = `Order #${data.order_id}`;
                    nextStep(4);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing your order.');
            });
        }
        
        // View orders
        function viewOrders() {
            window.location.href = '{{ route('orders.index') }}';
        }
        
        // Initialize payment indicator for default selection
        document.querySelector('.payment-indicator').classList.remove('hidden');
    </script>
    @endpush
</x-app-layout> 