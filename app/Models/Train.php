<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'train_number',
        'name',
        'type',
        'route',
        'source_station',
        'destination_station',
        'departure_time',
        'arrival_time',
        'total_seats',
        'available_seats',
        'fare_per_seat',
        'seat_configuration',
        'facilities',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'fare_per_seat' => 'decimal:2',
        'seat_configuration' => 'array',
        'facilities' => 'array',
    ];

    /**
     * Get all bookings for this train.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all coaches for this train.
     */
    public function coaches()
    {
        return $this->hasMany(TrainCoach::class)->orderBy('order');
    }

    /**
     * Get bookings for a specific date.
     */
    public function bookingsForDate($date)
    {
        return $this->bookings()->whereDate('journey_date', $date);
    }

    /**
     * Check if train is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get available seats for a specific date.
     */
    public function getAvailableSeatsForDate($date)
    {
        $bookedSeats = $this->bookingsForDate($date)
            ->where('booking_status', '!=', 'cancelled')
            ->sum('number_of_seats');
        
        return $this->total_seats - $bookedSeats;
    }
}
