@extends('layouts.app')

@section('title', 'Welcome - Railway Management System')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Train Image Background -->
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover opacity-15" src="https://images.unsplash.com/photo-1474487548417-781cb71495f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Modern Train">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 lg:py-36">
        <div class="text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white mb-8">
                <svg class="w-5 h-5 mr-2 text-primary-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold">Trusted by thousands of travelers</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight text-white mb-6">
                <span class="block">Welcome to</span>
                <span class="block bg-clip-text text-transparent bg-gradient-to-r from-primary-100 to-white mt-2">
                    Railway Management System
                </span>
            </h1>

            <!-- Subheading -->
            <p class="mt-6 max-w-3xl mx-auto text-lg sm:text-xl lg:text-2xl text-primary-50 leading-relaxed font-light">
                Book your train tickets online with ease. Fast, reliable, and secure railway booking system for all your travel needs <span class="font-semibold">across Bangladesh.</span>
            </p>

            <!-- CTA Buttons -->
            <div class="mt-12 flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="#features" class="group inline-flex items-center justify-center px-10 py-5 text-base font-bold rounded-xl text-primary-700 bg-white hover:bg-primary-50 shadow-2xl hover:shadow-primary-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search Trains
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#" class="group inline-flex items-center justify-center px-10 py-5 border-2 border-white/80 text-base font-bold rounded-xl text-white bg-white/5 backdrop-blur-sm hover:bg-white hover:text-primary-700 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Book
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 grid grid-cols-2 gap-6 sm:grid-cols-4 lg:gap-8">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl sm:text-4xl font-bold text-white">50K+</div>
                    <div class="mt-2 text-sm sm:text-base text-primary-100">Happy Travelers</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl sm:text-4xl font-bold text-white">100+</div>
                    <div class="mt-2 text-sm sm:text-base text-primary-100">Train Routes</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl sm:text-4xl font-bold text-white">24/7</div>
                    <div class="mt-2 text-sm sm:text-base text-primary-100">Support</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl sm:text-4xl font-bold text-white">99.9%</div>
                    <div class="mt-2 text-sm sm:text-base text-primary-100">Uptime</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Wave -->
    <div class="absolute bottom-0 left-0 right-0 -mb-1">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-16 sm:h-20">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>
</div>


<!-- Features Section -->
<div class="py-20 bg-gray-50" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold tracking-wide uppercase mb-4">
                Features
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 mb-6">
                Better way to book tickets
            </h2>
            <p class="mt-4 max-w-3xl mx-auto text-lg sm:text-xl text-gray-600 leading-relaxed">
                Experience seamless railway booking with our modern platform designed for your convenience
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
            <!-- Feature 1: Fast Booking -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Fast Booking</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Book your tickets in just a few clicks with our streamlined process. Save time and travel hassle-free.
                    </p>
                </div>
            </div>

            <!-- Feature 2: Secure Payment -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-green-600 via-green-500 to-emerald-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Secure Payment</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Your transactions are protected with industry-standard encryption and secure payment gateways.
                    </p>
                </div>
            </div>

            <!-- Feature 3: 24/7 Support -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 via-purple-500 to-indigo-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">24/7 Support</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Get help anytime with our round-the-clock customer support team ready to assist you.
                    </p>
                </div>
            </div>

            <!-- Feature 4: Easy Cancellation -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-amber-600 via-yellow-500 to-orange-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Easy Cancellation</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Cancel or modify your bookings with our flexible policies. Hassle-free refund process.
                    </p>
                </div>
            </div>

            <!-- Feature 5: Mobile Friendly -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 via-rose-500 to-red-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Friendly</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Access and manage your bookings on any device, anywhere, anytime with our responsive design.
                    </p>
                </div>
            </div>

            <!-- Feature 6: Real-time Updates -->
            <div class="group relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-600 via-teal-500 to-blue-400 rounded-3xl blur-lg opacity-25 group-hover:opacity-40 transition duration-300"></div>
                <div class="relative h-full bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-600 text-white mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Real-time Updates</h3>
                    <p class="text-base text-gray-600 leading-relaxed">
                        Stay informed with live train status, schedule updates, and instant booking confirmations.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Call to Action Section -->
<div class="relative py-20 overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Icon -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm border-2 border-white/40">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
        </div>

        <!-- Heading -->
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-6">
            Ready to start your journey?
        </h2>
        
        <!-- Subheading -->
        <p class="mt-6 text-lg sm:text-xl text-primary-50 max-w-3xl mx-auto leading-relaxed mb-12">
            Join <span class="font-bold text-white">thousands of satisfied travelers</span> who trust us for their railway bookings. Book your next trip with confidence.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
            <a href="/register" class="group inline-flex items-center justify-center px-10 py-5 text-base font-bold rounded-xl text-primary-700 bg-white hover:bg-primary-50 shadow-2xl hover:shadow-white/50 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                <span>Create Account</span>
                <svg class="ml-3 -mr-1 w-6 h-6 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
            <a href="/contact" class="group inline-flex items-center justify-center px-10 py-5 border-2 border-white/80 text-base font-bold rounded-xl text-white bg-white/10 backdrop-blur-sm hover:bg-white/20 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Contact Support</span>
            </a>
        </div>

        <!-- Trust Badges -->
        <div class="mt-16 flex flex-wrap justify-center items-center gap-8 opacity-80">
            <div class="flex items-center space-x-2 text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold">Secure & Trusted</span>
            </div>
            <div class="flex items-center space-x-2 text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                <span class="text-sm font-semibold">50,000+ Users</span>
            </div>
            <div class="flex items-center space-x-2 text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold">24/7 Available</span>
            </div>
        </div>
    </div>
</div>
@endsection
