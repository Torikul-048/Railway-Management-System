@extends('layouts.app')

@section('title', 'Payment - Booking')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">✓</div>
                        <span class="ml-2 font-semibold">Passenger Details</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-600 mx-4"></div>
                    <div class="flex items-center text-blue-600">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">3</div>
                        <span class="ml-2 font-semibold">Payment</span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Payment Timer Warning -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm text-yellow-700">
                        <strong>Important:</strong> Please complete your payment within 
                        <span id="countdown-timer" class="font-bold text-red-600"></span>
                    </p>
                    <p class="text-xs text-yellow-600 mt-1">
                        Your booking will be automatically cancelled if payment is not completed within 5 minutes to free up the seats for other passengers.
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Information</h2>
                    
                    <form method="POST" action="{{ route('bookings.process-payment', $booking) }}" id="payment-form">
                        @csrf
                        
                        <!-- Payment Method Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Select Payment Method <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- bKash -->
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-all">
                                    <input type="radio" name="payment_method" value="bkash" class="payment-method-radio" required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">bKash</span>
                                            <span class="text-2xl text-pink-600">৳</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Mobile Banking</p>
                                    </div>
                                </label>

                                <!-- Nagad -->
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-all">
                                    <input type="radio" name="payment_method" value="nagad" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">Nagad</span>
                                            <span class="text-2xl text-orange-600">৳</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Mobile Banking</p>
                                    </div>
                                </label>

                                <!-- Rocket -->
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-all">
                                    <input type="radio" name="payment_method" value="rocket" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">Rocket</span>
                                            <span class="text-2xl text-purple-600">৳</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Mobile Banking</p>
                                    </div>
                                </label>

                                <!-- Card -->
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-all">
                                    <input type="radio" name="payment_method" value="card" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">Credit/Debit Card</span>
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500">Visa, Mastercard</p>
                                    </div>
                                </label>

                                <!-- Bank Transfer -->
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition-all md:col-span-2">
                                    <input type="radio" name="payment_method" value="bank" class="payment-method-radio">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-900">Bank Transfer</span>
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500">Direct Bank Transfer</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Details -->
                        <div id="mobile-payment-fields" class="hidden mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mobile Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="payment_phone" 
                                value="{{ old('payment_phone') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payment_phone') border-red-500 @enderror"
                                placeholder="01XXXXXXXXX"
                            >
                            @error('payment_phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Transaction ID <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="transaction_id" 
                                value="{{ old('transaction_id') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('transaction_id') border-red-500 @enderror"
                                placeholder="Enter transaction/reference ID"
                                required
                            >
                            @error('transaction_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                <strong>Mock Payment:</strong> Enter any transaction ID (e.g., TXN123456789)
                            </p>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Mock Payment Mode</p>
                                    <p>This is a demonstration payment system. No actual money will be charged. Enter any transaction ID to proceed.</p>
                                </div>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            Complete Payment - ৳{{ number_format($booking->total_fare, 2) }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Booking Details</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">PNR Number</p>
                            <p class="font-mono text-lg font-bold text-blue-600">{{ $booking->booking_reference }}</p>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-xs text-gray-600 mb-1">Train</p>
                            <p class="font-semibold text-gray-900">{{ $booking->train->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->train->train_number }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Journey Date</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->journey_date)->format('D, M d, Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Seats</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($booking->seat_numbers as $seat)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $seat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">Fare ({{ $booking->number_of_seats }} × ৳{{ number_format($booking->train->fare_per_seat, 2) }})</span>
                                <span class="font-semibold text-gray-900">৳{{ number_format($booking->total_fare, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                <span class="font-bold text-gray-900">Total Amount</span>
                                <span class="text-2xl font-bold text-blue-600">৳{{ number_format($booking->total_fare, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide mobile payment fields based on payment method
    const paymentRadios = document.querySelectorAll('.payment-method-radio');
    const mobilePaymentFields = document.getElementById('mobile-payment-fields');
    const mobilePaymentInput = document.querySelector('input[name="payment_phone"]');
    
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const mobilePaymentMethods = ['bkash', 'nagad', 'rocket'];
            
            if (mobilePaymentMethods.includes(this.value)) {
                mobilePaymentFields.classList.remove('hidden');
                mobilePaymentInput.required = true;
            } else {
                mobilePaymentFields.classList.add('hidden');
                mobilePaymentInput.required = false;
            }
            
            // Update label border
            document.querySelectorAll('.payment-method-radio').forEach(r => {
                r.closest('label').classList.remove('border-blue-500', 'bg-blue-50');
            });
            this.closest('label').classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    // Countdown Timer for 30-minute payment deadline
    const bookingTime = new Date('{{ $booking->booking_date->toIso8601String() }}');
    const expiryTime = new Date(bookingTime.getTime() + (5 * 60 * 1000)); // 5 minutes from booking
    
    function updateCountdown() {
        const now = new Date();
        const timeLeft = expiryTime - now;
        
        if (timeLeft <= 0) {
            document.getElementById('countdown-timer').textContent = '00:00';
            document.getElementById('countdown-timer').classList.remove('text-red-600');
            document.getElementById('countdown-timer').classList.add('text-gray-500');
            
            // Show expiration message
            alert('Your booking has expired. Redirecting to home page...');
            window.location.href = '{{ route('home') }}';
            return;
        }
        
        const minutes = Math.floor(timeLeft / 1000 / 60);
        const seconds = Math.floor((timeLeft / 1000) % 60);
        
        const formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        document.getElementById('countdown-timer').textContent = formattedTime;
        
        // Change color when less than 5 minutes remaining
        const timerElement = document.getElementById('countdown-timer');
        if (minutes < 5) {
            timerElement.classList.remove('text-red-600');
            timerElement.classList.add('text-red-700', 'animate-pulse');
        } else {
            timerElement.classList.remove('text-red-700', 'animate-pulse');
            timerElement.classList.add('text-red-600');
        }
    }
    
    // Update countdown every second
    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
</script>
@endpush
@endsection
