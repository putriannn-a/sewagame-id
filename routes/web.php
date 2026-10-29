<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\PlatformController as AdminPlatformController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Toko & Detail Game)
|--------------------------------------------------------------------------
*/
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/toko', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/game/{id}', [CatalogController::class, 'show'])->name('catalog.show');

/*
|--------------------------------------------------------------------------
| Rute Tamu (Autentikasi)
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
| Rute Khusus Customer (Terproteksi Auth & Role Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/sewa-game/{id}', [RentalController::class, 'checkout'])->name('rentals.checkout');
    Route::post('/sewa-game', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/sewa-saya', [RentalController::class, 'myRentals'])->name('rentals.my');
});

/*
|--------------------------------------------------------------------------
| Rute Khusus Admin (Terproteksi Auth & Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Dashboard Operasional
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Aksi Operasional Rental
    Route::get('/rentals', [DashboardController::class, 'index'])->name('rentals.index');
    Route::post('/rentals/{id}/confirm-payment', [AdminRentalController::class, 'confirmPayment'])->name('rentals.confirmPayment');
    Route::post('/rentals/{id}/return', [AdminRentalController::class, 'returnGame'])->name('rentals.return');

    // 3. CRUD Master Game
    Route::resource('games', AdminGameController::class);

    // 4. CRUD Master Platform
    Route::resource('platforms', AdminPlatformController::class)->except(['create', 'show', 'edit']);
});