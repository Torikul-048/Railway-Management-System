<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'train_coach_id',
        'seat_number',
        'row_number',
        'column_number',
        'seat_type',
        'is_available',
        'is_reserved',
        'reserved_until',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_available' => 'boolean',
        'is_reserved' => 'boolean',
        'reserved_until' => 'datetime',
    ];

    /**
     * Get the coach that owns this seat.
     */
    public function trainCoach()
    {
        return $this->belongsTo(TrainCoach::class);
    }

    /**
     * Reserve this seat temporarily.
     */
    public function reserve($minutes = 10)
    {
        $this->update([
            'is_reserved' => true,
            'reserved_until' => Carbon::now()->addMinutes($minutes),
        ]);
    }

    /**
     * Release the reservation.
     */
    public function releaseReservation()
    {
        $this->update([
            'is_reserved' => false,
            'reserved_until' => null,
        ]);
    }

    /**
     * Check if reservation has expired.
     */
    public function isReservationExpired()
    {
        if (!$this->is_reserved || !$this->reserved_until) {
            return false;
        }
        
        return Carbon::now()->gt($this->reserved_until);
    }

    /**
     * Check if seat is currently available for booking.
     */
    public function isAvailableForBooking()
    {
        if (!$this->is_available) {
            return false;
        }
        
        if ($this->is_reserved && !$this->isReservationExpired()) {
            return false;
        }
        
        return true;
    }

    /**
     * Scope to get available seats.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                     ->where(function ($q) {
                         $q->where('is_reserved', false)
                           ->orWhere('reserved_until', '<', Carbon::now());
                     });
    }
}
