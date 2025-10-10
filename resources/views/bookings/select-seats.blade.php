@extends('layouts.app')

@section('title', 'Select Seats - ' . $train->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('trains.details', $train) }}?journey_date={{ $journeyDate }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Train Details
            </a>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Select Your Seats</h1>
                    <div class="flex flex-wrap items-center gap-4 text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($journeyDate)->format('D, M d, Y') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Departs at {{ \Carbon\Carbon::parse($train->departure_time)->format('h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 mb-1">Fare per seat</p>
                    <p class="text-lg font-bold text-blue-600">Varies by class</p>
                    <p class="text-sm text-gray-500">See individual coach prices below</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Seat Layout -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <!-- Legend -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Seat Legend</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-green-100 border-2 border-green-500 flex items-center justify-center mr-2">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Available</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 border-2 border-blue-600 flex items-center justify-center mr-2">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Selected</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gray-300 border-2 border-gray-400 flex items-center justify-center mr-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Booked</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-yellow-100 border-2 border-yellow-400 flex items-center justify-center mr-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700">Reserved</span>
                            </div>
                        </div>
                    </div>

                    <!-- Coaches -->
                    <div class="space-y-8">
                        @foreach($coaches as $coach)
                            <div class="border border-gray-200 rounded-lg p-6">
                                <!-- Coach Header -->
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Coach {{ $coach->coach_number }}</h3>
                                        <p class="text-sm text-gray-600">{{ $coach->coach_name }}</p>
                                        <p class="text-lg font-semibold text-blue-600 mt-1">৳{{ number_format($coach->price_per_seat ?? $train->fare_per_seat, 2) }} per seat</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Available Seats</p>
                                        <p class="text-lg font-bold text-green-600">{{ $coach->seats->whereNotIn('seat_number', $bookedSeats)->count() }}/{{ $coach->total_seats }}</p>
                                    </div>
                                </div>

                                <!-- Seat Grid -->
                                <div class="overflow-x-auto">
                                    <div class="inline-block min-w-full">
                                        @php
                                            $seatsByRow = $coach->seats->groupBy('row_number');
                                        @endphp
                                        
                                        <div class="space-y-3">
                                            @foreach($seatsByRow as $rowNumber => $seatsInRow)
                                                <div class="flex items-center justify-center gap-2">
                                                    <span class="text-xs text-gray-500 w-8">{{ $rowNumber }}</span>
                                                    
                                                    @foreach($seatsInRow as $seat)
                                                        @php
                                                            $isBooked = in_array($seat->seat_number, $bookedSeats);
                                                            $isReserved = $seat->is_reserved && !$seat->isReservationExpired();
                                                        @endphp
                                                        
                                                        <button
                                                            type="button"
                                                            data-seat-id="{{ $seat->id }}"
                                                            data-seat-number="{{ $seat->seat_number }}"
                                                            data-coach-id="{{ $coach->id }}"
                                                            data-seat-price="{{ $coach->price_per_seat ?? $train->fare_per_seat }}"
                                                            class="seat-button w-14 h-14 rounded-lg border-2 flex items-center justify-center text-xs font-semibold transition-all duration-200 transform hover:scale-105
                                                                @if($isBooked)
                                                                    bg-gray-300 border-gray-400 text-gray-500 cursor-not-allowed
                                                                @elseif($isReserved)
                                                                    bg-yellow-100 border-yellow-400 text-yellow-700 cursor-not-allowed
                                                                @else
                                                                    bg-green-100 border-green-500 text-green-700 hover:bg-green-200 cursor-pointer
                                                                @endif"
                                                            @if($isBooked || $isReserved) disabled @endif
                                                        >
                                                            <div class="text-center">
                                                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                                                                </svg>
                                                                <span class="text-[10px]">{{ $seat->seat_number }}</span>
                                                            </div>
                                                        </button>

                                                        @if($coach->layout_config['aisle_position'] ?? 0 == $seat->column_number)
                                                            <div class="w-8"></div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Booking Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Booking Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Selected Seats:</span>
                            <span class="font-semibold text-gray-900" id="selected-count">0</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-900 font-bold">Total Fare:</span>
                                <span class="text-2xl font-bold text-blue-600" id="total-fare">৳0.00</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Price varies by coach class</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-900 mb-2">Selected Seats:</h4>
                        <div id="selected-seats-list" class="flex flex-wrap gap-2 min-h-[40px] p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-500">No seats selected</span>
                        </div>
                    </div>

                    <form id="booking-form" method="POST" action="{{ route('bookings.booking-form', $train) }}">
                        @csrf
                        <input type="hidden" name="journey_date" value="{{ $journeyDate }}">
                        <div id="seat-numbers-container"></div>
                        
                        <button 
                            type="submit" 
                            id="continue-btn"
                            disabled
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 shadow-lg disabled:shadow-none"
                        >
                            Continue to Book
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Please select at least one seat to continue
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const selectedSeats = new Map(); // Changed to Map to store seat number and price

    // Seat selection handling
    document.querySelectorAll('.seat-button:not([disabled])').forEach(button => {
        button.addEventListener('click', function() {
            const seatNumber = this.dataset.seatNumber;
            const seatPrice = parseFloat(this.dataset.seatPrice);
            
            if (selectedSeats.has(seatNumber)) {
                // Deselect
                selectedSeats.delete(seatNumber);
                this.classList.remove('bg-blue-500', 'border-blue-600', 'text-white');
                this.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
            } else {
                // Select
                selectedSeats.set(seatNumber, seatPrice);
                this.classList.remove('bg-green-100', 'border-green-500', 'text-green-700');
                this.classList.add('bg-blue-500', 'border-blue-600', 'text-white');
            }
            
            updateSummary();
        });
    });

    function updateSummary() {
        const count = selectedSeats.size;
        
        // Calculate total by summing all seat prices
        let total = 0;
        selectedSeats.forEach((price, seat) => {
            total += price;
        });
        
        // Update count and total
        document.getElementById('selected-count').textContent = count;
        document.getElementById('total-fare').textContent = '৳' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        
        // Update selected seats list
        const listContainer = document.getElementById('selected-seats-list');
        if (count === 0) {
            listContainer.innerHTML = '<span class="text-sm text-gray-500">No seats selected</span>';
        } else {
            listContainer.innerHTML = Array.from(selectedSeats.keys())
                .map(seat => `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${seat}</span>`)
                .join('');
        }
        
        // Update hidden inputs as array
        const container = document.getElementById('seat-numbers-container');
        container.innerHTML = '';
        
        if (count > 0) {
            Array.from(selectedSeats.keys()).forEach((seat, index) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `seat_numbers[${index}]`;
                input.value = seat;
                container.appendChild(input);
            });
        }
        
        // Update button state
        document.getElementById('continue-btn').disabled = count === 0;
    }

    // Initialize
    updateSummary();
</script>
@endpush
@endsection
