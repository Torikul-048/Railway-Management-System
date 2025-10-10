<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class ExpirePendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:expire-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancel pending bookings that have not been paid within 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired pending bookings...');

        // Find all pending bookings older than 30 minutes
        $expiredBookings = Booking::where('booking_status', 'pending')
            ->where('payment_status', 'pending')
            ->where('booking_date', '<=', now()->subMinutes(30))
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('No expired pending bookings found.');
            return 0;
        }

        $count = 0;

        foreach ($expiredBookings as $booking) {
            try {
                DB::beginTransaction();

                // Cancel the booking
                $booking->update([
                    'booking_status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => 'Payment not completed within 30 minutes - Automatically cancelled by system',
                    'refund_percentage' => 0,
                    'refund_amount' => 0,
                ]);

                // Release the seats back to available pool
                $seatNumbers = $booking->seat_numbers;
                
                // Get the train coaches and find seats by seat number
                $seats = Seat::whereHas('trainCoach', function ($query) use ($booking) {
                    $query->where('train_id', $booking->train_id);
                })->whereIn('seat_number', $seatNumbers)->get();

                // Release reservations and make seats available again
                foreach ($seats as $seat) {
                    $seat->update([
                        'is_available' => true,
                        'is_reserved' => false,
                        'reserved_until' => null,
                    ]);
                }

                DB::commit();

                $this->line("✓ Expired booking {$booking->booking_reference} - Seats released: " . implode(', ', $seatNumbers));
                $count++;

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("✗ Failed to expire booking {$booking->booking_reference}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully expired {$count} pending booking(s).");
        return 0;
    }
}
