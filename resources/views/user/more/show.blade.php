<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $artist->name }} - Enzzie Shop</title>
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
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 30; }
        #sidebar-overlay.active { display: block; }
        #bannerTrack { display: flex; transition: transform 0.5s ease; }
        .banner-slide { flex-shrink: 0; width: 100%; }
        .kat-tab { padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; white-space: nowrap; border: 1px solid #2a2a2a; background: #1a1a1a; color: #999; }
        .kat-tab.active { background: #fff; color: #000; border-color: #fff; }
        .kat-tab:hover:not(.active) { background: #2a2a2a; color: #fff; }
        .merch-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .merch-card { background: #1a1a1a; border-radius: 12px; overflow: hidden; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
        .merch-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.6); }
        .merch-card:hover .merch-img { transform: scale(1.05); }
        .merch-img-wrap { aspect-ratio: 1; overflow: hidden; background: #141414; }
        .merch-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s; }
        .merch-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #333; font-size: 32px; }
        #searchModal { display: none; position: fixed; inset: 0; z-index: 50; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); align-items: flex-start; justify-content: center; padding-top: 80px; }
        #searchModal.active { display: flex; }
        .modal-box { background: #1A1A1A; border: 1px solid #2A2A2A; border-radius: 16px; width: 100%; max-width: 480px; max-height: 70vh; display: flex; flex-direction: column; overflow: hidden; animation: modalIn 0.2s ease; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(-12px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .artist-row:hover { background: rgba(255,255,255,0.05); }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.3s ease both; }
        @media(max-width: 640px) { .merch-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; } }
    </style>
</head>
<body class="text-white min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- SEARCH MODAL -->
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
            <div id="artistSearchBody">
                @foreach($allArtists as $a)
                <div class="artist-row flex items-center justify-between px-4 py-3 cursor-pointer border-t border-enzzie-border/50 transition-colors"
                     data-name="{{ strtolower($a->name) }}"
                     onclick="window.location='{{ route('user.more.show', $a->slug) }}'">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                            @if($a->avatar || $a->image)
                                <img src="{{ asset('storage/' . ($a->avatar ?? $a->image)) }}" class="w-full h-full object-cover" alt="{{ $a->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr($a->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <span class="text-sm font-medium text-white">{{ $a->name }}</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
                @endforeach
            </div>
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
                <a href="{{ route('user.more.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    More
                </a>
            </div>
            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-3">Artis</p>
                <button onclick="openSearchModal()" class="flex items-center gap-2 px-3 py-2 text-gray-400 hover:text-white text-sm transition-colors mb-2 w-full rounded-lg hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search Artis
                </button>

                {{-- FIX: Loop $allArtists, gunakan $a->avatar (bukan $artist->avatar) dan slug untuk route --}}
                @foreach($allArtists as $a)
                <a href="{{ route('user.more.show', $a->slug) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mb-0.5
                          {{ $a->id === $artist->id ? 'bg-white/10 border border-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                        @if($a->avatar || $a->image)
                            <img src="{{ asset('storage/' . ($a->avatar ?? $a->image)) }}" class="w-full h-full object-cover" alt="{{ $a->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                {{ strtoupper(substr($a->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-sm truncate {{ $a->id === $artist->id ? 'font-bold text-white' : 'font-medium' }}">{{ strtoupper($a->name) }}</span>
                </a>
                @endforeach
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
                <a href="{{ route('user.more.index') }}" class="flex items-center gap-1.5 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="text-sm font-medium">More</span>
                </a>
                <span class="text-gray-600">/</span>
                <span class="text-lg font-bold">{{ $artist->name }}</span>
            </div>
            <a href="{{ route('user.notifications.index') }}" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </a>
        </header>

        <main class="flex-1 overflow-x-hidden">
            <div class="hidden lg:flex items-center gap-2 px-6 pt-5 pb-1">
                <a href="{{ route('user.more.index') }}" class="flex items-center gap-1.5 text-gray-500 hover:text-white transition-colors text-sm group">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke More
                </a>
                <span class="text-gray-700">/</span>
                <span class="text-gray-400 text-sm">{{ $artist->name }}</span>
            </div>

            @if($banners->count())
            <div class="relative overflow-hidden" style="height:300px">
                <div id="bannerTrack" style="height:300px">
                    @foreach($banners as $banner)
                    <div class="banner-slide relative" style="height:300px">
                        @if($banner->image)
                            <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-enzzie-card"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-5">
                            <p class="text-xs text-gray-300 uppercase tracking-widest mb-1">{{ $artist->name }}</p>
                            <h2 class="text-white font-black text-xl leading-tight">{{ $banner->title }}</h2>
                            @if(isset($banner->subtitle) && $banner->subtitle)
                                <p class="text-sm text-gray-300 mt-1">{{ $banner->subtitle }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($banners->count() > 1)
                <button onclick="moveBanner(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/50 hover:bg-black/80 flex items-center justify-center text-white text-xl transition-colors z-10">&#8249;</button>
                <button onclick="moveBanner(1)"  class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/50 hover:bg-black/80 flex items-center justify-center text-white text-xl transition-colors z-10">&#8250;</button>
                <div class="absolute bottom-3 right-4 z-10">
                    <span id="bannerCounter" class="text-xs text-white/70 bg-black/40 px-2 py-0.5 rounded-full">1 | {{ $banners->count() }}</span>
                </div>
                @endif
            </div>
            @else
            <div class="relative h-44 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-enzzie-card via-enzzie-dark to-black"></div>
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 50%, #E8001E 0%, transparent 50%)"></div>
                <div class="relative h-full flex items-end p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white/20 bg-enzzie-dark">
                            @if($artist->avatar || $artist->image)
                                <img src="{{ asset('storage/' . ($artist->avatar ?? $artist->image)) }}" class="w-full h-full object-cover" alt="{{ $artist->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr($artist->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-0.5">Artis</p>
                            <h1 class="text-2xl font-black">{{ $artist->name }}</h1>
                            <p class="text-sm text-gray-400 mt-0.5">{{ $merches->flatten()->count() }} produk tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="p-4 lg:p-6 space-y-5">
                @if($merches->flatten()->count())
                <section>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Product</p>
                    <div class="flex gap-2 overflow-x-auto pb-2 mb-4" style="scrollbar-width: none;">
                        <button class="kat-tab active" data-kat="all" onclick="filterKat('all', this)">Semua</button>
                        @foreach($kategoris as $kat)
                        <button class="kat-tab" data-kat="{{ $kat }}" onclick="filterKat('{{ $kat }}', this)">{{ ucfirst($kat) }}</button>
                        @endforeach
                    </div>
                    <div class="merch-grid" id="merchContainer">
                        @foreach($merches->flatten() as $merch)
                        <div class="merch-card fade-up" data-kat="{{ $merch->kategori }}" onclick="window.location='{{ route('user.merch.show', $merch->id) }}'">
                            <div class="merch-img-wrap">
                                @if($merch->foto_url)
                                    <img src="{{ $merch->foto_url }}" alt="{{ $merch->nama }}" class="merch-img" loading="lazy">
                                @else
                                    <div class="merch-placeholder">👕</div>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-sm font-semibold text-white truncate mb-0.5">{{ $merch->nama }}</p>
                                <p class="text-xs text-gray-400 mb-2">Rp {{ number_format($merch->harga, 0, ',', '.') }}</p>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $merch->status === 'ready' ? 'bg-green-900/50 text-green-400' : ($merch->status === 'stok_habis' ? 'bg-red-900/50 text-red-400' : 'bg-purple-900/50 text-purple-400') }}">
                                    {{ $merch->status_label }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="emptyKat" class="hidden text-center py-16 text-gray-600">
                        <p class="text-4xl mb-3 opacity-40">📦</p>
                        <p>Tidak ada produk di kategori ini.</p>
                    </div>
                </section>
                @else
                <div class="text-center py-20 text-gray-600">
                    <p class="text-5xl mb-4 opacity-30">👕</p>
                    <p class="font-medium text-gray-500">Belum ada merch tersedia</p>
                    <p class="text-sm mt-1">Merch {{ $artist->name }} akan segera hadir!</p>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }
function openSearchModal() { document.getElementById('searchModal').classList.add('active'); setTimeout(() => document.getElementById('artistSearchInput').focus(), 100); }
function closeSearchModal(e) { if (!e || e.target === document.getElementById('searchModal')) { document.getElementById('searchModal').classList.remove('active'); document.getElementById('artistSearchInput').value = ''; filterArtistSearch(''); } }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearchModal(); });
function filterArtistSearch(q) {
    const rows = document.querySelectorAll('#artistSearchBody > div');
    let v = 0;
    rows.forEach(r => { const s = !q || r.dataset.name.includes(q.toLowerCase()); r.style.display = s ? '' : 'none'; if(s) v++; });
    document.getElementById('artistSearchEmpty').classList.toggle('hidden', v > 0);
}

let bannerIdx = 0;
const bannerEls = document.querySelectorAll('.banner-slide');
const bannerTot = bannerEls.length;
function moveBanner(dir) {
    bannerIdx = (bannerIdx + dir + bannerTot) % bannerTot;
    document.getElementById('bannerTrack').style.transform = 'translateX(-' + (bannerIdx * 100) + '%)';
    const c = document.getElementById('bannerCounter');
    if (c) c.textContent = (bannerIdx + 1) + ' | ' + bannerTot;
}
if (bannerTot > 1) setInterval(() => moveBanner(1), 4500);

function filterKat(kat, btn) {
    document.querySelectorAll('.kat-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const cards = document.querySelectorAll('.merch-card');
    let visible = 0;
    cards.forEach(card => { const show = kat === 'all' || card.dataset.kat === kat; card.style.display = show ? '' : 'none'; if (show) visible++; });
    document.getElementById('emptyKat').classList.toggle('hidden', visible > 0);
}
</script>
</body>
</html>