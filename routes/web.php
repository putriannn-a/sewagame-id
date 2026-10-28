<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik & Toko
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('catalog.index');
});

// Placeholder Katalog Toko (akan kita buat penuh di Tahap 4)
Route::get('/toko', function () {
    return view('catalog.placeholder');
})->name('catalog.index');

/*
|--------------------------------------------------------------------------
| Rute Tamu (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Rute Customer (Auth & Role: Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/sewa-saya', function () {
        return view('rentals.placeholder');
    })->name('rentals.my');
});

/*
|--------------------------------------------------------------------------
| Rute Admin (Auth & Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.placeholder');
    })->name('dashboard');
});