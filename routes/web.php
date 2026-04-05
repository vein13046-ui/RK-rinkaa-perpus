<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('auth.login');
});

// Guest only - redirect logged users to dashboard
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected - login/register locked
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/user', [AuthController::class, 'userDashboard'])->name('dashboard.user');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/photo', [AuthController::class, 'updateProfilePhoto'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes - simple auth check (add role=='admin' in controller if needed)
Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [\App\Http\Controllers\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [\App\Http\Controllers\BookController::class, 'store'])->name('books.store');
});
