@extends('layouts.customer')

@section('title', 'My Bookings')

@section('subtitle', 'View and manage your train bookings')

@section('header-actions')
    <a href="#" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        New Booking
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Upcoming Bookings -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Upcoming Trips</h3>
            <p class="mt-1 text-sm text-gray-500">Your confirmed and pending bookings</p>
        </div>
        <div class="p-6">
            <!-- Booking Card 1 -->
            <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                            <span class="ml-2 text-sm text-gray-500">Booking ID: #BK001</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Dhaka Express</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">From:</span>
                                <span class="font-medium text-gray-900 ml-1">Dhaka</span>
                            </div>
                            <div>
                                <span class="text-gray-500">To:</span>
                                <span class="font-medium text-gray-900 ml-1">Chittagong</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Date:</span>
                                <span class="font-medium text-gray-900 ml-1">Oct 10, 2025</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Time:</span>
                                <span class="font-medium text-gray-900 ml-1">08:00 AM</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Seat:</span>
                                <span class="font-medium text-gray-900 ml-1">A-12</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Class:</span>
                                <span class="font-medium text-gray-900 ml-1">AC Chair</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="text-2xl font-bold text-gray-900">৳1,500</div>
                        <div class="mt-4 space-x-2">
                            <a href="#" class="text-primary-600 hover:text-primary-900 text-sm font-medium">View Details</a>
                            <a href="#" class="text-red-600 hover:text-red-900 text-sm font-medium">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card 2 -->
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            <span class="ml-2 text-sm text-gray-500">Booking ID: #BK002</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Sylhet Mail</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">From:</span>
                                <span class="font-medium text-gray-900 ml-1">Dhaka</span>
                            </div>
                            <div>
                                <span class="text-gray-500">To:</span>
                                <span class="font-medium text-gray-900 ml-1">Sylhet</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Date:</span>
                                <span class="font-medium text-gray-900 ml-1">Oct 15, 2025</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Time:</span>
                                <span class="font-medium text-gray-900 ml-1">10:30 PM</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Seat:</span>
                                <span class="font-medium text-gray-900 ml-1">B-08</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Class:</span>
                                <span class="font-medium text-gray-900 ml-1">First Class</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="text-2xl font-bold text-gray-900">৳2,200</div>
                        <div class="mt-4 space-x-2">
                            <a href="#" class="text-primary-600 hover:text-primary-900 text-sm font-medium">View Details</a>
                            <a href="#" class="text-red-600 hover:text-red-900 text-sm font-medium">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Search Trains</h3>
                    <p class="text-sm text-gray-500">Find available trains</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Booking History</h3>
                    <p class="text-sm text-gray-500">View past trips</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">My Profile</h3>
                    <p class="text-sm text-gray-500">Update your info</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
