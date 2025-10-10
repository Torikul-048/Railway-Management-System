<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Train;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     */
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Convert to Carbon instances
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Revenue Summary
        $totalRevenue = Booking::whereBetween('booking_date', [$start, $end])
            ->where('payment_status', 'paid')
            ->sum('total_fare');

        $totalRefunds = Booking::whereBetween('cancelled_at', [$start, $end])
            ->whereNotNull('cancelled_at')
            ->sum('refund_amount');

        $netRevenue = $totalRevenue - $totalRefunds;

        // Booking Statistics
        $totalBookings = Booking::whereBetween('booking_date', [$start, $end])->count();
        $confirmedBookings = Booking::whereBetween('booking_date', [$start, $end])
            ->where('booking_status', 'confirmed')
            ->count();
        $cancelledBookings = Booking::whereBetween('booking_date', [$start, $end])
            ->where('booking_status', 'cancelled')
            ->count();
        $pendingBookings = Booking::whereBetween('booking_date', [$start, $end])
            ->where('booking_status', 'pending')
            ->count();

        // Total seats booked
        $totalSeatsBooked = Booking::whereBetween('booking_date', [$start, $end])
            ->where('booking_status', '!=', 'cancelled')
            ->sum('number_of_seats');

        // Average booking value
        $avgBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;

        // Top trains by revenue
        $topTrainsByRevenue = Booking::select('train_id', DB::raw('SUM(total_fare) as total_revenue'), DB::raw('COUNT(*) as booking_count'))
            ->whereBetween('booking_date', [$start, $end])
            ->where('payment_status', 'paid')
            ->groupBy('train_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->with('train')
            ->get();

        // Top trains by bookings
        $topTrainsByBookings = Booking::select('train_id', DB::raw('COUNT(*) as booking_count'), DB::raw('SUM(number_of_seats) as total_seats'))
            ->whereBetween('booking_date', [$start, $end])
            ->where('booking_status', '!=', 'cancelled')
            ->groupBy('train_id')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->with('train')
            ->get();

        // Recent bookings
        $recentBookings = Booking::with(['train', 'user'])
            ->whereBetween('booking_date', [$start, $end])
            ->latest('booking_date')
            ->limit(10)
            ->get();

        // Customer statistics
        $totalCustomers = User::where('role', 'customer')->count();
        $activeCustomers = Booking::whereBetween('booking_date', [$start, $end])
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalRefunds',
            'netRevenue',
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'pendingBookings',
            'totalSeatsBooked',
            'avgBookingValue',
            'topTrainsByRevenue',
            'topTrainsByBookings',
            'recentBookings',
            'totalCustomers',
            'activeCustomers'
        ));
    }

    /**
     * Get booking statistics data for charts (AJAX).
     */
    public function bookingStats(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Bookings by status
        $bookingsByStatus = Booking::select('booking_status', DB::raw('COUNT(*) as count'))
            ->whereBetween('booking_date', [$start, $end])
            ->groupBy('booking_status')
            ->get()
            ->pluck('count', 'booking_status');

        // Daily bookings trend
        $dailyBookings = Booking::select(
                DB::raw('DATE(booking_date) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_fare) as revenue')
            )
            ->whereBetween('booking_date', [$start, $end])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment status distribution
        $paymentStatus = Booking::select('payment_status', DB::raw('COUNT(*) as count'))
            ->whereBetween('booking_date', [$start, $end])
            ->groupBy('payment_status')
            ->get()
            ->pluck('count', 'payment_status');

        return response()->json([
            'bookingsByStatus' => $bookingsByStatus,
            'dailyBookings' => $dailyBookings,
            'paymentStatus' => $paymentStatus,
        ]);
    }

    /**
     * Get revenue statistics data for charts (AJAX).
     */
    public function revenueStats(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Daily revenue trend
        $dailyRevenue = Booking::select(
                DB::raw('DATE(booking_date) as date'),
                DB::raw('SUM(total_fare) as revenue'),
                DB::raw('COUNT(*) as bookings')
            )
            ->whereBetween('booking_date', [$start, $end])
            ->where('payment_status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by train type
        $revenueByTrainType = Booking::join('trains', 'bookings.train_id', '=', 'trains.id')
            ->select('trains.type', DB::raw('SUM(bookings.total_fare) as revenue'))
            ->whereBetween('bookings.booking_date', [$start, $end])
            ->where('bookings.payment_status', 'paid')
            ->groupBy('trains.type')
            ->get();

        return response()->json([
            'dailyRevenue' => $dailyRevenue,
            'revenueByTrainType' => $revenueByTrainType,
        ]);
    }

    /**
     * Export reports to CSV.
     */
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $bookings = Booking::with(['train', 'user'])
            ->whereBetween('booking_date', [$start, $end])
            ->orderBy('booking_date', 'desc')
            ->get();

        $filename = "bookings_report_{$startDate}_to_{$endDate}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'Booking Reference',
                'Customer Name',
                'Customer Email',
                'Train Name',
                'Train Number',
                'Journey Date',
                'Booking Date',
                'Seats',
                'Total Fare',
                'Status',
                'Payment Status',
            ]);

            // Add data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->user->name,
                    $booking->user->email,
                    $booking->train->name,
                    $booking->train->train_number,
                    $booking->journey_date->format('Y-m-d'),
                    $booking->booking_date->format('Y-m-d H:i:s'),
                    $booking->number_of_seats,
                    $booking->total_fare,
                    $booking->booking_status,
                    $booking->payment_status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
