<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enzzie Shop - More</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'enzzie-red':  '#E8001E',
                        'enzzie-dark': '#111111',
                        'enzzie-card': '#1A1A1A',
                        'enzzie-border': '#2A2A2A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }

        .banner-track {
            display: flex;
            transition: transform 0.5s ease;
        }
        .banner-slide {
            min-width: 100%;
            flex-shrink: 0;
        }
        .product-card:hover .product-img {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="text-white min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-40 flex flex-col bg-enzzie-dark border-r border-enzzie-border w-72 lg:static lg:translate-x-0 -translate-x-full transition-transform">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-enzzie-border">
            <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
            </div>
            <span class="text-lg font-bold tracking-tight text-white font-['Inter']">Enzzie Shop</span>
        </div>

        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="px-3 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('user.more') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    Shop
                </a>
            </div>

            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">Artis</p>
                <div class="relative mb-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Search Artis" class="w-full bg-enzzie-border/50 border border-enzzie-border rounded-md pl-7 pr-3 py-1.5 text-xs text-white placeholder-gray-600 outline-none focus:border-enzzie-red transition-colors">
                </div>
                @foreach($artists->take(4) as $artist)
                <a href="{{ route('user.artist.show', $artist->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 transition-colors group">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-[#1e1e1e]">
                         @if($artist->avatar)
                            <img src="{{ asset('storage/'.$artist->avatar) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[10px] font-bold">{{ strtoupper(substr($artist->name, 0, 2)) }}</div>
                        @endif
                    </div>
                    <span class="text-sm font-medium truncate uppercase">{{ $artist->name }}</span>
                </a>
                @endforeach
            </div>

            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">Go to Service</p>
                <a href="{{ route('user.shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <span class="text-sm font-medium">Shop</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto">
        <!-- HEADER -->
        <header class="sticky top-0 z-20 flex items-center justify-between px-4 py-4 bg-[#0a0a0a]/80 backdrop-blur-md border-b border-enzzie-border">
             <div class="flex items-center gap-3 lg:hidden">
                <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-lg font-bold">Enzzie Shop</span>
            </div>
            <div class="hidden lg:block"></div>
            <div class="flex items-center gap-4">
                <div class="relative">
                     <span class="absolute top-0 right-0 w-4 h-4 bg-enzzie-red text-[10px] font-bold text-white rounded-full flex items-center justify-center border-2 border-[#0a0a0a]">89+</span>
                     <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </header>

        <main class="p-4 lg:p-6 space-y-8">
            <!-- BANNER -->
            @if($banners->count())
            <div class="relative group h-64 lg:h-80 w-full overflow-hidden rounded-3xl bg-enzzie-card">
                 <div id="bannerTrack" class="banner-track h-full">
                    @foreach($banners as $banner)
                    <div class="banner-slide flex flex-col lg:flex-row items-center justify-between p-8 lg:p-12 gap-8 relative overflow-hidden">
                        <div class="relative z-10 space-y-4">
                            <h2 class="text-3xl lg:text-5xl font-black uppercase leading-tight max-w-xl">
                                {!! nl2br(e($banner->title)) !!}
                            </h2>
                            <p class="text-gray-400 text-sm lg:text-base font-medium">Let's celebrate together!</p>
                            <div class="flex items-center gap-2 pt-4">
                                <div class="h-1 w-12 bg-white rounded-full"></div>
                                <span class="text-xs font-bold text-gray-500">{{ $loop->iteration }} | {{ $banners->count() }}</span>
                            </div>
                        </div>
                        <div class="relative z-10 w-full lg:w-1/2 h-full flex items-center justify-center">
                            @if($banner->image)
                                <img src="{{ asset('storage/'.$banner->image) }}" class="max-h-full max-w-full object-contain drop-shadow-2xl">
                            @endif
                        </div>
                        <!-- Background glow effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-enzzie-red/20 to-transparent pointer-events-none"></div>
                    </div>
                    @endforeach
                 </div>
                 <!-- Controls -->
                 <button onclick="prevBanner()" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 hover:bg-white/20 transition-all opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                 </button>
                 <button onclick="nextBanner()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 hover:bg-white/20 transition-all opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                 </button>
            </div>
            @endif

            <!-- ARTIST ROW -->
            <div class="bg-enzzie-card border border-enzzie-border rounded-3xl p-6">
                <div class="flex items-center gap-6 overflow-x-auto scrollbar-none">
                    @foreach($artists as $artist)
                    <a href="{{ route('user.artist.show', $artist->slug) }}" class="flex flex-col items-center gap-2 shrink-0 group">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-enzzie-border group-hover:border-enzzie-red transition-all scale-100 group-hover:scale-105 bg-[#1e1e1e]">
                             @if($artist->avatar)
                                <img src="{{ asset('storage/'.$artist->avatar) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($artist->name, 0, 2)) }}</div>
                            @endif
                        </div>
                        <span class="text-[10px] uppercase font-bold text-gray-500 group-hover:text-white transition-colors">{{ $artist->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- SEARCH BAR MID -->
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" placeholder="Cari artis atau merch..." class="w-full bg-enzzie-card border border-enzzie-border rounded-full pl-12 pr-6 py-3.5 text-sm text-white placeholder-gray-600 outline-none focus:border-enzzie-red transition-all shadow-lg">
            </div>

            <!-- SECTIONS BY ARTIST -->
            @foreach($artists as $artist)
            @if($artist->merches->count())
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-600 uppercase tracking-widest">{{ $artist->agency ?? 'Enzzie Entertainment' }}</p>
                        <h3 class="text-xl font-black uppercase italic tracking-tighter flex items-center gap-2">
                            {{ $artist->name }}
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                        </h3>
                    </div>
                </div>

                <div class="flex gap-4 overflow-x-auto scrollbar-none pb-2">
                    @foreach($artist->merches as $merch)
                    <div class="product-card shrink-0 w-44 lg:w-48 bg-enzzie-card border border-enzzie-border rounded-2xl overflow-hidden transition-all hover:bg-white/5 active:scale-95">
                         <div class="aspect-square relative overflow-hidden bg-white/5 p-4 flex items-center justify-center">
                            @if($merch->foto_url)
                                <img src="{{ $merch->foto_url }}" class="product-img w-full h-full object-contain transition-transform duration-500">
                            @else
                                <div class="product-img w-20 h-20 text-gray-700 flex items-center justify-center text-4xl">📦</div>
                            @endif
                             @if($merch->status === 'pre_order')
                                <div class="absolute bottom-3 left-3 px-2 py-0.5 bg-enzzie-red text-[8px] font-black text-white rounded uppercase italic">Pre-Order</div>
                            @endif
                         </div>
                         <div class="p-4 space-y-1">
                            <h4 class="text-xs font-bold text-gray-400 truncate">{{ $merch->nama }}</h4>
                            <p class="text-xs font-black text-white">Rp.{{ number_format($merch->harga, 0, ',', '.') }}</p>
                            @if($merch->status !== 'stok_habis')
                                <div class="pt-2">
                                    <button class="w-full py-1.5 bg-enzzie-border text-[9px] font-bold uppercase rounded-md text-gray-300 hover:bg-enzzie-red hover:text-white transition-colors">Tambah Keranjang</button>
                                </div>
                            @else
                                <div class="pt-2">
                                    <div class="w-full py-1.5 bg-gray-800 text-[9px] font-bold uppercase rounded-md text-gray-600 text-center cursor-not-allowed">Stok Habis</div>
                                </div>
                            @endif
                         </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
            @endforeach
        </main>
    </div>

    <script>
        let currentIdx = 0;
        const banners = document.querySelectorAll('.banner-slide');
        const track = document.getElementById('bannerTrack');

        function updateBanner() {
            if (track) {
                track.style.transform = `translateX(-${currentIdx * 100}%)`;
            }
        }

        function nextBanner() {
            currentIdx = (currentIdx + 1) % banners.length;
            updateBanner();
        }

        function prevBanner() {
            currentIdx = (currentIdx - 1 + banners.length) % banners.length;
            updateBanner();
        }

        if (banners.length > 1) {
            setInterval(nextBanner, 5000);
        }
    </script>
</body>
</html>
