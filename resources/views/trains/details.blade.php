@extends('layouts.app')

@section('title', $train->name . ' - Train Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('trains.search') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Search
            </a>
        </div>

        <!-- Train Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-8 mb-6 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $train->name }}</h1>
                    <div class="flex items-center gap-4 text-blue-100">
                        <span class="text-lg font-medium">Train #{{ $train->train_number }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                            {{ ucfirst($train->type) }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-blue-100 mb-1">Starting from</p>
                    <p class="text-4xl font-bold">৳{{ number_format($train->fare_per_seat, 2) }}</p>
                    <p class="text-sm text-blue-100">per seat</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Journey Information -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Journey Details</h2>
                    
                    <div class="space-y-6">
                        <!-- Route -->
                        <div class="flex items-center gap-6">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-center">
                                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ \Carbon\Carbon::parse($train->departure_time)->format('H:i') }}</p>
                                        <p class="text-sm text-gray-600 mb-1">Departure</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $train->source_station }}</p>
                                    </div>
                                    
                                    <div class="flex-1 flex flex-col items-center px-4">
                                        <div class="w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full mb-2"></div>
                                        <p class="text-sm text-gray-600 font-medium">
                                            {{ \Carbon\Carbon::parse($train->departure_time)->diffForHumans(\Carbon\Carbon::parse($train->arrival_time), true) }}
                                        </p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ \Carbon\Carbon::parse($train->arrival_time)->format('H:i') }}</p>
                                        <p class="text-sm text-gray-600 mb-1">Arrival</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $train->destination_station }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Route Name -->
                        @if($train->route)
                            <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Route</p>
                                    <p class="font-semibold text-gray-900">{{ $train->route }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seat Information -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Seat Availability</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Total Seats</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $train->total_seats }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-1">Available Seats</p>
                            <p class="text-3xl font-bold text-green-600">{{ $train->available_seats }}</p>
                        </div>
                    </div>

                    <!-- Seat Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Booking Progress</span>
                            <span>{{ round(($train->total_seats - $train->available_seats) / $train->total_seats * 100) }}% Booked</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-500"
                                 style="width: {{ round(($train->total_seats - $train->available_seats) / $train->total_seats * 100) }}%"></div>
                        </div>
                    </div>

                    @if($train->seat_configuration)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-3">Seat Configuration</p>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($train->seat_configuration as $class => $count)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">{{ ucwords(str_replace('_', ' ', $class)) }}:</span>
                                        <span class="font-semibold text-gray-900">{{ $count }} seats</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Facilities & Amenities -->
                @if($train->facilities && count($train->facilities) > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Facilities & Amenities</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($train->facilities as $facility)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">{{ $facility }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                @if($train->description)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Train</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $train->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Booking Card -->
                <div class="bg-white rounded-xl shadow-md p-6 ">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Book Your Tickets</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Fare per Seat</span>
                            <span class="text-xl font-bold text-gray-900">৳{{ number_format($train->fare_per_seat, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600">Available Seats</span>
                            <span class="text-lg font-semibold text-green-600">{{ $train->available_seats }}</span>
                        </div>
                    </div>

                    @if($train->available_seats > 0)
                        @auth
                            <form method="GET" action="{{ route('bookings.select-seats', $train) }}" id="booking-form">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Journey Date</label>
                                    <input 
                                        type="date" 
                                        name="journey_date" 
                                        min="{{ date('Y-m-d') }}"
                                        value="{{ request('journey_date', date('Y-m-d')) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                        required
                                    >
                                </div>
                                <button 
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 mb-3">
                                    Book Now
                                </button>
                                <p class="text-xs text-center text-gray-500">Instant booking confirmation</p>
                            </form>
                        @else
                            <a 
                                href="{{ route('login') }}"
                                class="w-full block text-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 mb-3">
                                Login to Book
                            </a>
                            <p class="text-xs text-center text-gray-500">Please login to continue booking</p>
                        @endauth
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 px-6 rounded-lg cursor-not-allowed mb-3">
                            Sold Out
                        </button>
                        <p class="text-xs text-center text-gray-500">No seats available</p>
                    @endif
                </div>

                <!-- Quick Info -->
                <div class="bg-blue-50 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Booking confirmation within 5 minutes</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Free cancellation up to 24 hours before departure</span>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Secure payment options available</span>
                        </div>
                    </div>
                </div>

                <!-- Train Status -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Train Status</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Current Status</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($train->status === 'active') bg-green-100 text-green-800
                            @elseif($train->status === 'delayed') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($train->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection