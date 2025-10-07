<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Train;
use App\Models\TrainCoach;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show seat selection page for a train.
     */
    public function selectSeats(Request $request, Train $train)
    {
        $request->validate([
            'journey_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $journeyDate = $request->journey_date;

        // Get all coaches with their seats
        $coaches = $train->coaches()
            ->with(['seats' => function ($query) {
                $query->orderBy('row_number')->orderBy('column_number');
            }])
            ->get();

        // Get booked seats for this date
        $bookedSeats = Booking::where('train_id', $train->id)
            ->whereDate('journey_date', $journeyDate)
            ->whereIn('booking_status', ['confirmed', 'pending'])
            ->get()
            ->pluck('seat_numbers')
            ->flatten()
            ->unique()
            ->toArray();

        return view('bookings.select-seats', compact('train', 'coaches', 'journeyDate', 'bookedSeats'));
    }

    /**
     * Reserve seats temporarily (AJAX).
     */
    public function reserveSeats(Request $request)
    {
        $request->validate([
            'seat_ids' => ['required', 'array'],
            'seat_ids.*' => ['exists:seats,id'],
        ]);

        try {
            DB::beginTransaction();

            $seats = Seat::whereIn('id', $request->seat_ids)->get();

            foreach ($seats as $seat) {
                // Check if seat is available
                if (!$seat->isAvailableForBooking()) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Seat {$seat->seat_number} is no longer available.",
                    ], 422);
                }

                // Reserve the seat for 10 minutes
                $seat->reserve(10);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Seats reserved successfully for 10 minutes.',
                'reserved_until' => now()->addMinutes(10)->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to reserve seats. Please try again.',
            ], 500);
        }
    }

    /**
     * Show booking form with passenger details.
     */
    public function bookingForm(Request $request, Train $train)
    {
        $request->validate([
            'journey_date' => ['required', 'date', 'after_or_equal:today'],
            'seat_numbers' => ['required', 'array', 'min:1'],
            'seat_numbers.*' => ['required', 'string'],
        ]);

        $journeyDate = $request->journey_date;
        $seatNumbers = array_values($request->seat_numbers); // Ensure indexed array
        $numberOfSeats = count($seatNumbers);
        $totalFare = $train->fare_per_seat * $numberOfSeats;

        // Get seat details
        $seats = Seat::whereIn('seat_number', $seatNumbers)
            ->with('trainCoach')
            ->get();

        return view('bookings.booking-form', compact('train', 'journeyDate', 'seatNumbers', 'seats', 'numberOfSeats', 'totalFare'));
    }

    /**
     * Store the booking.
     */
    public function store(Request $request, Train $train)
    {
        $request->validate([
            'journey_date' => ['required', 'date', 'after_or_equal:today'],
            'seat_numbers' => ['required', 'array'],
            'seat_numbers.*' => ['string'],
            'passengers' => ['required', 'array'],
            'passengers.*.name' => ['required', 'string', 'max:255'],
            'passengers.*.age' => ['required', 'integer', 'min:1', 'max:120'],
            'passengers.*.gender' => ['required', 'in:male,female,other'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            DB::beginTransaction();

            // Verify seats are still available
            $bookedSeats = Booking::where('train_id', $train->id)
                ->whereDate('journey_date', $request->journey_date)
                ->whereIn('booking_status', ['confirmed', 'pending'])
                ->get()
                ->pluck('seat_numbers')
                ->flatten()
                ->unique()
                ->toArray();

            $requestedSeats = $request->seat_numbers;
            $unavailableSeats = array_intersect($requestedSeats, $bookedSeats);

            if (count($unavailableSeats) > 0) {
                DB::rollBack();
                return back()->with('error', 'Some seats are no longer available: ' . implode(', ', $unavailableSeats));
            }

            // Generate PNR (booking reference)
            $pnr = $this->generatePNR();

            // Calculate total fare
            $totalFare = $train->fare_per_seat * count($requestedSeats);

            // Create booking
            $booking = Booking::create([
                'booking_reference' => $pnr,
                'user_id' => Auth::id(),
                'train_id' => $train->id,
                'journey_date' => $request->journey_date,
                'number_of_seats' => count($requestedSeats),
                'seat_numbers' => $requestedSeats,
                'total_fare' => $totalFare,
                'booking_status' => 'pending',
                'payment_status' => 'pending',
                'booking_date' => now(),
                'passenger_details' => [
                    'passengers' => $request->passengers,
                    'contact_phone' => $request->contact_phone,
                    'contact_email' => $request->contact_email,
                ],
                'special_requests' => $request->special_requests,
            ]);

            // Release seat reservations
            Seat::whereIn('seat_number', $requestedSeats)->update([
                'is_reserved' => false,
                'reserved_until' => null,
            ]);

            DB::commit();

            // Redirect to payment
            return redirect()->route('bookings.payment', $booking);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create booking. Please try again.')->withInput();
        }
    }

    /**
     * Show payment page.
     */
    public function payment(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Check if booking is already paid
        if ($booking->payment_status === 'paid') {
            return redirect()->route('bookings.confirmation', $booking);
        }

        return view('bookings.payment', compact('booking'));
    }

    /**
     * Process payment (mock).
     */
    public function processPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => ['required', 'in:bkash,nagad,rocket,card,bank'],
            'payment_phone' => ['required_if:payment_method,bkash,nagad,rocket', 'nullable', 'string'],
            'transaction_id' => ['required', 'string', 'max:100'],
        ]);

        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }

        try {
            DB::beginTransaction();

            // Mock payment processing
            // In a real application, you would integrate with a payment gateway here
            
            // Update booking
            $booking->update([
                'payment_status' => 'paid',
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->transaction_id,
                'booking_status' => 'confirmed',
            ]);

            DB::commit();

            return redirect()->route('bookings.confirmation', $booking)
                ->with('success', 'Payment successful! Your booking is confirmed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment processing failed. Please try again.')->withInput();
        }
    }

    /**
     * Show booking confirmation.
     */
    public function confirmation(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }

        $booking->load(['train', 'user']);

        return view('bookings.confirmation', compact('booking'));
    }

    /**
     * Generate a unique PNR (Passenger Name Record).
     */
    private function generatePNR()
    {
        do {
            // Format: PNR + 10 alphanumeric characters
            $pnr = 'PNR' . strtoupper(Str::random(10));
        } while (Booking::where('booking_reference', $pnr)->exists());

        return $pnr;
    }

    /**
     * Check seat availability (AJAX).
     */
    public function checkSeatAvailability(Request $request)
    {
        $request->validate([
            'train_id' => ['required', 'exists:trains,id'],
            'journey_date' => ['required', 'date'],
            'seat_numbers' => ['required', 'array'],
        ]);

        $bookedSeats = Booking::where('train_id', $request->train_id)
            ->whereDate('journey_date', $request->journey_date)
            ->whereIn('booking_status', ['confirmed', 'pending'])
            ->get()
            ->pluck('seat_numbers')
            ->flatten()
            ->unique()
            ->toArray();

        $requestedSeats = $request->seat_numbers;
        $unavailableSeats = array_intersect($requestedSeats, $bookedSeats);

        return response()->json([
            'available' => count($unavailableSeats) === 0,
            'unavailable_seats' => array_values($unavailableSeats),
        ]);
    }
}
