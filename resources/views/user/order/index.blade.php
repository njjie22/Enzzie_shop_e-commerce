<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesanan Saya - Enzzie Shop</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-track { background: #111; } ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        #sidebar { transition: transform 0.3s ease; }
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 30; }
        #sidebar-overlay.active { display: block; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.3s ease both; }
        .order-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; transition: border-color 0.2s; }
        .order-card:hover { border-color: #3a3a3a; }
    </style>
</head>
<body class="text-white min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
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
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-3">Artis</p>
                <button onclick="openSearchModal()" class="flex items-center gap-2 px-3 py-2 text-gray-400 hover:text-white text-sm transition-colors mb-1 w-full rounded-lg hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search Artis
                </button>
                @foreach($artists->take(3) as $artist)
                <a href="{{ route('user.artist.show', $artist->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-white hover:bg-white/5 transition-colors group">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border border-enzzie-border" style="background-color: #1e1e1e">
                        @if($artist->image)
                            <img src="{{ asset('storage/'.$artist->image) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($artist->name, 0, 2)) }}</div>
                        @endif
                    </div>
                    <span class="text-sm font-medium truncate">{{ strtoupper($artist->name) }}</span>
                </a>
                @endforeach
                @if($artists->count() > 3)
                <button onclick="openSearchModal()" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-400 text-xs transition-colors mt-1 w-full rounded-lg hover:bg-white/5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    Lihat {{ $artists->count() - 3 }} artis lainnya
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
                <span class="text-lg font-bold">Pesanan Saya</span>
            </div>
            <a href="{{ route('user.notifications.index') }}" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </a>
        </header>

        <main class="flex-1 p-4 lg:p-6">

            <div class="hidden lg:block mb-6">
                <h1 class="text-2xl font-black">Pesanan Saya</h1>
                <p class="text-sm text-gray-500 mt-0.5">Riwayat semua pesananmu</p>
            </div>

            @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-900/30 border border-green-800 rounded-xl text-sm text-green-400">
                {{ session('success') }}
            </div>
            @endif

            @if($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center fade-up">
                <p class="text-6xl mb-4 opacity-30">📦</p>
                <p class="text-lg font-bold text-gray-400 mb-1">Belum ada pesanan</p>
                <p class="text-sm text-gray-600 mb-6">Yuk beli merch artis favoritmu!</p>
                <a href="{{ route('user.more.index') }}"
                   class="px-6 py-2.5 bg-white text-black text-sm font-bold rounded-xl hover:bg-gray-100 transition-colors">
                    Lihat Merch
                </a>
            </div>
            @else
            <div class="space-y-4 fade-up">
                @foreach($orders as $order)
                @php
                    $statusColor = match($order->status) {
                        'pending'    => 'bg-yellow-900/40 text-yellow-400 border-yellow-800',
                        'diproses'   => 'bg-blue-900/40 text-blue-400 border-blue-800',
                        'dikirim'    => 'bg-purple-900/40 text-purple-400 border-purple-800',
                        'selesai'    => 'bg-green-900/40 text-green-400 border-green-800',
                        'dibatalkan' => 'bg-red-900/40 text-red-400 border-red-800',
                        default      => 'bg-gray-900/40 text-gray-400 border-gray-700',
                    };
                    $statusLabel = match($order->status) {
                        'pending'    => 'Menunggu',
                        'diproses'   => 'Diproses',
                        'dikirim'    => 'Dikirim',
                        'selesai'    => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        default      => ucfirst($order->status),
                    };
                @endphp
                <div class="order-card p-5">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-sm font-bold font-mono">{{ $order->no_pesanan }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $order->artis }}</p>
                        </div>
                        <span class="inline-block text-xs font-bold px-3 py-1 rounded-full border {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <!-- Items -->
                    <div class="space-y-2 mb-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-enzzie-border flex-shrink-0">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-base">👕</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ $item->nama_produk }}</p>
                                <p class="text-xs text-gray-500">{{ $item->qty }} × Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-semibold flex-shrink-0">
                                Rp {{ number_format($item->qty * $item->harga_satuan, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Footer -->
                    <div class="border-t border-enzzie-border pt-3 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Metode: <span class="text-gray-300">{{ str_replace('_', ' ', ucwords($order->metode_pembayaran, '_')) }}</span></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Total</p>
                                <p class="text-base font-black">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                            @if($order->status === 'pending')
                            <form method="POST" action="{{ route('user.order.cancel', $order->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Batalkan pesanan ini?')"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-red-800 text-red-400 hover:bg-red-900/30 transition-colors">
                                    Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
            @endif
        </main>
    </div>
</div>

<script>
function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }
</script>
</body>
</html>