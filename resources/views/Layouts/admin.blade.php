<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - SewaGame.ID</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #1B2838;
            color: #C7D5E0;
        }
    </style>
</head>
<body class="bg-[#1B2838] text-[#C7D5E0] min-h-screen flex antialiased">

    <!-- Sidebar Kiri #171A21 Persis Screenshot 3 -->
    <aside class="w-56 bg-[#171A21] border-r border-black/30 flex flex-col justify-between p-6 flex-shrink-0 min-h-screen sticky top-0 h-screen">
        <div>
            <!-- Brand Logo -->
            <div class="text-lg font-extrabold text-white tracking-wider mb-8">
            <!-- Logo Modern Gaming Style -->
            <a href="{{ route('catalog.index') }}" class="flex items-center space-x-2.5 group">
                <!-- Tipografi Logo -->
                <div class="flex flex-col">
                    <span class="text-lg font-black tracking-wider text-white uppercase leading-none">
                        SEWA<span class="text-[#66C0F4]">GAME</span>
                    </span>
                    <span class="text-[9px] font-bold tracking-widest text-[#8F98A0] uppercase leading-tight">
                        CONSOLE RENTAL
                    </span>
                </div>
            </a>
            </div>

            <!-- Menu Sidebar -->
            <nav class="space-y-1 text-sm font-semibold">
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="block px-3 py-2.5 rounded transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#223347] text-white font-bold' : 'text-[#8F98A0] hover:text-white hover:bg-white/5' }}"
                >
                    Dashboard
                </a>

                <a 
                    href="{{ route('admin.games.index') }}" 
                    class="block px-3 py-2.5 rounded transition {{ request()->routeIs('admin.games.*') ? 'bg-[#223347] text-white font-bold' : 'text-[#8F98A0] hover:text-white hover:bg-white/5' }}"
                >
                    Game
                </a>

                <a 
                    href="{{ route('admin.platforms.index') }}" 
                    class="block px-3 py-2.5 rounded transition {{ request()->routeIs('admin.platforms.*') ? 'bg-[#223347] text-white font-bold' : 'text-[#8F98A0] hover:text-white hover:bg-white/5' }}"
                >
                    Platform
                </a>

                <a 
                    href="{{ route('admin.rentals.index') }}" 
                    class="block px-3 py-2.5 rounded transition {{ request()->routeIs('admin.rentals.*') ? 'bg-[#223347] text-white font-bold' : 'text-[#8F98A0] hover:text-white hover:bg-white/5' }}"
                >
                    Sewa
                </a>

                <a 
                    href="javascript:void(0)" 
                    onclick="alert('Manajemen pengguna aktif: {{ Auth::user()->name }} (Role: Admin)')" 
                    class="block px-3 py-2.5 rounded text-[#8F98A0] hover:text-white hover:bg-white/5 transition"
                >
                    Pengguna
                </a>
            </nav>
        </div>

        <!-- Tombol Keluar / Kembali ke Toko -->
        <div class="pt-4 border-t border-white/5 space-y-2">
            <a href="{{ route('catalog.index') }}" class="block text-xs font-semibold text-[#66C0F4] hover:underline px-3 py-1.5">
                &larr; Lihat Toko Publik
            </a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-semibold text-[#8F98A0] hover:text-rose-400 transition">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0 bg-[#1B2838]">
        
        <!-- Flash Message Notification -->
        <div class="px-8 pt-6 w-full">
            @if(session('success'))
                <div class="p-3.5 mb-4 rounded bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 text-xs flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 font-bold ml-2">&times;</button>
                </div>
            @endif

            @if(session('warning'))
                <div class="p-3.5 mb-4 rounded bg-amber-950/80 border border-amber-500/50 text-amber-200 text-xs flex justify-between items-center">
                    <span>{{ session('warning') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-amber-400 font-bold ml-2">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3.5 mb-4 rounded bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-rose-400 font-bold ml-2">&times;</button>
                </div>
            @endif
        </div>

        <main class="flex-grow p-8 pt-2">
            @yield('content')
        </main>
    </div>

</body>
</html>