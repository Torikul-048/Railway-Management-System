@extends('layouts.app')

@section('title', 'Cancel Booking - ' . $booking->booking_reference)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('bookings.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Bookings
            </a>
        </div>

        <!-- Warning Header -->
        <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-6 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-red-800">Cancel Booking Confirmation</h3>
                    <p class="mt-2 text-sm text-red-700">
                        You are about to cancel this booking. This action cannot be undone.
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking Details Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Booking Details</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <!-- Booking Reference -->
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Booking Reference</span>
                    <span class="text-lg font-bold text-gray-900">{{ $booking->booking_reference }}</span>
                </div>

                <!-- Train Info -->
                <div class="pb-4 border-b border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-gray-600 font-medium">Train</span>
                        <div class="text-right">
                            <div class="text-gray-900 font-semibold">{{ $booking->train->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->train->train_number }}</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $booking->train->source_station }} → {{ $booking->train->destination_station }}
                    </div>
                </div>

                <!-- Journey Details -->
                <div class="grid grid-cols-2 gap-4 pb-4 border-b border-gray-200">
                    <div>
                        <span class="text-gray-600 text-sm">Journey Date</span>
                        <div class="text-gray-900 font-semibold">{{ $booking->journey_date->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">Departure Time</span>
                        <div class="text-gray-900 font-semibold">{{ $booking->train->departure_time->format('h:i A') }}</div>
                    </div>
                </div>

                <!-- Seats -->
                <div class="pb-4 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Seats ({{ $booking->number_of_seats }})</span>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($booking->seat_numbers as $seatNumber)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                {{ $seatNumber }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Fare Info -->
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Total Fare Paid</span>
                    <span class="text-xl font-bold text-gray-900">৳{{ number_format($booking->total_fare, 2) }}</span>
                </div>

                <!-- Booking Date -->
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">Booked On</span>
                    <span class="text-gray-900">{{ $booking->booking_date->format('M d, Y h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Refund Information Card -->
        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl shadow-md p-6 mb-6 border border-green-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Refund Information
            </h3>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Refund Percentage</span>
                    <span class="text-2xl font-bold text-green-600">{{ number_format($refundPercentage, 0) }}%</span>
                </div>
                
                <div class="flex justify-between items-center pt-3 border-t border-green-200">
                    <span class="text-gray-700 font-semibold">You Will Receive</span>
                    <span class="text-3xl font-bold text-green-700">৳{{ number_format($refundAmount, 2) }}</span>
                </div>

                @if($refundPercentage < 100)
                    <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Note:</strong> Cancellation charges of ৳{{ number_format($booking->total_fare - $refundAmount, 2) }} 
                            ({{ 100 - $refundPercentage }}%) will be deducted as per our refund policy.
                        </p>
                    </div>
                @endif

                <!-- Refund Policy Info -->
                <div class="mt-4 bg-white bg-opacity-70 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Refund Policy:</h4>
                    <ul class="text-xs text-gray-700 space-y-1">
                        <li>• Within 6 hours of booking: 90% refund</li>
                        <li>• Within 12 hours of booking: 75% refund</li>
                        <li>• Within 24 hours of booking: 50% refund</li>
                        <li>• Within 48 hours of booking: 20% refund</li>
                        <li>• Less than 6 hours before departure: 10% refund</li>
                        <li>• After train departure: No refund</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cancellation Form -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" id="cancelForm">
                @csrf
                
                <div class="mb-6">
                    <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Cancellation (Optional)
                    </label>
                    <textarea 
                        name="cancellation_reason" 
                        id="cancellation_reason" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                        placeholder="Please provide a reason for cancellation..."
                    ></textarea>
                    <p class="mt-2 text-sm text-gray-500">
                        Your feedback helps us improve our service
                    </p>
                </div>

                <!-- Confirmation Checkbox -->
                <div class="mb-6">
                    <label class="flex items-start">
                        <input 
                            type="checkbox" 
                            id="confirmCancel" 
                            class="mt-1 h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                            required
                        >
                        <span class="ml-3 text-sm text-gray-700">
                            I understand that this action cannot be undone and I agree to the cancellation charges as per the refund policy.
                        </span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-lg transition shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submitBtn"
                    >
                        <i class="fas fa-times-circle mr-2"></i>
                        Confirm Cancellation
                    </button>
                    <a 
                        href="{{ route('bookings.index') }}" 
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 px-6 rounded-lg transition text-center"
                    >
                        <i class="fas fa-arrow-left mr-2"></i>
                        Keep Booking
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Disable submit button until checkbox is checked
    document.getElementById('confirmCancel').addEventListener('change', function() {
        document.getElementById('submitBtn').disabled = !this.checked;
    });
    
    // Initialize button state
    document.getElementById('submitBtn').disabled = !document.getElementById('confirmCancel').checked;
</script>
@endsection
