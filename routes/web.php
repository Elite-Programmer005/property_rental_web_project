<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Property Routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Authentication Routes (if using Laravel Breeze, these are already included)
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

// Temporary logout route (will be replaced by Laravel Breeze)
Route::post('/logout', function () {
    return redirect('/')->with('message', 'Logged out successfully!');
})->name('logout');

// Protected Routes (need login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // More protected routes will go here
});