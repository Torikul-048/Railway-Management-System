<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Train;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@railway.com',
            'password' => Hash::make('password'),
            'phone' => '+8801711111111',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@railway.com',
            'password' => Hash::make('password'),
            'phone' => '+8801722222222',
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Create test customer
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone' => '+8801733333333',
            'date_of_birth' => '1990-01-15',
            'gender' => 'male',
            'address' => '123 Main Street, Dhaka',
            'national_id' => '1234567890123',
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Create another test customer
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone' => '+8801744444444',
            'date_of_birth' => '1985-05-20',
            'gender' => 'female',
            'address' => '456 Oak Avenue, Chittagong',
            'national_id' => '9876543210987',
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Call other seeders
        $this->call([
            TrainSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
