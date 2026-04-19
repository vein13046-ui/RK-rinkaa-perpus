<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\PublicStorageController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/storage/{path}', [PublicStorageController::class, 'show'])
    ->where('path', '.*')
    ->name('public.storage.show');

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

    Route::get('/daftar-buku', [\App\Http\Controllers\BookController::class, 'indexUser'])->name('user.books');
    Route::post('/peminjaman/{book}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/peminjaman/status', [BorrowController::class, 'indexUser'])->name('borrow.user.index');
    Route::post('/peminjaman/{borrowRequest}/pickup', [BorrowController::class, 'pickup'])->name('borrow.pickup');
    Route::get('/peminjaman/{borrowRequest}/pickup-data', [BorrowController::class, 'pickupData'])->name('borrow.pickup.data');
    Route::post('/peminjaman/{borrowRequest}/request-return', [BorrowController::class, 'requestReturn'])->name('borrow.request-return');
    Route::get('/riwayat-peminjaman', [BorrowController::class, 'history'])->name('borrow.history');
    Route::delete('/riwayat-peminjaman/{borrowRequest}', [BorrowController::class, 'deleteHistory'])->name('borrow.history.delete');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/customer-service', [SupportController::class, 'index'])->name('support.index');
    Route::post('/customer-service', [SupportController::class, 'store'])->name('support.store');
    Route::post('/customer-service/clear', [SupportController::class, 'clear'])->name('support.clear');
    Route::get('/info-aplikasi', function () {
        return view('app_info');
    })->name('app.info');
    Route::post('/profile/photo', [AuthController::class, 'updateProfilePhoto'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes - requires admin role
Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [\App\Http\Controllers\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [\App\Http\Controllers\BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [\App\Http\Controllers\BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [\App\Http\Controllers\BookController::class, 'update'])->name('books.update');
    Route::get('/books/{book}/profile', [\App\Http\Controllers\BookController::class, 'showProfile'])->name('books.profile');
    Route::get('/books/{book}/profile/download', [\App\Http\Controllers\BookController::class, 'downloadProfile'])->name('books.profile.download');
    Route::delete('/books/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/peminjaman', [BorrowController::class, 'indexAdmin'])->name('borrow.index');
    Route::post('/peminjaman/{borrowRequest}/approve', [BorrowController::class, 'approve'])->name('borrow.approve');
    Route::post('/peminjaman/{borrowRequest}/reject', [BorrowController::class, 'reject'])->name('borrow.reject');
    Route::post('/peminjaman/{borrowRequest}/return', [BorrowController::class, 'approveReturn'])->name('borrow.return');
    Route::post('/peminjaman/{borrowRequest}/return/reject', [BorrowController::class, 'rejectReturn'])->name('borrow.return.reject');

    Route::resource('users', \App\Http\Controllers\UserController::class);
});
