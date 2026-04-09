<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang - Enzzie Shop</title>
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
        .cart-item { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 14px; transition: border-color 0.2s; }
        .cart-item:hover { border-color: #3a3a3a; }
        .qty-btn { width: 28px; height: 28px; border-radius: 6px; background: #2a2a2a; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; font-weight: 700; transition: background 0.15s; border: none; }
        .qty-btn:hover { background: #3a3a3a; }
    </style>
</head>
<body class="text-white min-h-screen">

<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
           class="fixed top-0 left-0 h-full z-40 flex flex-col bg-enzzie-dark border-r border-enzzie-border
                  w-72 lg:w-64 xl:w-72 -translate-x-full lg:translate-x-0 lg:static lg:h-auto">
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
                <a href="{{ route('user.cart.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-white/10 border border-white/10 text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="font-bold">Keranjang</span>
                </a>
                <a href="{{ route('user.order.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Pesanan
                </a>
            </div>
            <div class="mt-6 px-5">
                <p class="text-xs font-semibold text-gray-600 uppercase tracking-widest mb-3">Go to Service</p>
                <a href="{{ route('user.shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-enzzie-border flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <span class="text-sm font-medium">Shop</span>
                </a>
            </div>
        </nav>
        <div class="px-5 py-4 border-t border-enzzie-border">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-enzzie-red to-orange-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
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
                <span class="text-lg font-bold">Keranjang</span>
            </div>
            <a href="{{ route('user.notifications.index') }}" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </a>
        </header>

        <main class="flex-1 p-4 lg:p-6">

            <!-- Header desktop -->
            <div class="hidden lg:flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-black">Keranjang</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ count($cartItems) }} item di keranjang</p>
                </div>
                @if(count($cartItems) > 0)
                <form method="POST" action="{{ route('user.cart.clear') }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-gray-600 hover:text-red-400 transition-colors">Kosongkan semua</button>
                </form>
                @endif
            </div>

            @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-900/30 border border-green-800 rounded-xl text-sm text-green-400">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-900/30 border border-red-800 rounded-xl text-sm text-red-400">
                {{ session('error') }}
            </div>
            @endif

            @if(count($cartItems) === 0)
            <!-- Empty state -->
            <div class="flex flex-col items-center justify-center py-24 text-center fade-up">
                <p class="text-6xl mb-4 opacity-30">🛒</p>
                <p class="text-lg font-bold text-gray-400 mb-1">Keranjang kosong</p>
                <p class="text-sm text-gray-600 mb-6">Tambahkan merch favoritmu dulu!</p>
                <a href="{{ route('user.more.index') }}"
                   class="px-6 py-2.5 bg-white text-black text-sm font-bold rounded-xl hover:bg-gray-100 transition-colors">
                    Lihat Merch
                </a>
            </div>
          @else

            <form action="{{ route('user.order.checkout') }}" method="GET">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- LEFT: CART ITEMS -->
                <div class="flex-1 space-y-3">

                    <!-- Pilih Semua -->
                    <div class="flex items-center gap-2 px-1 mb-2">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 accent-red-500"
                            onclick="toggleAll(this)">
                        <label for="checkAll" class="text-sm text-gray-400 cursor-pointer">Pilih Semua</label>
                    </div>

                    @foreach($cartItems as $item)
                    <div class="cart-item p-4 flex items-center gap-4">

                        <!-- CHECKBOX -->
                        <input type="checkbox"
                            name="selected_ids[]"
                            value="{{ $item['merch']->id }}"
                            class="item-checkbox w-4 h-4 accent-red-500">

                        <!-- Gambar -->
                        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $item['merch']->foto_url }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <p class="font-bold truncate">{{ $item['merch']->nama }}</p>
                            <p class="text-sm text-gray-400">
                                Rp {{ number_format($item['merch']->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">Qty: {{ $item['qty'] }}</p>
                        </div>

                        <!-- Subtotal -->
                        <p class="text-sm font-bold flex-shrink-0">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </p>

                    </div>
                    @endforeach

                </div>

                <!-- RIGHT: SUMMARY -->
                <div class="w-full lg:w-72">
                    <div class="bg-gray-800 p-5 rounded-xl sticky top-24">
                        <p class="text-xs text-gray-500 mb-1">Total Keranjang</p>
                        <p class="text-lg font-bold mb-1">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mb-4">*Centang item yang ingin di-checkout</p>
                        <button type="submit"
                            class="w-full py-3 bg-white text-black font-bold rounded-xl hover:bg-gray-100 transition-colors">
                            Checkout →
                        </button>
                    </div>
                </div>

            </div>
            </form>

            @endif

<script>
function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }
function toggleAll(source) {
    document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = source.checked);
}

document.querySelectorAll('.item-checkbox').forEach(cb => {
    cb.addEventListener('change', () => {
        const all  = document.querySelectorAll('.item-checkbox');
        const checked = document.querySelectorAll('.item-checkbox:checked');
        document.getElementById('checkAll').checked = all.length === checked.length;
    });
});

function openSidebar()  { document.getElementById('sidebar').classList.remove('-translate-x-full'); document.getElementById('sidebar-overlay').classList.add('active'); }
function closeSidebar() { document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-overlay').classList.remove('active'); }
</script>
</body>
</html>