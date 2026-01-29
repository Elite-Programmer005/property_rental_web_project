<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalApplicationController;
use App\Http\Controllers\ImageController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');

// Breeze authentication routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Favorite routes
    Route::post('/properties/{property}/favorite', [PropertyController::class, 'favorite'])->name('properties.favorite');
    Route::delete('/properties/{property}/favorite', [PropertyController::class, 'unfavorite'])->name('properties.unfavorite');
    
    // Rental application routes
    Route::post('/properties/{property}/apply', [RentalApplicationController::class, 'store'])->name('properties.apply');
});

Route::middleware(['auth', 'landlord.agent'])->group(function () {
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
    
    // Image management routes
    Route::get('/properties/{property}/images', [ImageController::class, 'index'])->name('properties.images.index');
    Route::post('/properties/{property}/images/{image}/set-primary', [ImageController::class, 'setPrimary'])->name('properties.images.setPrimary');
    Route::post('/properties/{property}/images/reorder', [ImageController::class, 'reorder'])->name('properties.images.reorder');
    Route::delete('/properties/{property}/images/{image}', [ImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::post('/properties/{property}/images/bulk-delete', [ImageController::class, 'bulkDelete'])->name('properties.images.bulkDelete');
});

// Property show route (MUST be after /properties/create)
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Debug route - Remove after testing
Route::get('/debug-storage', function() {
    return response()->json([
        'storage_link_exists' => file_exists(public_path('storage')),
        'storage_path' => storage_path('app/public'),
        'public_storage_path' => public_path('storage'),
        'filesystem_disk' => config('filesystems.default'),
        'public_disk_url' => config('filesystems.disks.public.url'),
        'properties_folder_exists' => is_dir(storage_path('app/public/properties')),
        'test_file_url' => asset('storage/test.jpg'),
    ]);
});

// Breeze auth routes (login, register, logout)
require __DIR__.'/auth.php';