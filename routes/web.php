<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Katalog & Detail Game)
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
| Rute Khusus Customer (Auth & Role: Customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Placeholder untuk checkout dan sewa saya (akan dihubungkan di Tahap 5)
    Route::get('/sewa-game/{id}', function ($id) {
        return redirect()->route('catalog.show', $id);
    })->name('rentals.checkout');

    Route::get('/sewa-saya', function () {
        return view('rentals.placeholder');
    })->name('rentals.my');
});

/*
|--------------------------------------------------------------------------
| Rute Khusus Admin (Auth & Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.placeholder');
    })->name('dashboard');
});