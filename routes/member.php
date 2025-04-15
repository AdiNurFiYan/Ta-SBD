<?php

use App\Http\Controllers\Member\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Member\Auth\RegisteredUserController;
use App\Http\Controllers\Member\BookingController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\PackageController;
use App\Http\Controllers\Member\SlotController;
use Illuminate\Support\Facades\Route;

Route::prefix('member')->name('member.')->group(function () {
    // Guest routes (login, register)
    Route::middleware('guest:member')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // Protected routes
    Route::middleware(['auth:member', 'prevent-back-history'])->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Packages
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('packages/{package}', [PackageController::class, 'show'])->name('packages.show');
        
        // Slots
        Route::get('packages/{package}/slots', [SlotController::class, 'index'])->name('slots.index');
        
        // Bookings
        Route::get('packages/{package}/slots/{slot}/book', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('packages/{package}/slots/{slot}/book', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/history', [BookingController::class, 'history'])->name('bookings.history');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        
        // Logout
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});