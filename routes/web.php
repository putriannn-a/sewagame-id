<?php

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
| Rute Khusus Customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/sewa-game/{id}', [RentalController::class, 'checkout'])->name('rentals.checkout');
    Route::post('/sewa-game', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/sewa-saya', [RentalController::class, 'myRentals'])->name('rentals.my');
});

/*
|--------------------------------------------------------------------------
| Rute Khusus Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.placeholder');
    })->name('dashboard');

    // Aksi Operasional Rental Admin
    Route::post('/rentals/{id}/confirm-payment', [AdminRentalController::class, 'confirmPayment'])->name('rentals.confirmPayment');
    Route::post('/rentals/{id}/return', [AdminRentalController::class, 'returnGame'])->name('rentals.return');
});