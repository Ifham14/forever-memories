<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

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

    //Notebook
    Route::get('/notebook', [NotebookController::class, 'index'])->name('notebook.index');
    Route::get('/notebook/create', [NotebookController::class, 'create'])->name('notebook.create');
    Route::post('/notebook', [NotebookController::class, 'store'])->name('notebook.store');
    Route::get('/notebook/{notebook}/edit', [NotebookController::class, 'edit'])->name('notebook.edit');
    Route::put('/notebook/{notebook}', [NotebookController::class, 'update'])->name('notebook.update');
    Route::delete('/notebook/{notebook}', [NotebookController::class, 'destroy'])->name('notebook.destroy');
    Route::get('/notebook/{notebook}', [NotebookController::class, 'show'])->name('notebook.show');

    //Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit-password', [AdminController::class, 'editPassword'])->name('users.editPassword');
    Route::put('/users/{user}/update-password', [AdminController::class, 'updatePassword'])->name('users.updatePassword');
    Route::post('/users/{user}/toggle-active', [AdminController::class, 'toggleActive'])->name('users.toggle-active');
});