<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-900 to-indigo-800 text-white">
        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
        <div class="container mx-auto px-6 py-24 md:py-32 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Expert PC Solutions For Every Need</h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">Premium computer builds, parts, and repair services at competitive prices.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('pc-builder') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300">Build Your PC</a>
                    <a href="{{ route('buy') }}" class="px-6 py-3 bg-white hover:bg-gray-100 rounded-lg text-indigo-700 font-semibold transition duration-300">Shop Pre-Built PCs</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Premium PC Solutions</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover our range of high-performance computers and components tailored to your needs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="bg-blue-600 p-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Hardware Repair</h3>
                    <p class="mb-4">Expert diagnostics and repair for all computer hardware issues.</p>
                </div>
                <div class="p-6 bg-white">
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Component replacement
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Performance optimization
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Hardware diagnostics
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="bg-indigo-600 p-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.586 6L14 0.414A2 2 0 0012.586 0H10a2 2 0 00-2 2zm7.586 2H14V0.414L19.586 6H17.586z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Custom PC Builds</h3>
                    <p class="mb-4">Tailor-made computers designed for your specific needs and budget.</p>
                </div>
                <div class="p-6 bg-white">
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Gaming systems
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Workstations
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Custom configurations
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="bg-purple-600 p-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947z" clip-rule="evenodd" />
                        <path d="M10 13a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Software Solutions</h3>
                    <p class="mb-4">Comprehensive software services to keep your system running smoothly.</p>
                </div>
                <div class="p-6 bg-white">
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            OS installation
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Virus removal
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Data recovery
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gray-100">
        <div class="container mx-auto px-6 py-16">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h2 class="text-3xl font-bold mb-4">Ready to upgrade your computing experience?</h2>
                    <p class="text-gray-600 mb-6">Our team of experts is ready to help you find the perfect PC solution for your needs.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300">Get Started</a>
                        <a href="#contact-form" class="px-6 py-3 border border-indigo-600 hover:bg-indigo-50 rounded-lg text-indigo-600 font-semibold transition duration-300">Contact Us</a>
                    </div>
                </div>
                <div class="md:w-5/12">
                    <img src="{{ asset('images/gpu.webp') }}" alt="Modern PC Components" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div id="contact-form" class="container mx-auto px-6 py-16">
        <div class="max-w-xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Get in Touch</h2>
            <p class="text-gray-600">Have questions? Reach out to our team for personalized assistance.</p>
        </div>

        <form method="POST" action="{{ route('home') }}" class="max-w-xl mx-auto">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-semibold transition duration-300">Send Message</button>
            </div>
        </form>
    </div>

    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</x-app-layout> 