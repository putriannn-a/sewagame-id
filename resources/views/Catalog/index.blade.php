@extends('layouts.app', ['title' => 'Toko - Rental Game Fisik'])

@section('filter_bar')
<form action="{{ route('catalog.index') }}" method="GET" class="py-3 pb-4 flex flex-wrap items-center gap-3">
    <!-- Input Pencarian -->
    <div class="w-full sm:w-72">
        <input 
            type="text" 
            name="q" 
            value="{{ $searchQuery }}" 
            placeholder="Cari game" 
            class="w-full bg-[#10141A] border border-[#223347] rounded px-3 py-2 text-xs text-white placeholder-[#5A697A] focus:outline-none focus:border-[#66C0F4]"
        >
    </div>

    <!-- Tab Platform (1 Baris Bersih Sesuai Screenshot 2) -->
    <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'all'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ $activeFilter === 'all' ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            Semua
        </a>
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'PS5'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ str_contains(strtolower($activeFilter), 'ps5') ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            PS5
        </a>
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'PS4'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ str_contains(strtolower($activeFilter), 'ps4') ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            PS4
        </a>
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'Switch'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ str_contains(strtolower($activeFilter), 'switch') ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            Switch
        </a>
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'Xbox'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ str_contains(strtolower($activeFilter), 'xbox') ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            Xbox
        </a>
        <a 
            href="{{ route('catalog.index', array_merge(request()->except('platform'), ['platform' => 'Retro'])) }}" 
            class="px-3.5 py-1.5 rounded transition {{ str_contains(strtolower($activeFilter), 'retro') ? 'bg-[#324965] text-white' : 'text-[#C7D5E0] hover:text-white hover:bg-white/5' }}"
        >
            Retro
        </a>
    </div>
</form>
@endsection

@section('content')

<!-- ============================================= -->
<!-- SEKSI 1: GAME PILIHAN (Hero Besar + List Kanan) -->
<!-- ============================================= -->
@if($featuredHero)
<section class="mb-10">
    <h2 class="text-xs font-bold uppercase tracking-widest text-[#728292] mb-3">GAME PILIHAN</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kartu Besar Game Pilihan Utama (Kiri) -->
        <div class="lg:col-span-8 bg-[#223347] rounded-md overflow-hidden relative group h-96">
            <a href="{{ route('catalog.show', $featuredHero->id) }}">
                <!-- Cover Gambar Besar -->
                <img 
                    src="{{ $featuredHero->coverUrl() }}" 
                    alt="{{ $featuredHero->title }}" 
                    class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500 brightness-90"
                >
                <!-- Gradient Overlay Bawah -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#101721] via-[#101721]/50 to-transparent"></div>
                
                <!-- Info Overlay -->
                <div class="absolute bottom-0 inset-x-0 p-6 pt-12 z-10">
                    <h1 class="text-3xl font-extrabold text-white">{{ $featuredHero->title }}</h1>
                    <p class="text-xs text-[#C7D5E0] mt-1">{{ $featuredHero->platform->name }} &bull; Sewa 3, 7, atau 14 hari</p>
                    
                    <div class="flex items-center gap-3 mt-4">
                        <span class="bg-[#3F7D1A] hover:bg-[#4C9620] text-white font-bold text-xs px-5 py-2.5 rounded transition shadow">
                            Sewa sekarang
                        </span>
                        <div class="bg-[#10141A] text-xs font-bold text-white px-3 py-2 rounded">
                            Rp {{ number_format($featuredHero->rent_daily_price, 0, ',', '.') }} / hari
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Daftar 5 Game Pilihan di Kanan -->
        <div class="lg:col-span-4 space-y-2">
            @foreach($featuredList as $index => $item)
                <a 
                    href="{{ route('catalog.show', $item->id) }}" 
                    class="{{ $index === 0 ? 'bg-[#2D4560] border border-[#66C0F4]/30' : 'bg-[#223347] hover:bg-[#283c54]' }} p-3 rounded flex items-center justify-between cursor-pointer transition block"
                >
                    <div class="flex items-center space-x-3">
                        <!-- Thumbnail Cover Kecil -->
                        <div class="w-10 h-10 rounded bg-[#10141A] overflow-hidden flex-shrink-0">
                            <img 
                                src="{{ $item->coverUrl() }}" 
                                alt="{{ $item->title }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white line-clamp-1">{{ $item->title }}</h3>
                            <p class="text-[11px] text-[#AAB8C6] mt-0.5">{{ $item->platform->name }}</p>
                        </div>
                    </div>
                    <div class="bg-[#171A21] px-2.5 py-1.5 rounded text-xs font-bold text-white font-mono flex-shrink-0 ml-2">
                        Rp {{ number_format($item->rent_daily_price, 0, ',', '.') }}
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- ============================================= -->
<!-- SEKSI 2: BARU MASUK (Grid 4 Kolom dengan Cover) -->
<!-- ============================================= -->
<section class="mb-10">
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-xs font-bold uppercase tracking-widest text-[#728292]">BARU MASUK</h2>
        @if($searchQuery || $activeFilter !== 'all')
            <a href="{{ route('catalog.index') }}" class="text-xs text-[#66C0F4] hover:underline">Reset Filter</a>
        @endif
    </div>
    
    @if($recentGames->isEmpty())
        <div class="bg-[#223347] p-8 rounded text-center text-xs text-[#8F98A0]">
            Tidak ada game fisik yang cocok dengan pencarian atau filter platform Anda.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($recentGames as $game)
                <a href="{{ route('catalog.show', $game->id) }}" class="bg-[#223347] rounded-md overflow-hidden flex flex-col justify-between cursor-pointer group hover:ring-1 hover:ring-[#66C0F4]/50 transition">
                    <!-- Cover Gambar Game -->
                    <div class="h-44 bg-[#182535] relative overflow-hidden">
                        <img 
                            src="{{ $game->coverUrl() }}" 
                            alt="{{ $game->title }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#223347] via-transparent to-transparent opacity-60"></div>
                    </div>

                    <!-- Info Game -->
                    <div class="p-3.5">
                        <h3 class="text-sm font-bold text-white line-clamp-1 group-hover:text-[#66C0F4] transition">{{ $game->title }}</h3>
                        <p class="text-xs text-[#8F98A0] mt-0.5">{{ $game->platform->name }}</p>
                        
                        <div class="flex items-center justify-between mt-3 pt-2">
                            <!-- Dot Ketersediaan: Biru = Tersedia, Abu = Dipinjam -->
                            @if($game->stock > 0)
                                <div class="flex items-center space-x-1.5 text-xs text-[#C7D5E0]">
                                    <span class="w-2 h-2 rounded-full bg-[#66C0F4]"></span>
                                    <span>Tersedia</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-1.5 text-xs text-[#8F98A0]">
                                    <span class="w-2 h-2 rounded-full bg-[#5A697A]"></span>
                                    <span>Dipinjam</span>
                                </div>
                            @endif

                            <!-- Pill Harga Per Hari -->
                            <div class="bg-[#171A21] px-2 py-1 rounded text-xs font-bold text-white font-mono">
                                Rp {{ number_format($game->rent_daily_price, 0, ',', '.') }} / hari
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $recentGames->links() }}
        </div>
    @endif
</section>

<!-- ============================================= -->
<!-- SEKSI 3: JELAJAHI PLATFORM -->
<!-- ============================================= -->
<section class="mb-12">
    <h2 class="text-xs font-bold uppercase tracking-widest text-[#728292] mb-3">JELAJAHI PLATFORM</h2>
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach($platforms as $p)
            <a 
                href="{{ route('catalog.index', ['platform' => $p->name]) }}" 
                class="bg-[#223347] hover:bg-[#2b415b] text-white font-bold text-sm py-5 rounded text-center transition block"
            >
                {{ $p->name }}
            </a>
        @endforeach
    </div>
</section>
@endsection