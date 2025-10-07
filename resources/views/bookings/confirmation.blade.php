@extends('layouts.app')

@section('title', 'Booking Confirmed - ' . $booking->booking_reference)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Success Message -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-6 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Booking Confirmed!
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Your train ticket has been booked successfully. A confirmation email has been sent to your registered email address.
            </p>
            
            <div class="inline-block">
                <p class="text-sm text-gray-600 mb-2">Your PNR Number</p>
                <p class="text-3xl font-mono font-bold text-blue-600 bg-blue-50 px-8 py-4 rounded-lg">
                    {{ $booking->booking_reference }}
                </p>
            </div>
        </div>

        <!-- Ticket Details -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <!-- Ticket Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">{{ $booking->train->name }}</h2>
                        <p class="text-blue-100">Train No: {{ $booking->train->train_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500 text-white">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ticket Body -->
            <div class="p-6">
                <!-- Journey Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">From</p>
                        <p class="text-xl font-bold text-gray-900">{{ $booking->train->source_station }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Dep: {{ \Carbon\Carbon::parse($booking->train->departure_time)->format('h:i A') }}
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <div class="flex items-center justify-center mb-2">
                                <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                                <div class="w-20 h-1 bg-blue-600"></div>
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->journey_date)->format('D, M d, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">To</p>
                        <p class="text-xl font-bold text-gray-900">{{ $booking->train->destination_station }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            Arr: {{ \Carbon\Carbon::parse($booking->train->arrival_time)->format('h:i A') }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Passenger Information -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Passenger Details</h3>
                            <div class="space-y-3">
                                @foreach($booking->passenger_details['passengers'] as $index => $passenger)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="font-semibold text-gray-900">{{ $passenger['name'] }}</p>
                                            <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                                {{ $booking->seat_numbers[$index] ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="flex gap-4 text-sm text-gray-600">
                                            <span>Age: {{ $passenger['age'] }}</span>
                                            <span>{{ ucfirst($passenger['gender']) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Booking Information -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Booking Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">PNR Number:</span>
                                    <span class="font-mono font-semibold text-gray-900">{{ $booking->booking_reference }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Booking Date:</span>
                                    <span class="font-semibold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Number of Seats:</span>
                                    <span class="font-semibold text-gray-900">{{ $booking->number_of_seats }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Seat Numbers:</span>
                                    <div class="flex flex-wrap gap-1 justify-end">
                                        @foreach($booking->seat_numbers as $seat)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $seat }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Payment Method:</span>
                                    <span class="font-semibold text-gray-900">{{ ucfirst($booking->payment_method) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Payment Status:</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center pt-4">
                                    <span class="text-lg font-bold text-gray-900">Total Fare:</span>
                                    <span class="text-2xl font-bold text-blue-600">৳{{ number_format($booking->total_fare, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                @if(isset($booking->passenger_details['contact_phone']) || isset($booking->passenger_details['contact_email']))
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(isset($booking->passenger_details['contact_phone']))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-gray-900">{{ $booking->passenger_details['contact_phone'] }}</span>
                                </div>
                            @endif
                            @if(isset($booking->passenger_details['contact_email']))
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-900">{{ $booking->passenger_details['contact_email'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button 
                onclick="window.print()"
                class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Ticket
            </button>
            
            <a 
                href="{{ route('customer.dashboard') }}"
                class="inline-flex items-center justify-center px-8 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-lg transition-all duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Go to Dashboard
            </a>
            
            <a 
                href="{{ route('trains.search') }}"
                class="inline-flex items-center justify-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Book Another Ticket
            </a>
        </div>

        <!-- Important Notes -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Important Notes</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Please carry a valid photo ID proof during your journey</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Report at the station at least 30 minutes before departure</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Cancellation is allowed up to 24 hours before departure</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Keep your PNR number safe for future reference</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .bg-white.rounded-xl.shadow-md.overflow-hidden,
        .bg-white.rounded-xl.shadow-md.overflow-hidden * {
            visibility: visible;
        }
        .bg-white.rounded-xl.shadow-md.overflow-hidden {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@endpush
@endsection
