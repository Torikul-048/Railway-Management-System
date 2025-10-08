<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');




// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Train Search Routes (Public)
Route::get('/trains/search', [TrainSearchController::class, 'index'])->name('trains.search');
Route::get('/trains/{train}/details', [TrainSearchController::class, 'show'])->name('trains.details');

// Booking Routes (Authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-bookings', [App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.index');
    Route::get('/bookings/{booking}/download-ticket', [App\Http\Controllers\BookingController::class, 'downloadTicket'])->name('bookings.download-ticket');
    Route::get('/trains/{train}/select-seats', [App\Http\Controllers\BookingController::class, 'selectSeats'])->name('bookings.select-seats');
    Route::post('/bookings/reserve-seats', [App\Http\Controllers\BookingController::class, 'reserveSeats'])->name('bookings.reserve-seats');
    Route::post('/trains/{train}/booking-form', [App\Http\Controllers\BookingController::class, 'bookingForm'])->name('bookings.booking-form');
    Route::post('/trains/{train}/book', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/payment', [App\Http\Controllers\BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/bookings/{booking}/process-payment', [App\Http\Controllers\BookingController::class, 'processPayment'])->name('bookings.process-payment');
    Route::get('/bookings/{booking}/confirmation', [App\Http\Controllers\BookingController::class, 'confirmation'])->name('bookings.confirmation');
    Route::post('/bookings/check-availability', [App\Http\Controllers\BookingController::class, 'checkSeatAvailability'])->name('bookings.check-availability');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Train Management Routes
    Route::resource('trains', TrainController::class);
});

// Customer Routes
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('test.customer');
    })->name('dashboard');
});

// Test routes for layouts (remove these after testing)
Route::get('/test-admin', function () {
    return view('admin.dashboard');
})->name('test.admin');

Route::get('/test-customer', function () {
    return view('test.customer');
})->name('test.customer');
