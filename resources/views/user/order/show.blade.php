<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rincian Pesanan - Enzzie Shop</title>
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
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #2a2a2a; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
    </style>
</head>
<body class="text-white min-h-screen">

<!-- TOP BAR -->
<div class="sticky top-0 z-20 bg-enzzie-dark border-b border-enzzie-border px-4 py-4 flex items-center gap-4">
    <a href="{{ route('user.shop.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span class="text-sm font-medium"><h1 class="text-base font-bold">Kembali</h1></span>
    </a>
</div>

<div class="max-w-2xl mx-auto px-4 py-6 fade-up">

    @php
        $statusColor = match($order->status) {
            'pending'    => 'bg-yellow-600',
            'dikemas'    => 'bg-blue-600',
            'dikirim'    => 'bg-purple-600',
            'selesai'    => 'bg-green-600',
            'dibatalkan' => 'bg-red-700',
            default      => 'bg-gray-600',
        };
        $statusLabel = match($order->status) {
            'pending'    => 'Menunggu Konfirmasi',
            'dikemas'    => 'Sedang Dikemas',
            'dikirim'    => 'Sedang Dikirim',
            'selesai'    => 'Pesanan Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($order->status),
        };
    @endphp

    <div class="flex flex-col gap-4">

        <!-- STATUS BANNER -->
        <div class="{{ $statusColor }} rounded-2xl px-5 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold opacity-80 uppercase tracking-widest mb-0.5">Status Pesanan</p>
                <p class="text-lg font-black">{{ $statusLabel }}</p>
            </div>
            <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>

        <!-- INFORMASI PESANAN -->
        <div class="section-card p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Informasi</p>
            <div class="bg-enzzie-dark rounded-xl p-4 space-y-3">
                <div>
                    <p class="text-xs font-bold text-enzzie-red uppercase tracking-wider">Pelanggan</p>
                    <p class="text-sm mt-0.5">{{ $order->pelanggan }}</p>
                    <p class="text-xs text-gray-500">{{ $order->email }}</p>
                </div>
                <div class="border-t border-enzzie-border pt-3">
                    <p class="text-xs font-bold text-enzzie-red uppercase tracking-wider">Status</p>
                    <p class="text-sm mt-0.5">{{ $statusLabel }}</p>
                </div>
                <div class="border-t border-enzzie-border pt-3">
                    <p class="text-xs font-bold text-enzzie-red uppercase tracking-wider">Tanggal Pesanan</p>
                    <p class="text-sm mt-0.5">{{ $order->created_at->format('Y-m-d') }}</p>
                    <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- PRODUK -->
        <div class="section-card p-5">
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Produk</p>
                @if($order->artis)
                <span class="text-xs font-bold text-white">{{ strtoupper($order->artis) }} &rsaquo;</span>
                @endif
            </div>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-enzzie-border flex-shrink-0">
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl">👕</div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">{{ $item->nama_produk }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">× {{ $item->qty }}</p>
                    </div>
                    <p class="text-sm font-bold flex-shrink-0">Rp {{ number_format($item->qty * $item->harga_satuan, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="border-t border-enzzie-border mt-4 pt-3 flex justify-between text-sm">
                <span class="text-gray-500">Total Pesanan</span>
                <span class="font-black text-base">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- METODE PEMBAYARAN -->
        <div class="section-card px-5">
            <div class="info-row">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-bold uppercase">{{ $order->metode_pembayaran }}</span>
            </div>
        </div>

        <!-- NOMOR REKENING (jika bank) -->
        @if(strtolower($order->metode_pembayaran) === 'bank')
        <div class="section-card p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Informasi Transfer</p>
            <div>
                <div class="info-row">
                    <span class="text-gray-500">Bank</span>
                    <span class="font-semibold">BCA</span>
                </div>
                <div class="info-row">
                    <span class="text-gray-500">No. Rekening</span>
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-bold" id="noRek">1234567890</span>
                        <button type="button" onclick="copyRek()"
                                class="text-xs px-2 py-0.5 rounded bg-enzzie-border hover:bg-white/10 transition-colors text-gray-400 hover:text-white">
                            Salin
                        </button>
                    </div>
                </div>
                <div class="info-row">
                    <span class="text-gray-500">Atas Nama</span>
                    <span class="font-semibold">Enzzie Shop</span>
                </div>
                <div class="info-row">
                    <span class="text-gray-500">Jumlah Transfer</span>
                    <span class="font-bold text-enzzie-red">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- NO PESANAN -->
        <div class="section-card px-5">
            <div class="info-row">
                <span class="text-gray-500">No. Pesanan</span>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold">{{ $order->no_pesanan }}</span>
                    <button type="button" onclick="copyNoPesanan()"
                            class="text-xs px-2 py-0.5 rounded bg-enzzie-border hover:bg-white/10 transition-colors text-gray-400 hover:text-white">
                        Salin
                    </button>
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex gap-3">
            @if($order->status === 'pending')
            <form method="POST" action="{{ route('user.order.cancel', $order->id) }}" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit"
                        onclick="return confirm('Batalkan pesanan ini?')"
                        class="w-full py-3 rounded-xl border border-red-800 text-red-400 text-sm font-bold hover:bg-red-900/30 transition-colors">
                    Batalkan Pesanan
                </button>
            </form>
            @endif
            <button type="button" onclick="window.print()"
                    class="flex-1 py-3 rounded-xl bg-enzzie-card border border-enzzie-border text-sm font-bold hover:bg-white/5 transition-colors">
                Cetak
            </button>
        </div>

    </div>
</div>

<script>
function copyRek() {
    const noRek = document.getElementById('noRek').textContent;
    navigator.clipboard.writeText(noRek).then(() => alert('Nomor rekening disalin: ' + noRek));
}
function copyNoPesanan() {
    const no = '{{ $order->no_pesanan }}';
    navigator.clipboard.writeText(no).then(() => alert('No. pesanan disalin: ' + no));
}
</script>
</body>
</html>