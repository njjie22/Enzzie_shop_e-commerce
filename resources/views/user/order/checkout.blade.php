<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout - Enzzie Shop</title>
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
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.3s ease both; }
        .section-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
        .field-input { width: 100%; background: #111; border: 1px solid #2a2a2a; border-radius: 10px; padding: 10px 14px; font-size: 13px; color: #fff; outline: none; }
        .field-input:focus { border-color: #555; }
        .field-input::placeholder { color: #444; }
    </style>
</head>
<body class="text-white min-h-screen">

<!-- TOP BAR -->
<div class="sticky top-0 z-20 bg-enzzie-dark border-b border-enzzie-border px-4 py-4 flex items-center gap-4">
    <a href="{{ route('user.shop.index') }}" class="text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <h1 class="text-base font-bold">Checkout</h1>
</div>

<div class="max-w-2xl mx-auto px-4 py-6 fade-up">
    <form method="POST" action="{{ route('user.order.store') }}">
        @csrf

        <div class="flex flex-col gap-4">

            <!-- INFO PEMBELI -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">INFO PEMBELI</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-enzzie-red to-orange-500 flex items-center justify-center text-sm font-black flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- PRODUK DIPESAN -->
            @php $artistName = $items[0]['merch']->artist->name ?? ''; @endphp
            <div class="section-card p-5">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">PRODUK DIPESAN</p>
                    @if($artistName)
                    <span class="text-xs font-bold text-white">{{ strtoupper($artistName) }} &rsaquo;</span>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach($items as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-enzzie-border flex-shrink-0">
                            @if($item['merch']->foto)
                                <img src="{{ $item['merch']->foto_url }}" alt="{{ $item['merch']->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-2xl">👕</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate">{{ $item['merch']->nama }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $item['qty'] }} × Rp {{ number_format($item['merch']->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm font-bold flex-shrink-0">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-enzzie-border mt-4 pt-3 flex justify-between">
                    <span class="text-sm text-gray-500">Total Pesanan ({{ count($items) }} Produk)</span>
                    <span class="text-sm font-bold text-enzzie-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- ALAMAT PENGIRIMAN (tetap ada) -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">ALAMAT PENGIRIMAN</p>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1.5 block">Alamat Lengkap</label>
                        @error('alamat_lengkap')
                            <p class="text-xs text-red-400 mb-1">{{ $message }}</p>
                        @enderror
                        <textarea name="alamat_lengkap" rows="2" class="field-input resize-none" placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan...">{{ old('alamat_lengkap') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500 mb-1.5 block">Kota</label>
                            @error('kota')
                                <p class="text-xs text-red-400 mb-1">{{ $message }}</p>
                            @enderror
                            <input type="text" name="kota" value="{{ old('kota') }}" class="field-input" placeholder="Contoh: Jakarta Selatan">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1.5 block">Kode Pos</label>
                            @error('kode_pos')
                                <p class="text-xs text-red-400 mb-1">{{ $message }}</p>
                            @enderror
                            <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="field-input" placeholder="12345" maxlength="5">
                        </div>
                    </div>
                </div>
            </div>

            <!-- METODE PEMBAYARAN -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">METODE PEMBAYARAN</p>
                @error('metode_pembayaran')
                    <p class="text-xs text-red-400 mb-3">{{ $message }}</p>
                @enderror
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bank_transfer" class="accent-white"
                            {{ old('metode_pembayaran') == 'bank_transfer' ? 'checked' : '' }} required
                            onchange="toggleBankInfo(this.value)">
                        <span class="text-sm">Bank Transfer</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="cod" class="accent-white"
                            {{ old('metode_pembayaran') == 'cod' ? 'checked' : '' }}
                            onchange="toggleBankInfo(this.value)">
                        <span class="text-sm">COD (Bayar di Tempat)</span>
                    </label>
                </div>

                {{-- Info rekening muncul saat bank transfer dipilih --}}
                <div id="bankInfo" class="mt-4 p-4 bg-enzzie-dark border border-enzzie-border rounded-xl
                                        {{ old('metode_pembayaran') == 'bank_transfer' ? '' : 'hidden' }}">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Info Transfer</p>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Bank</span>
                            <span class="font-semibold">BCA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">No. Rekening</span>
                            <span class="font-semibold font-mono tracking-widest">1234567890</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Atas Nama</span>
                            <span class="font-semibold">Enzzie Shop</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 pt-2 border-t border-enzzie-border">
                            Harap transfer sesuai total pembayaran. Pesanan akan diproses setelah pembayaran dikonfirmasi.
                        </p>
                    </div>
                </div>
            </div>
            <!-- RINGKASAN PEMBAYARAN -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">RINGKASAN PEMBAYARAN</p>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-500">Subtotal Pesanan</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-black border-t border-enzzie-border pt-2 mt-2">
                    <span>Total Pembayaran</span>
                    <span class="text-enzzie-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-enzzie-red text-white text-sm font-black rounded-xl hover:bg-red-700 transition-colors">
                Buat Pesanan
            </button>

        </div>
    </form>
</div>

<script>
function toggleBankInfo(val) {
    document.getElementById('bankInfo').classList.toggle('hidden', val !== 'bank_transfer');
}
</script>
</body>
</html>