<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $merch->nama }} - Enzzie Shop</title>
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
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }

        #sidebar { transition: transform 0.3s ease; }
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 30; }
        #sidebar-overlay.active { display: block; }

        .tab-btn {
            transition: all 0.2s;
            padding: 12px 0;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .08em;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }
        .tab-btn.active { border-bottom: 2px solid #fff; color: #fff; }
        .tab-btn:not(.active) { border-bottom: 2px solid transparent; color: #555; }
        .tab-btn:hover:not(.active) { color: #999; }

        #searchModal { display: none; position: fixed; inset: 0; z-index: 50; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); align-items: flex-start; justify-content: center; padding-top: 80px; }
        #searchModal.active { display: flex; }
        .modal-box { background: #1A1A1A; border: 1px solid #2A2A2A; border-radius: 16px; width: 100%; max-width: 480px; max-height: 70vh; display: flex; flex-direction: column; overflow: hidden; animation: modalIn 0.2s ease; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(-12px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .artist-row:hover { background: rgba(255,255,255,0.05); }

        .qty-btn { width: 28px; height: 28px; border-radius: 6px; background: #2a2a2a; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 18px; font-weight: 700; transition: background 0.15s; user-select: none; line-height: 1; }
        .qty-btn:hover { background: #3a3a3a; }
        .qty-btn:active { background: #444; transform: scale(0.93); }

        .product-img-main { transition: opacity 0.25s; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.3s ease both; }

        .info-row { display: flex; border-bottom: 1px solid #2a2a2a; }
        .info-row:last-child { border-bottom: none; }
        .info-label { width: 140px; min-width: 140px; padding: 10px 16px; font-size: 13px; color: #666; font-weight: 500; border-right: 1px solid #2a2a2a; background: rgba(26,26,26,0.6); }
        .info-value { flex: 1; padding: 10px 16px; font-size: 13px; color: #e0e0e0; }

        .related-card { background: #1a1a1a; border-radius: 12px; overflow: hidden; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; border: 1px solid #2a2a2a; }
        .related-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.6); }
        .related-img-wrap { aspect-ratio: 1; overflow: hidden; background: #141414; }
        .related-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.35s; }
        .related-card:hover .related-img { transform: scale(1.05); }
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
            <div id="artistSearchBody">
                @foreach($allArtists as $a)
                <div class="artist-row flex items-center justify-between px-4 py-3 cursor-pointer border-t border-enzzie-border/50 transition-colors"
                     data-name="{{ strtolower($a->name) }}"
                     onclick="window.location='{{ route('user.more.show', $a->id) }}'">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                            @if($a->foto_url)
                                <img src="{{ $a->foto_url }}" alt="{{ $a->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ strtoupper(substr($a->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <span class="text-sm font-medium text-white">{{ $a->name }}</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
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
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                </svg>
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
                @foreach($allArtists->take(3) as $a)
                <a href="{{ route('user.more.show', $a->id) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mb-0.5
                          {{ $a->id === $merch->artist_id ? 'bg-white/10 border border-white/10' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border bg-enzzie-card">
                        @if($a->foto_url)
                            <img src="{{ $a->foto_url }}" alt="{{ $a->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-gray-400">{{ strtoupper(substr($a->name, 0, 2)) }}</div>
                        @endif
                    </div>
                    <span class="text-sm truncate {{ $a->id === $merch->artist_id ? 'font-bold text-white' : 'font-medium' }}">{{ strtoupper($a->name) }}</span>
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

        <div class="hidden">
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOP BAR mobile -->
        <header class="sticky top-0 z-20 flex items-center justify-between px-4 py-4 bg-enzzie-dark border-b border-enzzie-border lg:hidden">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <a href="{{ route('user.more.show', $merch->artist_id) }}" class="flex items-center gap-1.5 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="text-sm font-medium">Back</span>
                </a>
                <span class="text-gray-600">/</span>
                <span class="text-sm font-semibold truncate max-w-[130px]">{{ $merch->nama }}</span>
            </div>
            <a href="{{ route('user.notifications.index') }}" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </a>
        </header>

        <main class="flex-1 overflow-x-hidden">

            <!-- Desktop breadcrumb -->
            <div class="hidden lg:flex items-center gap-2 px-6 pt-5 pb-1">
                <a href="{{ route('user.more.show', $merch->artist_id) }}"
                   class="flex items-center gap-1.5 text-gray-500 hover:text-white transition-colors text-sm group">
                    <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ $merch->artist->name ?? 'More' }}
                </a>
                <span class="text-gray-700">/</span>
                <span class="text-gray-400 text-sm truncate">{{ $merch->nama }}</span>
            </div>

            <!-- PRODUCT SECTION -->
            <div class="p-4 lg:p-6">
                <div class="flex flex-col lg:flex-row gap-6 lg:gap-10">

                    <!-- LEFT: Gambar -->
                    <div class="w-full lg:w-[320px] xl:w-[360px] flex-shrink-0">
                        <div class="aspect-square rounded-2xl overflow-hidden bg-enzzie-card border border-enzzie-border">
                            @if($merch->foto)
                                <img id="mainImg"
                                     src="{{ $merch->foto_url }}"
                                     alt="{{ $merch->nama }}"
                                     class="product-img-main w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl text-gray-700">👕</div>
                            @endif
                        </div>
                    </div>

                    <!-- RIGHT: Info -->
                    <div class="flex-1 min-w-0 fade-up">

                        <!-- Artist link -->
                        <div class="flex items-center gap-1 mb-3">
                            <a href="{{ route('user.more.show', $merch->artist_id) }}"
                               class="text-sm font-bold text-white hover:underline tracking-wide">
                                {{ strtoupper($merch->artist->name ?? '') }}
                            </a>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>

                        <!-- Nama produk -->
                        <h1 class="text-xl font-black text-white mb-1">{{ $merch->nama }}</h1>

                        <!-- Harga -->
                        <p class="text-xl font-bold text-white mb-3">
                            Rp {{ number_format($merch->harga, 0, ',', '.') }}
                        </p>

                        <!-- Status badge -->
                        <div class="mb-5">
                            @php
                                $statusClass = match($merch->status) {
                                    'ready'      => 'bg-green-900/40 text-green-400 border-green-800',
                                    'stok_habis' => 'bg-red-900/40 text-red-400 border-red-800',
                                    default      => 'bg-purple-900/40 text-purple-400 border-purple-800',
                                };
                                $statusLabel = match($merch->status) {
                                    'ready'      => 'Ready',
                                    'stok_habis' => 'Stok Habis',
                                    default      => 'Pre-Order',
                                };
                            @endphp
                            <span class="inline-block text-xs font-bold px-3 py-1 rounded-full border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <div class="border-t border-enzzie-border mb-4"></div>

                        <!-- Qty + item total -->
                        <div class="flex items-center justify-between mb-1">
                            <div>
                                <p class="text-sm font-semibold text-white mb-2">{{ $merch->nama }}</p>
                                <div class="flex items-center gap-3">
                                    <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                                    <span id="qtyDisplay" class="text-sm font-bold w-5 text-center select-none">1</span>
                                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                                </div>
                            </div>
                            <p id="itemTotal" class="text-base font-bold text-white">
                                Rp {{ number_format($merch->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Grand total -->
                        <div class="border-t border-enzzie-border mt-4 pt-3 flex items-end justify-between mb-5">
                            <p class="text-sm font-semibold text-blue-400">
                                <span id="selectedCount">1</span> Terpilih
                            </p>
                            <div class="text-right">
                                <p id="grandTotal" class="text-lg font-black text-white">
                                    Rp {{ number_format($merch->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 -mt-0.5">total</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($merch->status !== 'stok_habis')
                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('user.cart.add') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="merch_id" value="{{ $merch->id }}">
                                <input type="hidden" name="qty" id="cartQty" value="1">
                                <button type="submit"
                                        class="w-full py-3 rounded-xl border border-enzzie-border text-sm font-bold
                                               bg-enzzie-card hover:bg-enzzie-border transition-colors text-white">
                                    keranjang
                                </button>
                            </form>
                            <form method="POST" action="{{ route('user.order.buy-now') }}" class="flex-1">
                            @csrf
                            <input type="hidden" name="merch_id" value="{{ $merch->id }}">
                            <input type="hidden" name="qty" id="buyQty" value="1">
                            <button type="submit"
                                    class="w-full py-3 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-100 transition-colors">
                                pembelian
                            </button>
                        </form>
                        </div>
                        @else
                        <div class="flex gap-3">
                            <button disabled class="flex-1 py-3 rounded-xl border border-enzzie-border text-sm font-bold bg-enzzie-card text-gray-600 cursor-not-allowed">keranjang</button>
                            <form method="POST" action="{{ route('user.order.buy-now') }}">
                            @csrf
                            <input type="hidden" name="merch_id" value="{{ $merch->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="...">Beli Sekarang</button>
                        </form>
                        </div>
                        <p class="text-xs text-red-400 text-center mt-2">Stok habis, tidak dapat memesan saat ini.</p>
                        @endif

                        @if($merch->status !== 'stok_habis' && $merch->stok > 0)
                        <p class="text-xs text-gray-600 mt-3 text-center">Stok tersedia: {{ $merch->stok }} pcs</p>
                        @endif

                    </div>
                </div>

                <!-- TABS -->
                <div class="mt-10">
                    <div class="flex border-b border-enzzie-border mb-6">
                        <button type="button" class="tab-btn active" onclick="switchTab('detail', this)">DETAIL</button>
                        <button type="button" class="tab-btn" onclick="switchTab('notes', this)">NOTES</button>
                    </div>

                    <!-- TAB DETAIL -->
                    <div id="tab-detail">

                        {{-- CATATAN (jika ada) --}}
                        @if(!empty($merch->catatan))
                        <div class="mb-5">
                            <p class="text-xs font-bold text-white uppercase tracking-wider mb-1">CATATAN</p>
                            <p class="text-sm text-gray-400">{{ $merch->catatan }}</p>
                        </div>
                        @endif

                        {{-- Foto produk di tab detail --}}
                        @if($merch->foto)
                        <div class="mb-6 flex justify-center">
                            <div class="w-full rounded-2xl overflow-hidden bg-enzzie-card border border-enzzie-border">
                                <img src="{{ $merch->foto_url }}"
                                     alt="{{ $merch->nama }}" class="w-full object-cover">
                            </div>
                        </div>
                        @endif

                        {{-- Tabel informasi full width --}}
                        <p class="text-sm font-bold text-white uppercase tracking-wider mb-3">INFORMATION</p>
                        <div class="border border-enzzie-border rounded-xl overflow-hidden w-full">
                            @if($merch->ukuran)
                            <div class="info-row">
                                <div class="info-label">Ukuran</div>
                                <div class="info-value">{{ $merch->ukuran }}</div>
                            </div>
                            @endif
                            @if($merch->bahan)
                            <div class="info-row">
                                <div class="info-label">Bahan</div>
                                <div class="info-value">{{ $merch->bahan }}</div>
                            </div>
                            @endif
                            @if($merch->tanggal_terbit)
                            <div class="info-row">
                                <div class="info-label">Tanggal Terbit</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($merch->tanggal_terbit)->format('d.m.Y') }}</div>
                            </div>
                            @endif
                            @if($merch->garansi)
                            <div class="info-row">
                                <div class="info-label">Masa garansi</div>
                                <div class="info-value">{{ $merch->garansi }}</div>
                            </div>
                            @endif
                            @if($merch->no_telfon)
                            <div class="info-row">
                                <div class="info-label">No. Telfon</div>
                                <div class="info-value">{{ $merch->no_telfon }}</div>
                            </div>
                            @endif
                            @if($merch->email)
                            <div class="info-row">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $merch->email }}</div>
                            </div>
                            @endif
                            @if(!$merch->ukuran && !$merch->bahan && !$merch->tanggal_terbit && !$merch->garansi && !$merch->no_telfon && !$merch->email)
                            <div class="info-row">
                                <div class="info-value py-4 text-gray-600 text-center w-full">Tidak ada informasi tambahan.</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- TAB NOTES -->
                    <div id="tab-notes" class="hidden">
                        <p class="text-sm font-bold text-white uppercase tracking-wider mb-3">INFORMATION</p>
                        <div class="border border-enzzie-border rounded-xl overflow-hidden w-full">
                            @if($merch->ukuran)
                            <div class="info-row">
                                <div class="info-label">Ukuran</div>
                                <div class="info-value">{{ $merch->ukuran }}</div>
                            </div>
                            @endif
                            @if($merch->bahan)
                            <div class="info-row">
                                <div class="info-label">Bahan</div>
                                <div class="info-value">{{ $merch->bahan }}</div>
                            </div>
                            @endif
                            @if($merch->tanggal_terbit)
                            <div class="info-row">
                                <div class="info-label">Tanggal Terbit</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($merch->tanggal_terbit)->format('d.m.Y') }}</div>
                            </div>
                            @endif
                            @if($merch->garansi)
                            <div class="info-row">
                                <div class="info-label">Masa garansi</div>
                                <div class="info-value">{{ $merch->garansi }}</div>
                            </div>
                            @endif
                            @if($merch->no_telfon)
                            <div class="info-row">
                                <div class="info-label">No. Telfon</div>
                                <div class="info-value">{{ $merch->no_telfon }}</div>
                            </div>
                            @endif
                            @if($merch->email)
                            <div class="info-row">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $merch->email }}</div>
                            </div>
                            @endif
                            @if(!$merch->ukuran && !$merch->bahan && !$merch->tanggal_terbit && !$merch->garansi && !$merch->no_telfon && !$merch->email)
                            <div class="info-row">
                                <div class="info-value py-4 text-gray-600 text-center w-full">Tidak ada informasi tambahan.</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RELATED PRODUCTS -->
                @if($related->count())
                <div class="mt-10">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">
                        Produk Lainnya dari {{ $merch->artist->name ?? '' }}
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3">
                        @foreach($related as $r)
                        <div class="related-card" onclick="window.location='{{ route('user.merch.show', $r->id) }}'">
                            <div class="related-img-wrap">
                                @if($r->foto)
                                    <img src="{{ $r->foto_url }}" alt="{{ $r->nama }}" class="related-img">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl text-gray-700">👕</div>
                                @endif
                            </div>
                            <div class="p-2.5">
                                <p class="text-xs font-semibold truncate mb-0.5">{{ $r->nama }}</p>
                                <p class="text-xs text-gray-400">Rp {{ number_format($r->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </main>
    </div>
</div>

<script>
// Sidebar
function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }

// Search Modal
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
function filterArtistSearch(q) {
    const rows = document.querySelectorAll('#artistSearchBody > div');
    let visible = 0;
    rows.forEach(r => {
        const show = !q || r.dataset.name.includes(q.toLowerCase());
        r.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('artistSearchEmpty').classList.toggle('hidden', visible > 0);
}

// Qty & Total
const BASE_PRICE = {{ $merch->harga }};
const MAX_QTY    = {{ $merch->stok > 0 ? $merch->stok : 99 }};
let qty = 1;

function formatRp(n) {
    return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function updateTotals() {
    document.getElementById('qtyDisplay').textContent    = qty;
    document.getElementById('selectedCount').textContent = qty;
    document.getElementById('itemTotal').textContent     = formatRp(BASE_PRICE);
    document.getElementById('grandTotal').textContent    = formatRp(BASE_PRICE * qty);
    const cq = document.getElementById('cartQty');
    const bq = document.getElementById('buyQty');
    if (cq) cq.value = qty;
    if (bq) bq.value = qty;
}
function changeQty(delta) {
    qty = Math.max(1, Math.min(MAX_QTY, qty + delta));
    updateTotals();
}

// Tabs
function switchTab(name, btn) {
    event.preventDefault();
    const scrollY = window.scrollY;
    ['detail','notes'].forEach(t => document.getElementById('tab-'+t).classList.add('hidden'));
    document.getElementById('tab-'+name).classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            window.scrollTo(0, scrollY);
        });
    });
}
</script>
</body>
</html>