<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/',         [SportController::class, 'home'])->name('home');
Route::get('/venues',   [SportController::class, 'venues'])->name('venues');

// SAW recommendation search
Route::get('/recommend',  [SportController::class, 'recommend'])->name('recommend');

// Booking (available to guests + logged-in users)
Route::get('/book',    [SportController::class, 'book'])->name('book');
Route::post('/book',   [SportController::class, 'submitBooking'])->name('book.submit');
Route::get('/booking/{ref}', [SportController::class, 'confirmation'])->name('booking.confirmation');

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Renter Dashboard ──────────────────────────────────────────────────────────
Route::prefix('dashboard')->middleware(['auth', 'role:renter'])->name('renter.')->group(function () {
    Route::get('/',          [RenterController::class, 'dashboard'])->name('dashboard');
    Route::post('/reservations/{reservation}/cancel', [RenterController::class, 'cancelReservation'])->name('reservation.cancel');
});

// ── Staff Dashboard ───────────────────────────────────────────────────────────
Route::prefix('staff')->middleware(['auth', 'role:staff,admin'])->name('staff.')->group(function () {
    Route::get('/',                       [StaffController::class, 'dashboard'])->name('dashboard');
    Route::post('/reservations/{reservation}/status', [StaffController::class, 'updateStatus'])->name('reservation.status');
    Route::post('/reservations/{reservation}/verify-payment', [StaffController::class, 'verifyPayment'])->name('reservation.verify-payment');
    Route::get('/walk-in',                [StaffController::class, 'walkIn'])->name('walk-in');
    Route::post('/walk-in',               [StaffController::class, 'storeWalkIn'])->name('walk-in.store');
});

// ── Admin Dashboard ───────────────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/',                  [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservations',      [AdminController::class, 'reservations'])->name('reservations');
    Route::get('/users',             [AdminController::class, 'users'])->name('users');
    Route::post('/venues/{venue}/toggle', [AdminController::class, 'toggleVenue'])->name('venues.toggle');
});
