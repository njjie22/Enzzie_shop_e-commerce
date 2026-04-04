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
        .payment-option { border: 1.5px solid #2a2a2a; border-radius: 12px; padding: 14px 16px; cursor: pointer; transition: all 0.15s; display: flex; align-items: center; gap: 12px; }
        .payment-option:has(input:checked) { border-color: #fff; background: rgba(255,255,255,0.05); }
        .payment-option:hover { border-color: #555; }
        .section-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 16px; }
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
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Info Pembeli</p>
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
            @php $artistName = $cartItems[0]['merch']->artist->name ?? ''; @endphp
            <div class="section-card p-5">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Produk Dipesan</p>
                    @if($artistName)
                    <span class="text-xs font-bold text-white">{{ strtoupper($artistName) }} &rsaquo;</span>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-enzzie-border flex-shrink-0">
                            @if($item['merch']->foto)
                                <img src="{{ asset('storage/'.$item['merch']->foto) }}" alt="{{ $item['merch']->nama }}" class="w-full h-full object-cover">
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
                    <span class="text-sm text-gray-500">Total Pesanan ({{ count($cartItems) }} Produk)</span>
                    <span class="text-sm font-bold text-enzzie-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- METODE PEMBAYARAN -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Metode Pembayaran</p>
                @error('metode_pembayaran')
                    <p class="text-xs text-red-400 mb-3">{{ $message }}</p>
                @enderror
                <div class="space-y-2">
                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="bank"
                               class="accent-white" onchange="toggleBankInfo(this.value)"
                               {{ old('metode_pembayaran') === 'bank' ? 'checked' : '' }}>
                        <span class="text-lg">🏦</span>
                        <span class="text-sm font-medium">Bank Transfer</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="cod"
                               class="accent-white" onchange="toggleBankInfo(this.value)"
                               {{ old('metode_pembayaran') === 'cod' ? 'checked' : '' }}>
                        <span class="text-lg">💵</span>
                        <span class="text-sm font-medium">COD (Bayar di Tempat)</span>
                    </label>
                </div>

                <!-- Info Rekening (muncul jika pilih Bank) -->
                <div id="bankInfo" class="hidden mt-4 p-4 bg-enzzie-dark border border-enzzie-border rounded-xl">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Informasi Rekening</p>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Bank</span>
                            <span class="font-semibold">BCA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">No. Rekening</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold" id="noRekening">1234567890</span>
                                <button type="button" onclick="copyRekening()"
                                        class="text-xs px-2 py-0.5 rounded bg-enzzie-border hover:bg-white/10 transition-colors text-gray-400 hover:text-white">
                                    Salin
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Atas Nama</span>
                            <span class="font-semibold">Enzzie Shop</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jumlah Transfer</span>
                            <span class="font-bold text-enzzie-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-3">* Transfer sesuai nominal agar pesanan lebih cepat diproses.</p>
                </div>
            </div>

            <!-- RINGKASAN & SUBMIT -->
            <div class="section-card p-5">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Ringkasan Pembayaran</p>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal Pesanan</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-black border-t border-enzzie-border pt-2 mt-2">
                        <span>Total Pembayaran</span>
                        <span class="text-lg text-enzzie-red">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button type="submit"
                        class="w-full py-3.5 bg-enzzie-red text-white text-sm font-black rounded-xl hover:bg-red-700 transition-colors">
                    Buat Pesanan
                </button>
                <p class="text-xs text-gray-600 text-center mt-3">Dengan menekan tombol, kamu menyetujui syarat & ketentuan pembelian.</p>
            </div>

        </div>
    </form>
</div>

<script>
function toggleBankInfo(val) {
    const info = document.getElementById('bankInfo');
    info.classList.toggle('hidden', val !== 'bank');
}

function copyRekening() {
    const noRek = document.getElementById('noRekening').textContent;
    navigator.clipboard.writeText(noRek).then(() => {
        alert('Nomor rekening disalin: ' + noRek);
    });
}

// Trigger jika old value = bank
window.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="metode_pembayaran"]:checked');
    if (checked) toggleBankInfo(checked.value);
});
</script>
</body>
</html>