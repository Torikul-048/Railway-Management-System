<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Train;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sample users and trains
        $users = User::where('role', 'customer')->get();
        $trains = Train::where('status', 'active')->get();

        if ($users->count() > 0 && $trains->count() > 0) {
            // Create some sample bookings
            $bookings = [
                [
                    'user_id' => $users->first()->id,
                    'train_id' => $trains->first()->id,
                    'journey_date' => Carbon::now()->addDays(7),
                    'number_of_seats' => 2,
                    'seat_numbers' => ['A1', 'A2'],
                    'total_fare' => $trains->first()->fare_per_seat * 2,
                    'booking_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'credit_card',
                    'payment_reference' => 'PAY123456789',
                    'passenger_details' => [
                        [
                            'name' => 'John Doe',
                            'age' => 30,
                            'gender' => 'male',
                            'seat' => 'A1'
                        ],
                        [
                            'name' => 'Jane Doe',
                            'age' => 28,
                            'gender' => 'female',
                            'seat' => 'A2'
                        ]
                    ],
                    'special_requests' => 'Window seats preferred'
                ],
                [
                    'user_id' => $users->count() > 1 ? $users->get(1)->id : $users->first()->id,
                    'train_id' => $trains->count() > 1 ? $trains->get(1)->id : $trains->first()->id,
                    'journey_date' => Carbon::now()->addDays(3),
                    'number_of_seats' => 1,
                    'seat_numbers' => ['B5'],
                    'total_fare' => $trains->count() > 1 ? $trains->get(1)->fare_per_seat : $trains->first()->fare_per_seat,
                    'booking_status' => 'pending',
                    'payment_status' => 'pending',
                    'passenger_details' => [
                        [
                            'name' => 'Jane Smith',
                            'age' => 35,
                            'gender' => 'female',
                            'seat' => 'B5'
                        ]
                    ]
                ],
                [
                    'user_id' => $users->first()->id,
                    'train_id' => $trains->count() > 2 ? $trains->get(2)->id : $trains->first()->id,
                    'journey_date' => Carbon::now()->addDays(14),
                    'number_of_seats' => 3,
                    'seat_numbers' => ['C1', 'C2', 'C3'],
                    'total_fare' => ($trains->count() > 2 ? $trains->get(2)->fare_per_seat : $trains->first()->fare_per_seat) * 3,
                    'booking_status' => 'confirmed',
                    'payment_status' => 'paid',
                    'payment_method' => 'bkash',
                    'payment_reference' => 'BK987654321',
                    'passenger_details' => [
                        [
                            'name' => 'Alice Johnson',
                            'age' => 25,
                            'gender' => 'female',
                            'seat' => 'C1'
                        ],
                        [
                            'name' => 'Bob Johnson',
                            'age' => 27,
                            'gender' => 'male',
                            'seat' => 'C2'
                        ],
                        [
                            'name' => 'Charlie Johnson',
                            'age' => 5,
                            'gender' => 'male',
                            'seat' => 'C3'
                        ]
                    ],
                    'special_requests' => 'Family with child - adjacent seats'
                ]
            ];

            foreach ($bookings as $bookingData) {
                Booking::create($bookingData);
            }

            // Update available seats for trains
            $trains->each(function ($train) {
                $bookedSeats = $train->bookings()
                    ->where('booking_status', '!=', 'cancelled')
                    ->sum('number_of_seats');
                
                $train->update([
                    'available_seats' => $train->total_seats - $bookedSeats
                ]);
            });
        }
    }
}
