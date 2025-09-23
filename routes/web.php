<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Test routes for layouts (remove these after testing)
Route::get('/test-admin', function () {
    return view('admin.dashboard');
})->name('test.admin');

Route::get('/test-customer', function () {
    return view('test.customer');
})->name('test.customer');
