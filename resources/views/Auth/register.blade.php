@extends('layouts.app', ['title' => 'Daftar Akun'])

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="bg-[#223347] p-8 rounded-md shadow-2xl border border-black/20">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-white">Daftar Akun Baru</h1>
            <p class="text-xs text-[#8F98A0] mt-1">Daftar sekali untuk menyewa ratusan kaset game fisik</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs font-semibold text-[#8F98A0] uppercase tracking-wider mb-1.5">
                    Nama Lengkap
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}" 
                    required 
                    class="w-full bg-[#171A21] border @error('name') border-rose-500 @else border-[#30455E] @enderror rounded px-3 py-2.5 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]"
                    placeholder="Contoh: Cierlary"
                >
                @error('name')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

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
                    Password (Min. 8 Karakter)
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

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-[#8F98A0] uppercase tracking-wider mb-1.5">
                    Ulangi Password
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    required 
                    class="w-full bg-[#171A21] border border-[#30455E] rounded px-3 py-2.5 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]"
                    placeholder="••••••••"
                >
            </div>

            <!-- Submit Button Hijau -->
            <button 
                type="submit" 
                class="w-full bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold py-2.5 px-4 rounded text-xs transition duration-150 uppercase tracking-wider shadow"
            >
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-[#8F98A0] mt-6">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-[#66C0F4] hover:underline">
                Masuk di sini
            </a>
        </p>

    </div>
</div>
@endsection