@extends('layouts.app', ['title' => 'Masuk'])

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="bg-[#223347] p-8 rounded-md shadow-2xl border border-black/20">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-white">Masuk ke Akun</h1>
            <p class="text-xs text-[#8F98A0] mt-1">Sewa game fisik PS5, Switch, PS4, Xbox & Retro</p>
        </div>

        <!-- Akun Demo untuk Penguji UAS
        <div class="mb-6 p-3 bg-[#171A21] border border-[#30455E] rounded text-xs">
            <p class="font-bold text-[#66C0F4] mb-1">Akun Demo Pengujian UAS:</p>
            <div class="grid grid-cols-2 gap-2 text-[11px]">
                <div>
                    <span class="text-slate-400">Admin:</span><br>
                    <code class="text-white">admin@sewagame.id</code><br>
                    <span class="text-slate-400">pass: admin123</span>
                </div>
                <div>
                    <span class="text-slate-400">Customer:</span><br>
                    <code class="text-white">cierlary@gmail.com</code><br>
                    <span class="text-slate-400">pass: customer123</span>
                </div>
            </div>
        </div> -->

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            <!-- Proteksi CSRF Server-Side -->
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#8F98A0] uppercase tracking-wider mb-1.5">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email') }}" 
                    required 
                    class="w-full bg-[#171A21] border @error('email') border-rose-500 @else border-[#30455E] @enderror rounded px-3 py-2.5 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]"
                    placeholder="nama@email.com"
                >
                @error('email')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-[#8F98A0] uppercase tracking-wider mb-1.5">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    class="w-full bg-[#171A21] border @error('password') border-rose-500 @else border-[#30455E] @enderror rounded px-3 py-2.5 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center text-xs">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded bg-[#171A21] border-[#30455E] text-[#66C0F4] focus:ring-0">
                    <span class="text-[#8F98A0]">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button (Warna Aksi Utama Hijau #3F7D1A) -->
            <button 
                type="submit" 
                class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold py-2.5 px-4 rounded text-xs transition duration-150 uppercase tracking-wider shadow"
            >
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-[#8F98A0] mt-6">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-[#66C0F4] hover:underline">
                Daftar akun baru
            </a>
        </p>

    </div>
</div>
@endsection