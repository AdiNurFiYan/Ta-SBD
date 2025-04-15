<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SlotController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // Auth Routes
    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Packages Management
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::patch('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
        Route::patch('packages/{id}/restore', [PackageController::class, 'restore'])->name('packages.restore');
        Route::delete('packages/{id}/force-delete', [PackageController::class, 'forceDelete'])->name('packages.force-delete');
        
        // Slots Management
        Route::get('slots', [SlotController::class, 'index'])->name('slots.index');
        Route::get('slots/create', [SlotController::class, 'create'])->name('slots.create');
        Route::post('slots', [SlotController::class, 'store'])->name('slots.store');
        Route::get('slots/{slot}/edit', [SlotController::class, 'edit'])->name('slots.edit');
        Route::patch('slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
        Route::delete('slots/{slot}', [SlotController::class, 'destroy'])->name('slots.destroy');
        Route::delete('slots/{id}/force-delete', [SlotController::class, 'forceDelete'])->name('slots.force-delete');
        Route::post('slots/generate', [SlotController::class, 'generate'])->name('slots.generate');
        
        // Bookings Management
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::patch('bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
        Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('bookings-history', [BookingController::class, 'history'])->name('bookings.history');
        Route::patch('bookings/{id}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
        Route::delete('bookings/{id}/force-delete', [BookingController::class, 'forceDelete'])->name('bookings.force-delete');
        
        // Members Management
        Route::get('members', [MemberController::class, 'index'])->name('members.index');
        Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::delete('members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
        Route::patch('members/{id}/restore', [MemberController::class, 'restore'])->name('members.restore');
        Route::delete('members/{id}/force-delete', [MemberController::class, 'forceDelete'])->name('members.force-delete');
        
        // Logout
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});