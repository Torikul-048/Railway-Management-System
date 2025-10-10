@extends('layouts.app')

@section('title', 'About Us - Railway Management System')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    About Railway MS
                </h1>
                <p class="mt-4 text-xl text-primary-100">
                    Your trusted partner for railway booking and management
                </p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-primary-600 font-semibold tracking-wide uppercase">Our Mission</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Revolutionizing Railway Travel
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                We're committed to providing the most efficient, reliable, and user-friendly railway booking experience. 
                Our platform connects millions of travelers with their destinations seamlessly.
            </p>
        </div>

        <!-- Features -->
        <div class="mt-16">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Fast Booking</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Book your tickets in seconds with our streamlined booking process. No hassle, no delays.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Secure Payments</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Your transactions are protected with bank-level security and encryption.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Real-time Updates</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Get instant notifications about train schedules, delays, and platform changes.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Easy Refunds</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Cancel your tickets anytime and get instant refunds based on our transparent policy.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">24/7 Support</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Our dedicated customer support team is always ready to assist you.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Smart Analytics</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Track your travel history and get personalized recommendations.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-primary-600 mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <div class="text-center">
                    <p class="text-5xl font-extrabold text-white">1M+</p>
                    <p class="mt-2 text-lg text-primary-100">Happy Travelers</p>
                </div>
                <div class="mt-10 text-center lg:mt-0">
                    <p class="text-5xl font-extrabold text-white">500+</p>
                    <p class="mt-2 text-lg text-primary-100">Train Routes</p>
                </div>
                <div class="mt-10 text-center lg:mt-0">
                    <p class="text-5xl font-extrabold text-white">99.9%</p>
                    <p class="mt-2 text-lg text-primary-100">Uptime</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="bg-primary-700 rounded-lg shadow-xl overflow-hidden lg:grid lg:grid-cols-2 lg:gap-4">
                <div class="pt-10 pb-12 px-6 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
                    <div class="lg:self-center">
                        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                            <span class="block">Ready to get started?</span>
                        </h2>
                        <p class="mt-4 text-lg leading-6 text-primary-100">
                            Join millions of travelers who trust Railway MS for their journey. Book your first ticket today!
                        </p>
                        <a href="{{ route('trains.search') }}" class="mt-8 bg-white border border-transparent rounded-md shadow px-6 py-3 inline-flex items-center text-base font-medium text-primary-600 hover:bg-primary-50">
                            Search Trains
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="relative pb-3/5 -mt-6 md:pb-1/2 lg:pb-full">
                    <img class="absolute inset-0 w-full h-full transform translate-x-6 translate-y-6 rounded-md object-cover object-left-top sm:translate-x-16 lg:translate-y-20" src="https://images.unsplash.com/photo-1554990349-170b9e4bdf3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Railway">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
