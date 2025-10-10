<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Train;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display all bookings with search and filters.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'train'])->latest();

        // Search by PNR
        if ($request->filled('pnr')) {
            $query->where('booking_reference', 'like', '%' . $request->pnr . '%');
        }

        // Search by user (name or email)
        if ($request->filled('user')) {
            $searchTerm = $request->user;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Search by phone number (from passenger details)
        if ($request->filled('phone')) {
            $phone = $request->phone;
            $query->where('passenger_details->contact_phone', 'like', '%' . $phone . '%');
        }

        // Filter by booking status
        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by train
        if ($request->filled('train_id')) {
            $query->where('train_id', $request->train_id);
        }

        // Filter by journey date
        if ($request->filled('journey_date')) {
            $query->whereDate('journey_date', $request->journey_date);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        $bookings = $query->paginate(20)->withQueryString();

        // Get all trains for filter dropdown
        $trains = Train::orderBy('name')->get(['id', 'name', 'train_number']);

        // Calculate statistics
        $stats = $this->calculateStats();

        return view('admin.bookings.index', compact('bookings', 'trains', 'stats'));
    }

    /**
     * Show detailed booking information.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'train']);

        // Get seat details
        $seats = Seat::whereHas('trainCoach', function ($query) use ($booking) {
            $query->where('train_id', $booking->train_id);
        })->whereIn('seat_number', $booking->seat_numbers)
          ->with('trainCoach')
          ->get();

        return view('admin.bookings.show', compact('booking', 'seats'));
    }

    /**
     * Show cancellation confirmation page.
     */
    public function cancelConfirm(Booking $booking)
    {
        // Check if booking can be cancelled
        if (!$booking->canBeCancelled()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'This booking cannot be cancelled.');
        }

        $booking->load(['train', 'user']);

        // Calculate refund details
        $refundPercentage = $booking->calculateRefundPercentage();
        $refundAmount = $booking->calculateRefundAmount();

        return view('admin.bookings.cancel', compact('booking', 'refundPercentage', 'refundAmount'));
    }

    /**
     * Cancel a booking (Admin).
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Check if booking can be cancelled
        if (!$booking->canBeCancelled()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'This booking cannot be cancelled. The train may have already departed or the booking is already cancelled.');
        }

        $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:500'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            DB::beginTransaction();

            // Calculate refund and cancel the booking
            $refundInfo = $booking->cancel($request->cancellation_reason);

            // Add admin notes if provided
            if ($request->filled('admin_notes')) {
                $passengerDetails = $booking->passenger_details;
                $passengerDetails['admin_notes'] = $request->admin_notes;
                $booking->passenger_details = $passengerDetails;
                $booking->save();
            }

            // Release the seats back to available pool
            $seatNumbers = $booking->seat_numbers;
            
            // Get the train coaches and find seats by seat number
            $seats = Seat::whereHas('trainCoach', function ($query) use ($booking) {
                $query->where('train_id', $booking->train_id);
            })->whereIn('seat_number', $seatNumbers)->get();

            // Release reservations and make seats available again
            foreach ($seats as $seat) {
                $seat->releaseReservation();
            }

            DB::commit();

            $message = sprintf(
                'Booking %s cancelled successfully. Refund: ৳%.2f (%.0f%% of total fare)',
                $booking->booking_reference,
                $refundInfo['refund_amount'],
                $refundInfo['refund_percentage']
            );

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel booking. Please try again or contact support. Error: ' . $e->getMessage());
        }
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'booking_status' => ['required', 'in:pending,confirmed,cancelled,completed'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $booking->booking_status = $request->booking_status;

            if ($request->filled('notes')) {
                $passengerDetails = $booking->passenger_details;
                $passengerDetails['status_notes'] = $request->notes;
                $booking->passenger_details = $passengerDetails;
            }

            $booking->save();

            return redirect()->back()->with('success', 'Booking status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update booking status.');
        }
    }

    /**
     * Calculate booking statistics.
     */
    private function calculateStats()
    {
        return [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('booking_status', 'cancelled')->count(),
            'total_revenue' => Booking::whereIn('booking_status', ['confirmed', 'completed'])
                ->where('payment_status', 'paid')
                ->sum('total_fare'),
            'pending_revenue' => Booking::where('booking_status', 'pending')
                ->where('payment_status', 'pending')
                ->sum('total_fare'),
            'refunded_amount' => Booking::where('booking_status', 'cancelled')
                ->sum('refund_amount'),
            'today_bookings' => Booking::whereDate('booking_date', today())->count(),
        ];
    }

    /**
     * Export bookings to CSV.
     */
    public function export(Request $request)
    {
        $query = Booking::with(['user', 'train'])->latest();

        // Apply same filters as index
        if ($request->filled('pnr')) {
            $query->where('booking_reference', 'like', '%' . $request->pnr . '%');
        }
        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        $bookings = $query->get();

        $filename = 'bookings_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'PNR',
                'User Name',
                'User Email',
                'Train',
                'Journey Date',
                'Booking Date',
                'Seats',
                'Total Fare',
                'Payment Status',
                'Booking Status',
                'Payment Method',
            ]);

            // Add data rows
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->user->name,
                    $booking->user->email,
                    $booking->train->name . ' (' . $booking->train->train_number . ')',
                    $booking->journey_date->format('Y-m-d'),
                    $booking->booking_date->format('Y-m-d H:i'),
                    implode(', ', $booking->seat_numbers),
                    $booking->total_fare,
                    ucfirst($booking->payment_status),
                    ucfirst($booking->booking_status),
                    $booking->payment_method ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
