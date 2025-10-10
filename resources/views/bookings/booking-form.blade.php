@extends('layouts.app')

@section('title', 'Passenger Details - Booking')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">✓</div>
                        <span class="ml-2 font-semibold">Select Seats</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-600 mx-4"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">2</div>
                        <span class="ml-2 font-semibold">Passenger Details</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400">
                        <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                        <span class="ml-2 font-semibold">Payment</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Passenger Details</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600">Train</p>
                    <p class="font-semibold text-gray-900">{{ $train->name }} ({{ $train->train_number }})</p>
                </div>
                <div>
                    <p class="text-gray-600">Journey Date</p>
                    <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($journeyDate)->format('D, M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Selected Seats</p>
                    <p class="font-semibold text-blue-600">{{ implode(', ', $seatNumbers) }}</p>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store', $train) }}" id="booking-form">
            @csrf
            <input type="hidden" name="journey_date" value="{{ $journeyDate }}">
            @foreach($seatNumbers as $index => $seatNumber)
                <input type="hidden" name="seat_numbers[]" value="{{ $seatNumber }}">
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Passenger Details Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Passengers -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Passenger Information</h2>
                        
                        <div id="passengers-container" class="space-y-6">
                            @foreach($seatNumbers as $index => $seatNumber)
                                <div class="passenger-form border border-gray-200 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                        Passenger {{ $index + 1 }} - Seat {{ $seatNumber }}
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Full Name <span class="text-red-500">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                name="passengers[{{ $index }}][name]" 
                                                value="{{ old("passengers.{$index}.name") }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error("passengers.{$index}.name") border-red-500 @enderror"
                                                placeholder="Enter full name"
                                                required
                                            >
                                            @error("passengers.{$index}.name")
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Age <span class="text-red-500">*</span>
                                            </label>
                                            <input 
                                                type="number" 
                                                name="passengers[{{ $index }}][age]" 
                                                value="{{ old("passengers.{$index}.age") }}"
                                                min="1" 
                                                max="120"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error("passengers.{$index}.age") border-red-500 @enderror"
                                                placeholder="Age"
                                                required
                                            >
                                            @error("passengers.{$index}.age")
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Gender <span class="text-red-500">*</span>
                                            </label>
                                            <select 
                                                name="passengers[{{ $index }}][gender]"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error("passengers.{$index}.gender") border-red-500 @enderror"
                                                required
                                            >
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old("passengers.{$index}.gender") == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old("passengers.{$index}.gender") == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old("passengers.{$index}.gender") == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error("passengers.{$index}.gender")
                                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact Phone <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    name="contact_phone" 
                                    value="{{ old('contact_phone', Auth::user()->phone) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_phone') border-red-500 @enderror"
                                    placeholder="+880 1XXX-XXXXXX"
                                    required
                                >
                                @error('contact_phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="contact_email" 
                                    value="{{ old('contact_email', Auth::user()->email) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_email') border-red-500 @enderror"
                                    placeholder="email@example.com"
                                    required
                                >
                                @error('contact_email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Special Requests (Optional)
                            </label>
                            <textarea 
                                name="special_requests" 
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('special_requests') border-red-500 @enderror"
                                placeholder="Any special requirements or requests..."
                            >{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Booking Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Booking Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Number of Seats:</span>
                                <span class="font-semibold text-gray-900">{{ $numberOfSeats }}</span>
                            </div>
                            
                            <!-- Fare Breakdown by Coach -->
                            <div class="border-t border-gray-200 pt-3">
                                <p class="text-xs font-semibold text-gray-700 mb-2">Fare Breakdown:</p>
                                @php
                                    $seatsByCoach = $seats->groupBy('train_coach_id');
                                @endphp
                                @foreach($seatsByCoach as $coachId => $coachSeats)
                                    @php
                                        $coach = $coachSeats->first()->trainCoach;
                                        $coachSeatCount = $coachSeats->count();
                                        $coachPrice = $coach->price_per_seat ?? $train->fare_per_seat;
                                        $coachTotal = $coachPrice * $coachSeatCount;
                                    @endphp
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600">{{ $coach->coach_name }} ({{ $coachSeatCount }}x):</span>
                                        <span class="font-semibold text-gray-900">৳{{ number_format($coachTotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-900 font-bold">Total Amount:</span>
                                    <span class="text-2xl font-bold text-blue-600">৳{{ number_format($totalFare, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Seat Numbers:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($seatNumbers as $seat)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $seat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button 
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                Proceed to Payment
                            </button>
                            
                            <a 
                                href="{{ route('bookings.select-seats', $train) }}?journey_date={{ $journeyDate }}"
                                class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition-all duration-200"
                            >
                                Change Seats
                            </a>
                        </div>

                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-900 mb-2">Note:</h4>
                            <ul class="text-xs text-blue-800 space-y-1">
                                <li>• All passenger details are required</li>
                                <li>• Ensure contact information is correct</li>
                                <li>• Booking confirmation will be sent to your email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
