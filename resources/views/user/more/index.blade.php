<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>More - Enzzie Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'enzzie-red':    '#E8001E',
                        'enzzie-dark':   '#111111',
                        'enzzie-card':   '#1A1A1A',
                        'enzzie-border': '#2A2A2A',
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 4px; height: 4px; } ::-webkit-scrollbar-track { background: #111; } ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        #sidebar { transition: transform 0.3s ease; }
        #sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:30; }
        #sidebar-overlay.active { display:block; }
        .artist-row:hover { background: rgba(255,255,255,0.05); }
        #searchModal { display:none; position:fixed; inset:0; z-index:50; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); align-items:flex-start; justify-content:center; padding-top:80px; }
        #searchModal.active { display:flex; }
        #searchModal .modal-box { background:#1A1A1A; border:1px solid #2A2A2A; border-radius:16px; width:100%; max-width:480px; max-height:70vh; display:flex; flex-direction:column; overflow:hidden; animation:modalIn 0.2s ease; }
        @keyframes modalIn { from{opacity:0;transform:translateY(-12px) scale(0.97)} to{opacity:1;transform:translateY(0) scale(1)} }
        .more-search-input { background:#1e1e1e; border:1px solid #2a2a2a; border-radius:30px; padding:10px 16px 10px 42px; color:#fff; font-size:14px; outline:none; transition:all 0.2s; width:100%; }
        .more-search-input:focus { border-color:#E8001E; box-shadow:0 0 0 3px rgba(232,0,30,0.1); }
        .more-search-input::placeholder { color:#555; }
        .search-dropdown { position:absolute; top:calc(100% + 6px); left:0; right:0; background:#1A1A1A; border:1px solid #2a2a2a; border-radius:10px; z-index:50; display:none; max-height:280px; overflow-y:auto; box-shadow:0 8px 32px rgba(0,0,0,0.5); }
        .search-dropdown.show { display:block; animation:dropIn 0.18s ease; }
        @keyframes dropIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
        .drop-item { display:flex; align-items:center; gap:10px; padding:10px 14px; cursor:pointer; text-decoration:none; color:#fff; transition:background 0.15s; }
        .drop-item:hover, .drop-item.active { background:#242424; }
        .artist-section { background:#1A1A1A; border:1px solid #2a2a2a; border-radius:16px; padding:20px; margin-bottom:16px; transition:border-color 0.2s; }
        .artist-section:hover { border-color:rgba(232,0,30,0.3); }
        .merch-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(130px, 1fr)); gap:10px; }
        .merch-card { background:#242424; border-radius:10px; overflow:hidden; cursor:pointer; transition:transform 0.2s, box-shadow 0.2s; }
        .merch-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.5); }
        .merch-card:hover .merch-img { transform:scale(1.06); }
        .merch-img-wrap { aspect-ratio:1; overflow:hidden; background:#1e1e1e; }
        .merch-img { width:100%; height:100%; object-fit:cover; transition:transform 0.35s; }
        .merch-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#444; font-size:30px; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation:fadeUp 0.35s ease both; }
        @media(max-width:640px) { .merch-grid { grid-template-columns:repeat(3,1fr); gap:8px; } }
        @media(max-width:400px) { .merch-grid { grid-template-columns:repeat(2,1fr); } }
    </style>
</head>
<body class="text-white min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ===================== SEARCH MODAL ===================== --}}
{{-- FIX: loop var $a (bukan $artist) supaya tidak konflik dengan $artists di bawah --}}
<div id="searchModal" onclick="closeSearchModal(event)">
    <div class="modal-box">
        <div class="flex items-center gap-3 px-4 py-3 border-b border-enzzie-border">
            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input id="artistSearchInput" type="text" placeholder="Cari artis..." oninput="filterArtistSearch(this.value)" class="flex-1 bg-transparent text-sm text-white placeholder-gray-600 outline-none" />
            <button onclick="closeSearchModal()" class="text-gray-600 hover:text-gray-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="overflow-y-auto flex-1">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-enzzie-dark">
                    <tr class="text-xs text-gray-600 uppercase tracking-widest">
                        <th class="text-left px-4 py-2.5 font-semibold">Artis</th>
                        <th class="px-4 py-2.5"></th>
                    </tr>
                </thead>
                <tbody id="artistSearchBody">
                    @foreach($allArtists as $a)
                    <tr class="artist-row transition-colors cursor-pointer border-t border-enzzie-border/50"
                        data-name="{{ strtolower($a->name) }}"
                        onclick="window.location='{{ route('user.more.show', $a->id) }}'">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                                    @if($a->foto_url)
                                        <img src="{{ $a->foto_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                            {{ strtoupper(substr($a->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="font-medium text-white">{{ $a->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <svg class="w-4 h-4 text-gray-600 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="artistSearchEmpty" class="hidden py-10 text-center text-gray-600 text-sm">Artis tidak ditemukan.</div>
        </div>
    </div>
</div>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
           class="fixed top-0 left-0 h-full z-40 flex flex-col bg-enzzie-dark border-r border-enzzie-border
                  w-72 lg:w-64 xl:w-72 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-enzzie-border">
            <button onclick="closeSidebar()" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            </div>
            <span class="text-lg font-bold tracking-tight">Enzzie Shop</span>
        </div>
        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="px-3 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('user.more.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    More
                </a>
            </div>
            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-3">Artis</p>
                <button onclick="openSearchModal()" class="flex items-center gap-2 px-3 py-2 text-gray-400 hover:text-white text-sm transition-colors mb-1 w-full rounded-lg hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search Artis
                </button>
                @foreach($allArtists->take(3) as $a)
                <a href="{{ route('user.more.show', $a->id) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 transition-colors group">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                        @if($a->foto_url)
                            <img src="{{ $a->foto_url }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                            {{ strtoupper(substr($a->name, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <span class="text-sm font-medium truncate">{{ strtoupper($a->name) }}</span>
                </a>
                @endforeach
                @if($allArtists->count() > 3)
                <button onclick="openSearchModal()" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-400 text-xs transition-colors mt-1 w-full rounded-lg hover:bg-white/5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Lihat {{ $allArtists->count() - 3 }} artis lainnya
                </button>
                @endif
            </div>
            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-gray-600 uppercase tracking-widest mb-3">Go to Service</p>
                <a href="{{ route('user.shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <span class="text-sm font-medium">Aktivitas Belanja</span>
                </a>
            </div>
            <!-- USER + LOGOUT -->
            <div class="mt-4 px-5 pb-4">
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-enzzie-red to-orange-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-400 transition-colors" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-20 flex items-center justify-between px-4 py-4 bg-enzzie-dark border-b border-enzzie-border lg:hidden">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-lg font-bold">More</span>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 space-y-4 overflow-x-hidden">

            {{-- BANNER --}}
            @if($banners->count())
            <section class="relative">
                <div class="overflow-hidden rounded-2xl bg-enzzie-card border border-enzzie-border">
                    <div id="bannerTrack" class="flex transition-transform duration-500 ease-in-out">
                        @foreach($banners as $banner)
                        <div class="flex-shrink-0 w-full flex" style="min-width:100%;min-height:160px">
                            <div class="w-2/5 relative overflow-hidden" style="min-height:160px">
                                @if($banner->image)
                                    <img src="{{ $banner->foto_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover absolute inset-0">
                                @else
                                    <div class="w-full h-full bg-enzzie-border absolute inset-0 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col justify-center px-5 py-5 relative z-10">
                                @if($banner->artist)
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">{{ $banner->artist->name }}</p>
                                @endif
                                <h3 class="text-white font-black text-lg leading-tight">{{ $banner->title }}</h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if($banners->count() > 1)
                <button onclick="moveBanner(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/50 hover:bg-black/80 flex items-center justify-center text-white text-lg transition-colors z-10">&#8249;</button>
                <button onclick="moveBanner(1)"  class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/50 hover:bg-black/80 flex items-center justify-center text-white text-lg transition-colors z-10">&#8250;</button>
                <div class="flex justify-center mt-2"><span id="bannerCounter" class="text-xs text-gray-500">1 | {{ $banners->count() }}</span></div>
                @endif
            </section>
            @endif

            {{-- ARTIS SCROLL --}}
            <section>
                <div class="bg-enzzie-card rounded-2xl p-4 border border-enzzie-border">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">Artis</p>
                    <div class="flex gap-4 overflow-x-auto pb-1" style="scrollbar-width:none;-webkit-overflow-scrolling:touch">
                        @foreach($allArtists as $a)
                        <a href="{{ route('user.more.show', $a->id) }}" class="flex flex-col items-center gap-1.5 flex-shrink-0 group">
                            <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-enzzie-border group-hover:border-enzzie-red transition-colors bg-enzzie-dark">
                                @if($a->foto_url)
                                    <img src="{{ $a->foto_url }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr($a->name, 0, 2)) }}
                                </div>
                                @endif
                            </div>
                            <span class="text-[10px] text-gray-500 group-hover:text-gray-300 transition-colors max-w-[56px] truncate text-center uppercase">{{ $a->name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- SEARCH BAR --}}
            <div class="relative" id="searchWrap">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="moreSearch" class="more-search-input" placeholder="Cari artis..." value="{{ $search }}" autocomplete="off" />
                <button id="searchClear" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white text-xl leading-none {{ $search ? '' : 'hidden' }}" onclick="clearSearch()">&times;</button>
                <div class="search-dropdown" id="dropdownWrap">
                    @foreach($allArtists as $a)
                    <a href="{{ route('user.more.show', $a->id) }}" class="drop-item" data-name="{{ strtolower($a->name) }}">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 bg-enzzie-card border border-enzzie-border">
                            @if($a->foto_url)
                                <img src="{{ $a->foto_url }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                {{ strtoupper(substr($a->name, 0, 2)) }}
                            </div>
                            @endif
                        </div>
                        <span class="text-sm font-medium truncate">{{ $a->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            @if($search)
            <p class="text-sm text-gray-500">Hasil untuk <span class="text-enzzie-red font-semibold">"{{ $search }}"</span> — {{ $artists->count() }} artis ditemukan</p>
            @endif

            {{-- ARTIST LIST --}}
            @forelse($artists as $artist)
            <div class="artist-section fade-up" style="animation-delay: {{ $loop->index * 0.06 }}s">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-full overflow-hidden flex-shrink-0 border-2 border-enzzie-border bg-enzzie-card">
                        @if($artist->foto_url)
                            <img src="{{ $artist->foto_url }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                            {{ strtoupper(substr($artist->name, 0, 2)) }}
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('user.more.show', $artist->id) }}" class="text-base font-bold text-white hover:text-enzzie-red transition-colors inline-flex items-center gap-1">
                            {{ $artist->name }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @if($artist->merches->isNotEmpty())
                <div class="merch-grid">
                    @foreach($artist->merches->take(6) as $merch)
                    <div class="merch-card" onclick="window.location='{{ route('user.merch.show', $merch->id) }}'">
                        <div class="merch-img-wrap">
                            @if($merch->foto_url)
                                <img src="{{ $merch->foto_url }}" alt="{{ $merch->nama }}" class="merch-img" loading="lazy">
                            @else
                                <div class="merch-placeholder">👕</div>
                            @endif
                        </div>
                        <div class="p-2.5">
                            <p class="text-xs font-semibold text-white truncate mb-0.5">{{ $merch->nama }}</p>
                            <p class="text-xs text-gray-500 mb-1.5">Rp {{ number_format($merch->harga, 0, ',', '.') }}</p>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $merch->status === 'ready' ? 'bg-green-900/50 text-green-400' : ($merch->status === 'stok_habis' ? 'bg-red-900/50 text-red-400' : 'bg-purple-900/50 text-purple-400') }}">{{ $merch->status_label }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($artist->merches_count > 6)
                <div class="flex items-center justify-center gap-3 mt-4 text-xs text-gray-600">
                    <button disabled class="w-7 h-7 rounded-full bg-enzzie-card border border-enzzie-border flex items-center justify-center opacity-30">‹</button>
                    <span>1 / {{ ceil($artist->merches_count / 6) }}</span>
                    <button onclick="window.location='{{ route('user.more.show', $artist->id) }}'" class="w-7 h-7 rounded-full bg-enzzie-card border border-enzzie-border flex items-center justify-center hover:bg-enzzie-red hover:border-enzzie-red hover:text-white transition-colors">›</button>
                </div>
                @endif
                @else
                <p class="text-sm text-gray-600">Belum ada merch untuk artis ini.</p>
                @endif
            </div>
            @empty
            <div class="text-center py-20 text-gray-600">
                <div class="text-5xl mb-4 opacity-40">🔍</div>
                <p class="text-base font-medium text-gray-500">Artis tidak ditemukan</p>
                <p class="text-sm mt-1">Coba cari dengan nama lain</p>
            </div>
            @endforelse

        </main>
    </div>
</div>

<script>
let bannerIdx = 0;
const bannerSlides = document.querySelectorAll('#bannerTrack > div');
const bannerTotal  = bannerSlides.length;
function moveBanner(dir) {
    bannerIdx = (bannerIdx + dir + bannerTotal) % bannerTotal;
    document.getElementById('bannerTrack').style.transform = 'translateX(-' + (bannerIdx * 100) + '%)';
    const c = document.getElementById('bannerCounter');
    if (c) c.textContent = (bannerIdx + 1) + ' | ' + bannerTotal;
}
if (bannerTotal > 1) setInterval(() => moveBanner(1), 4500);

function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }
function openSearchModal() { document.getElementById('searchModal').classList.add('active'); setTimeout(() => document.getElementById('artistSearchInput').focus(), 100); }
function closeSearchModal(e) { if (!e || e.target === document.getElementById('searchModal')) { document.getElementById('searchModal').classList.remove('active'); document.getElementById('artistSearchInput').value = ''; filterArtistSearch(''); } }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearchModal(); });
function filterArtistSearch(q) {
    const rows = document.querySelectorAll('#artistSearchBody tr.artist-row');
    let v = 0;
    rows.forEach(r => { const s = !q || r.dataset.name.includes(q.toLowerCase()); r.style.display = s ? '' : 'none'; if(s) v++; });
    document.getElementById('artistSearchEmpty').classList.toggle('hidden', v > 0);
}

const moreInput = document.getElementById('moreSearch');
const dropdown  = document.getElementById('dropdownWrap');
const clearBtn  = document.getElementById('searchClear');
const dropItems = Array.from(document.querySelectorAll('.drop-item'));
let searchTimer = null, activeIdx = -1;

function filterDrop(q) {
    const query = q.toLowerCase().trim();
    let count = 0;
    dropItems.forEach(item => { const show = !query || item.dataset.name.includes(query); item.style.display = show ? '' : 'none'; if (show) count++; });
    let noRes = document.getElementById('dropNoResult');
    if (count === 0) {
        if (!noRes) { noRes = document.createElement('div'); noRes.id = 'dropNoResult'; noRes.className = 'px-4 py-5 text-sm text-center text-gray-600'; noRes.textContent = 'Artis tidak ditemukan'; dropdown.appendChild(noRes); }
        noRes.style.display = '';
    } else if (noRes) { noRes.style.display = 'none'; }
}
function openDrop()  { dropdown.classList.add('show'); }
function closeDrop() { dropdown.classList.remove('show'); activeIdx = -1; }
function goSearch(q) { const url = new URL(window.location.href); q ? url.searchParams.set('search', q) : url.searchParams.delete('search'); window.location = url.toString(); }
function clearSearch() { moreInput.value = ''; clearBtn.classList.add('hidden'); filterDrop(''); openDrop(); goSearch(''); }

moreInput.addEventListener('focus', () => { filterDrop(moreInput.value); openDrop(); });
moreInput.addEventListener('input', function() {
    clearBtn.classList.toggle('hidden', !this.value);
    filterDrop(this.value);
    openDrop();
    clearTimeout(searchTimer);
    if (this.value.trim()) searchTimer = setTimeout(() => goSearch(this.value.trim()), 700);
});
moreInput.addEventListener('keydown', function(e) {
    const vis = dropItems.filter(i => i.style.display !== 'none');
    if (e.key === 'ArrowDown') { e.preventDefault(); activeIdx = Math.min(activeIdx+1, vis.length-1); vis.forEach((el,i) => el.classList.toggle('active', i===activeIdx)); }
    else if (e.key === 'ArrowUp') { e.preventDefault(); activeIdx = Math.max(activeIdx-1, -1); vis.forEach((el,i) => el.classList.toggle('active', i===activeIdx)); }
    else if (e.key === 'Enter') { e.preventDefault(); activeIdx >= 0 && vis[activeIdx] ? window.location = vis[activeIdx].href : goSearch(this.value.trim()); }
    else if (e.key === 'Escape') closeDrop();
});
document.addEventListener('click', e => { if (!document.getElementById('searchWrap').contains(e.target)) closeDrop(); });
if (moreInput.value) filterDrop(moreInput.value);
</script>
</body>
</html>