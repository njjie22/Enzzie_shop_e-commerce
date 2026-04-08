<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enzzie Shop</title>
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

        #sidebar { transition: transform 0.3s ease, width 0.3s ease; }

        .banner-track { display: flex; transition: transform 0.5s ease; }
        .banner-slide { min-width: 340px; flex-shrink: 0; }

        .merch-card:hover .merch-img { transform: scale(1.05); }

        .badge-exclusive { background: #2563EB; }
        .badge-preorder  { background: #7C3AED; }
        .badge-new       { background: #16A34A; }

        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.6); z-index: 30;
        }
        #sidebar-overlay.active { display: block; }

        #searchModal {
            display: none; position: fixed; inset: 0; z-index: 50;
            background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);
            align-items: flex-start; justify-content: center; padding-top: 80px;
        }
        #searchModal.active { display: flex; }
        #searchModal .modal-box {
            background: #1A1A1A; border: 1px solid #2A2A2A; border-radius: 16px;
            width: 100%; max-width: 480px; max-height: 70vh;
            display: flex; flex-direction: column; overflow: hidden;
            animation: modalSlideIn 0.2s ease;
        }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(-12px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .artist-row:hover { background: rgba(255,255,255,0.05); }
    </style>
</head>
<body class="text-white min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- SEARCH MODAL -->
<div id="searchModal" onclick="closeSearchModal(event)">
    <div class="modal-box">
        <div class="flex items-center gap-3 px-4 py-3 border-b border-enzzie-border">
            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input id="artistSearchInput" type="text" placeholder="Cari artis..."
                   oninput="filterArtistSearch(this.value)"
                   class="flex-1 bg-transparent text-sm text-white placeholder-gray-600 outline-none" />
            <button onclick="closeSearchModal()" class="text-gray-600 hover:text-gray-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto flex-1">
            <table class="w-full text-sm" id="artistSearchTable">
                <thead class="sticky top-0 bg-enzzie-dark">
                    <tr class="text-xs text-gray-600 uppercase tracking-widest">
                        <th class="text-left px-4 py-2.5 font-semibold">Artis</th>
                        <th class="text-left px-4 py-2.5 font-semibold hidden sm:table-cell">Kategori</th>
                        <th class="px-4 py-2.5"></th>
                    </tr>
                </thead>
                <tbody id="artistSearchBody">
                    @foreach($artists as $artist)
                    <tr class="artist-row transition-colors cursor-pointer border-t border-enzzie-border/50"
                        data-name="{{ strtolower($artist->name) }}"
                        onclick="window.location='{{ route('user.artist.show', $artist->slug) }}'">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border" style="background-color: #1e1e1e">
                                    @if($artist->avatar || $artist->image)
                                        <img src="{{ asset('storage/' . ($artist->avatar ?? $artist->image)) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($artist->name, 0, 3)) }}
                                    @endif
                                </div>
                                <span class="font-medium text-white">{{ $artist->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500 hidden sm:table-cell">{{ $artist->category ?? '-' }}</td>
                        <td class="px-4 py-3 text-right">
                            <svg class="w-4 h-4 text-gray-600 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
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
    <aside id="sidebar" class="fixed top-0 left-0 h-full z-40 flex flex-col bg-enzzie-dark border-r border-enzzie-border w-72 lg:w-64 xl:w-72 -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen">
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
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 text-white font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('user.more.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                    More
                </a>
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
                <span class="text-lg font-bold">Enzzie Shop</span>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <button class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                </button>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-6 space-y-6 overflow-x-hidden">

            <!-- BANNER SLIDER -->
            @if($banners->count())
            <section class="relative">
                <div class="overflow-hidden rounded-2xl">
                    <div id="bannerTrack" class="banner-track gap-3">
                        @foreach($banners as $banner)
                        <div class="banner-slide rounded-xl overflow-hidden relative h-44 flex flex-col justify-between p-5 cursor-pointer hover:opacity-90 transition-opacity"
                             style="background-color: {{ $banner->bg_color ?? '#E8001E' }}">
                            <div class="relative z-10">
                                @if($banner->artist)
                                <p class="text-white/70 text-xs font-semibold uppercase tracking-widest mb-2">{{ $banner->artist->name }}</p>
                                @endif
                                <h3 class="text-white font-black text-xl leading-tight">{!! nl2br(e($banner->title)) !!}</h3>
                                @if($banner->subtitle)
                                <p class="text-white/80 text-xs mt-1">{{ $banner->subtitle }}</p>
                                @endif
                            </div>
                            <div class="relative z-10">
                                @if($banner->event_date)
                                <p class="text-white/70 text-[11px]">{{ \Carbon\Carbon::parse($banner->event_date)->format('M d, g:i A (T)') }}</p>
                                @endif
                                @if($banner->event_label)
                                <p class="text-white/60 text-[11px]">{{ $banner->event_label }}</p>
                                @endif
                            </div>
                            @if($banner->image)
                            <div class="absolute right-0 bottom-0 h-full w-2/3 pointer-events-none z-0">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                     class="absolute right-0 bottom-0 h-36 w-auto object-contain">
                                <div class="absolute inset-0" style="background: linear-gradient(to right, {{ $banner->bg_color ?? '#E8001E' }} 0%, {{ $banner->bg_color ?? '#E8001E' }}cc 30%, {{ $banner->bg_color ?? '#E8001E' }}55 55%, {{ $banner->bg_color ?? '#E8001E' }}00 100%);"></div>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @if($banners->count() > 1)
                <div class="flex justify-center gap-1.5 mt-3" id="bannerDots">
                    @foreach($banners as $i => $banner)
                    <button onclick="goToBanner({{ $i }})"
                            class="banner-dot w-2 h-2 rounded-full transition-colors {{ $i === 0 ? 'bg-white' : 'bg-white/30' }}">
                    </button>
                    @endforeach
                </div>
                @endif
            </section>
            @endif

            <!-- AGENCY PILLS -->
            <section>
                <div class="bg-enzzie-card rounded-2xl p-4 border border-enzzie-border">
                    <div class="flex items-center gap-3 overflow-x-auto scrollbar-none pb-1">
                        <button class="w-12 h-12 rounded-full bg-enzzie-border hover:bg-white/10 transition-colors flex items-center justify-center flex-shrink-0 border border-enzzie-border">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        @foreach($artists as $artist)
                        <button onclick="filterMerch('{{ $artist->id }}')" class="artist-pill flex flex-col items-center gap-1 flex-shrink-0 group">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-enzzie-border group-hover:border-white/40 transition-colors" style="background-color: #1e1e1e">
                                @if($artist->avatar || $artist->image)
                                    <img src="{{ asset('storage/' . ($artist->avatar ?? $artist->image)) }}">
                                @else
                                    {{ strtoupper(substr($artist->name, 0, 2)) }}
                                @endif
                            </div>
                            <span class="text-[10px] text-gray-500 group-hover:text-gray-300 transition-colors max-w-[52px] truncate text-center">{{ strtoupper($artist->name) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- MERCH SECTION -->
            <section>
                <div class="bg-enzzie-card rounded-2xl border border-enzzie-border overflow-hidden">
                    <div class="px-5 pt-5 pb-3">
                        <h2 class="text-base font-bold mb-4">Merch</h2>
                        <div class="flex items-center gap-2 overflow-x-auto scrollbar-none">
                            <button onclick="filterMerch('all')" class="merch-filter-btn active px-3 py-1.5 rounded-full text-xs font-semibold bg-white text-black flex-shrink-0" data-artist="all">All</button>
                            @foreach($artists as $artist)
                            <button onclick="filterMerch('{{ $artist->id }}')" class="merch-filter-btn px-3 py-1.5 rounded-full text-xs font-semibold bg-enzzie-border text-gray-400 hover:text-white flex-shrink-0 transition-colors" data-artist="{{ $artist->id }}">
                                {{ strtoupper($artist->name) }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    <div id="merchGrid" class="px-5 pb-5">
                        <div class="flex gap-4 overflow-x-auto scrollbar-none pb-2">
                            @foreach($merches as $merch)
                            <div class="merch-card flex-shrink-0 w-44 cursor-pointer group" data-artist="{{ $merch->artist_id }}">
                                <a href="{{ route('user.merch.show', $merch->id) }}">
                                    <div class="bg-white rounded-xl overflow-hidden mb-3 aspect-square">
                                        <div class="overflow-hidden w-full h-full">
                                            @if($merch->foto_url)
                                            <img src="{{ $merch->foto_url }}" alt="{{ $merch->nama }}" class="merch-img w-full h-full object-cover transition-transform duration-300">
                                            @else
                                            <div class="w-full h-full bg-enzzie-border flex items-center justify-center">
                                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        @if($merch->status === 'pre_order')
                                        <span class="inline-block text-[10px] font-bold text-white px-2 py-0.5 rounded mb-1 badge-preorder">PRE ORDER</span>
                                        @elseif($merch->status === 'stok_habis')
                                        <span class="inline-block text-[10px] font-bold text-white px-2 py-0.5 rounded mb-1 bg-gray-600">STOK HABIS</span>
                                        @endif
                                        <p class="text-xs text-gray-400 truncate">{{ $merch->nama }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ $merch->kategori_label }}</p>
                                        <div class="flex items-baseline gap-1.5 mt-1">
                                            <span class="text-sm font-bold text-white">Rp {{ number_format($merch->harga, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                            <div id="merch-empty" class="hidden col-span-full py-10 text-center text-gray-600 w-full">
                                <p>Tidak ada merch untuk artis ini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>
</div>

<script>
function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full');    document.getElementById('sidebar-overlay').classList.remove('active'); }

function openSearchModal() {
    document.getElementById('searchModal').classList.add('active');
    setTimeout(() => document.getElementById('artistSearchInput').focus(), 100);
}
function closeSearchModal(e) {
    if (!e || e.target === document.getElementById('searchModal')) {
        document.getElementById('searchModal').classList.remove('active');
        document.getElementById('artistSearchInput').value = '';
        filterArtistSearch('');
    }
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSearchModal(); });

function filterArtistSearch(query) {
    const rows = document.querySelectorAll('#artistSearchBody tr.artist-row');
    const q = query.toLowerCase().trim();
    let visible = 0;
    rows.forEach(row => {
        const show = !q || (row.dataset.name || '').includes(q);
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('artistSearchEmpty').classList.toggle('hidden', visible > 0);
}

let currentBanner = 0;
const slides = document.querySelectorAll('.banner-slide');
const dots   = document.querySelectorAll('.banner-dot');
const track  = document.getElementById('bannerTrack');

function goToBanner(index) {
    currentBanner = index;
    if (track && slides.length) {
        const slideWidth = slides[0].offsetWidth + 12;
        track.style.transform = `translateX(-${index * slideWidth}px)`;
    }
    dots.forEach((d, i) => {
        d.classList.toggle('bg-white', i === index);
        d.classList.toggle('bg-white/30', i !== index);
    });
}
if (slides.length > 1) setInterval(() => goToBanner((currentBanner + 1) % slides.length), 4000);

function filterMerch(artistId) {
    document.querySelectorAll('.merch-filter-btn').forEach(btn => {
        const isActive = btn.dataset.artist == artistId;
        btn.classList.toggle('bg-white', isActive);
        btn.classList.toggle('text-black', isActive);
        btn.classList.toggle('bg-enzzie-border', !isActive);
        btn.classList.toggle('text-gray-400', !isActive);
    });
    const cards = document.querySelectorAll('.merch-card');
    let visible = 0;
    cards.forEach(card => {
        const show = artistId === 'all' || card.dataset.artist == artistId;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const empty = document.getElementById('merch-empty');
    if (empty) empty.classList.toggle('hidden', visible > 0);
}
document.querySelectorAll('.merch-filter-btn').forEach(btn => {
    if (!btn.classList.contains('active')) btn.classList.add('bg-enzzie-border', 'text-gray-400');
});
</script>
</body>
</html>