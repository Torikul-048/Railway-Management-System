<?php

namespace Database\Seeders;

use App\Models\Train;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trains = [
            [
                'train_number' => 'EXP001',
                'name' => 'Dhaka Express',
                'type' => 'express',
                'route' => 'Dhaka - Chittagong',
                'source_station' => 'Dhaka',
                'destination_station' => 'Chittagong',
                'departure_time' => '08:00:00',
                'arrival_time' => '14:30:00',
                'total_seats' => 200,
                'available_seats' => 200,
                'fare_per_seat' => 450.00,
                'seat_configuration' => [
                    'ac_first' => 20,
                    'ac_chair' => 60,
                    'first_class' => 80,
                    'second_class' => 40
                ],
                'facilities' => ['AC', 'Food Service', 'WiFi', 'Reading Lights', 'Mobile Charging'],
                'status' => 'active',
                'description' => 'Premium express service between Dhaka and Chittagong'
            ],
            [
                'train_number' => 'LOC002',
                'name' => 'Sylhet Local',
                'type' => 'local',
                'route' => 'Dhaka - Sylhet',
                'source_station' => 'Dhaka',
                'destination_station' => 'Sylhet',
                'departure_time' => '06:30:00',
                'arrival_time' => '13:45:00',
                'total_seats' => 150,
                'available_seats' => 150,
                'fare_per_seat' => 280.00,
                'seat_configuration' => [
                    'first_class' => 50,
                    'second_class' => 100
                ],
                'facilities' => ['Basic Seating', 'Fan', 'Drinking Water'],
                'status' => 'active',
                'description' => 'Regular local service to Sylhet'
            ],
            [
                'train_number' => 'IC003',
                'name' => 'Rajshahi Intercity',
                'type' => 'intercity',
                'route' => 'Dhaka - Rajshahi',
                'source_station' => 'Dhaka',
                'destination_station' => 'Rajshahi',
                'departure_time' => '15:30:00',
                'arrival_time' => '21:15:00',
                'total_seats' => 180,
                'available_seats' => 180,
                'fare_per_seat' => 380.00,
                'seat_configuration' => [
                    'ac_chair' => 80,
                    'first_class' => 60,
                    'second_class' => 40
                ],
                'facilities' => ['AC', 'Food Service', 'Reading Lights', 'Mobile Charging'],
                'status' => 'active',
                'description' => 'Comfortable intercity service to Rajshahi'
            ],
            [
                'train_number' => 'MAIL004',
                'name' => 'Khulna Mail',
                'type' => 'mail',
                'route' => 'Dhaka - Khulna',
                'source_station' => 'Dhaka',
                'destination_station' => 'Khulna',
                'departure_time' => '22:00:00',
                'arrival_time' => '05:30:00',
                'total_seats' => 160,
                'available_seats' => 160,
                'fare_per_seat' => 320.00,
                'seat_configuration' => [
                    'sleeper' => 40,
                    'first_class' => 60,
                    'second_class' => 60
                ],
                'facilities' => ['Sleeper Berths', 'Food Service', 'Blankets', 'Reading Lights'],
                'status' => 'active',
                'description' => 'Overnight mail service to Khulna'
            ],
            [
                'train_number' => 'PASS005',
                'name' => 'Mymensingh Passenger',
                'type' => 'passenger',
                'route' => 'Dhaka - Mymensingh',
                'source_station' => 'Dhaka',
                'destination_station' => 'Mymensingh',
                'departure_time' => '09:15:00',
                'arrival_time' => '12:30:00',
                'total_seats' => 120,
                'available_seats' => 120,
                'fare_per_seat' => 150.00,
                'seat_configuration' => [
                    'second_class' => 120
                ],
                'facilities' => ['Basic Seating', 'Fan'],
                'status' => 'active',
                'description' => 'Economic passenger service to Mymensingh'
            ],
            [
                'train_number' => 'MAINT006',
                'name' => 'Barisal Express',
                'type' => 'express',
                'route' => 'Dhaka - Barisal',
                'source_station' => 'Dhaka',
                'destination_station' => 'Barisal',
                'departure_time' => '07:45:00',
                'arrival_time' => '13:20:00',
                'total_seats' => 140,
                'available_seats' => 0,
                'fare_per_seat' => 350.00,
                'seat_configuration' => [
                    'ac_chair' => 60,
                    'first_class' => 80
                ],
                'facilities' => ['Under Maintenance'],
                'status' => 'maintenance',
                'description' => 'Currently under maintenance - will resume service soon'
            ]
        ];

        foreach ($trains as $train) {
            Train::create($train);
        }
    }
}
