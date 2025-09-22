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
     * Cancel the booking.
     */
    public function cancel($reason = null)
    {
        $this->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }
}
