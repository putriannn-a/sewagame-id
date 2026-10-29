<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Toko' }} - SewaGame.ID</title>

    <!-- Google Font: Figtree -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        figtree: ['Figtree', 'sans-serif'],
                    },
                    colors: {
                        sg: {
                            bg: '#1B2838',
                            header: '#171A21',
                            panel: '#223347',
                            panelHover: '#2A3F58',
                            text: '#C7D5E0',
                            muted: '#8F98A0',
                            blue: '#66C0F4',
                            green: '#3F7D1A',
                            greenHover: '#4C9620',
                            btnDark: '#2A475E',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #1B2838;
            color: #C7D5E0;
        }
    </style>
</head>
<body class="bg-[#1B2838] text-[#C7D5E0] min-h-screen flex flex-col antialiased selection:bg-[#66C0F4] selection:text-black">

    <!-- Header #171A21 (Hampir Hitam Sesuai Screenshot) -->
    <header class="bg-[#171A21] border-b border-black/40 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            <!-- Top Navigation Bar -->
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('catalog.index') }}" class="text-xl font-extrabold tracking-wider text-white">
                        SewaGame<span class="text-[#66C0F4]">.ID</span>
                    </a>
                </div>

                <!-- Menu Utama -->
                <nav class="flex items-center space-x-6 text-sm">
                    <!-- Menu Sewa Kaset (Toko Utama) -->
                    <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'text-white font-semibold border-b-2 border-[#66C0F4] pb-1' : 'text-[#C7D5E0] hover:text-white transition' }}">
                        Sewa Kaset
                    </a>
                    
                    <!-- Menu Terpisah untuk Sewa Unit Mesin / Paket Mabar -->
                    <!-- <a href="javascript:void(0)" onclick="alert('Fitur Lanjutan: Paket Sewa Mesin Konsol (PS5/Switch), Stik Tambahan & Layar Portable. Saat ini katalog fokus pada persewaan kaset game fisik original.')" class="text-[#C7D5E0] hover:text-[#66C0F4] transition flex items-center space-x-1"> -->
                        <span>Sewa Konsol & Unit</span>
                        <!-- <span class="text-[9px] bg-amber-500/20 text-amber-300 border border-amber-500/30 px-1.5 py-0.5 rounded font-bold">Coming Soon</span> -->
                    </a>

                    <!-- Cara Sewa Modal Alert -->
                    <a href="javascript:void(0)" onclick="alert('Cara sewa: 1. Pilih kaset game, 2. Tentukan durasi 3/7/14 hari, 3. Bayar sewa + jaminan, 4. Ambil di toko / kurir, 5. Jaminan kembali 100% saat kaset kembali!')" class="text-[#C7D5E0] hover:text-white transition">
                        Cara sewa
                    </a>

                    <!-- Area Autentikasi Pengguna -->
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-[#66C0F4] font-semibold hover:underline">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('rentals.my') }}" class="{{ request()->routeIs('rentals.*') ? 'text-white font-semibold border-b-2 border-[#66C0F4] pb-1' : 'text-[#C7D5E0] hover:text-white transition' }}">
                                Sewa saya
                            </a>
                        @endif

                        <!-- Profil & Tombol Logout -->
                        <div class="flex items-center space-x-3 pl-2">
                            <span class="text-xs text-white font-semibold hidden sm:inline">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs bg-[#2A475E] hover:bg-[#345976] text-white px-3 py-1.5 rounded transition font-semibold">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#2A475E] hover:bg-[#345976] text-white text-xs font-semibold px-4 py-2 rounded transition">
                            Masuk
                        </a>
                    @endauth
                </nav>
            </div>

            <!-- Filter & Pencarian Bar (Render dari View Anak) -->
            @yield('filter_bar')

        </div>
    </header>

    <!-- Flash Message Notifikasi -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4 w-full">
        @if(session('success'))
            <div class="p-3.5 mb-3 rounded bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 text-xs flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 font-bold ml-2">&times;</button>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-3.5 mb-3 rounded bg-amber-950/80 border border-amber-500/50 text-amber-200 text-xs flex justify-between items-center">
                <span>{{ session('warning') }}</span>
                <button onclick="this.parentElement.remove()" class="text-amber-400 font-bold ml-2">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 mb-3 rounded bg-rose-950/80 border border-rose-500/50 text-rose-200 text-xs flex justify-between items-center">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-rose-400 font-bold ml-2">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 sm:px-6 py-6">
        @yield('content')
    </main>

    <!-- Footer #171A21 -->
    <footer class="bg-[#171A21] border-t border-black/40 py-6 text-xs text-[#8F98A0] mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div>
                <span class="text-white font-bold">SewaGame<span class="text-[#66C0F4]">.ID</span></span> &bull; Rental Kaset Game Fisik Konsol Original
            </div>
            <div>
                UAS Web Application Development &bull; Universitas Cakrawala &copy; {{ date('Y') }}
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>