@php
use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CT ZONE') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <!-- Main Navigation -->
        <header class="bg-white shadow-sm">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                            <i class="fas fa-microchip text-indigo-600 text-2xl mr-2"></i>
                            <span class="text-xl font-bold">CT ZONE</span>
                        </a>
                        
                        <!-- Desktop Navigation -->
                        <nav class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:border-indigo-600 hover:text-indigo-600 transition duration-150">
                                Home
                            </a>
                            <a href="{{ route('buy') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-indigo-600 hover:text-indigo-600 transition duration-150">
                                Buy
                            </a>
                            <a href="{{ route('pc-builder') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-indigo-600 hover:text-indigo-600 transition duration-150">
                                Build
                            </a>
                            <a href="{{ route('mining.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:border-indigo-600 hover:text-indigo-600 transition duration-150">
                                Mining
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center">
                        @auth
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="ml-1">Cart</span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">
                                    <i class="fas fa-history"></i>
                                    <span class="ml-1">Orders</span>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">
                                    <i class="fas fa-user"></i>
                                    <span class="ml-1">Profile</span>
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.welcome') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">
                                        <i class="fas fa-user-shield"></i>
                                        <span class="ml-1">Admin</span>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-500 hover:text-indigo-600 transition duration-150">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span class="ml-1">Logout</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-indigo-600 transition duration-150">Login</a>
                            <span class="mx-2 text-gray-300">|</span>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition duration-150">Register</a>
                        @endauth

                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/96171648744" target="_blank" class="ml-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-150 flex items-center">
                            <i class="fab fa-whatsapp text-lg mr-2"></i>
                            <span>Chat with Us</span>
                        </a>
                        
                        <!-- Mobile Menu Button -->
                        <div class="flex items-center md:hidden ml-4">
                            <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Navigation Menu -->
                <div id="mobile-menu" class="hidden md:hidden pb-3">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out">Home</a>
                        <a href="{{ route('buy') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Buy</a>
                        <a href="{{ route('pc-builder') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Build</a>
                        <a href="{{ route('mining.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Mining</a>
                    </div>
                    
                    @auth
                        <div class="pt-4 pb-3 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div>
                                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Cart</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Order History</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Profile</a>
                                <a href="{{ route('profile.custom-builds') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Custom Builds</a>
                                
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.welcome') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Admin Dashboard</a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="py-3 border-t border-gray-200 flex justify-between px-4">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 transition duration-150">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition duration-150">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            @yield('content', $slot ?? '')
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="container mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">About CT ZONE</h3>
                        <p class="text-gray-400 mb-4">We provide high-quality computer products and services to meet all your tech needs.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Products</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('buy') }}" class="hover:text-white transition-colors">Gaming PCs</a></li>
                            <li><a href="{{ route('buy') }}" class="hover:text-white transition-colors">Office PCs</a></li>
                            <li><a href="{{ route('pc-builder') }}" class="hover:text-white transition-colors">PC Parts</a></li>
                            <li><a href="{{ route('buy') }}" class="hover:text-white transition-colors">Accessories</a></li>
                            <li><a href="{{ route('mining.index') }}" class="hover:text-white transition-colors">Mining Equipment</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Services</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">PC Repair</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">PC Building</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Consultation</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                                <span>Lebanon, Tripoli</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-2"></i>
                                <span>+961 71 64 87 44</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>info@ctzone.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} CT ZONE. All rights reserved.</p>
                </div>
            </div>
        </footer>
        
        <!-- AI Chatbot -->
        @include('components.chatbot')

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- Chatbot JS -->
        <script src="{{ asset('js/chatbot.js') }}"></script>
        
        <script>
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                mobileMenu.classList.toggle('hidden');
            });
            
            // Initialize Alpine.js
            document.addEventListener('alpine:init', () => {
                Alpine.data('dropdown', () => ({
                    open: false,
                    toggle() {
                        this.open = !this.open;
                    }
                }));
            });
        </script>
        
        @stack('scripts')
    </body>
</html>
