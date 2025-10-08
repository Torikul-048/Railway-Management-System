<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_reference',
        'user_id',
        'train_id',
        'journey_date',
        'number_of_seats',
        'seat_numbers',
        'total_fare',
        'booking_status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'booking_date',
        'passenger_details',
        'special_requests',
        'cancelled_at',
        'cancellation_reason',
        'refund_amount',
        'refund_percentage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'journey_date' => 'date',
        'booking_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'seat_numbers' => 'array',
        'passenger_details' => 'array',
        'total_fare' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'refund_percentage' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BK' . strtoupper(Str::random(8));
            }
            if (empty($booking->booking_date)) {
                $booking->booking_date = now();
            }
        });
    }

    /**
     * Get the user that made this booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the train for this booking.
     */
    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    /**
     * Check if booking is confirmed.
     */
    public function isConfirmed()
    {
        return $this->booking_status === 'confirmed';
    }

    /**
     * Check if booking is cancelled.
     */
    public function isCancelled()
    {
        return $this->booking_status === 'cancelled';
    }

    /**
     * Check if payment is completed.
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Calculate refund percentage based on cancellation time.
     * 
     * Refund Policy:
     * - Less than 6 hours from booking: 90% refund
     * - Less than 12 hours from booking: 75% refund
     * - Less than 24 hours from booking (1 day): 50% refund
     * - Less than 48 hours from booking (2 days): 20% refund
     * - Less than 6 hours before departure: 10% refund
     * - Train already departed: 0% refund
     * 
     * @return float Refund percentage (0-100)
     */
    public function calculateRefundPercentage()
    {
        $now = now();
        
        // Get the train's departure datetime
        $departureDateTime = $this->journey_date->copy()
            ->setTimeFromTimeString($this->train->departure_time->format('H:i:s'));
        
        // If train has already departed, no refund
        if ($now->greaterThanOrEqualTo($departureDateTime)) {
            return 0;
        }
        
        // Check time before departure
        $hoursBeforeDeparture = $now->diffInHours($departureDateTime, false);
        
        // If less than 6 hours before departure, 10% refund
        if ($hoursBeforeDeparture < 6) {
            return 10;
        }
        
        // Check time since booking
        $hoursSinceBooking = $this->booking_date->diffInHours($now);
        
        if ($hoursSinceBooking < 6) {
            return 90;
        } elseif ($hoursSinceBooking < 12) {
            return 75;
        } elseif ($hoursSinceBooking < 24) {
            return 50;
        } elseif ($hoursSinceBooking < 48) {
            return 20;
        } else {
            // More than 48 hours since booking, check departure time
            return 10;
        }
    }
    
    /**
     * Calculate the refund amount.
     * 
     * @return float Refund amount
     */
    public function calculateRefundAmount()
    {
        $percentage = $this->calculateRefundPercentage();
        return ($this->total_fare * $percentage) / 100;
    }
    
    /**
     * Check if booking can be cancelled.
     * 
     * @return bool
     */
    public function canBeCancelled()
    {
        // Can only cancel confirmed or pending bookings
        if (!in_array($this->booking_status, ['confirmed', 'pending'])) {
            return false;
        }
        
        // Can't cancel if train has already departed
        $departureDateTime = $this->journey_date->copy()
            ->setTimeFromTimeString($this->train->departure_time->format('H:i:s'));
        
        return now()->lessThan($departureDateTime);
    }

    /**
     * Cancel the booking with refund calculation.
     */
    public function cancel($reason = null)
    {
        $refundPercentage = $this->calculateRefundPercentage();
        $refundAmount = $this->calculateRefundAmount();
        
        $this->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
            'refund_percentage' => $refundPercentage,
            'refund_amount' => $refundAmount,
            'payment_status' => $refundAmount > 0 ? 'refunded' : 'paid',
        ]);
        
        return [
            'refund_percentage' => $refundPercentage,
            'refund_amount' => $refundAmount,
        ];
    }
}
