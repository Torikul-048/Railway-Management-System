<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainCoach extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'train_id',
        'coach_number',
        'coach_name',
        'coach_type',
        'total_seats',
        'seats_per_row',
        'total_rows',
        'layout_config',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'layout_config' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the train that owns this coach.
     */
    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    /**
     * Get all seats in this coach.
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Get available seats in this coach.
     */
    public function availableSeats()
    {
        return $this->seats()->where('is_available', true)->where('is_reserved', false);
    }

    /**
     * Get available seats for a specific date.
     */
    public function getAvailableSeatsForDate($date)
    {
        // Get all seats in this coach
        $allSeats = $this->seats()->pluck('seat_number')->toArray();
        
        // Get booked seats for this date
        $bookedSeats = Booking::where('train_id', $this->train_id)
            ->whereDate('journey_date', $date)
            ->whereIn('booking_status', ['confirmed', 'pending'])
            ->get()
            ->pluck('seat_numbers')
            ->flatten()
            ->toArray();
        
        // Return available seats
        return array_diff($allSeats, $bookedSeats);
    }
}
