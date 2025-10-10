<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirect admins to dashboard
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'verifyEmail'])->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Profile Routes
Route::middleware(['auth', 'redirect.if.admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// Train Search Routes (Public - but redirect admins)
Route::middleware(['redirect.if.admin'])->group(function () {
    Route::get('/trains/search', [TrainSearchController::class, 'index'])->name('trains.search');
    Route::get('/trains/{train}/details', [TrainSearchController::class, 'show'])->name('trains.details');
});

// Booking Routes (Authenticated - customers only)
Route::middleware(['auth', 'redirect.if.admin'])->group(function () {
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
    
    // Booking Cancellation Routes
    Route::get('/bookings/{booking}/cancel', [App\Http\Controllers\BookingController::class, 'cancelConfirm'])->name('bookings.cancel-confirm');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $recentBookings = \App\Models\Booking::with(['user', 'train'])
            ->latest()
            ->take(5)
            ->get();
        
        $totalTrains = \App\Models\Train::count();
        $totalBookings = \App\Models\Booking::count();
        $totalUsers = \App\Models\User::where('role', 'customer')->count();
        $totalRevenue = \App\Models\Booking::where('booking_status', 'confirmed')->sum('total_fare');
        
        return view('admin.dashboard', compact('recentBookings', 'totalTrains', 'totalBookings', 'totalUsers', 'totalRevenue'));
    })->name('dashboard');
    
    // Train Management Routes
    Route::resource('trains', TrainController::class);
    
    // Admin Booking Management Routes
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/cancel-confirm', [App\Http\Controllers\Admin\BookingController::class, 'cancelConfirm'])->name('bookings.cancel-confirm');
    Route::post('/bookings/{booking}/cancel', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::get('/bookings/export', [App\Http\Controllers\Admin\BookingController::class, 'export'])->name('bookings.export');
    
    // Reports & Analytics Routes
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/booking-stats', [App\Http\Controllers\Admin\ReportController::class, 'bookingStats'])->name('reports.booking-stats');
    Route::get('/reports/revenue-stats', [App\Http\Controllers\Admin\ReportController::class, 'revenueStats'])->name('reports.revenue-stats');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
    
    // User Management Routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Route Management Routes
    Route::get('/routes', [App\Http\Controllers\Admin\RouteManagementController::class, 'index'])->name('routes.index');
    
    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
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
