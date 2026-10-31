<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('catalog.index');
        }

        return view('auth.login');
    }

    // Memproses Percobaan Login
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        // Auth::attempt memverifikasi password via Hash::check secara otomatis
        if (Auth::attempt($credentials, $remember)) {
            // Mencegah Session Fixation Attack dengan meregenerasi session ID
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, Admin!');
            }

            return redirect()->intended(route('catalog.index'))
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        // Jika kredensial salah
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.']);
    }

    // Menampilkan Form Registrasi
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('catalog.index');
        }

        return view('auth.register');
    }

    // Memproses Registrasi Customer Baru
    public function register(RegisterRequest $request): RedirectResponse
    {
        // Enkripsi password dengan algoritma Bcrypt (Hash::make)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'customer', // Customer biasa secara default
        ]);

        // Auto login setelah registrasi berhasil
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('catalog.index')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di SewaGame.id.');
    }

    // Memproses Logout Pengguna
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        // Bersihkan seluruh data session & regenerasi CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}