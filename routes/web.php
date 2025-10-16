<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
// Register
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Forgot / Reset password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->middleware('guest')->name('password.update');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); //dummy route
// Route::get('/journey/{id}', [JourneyController::class, 'show'])->name('journey.show'); //dummy route
// Route::get('/journeys/create', [JourneyController::class, 'create'])->name('journey.create'); //dummy route
 //dummy route
// Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); //dummy route

Route::middleware('auth')->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Journey
    Route::get('/journey/create', [JourneyController::class, 'create'])->name('journey.create');
    Route::post('/journey', [JourneyController::class, 'store'])->name('journey.store');
    Route::get('/journey/{journey}/edit', [JourneyController::class, 'edit'])->name('journey.edit');
    Route::put('/journey/{journey}', [JourneyController::class, 'update'])->name('journey.update');
    Route::delete('/journey/{journey}', [JourneyController::class, 'destroy'])->name('journey.destroy');
    Route::get('/journey/{journey}', [JourneyController::class, 'show'])->name('journey.show');

    //Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});