<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Admin Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @layer base {
            :root { --accent: #c0392b; --accent-hover: #a93226; }
        }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #3a3a3a; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #888; }
    </style>
</head>
<body class="bg-[#111] text-[#f0f0f0] font-['DM_Sans'] min-h-screen flex overflow-x-hidden">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-[240px] max-[900px]:w-[60px] h-screen sticky top-0 bg-[#1e1e1e] border-r border-[#2e2e38] flex flex-col shrink-0 z-[100] transition-all duration-300 max-[768px]:fixed max-[768px]:-left-full max-[768px]:w-[200px] [&.open]:left-0 overflow-hidden">
        <div class="flex items-center gap-2.5 px-3.5 py-4 border-b border-[#3a3a3a]">
            <div class="flex flex-col gap-1 cursor-pointer p-1 rounded hover:bg-[#2e2e2e] transition-colors shrink-0">
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
            </div>
            <span class="font-['Syne'] text-[0.95rem] font-extrabold text-[#f0f0f0] whitespace-nowrap max-[900px]:hidden">Enzzie Shop</span>
        </div>
        <nav class="flex flex-col gap-[1px] pt-2.5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#2e2e2e] hover:text-[#f0f0f0] {{ request()->routeIs('admin.dashboard') ? 'bg-[#2e2e2e] text-[#f0f0f0] border-l-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="max-[900px]:hidden whitespace-nowrap">Home</span>
            </a>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#2e2e2e] hover:text-[#f0f0f0] {{ request()->routeIs('admin.order.*') ? 'bg-[#2e2e2e] text-[#f0f0f0] border-l-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                <span class="max-[900px]:hidden whitespace-nowrap">Order</span>
            </a>
            <a href="{{ route('admin.artist.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#2e2e2e] hover:text-[#f0f0f0] {{ request()->routeIs('admin.artist.*') ? 'bg-[#2e2e2e] text-[#f0f0f0] border-l-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/></svg>
                <span class="max-[900px]:hidden whitespace-nowrap">Artis</span>
            </a>
            <a href="{{ route('admin.merch') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#2e2e2e] hover:text-[#f0f0f0] {{ request()->routeIs('admin.merch*') ? 'bg-[#2e2e2e] text-[#f0f0f0] border-l-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                <span class="max-[900px]:hidden whitespace-nowrap">Merch</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col min-w-0 bg-[#1c1c1c]">
        <!-- CONTENT AREA -->
        <div class="flex-1 flex overflow-hidden h-screen">
            <!-- LEFT: TABLE -->
            <div class="flex-1 p-4 overflow-y-auto min-w-0">
                <!-- SEARCH BAR -->
                <div class="flex items-center gap-2 flex-wrap mb-3.5">
                    <div class="flex flex-1 min-w-[200px]">
                        <select id="filterStatus" class="bg-[#2e2e2e] border border-[#444] border-r-0 rounded-l-md px-2.5 py-1.5 text-[#cccccc] font-['DM_Sans'] text-[0.8rem] outline-none cursor-pointer min-w-[70px] focus:border-[#c0392b]" onchange="applyFilter()">
                            <option value="all">All</option>
                            <option value="pending">Pending</option>
                            <option value="dikemas">Dikemas</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <input type="text" id="searchInput" class="flex-1 bg-[#2e2e2e] border border-[#444] rounded-r-md px-3 py-1.5 text-[#f0f0f0] font-['DM_Sans'] text-[0.82rem] outline-none transition-colors placeholder:text-[#888] focus:border-[#c0392b]" placeholder="Nama Pelanggan atau ID" oninput="applyFilter()">
                    </div>
                    <button class="px-5 py-1.5 bg-[#c0392b] text-white rounded-md font-['DM_Sans'] text-[0.82rem] font-semibold cursor-pointer transition-colors hover:bg-[#a93226] whitespace-nowrap" onclick="applyFilter()">Cari</button>
                </div>

                <!-- ORDER TABLE -->
                <div class="bg-[#242424] border border-[#3a3a3a] rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-[#2e2e2e]">
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">ID</th>
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">Pelanggan</th>
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">Total</th>
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">Status</th>
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">Tanggal</th>
                                    <th class="px-3.5 py-2.5 text-left text-[0.75rem] font-bold tracking-wider uppercase text-[#cccccc]">Detail</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody">
                                @forelse($orders as $order)
                                <tr class="transition-colors hover:bg-white/[0.03] [&.row-active]:bg-[#c0392b]/[0.07]" data-id="{{ $order->id }}" data-pelanggan="{{ strtolower($order->pelanggan) }}" data-status="{{ $order->status }}">
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a] text-[#888] font-semibold">{{ $order->id }}</td>
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a] text-[#f0f0f0]">{{ $order->pelanggan }}</td>
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a] text-[#f0f0f0] font-semibold">{{ $order->total_rupiah }}</td>
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a]">
                                        <select class="appearance-none border border-[#3a3a3a] rounded-md px-2 py-1 pr-6 font-['DM_Sans'] text-[0.76rem] font-semibold cursor-pointer outline-none bg-no-repeat bg-[right_7px_center] bg-[length:8px_5px] transition-all
                                            @if($order->status === 'pending') bg-[rgba(217,119,6,0.15)] text-[#f59e0b] border-[rgba(217,119,6,0.3)]
                                            @elseif($order->status === 'dikemas') bg-[rgba(37,99,235,0.15)] text-[#60a5fa] border-[rgba(37,99,235,0.3)]
                                            @elseif($order->status === 'dikirim') bg-[rgba(5,150,105,0.15)] text-[#34d399] border-[rgba(5,150,105,0.3)]
                                            @elseif($order->status === 'selesai') bg-[rgba(107,114,128,0.15)] text-[#9ca3af] border-[rgba(107,114,128,0.3)]
                                            @endif"
                                            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'8\' height=\'5\' viewBox=\'0 0 9 5\'%3E%3Cpath d=\'M0 0l4.5 5 4.5-5z\' fill=\'%23888\'/%3E%3C/svg%3E')"
                                            onchange="updateStatus(this, {{ $order->id }})">
                                            <option value="pending" @selected($order->status === 'pending') class="bg-[#2e2e2e] text-white">Pending</option>
                                            <option value="dikemas" @selected($order->status === 'dikemas') class="bg-[#2e2e2e] text-white">Dikemas</option>
                                            <option value="dikirim" @selected($order->status === 'dikirim') class="bg-[#2e2e2e] text-white">Dikirim</option>
                                            <option value="selesai" @selected($order->status === 'selesai') class="bg-[#2e2e2e] text-white">Selesai</option>
                                        </select>
                                    </td>
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a] text-[#cccccc]">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-3.5 py-2.5 text-[0.84rem] border-t border-[#3a3a3a]">
                                        <button class="px-3.5 py-1 bg-[#c0392b] text-white rounded-md font-['DM_Sans'] text-[0.76rem] font-semibold cursor-pointer transition-all hover:bg-[#a93226] [&.active]:bg-[#a93226] [&.active]:shadow-[0_0_0_2px_rgba(192,57,43,0.35)]" onclick="showDetail(this, {{ $order->id }})">Detail</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-[#888] text-[0.85rem] border-t border-[#3a3a3a]">Belum ada data order.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- RIGHT: DETAIL PANEL -->
            <aside id="detailPanel" class="w-0 bg-[#242424] border-l border-[#3a3a3a] overflow-hidden flex flex-col shrink-0 transition-[width] duration-300 [&.open]:w-[310px] max-[700px]:fixed max-[700px]:right-0 max-[700px]:top-0 max-[700px]:bottom-0 max-[700px]:[&.open]:w-[min(320px,95vw)] max-[700px]:z-[200] max-[700px]:shadow-[-8px_0_32px_rgba(0,0,0,0.7)]">
                <div class="w-[310px] h-full flex flex-col">
                    <!-- PANEL HEADER -->
                    <div class="px-3.5 py-3 flex items-center justify-between border-b border-[#3a3a3a] bg-[#2e2e2e] shrink-0">
                        <span class="font-['Syne'] text-[0.9rem] font-bold text-[#f0f0f0]">← Rincian Pesanan</span>
                        <div class="w-6 h-6 rounded bg-[#383838] border border-[#3a3a3a] flex items-center justify-center cursor-pointer text-[#888] text-[0.8rem] transition-all hover:bg-[#444] hover:text-[#f0f0f0]" onclick="closeDetail()">✕</div>
                    </div>

                    <!-- PANEL BODY -->
                    <div class="p-3.5 flex flex-col gap-2.5 flex-1 bg-[#222] relative overflow-y-auto">
                        <!-- Loading overlay -->
                        <div id="panelLoading" class="hidden absolute inset-0 bg-[#0e0e10]/[0.65] items-center justify-center z-10 [&.show]:flex">
                            <div class="w-5 h-5 border-2 border-[#444] border-t-[#c0392b] rounded-full animate-spin"></div>
                        </div>

                        <!-- INFO CARD -->
                        <div class="bg-[#2e2e2e] border border-[#3a3a3a] rounded-lg p-3.5">
                            <div class="font-['Syne'] text-[0.82rem] font-bold mb-3 text-[#f0f0f0]">Informasi</div>
                            <div class="mb-2.5">
                                <div class="text-[0.67rem] font-bold text-[#c0392b] uppercase tracking-wider mb-0.5">Pelanggan</div>
                                <div id="rincian-pelanggan" class="text-[0.82rem] text-[#f0f0f0] leading-relaxed">—</div>
                                <div id="rincian-email" class="text-[0.77rem] text-[#888] leading-relaxed">—</div>
                            </div>
                            <div class="mb-2.5">
                                <div class="text-[0.67rem] font-bold text-[#c0392b] uppercase tracking-wider mb-0.5">Status</div>
                                <div id="rincian-status" class="text-[0.82rem] text-[#f0f0f0] leading-relaxed">—</div>
                            </div>
                            <div>
                                <div class="text-[0.67rem] font-bold text-[#c0392b] uppercase tracking-wider mb-0.5">Tanggal Pesanan</div>
                                <div id="rincian-tanggal" class="text-[0.82rem] text-[#f0f0f0] leading-relaxed">—</div>
                            </div>
                        </div>

                        <!-- MERCH CARD -->
                        <div class="bg-[#2e2e2e] border border-[#3a3a3a] rounded-lg overflow-hidden">
                            <div class="px-3.5 py-2.5 flex items-center justify-between border-b border-[#3a3a3a] bg-[#383838]">
                                <span id="rincian-artis" class="text-[0.8rem] font-bold text-[#f0f0f0]">—</span>
                                <span class="text-[#888] text-[0.65rem]">▼</span>
                            </div>
                            <div id="merch-items-container"></div>
                            <div class="px-3.5 py-2.5 flex items-center justify-end gap-1.5 text-[0.8rem] bg-[#383838]">
                                <span class="text-[#888]">Total Pesanan :</span>
                                <strong id="rincian-total" class="text-[0.86rem] text-[#f0f0f0]">—</strong>
                            </div>
                        </div>

                        <!-- META -->
                        <div class="bg-[#2e2e2e] border border-[#3a3a3a] rounded-lg overflow-hidden">
                            <div class="p-2.5 flex items-center justify-between border-b border-[#3a3a3a] gap-2.5">
                                <span class="text-[0.81rem] font-bold text-[#f0f0f0]">Metode Pembayaran</span>
                                <span id="rincian-metode" class="text-[0.78rem] text-[#888]">—</span>
                            </div>
                            <div class="p-2.5 flex items-center justify-between gap-2.5">
                                <span class="text-[0.81rem] font-bold text-[#f0f0f0]">No. Pesanan</span>
                                <span class="text-[0.78rem] text-[#888] flex items-center gap-2">
                                    <span id="noPesanan">—</span>
                                    <button class="px-2 py-0.5 bg-[#383838] border border-[#444] rounded text-[#888] text-[0.68rem] font-bold cursor-pointer transition-all hover:bg-[#3a3a3a] hover:text-[#f0f0f0] [&.copied]:bg-[#059669]/20 [&.copied]:text-[#34d399] [&.copied]:border-[#059669]/30" onclick="salinNoPesanan(this)">Salin</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- PANEL FOOTER -->
                    <div class="p-3.5 border-t border-[#3a3a3a] bg-[#242424] shrink-0">
                        <button class="w-full px-2.5 py-2 bg-[#2e2e2e] border border-[#444] rounded-md text-[#f0f0f0] font-['DM_Sans'] text-[0.85rem] font-semibold cursor-pointer transition-all hover:bg-[#3a3a3a] tracking-wide" onclick="window.print()">Cetak</button>
                    </div>
                </div>
            </aside>
        </div>
    </main>

<script>
    const CSRF  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const BASE  = '{{ rtrim(url("/admin/order"), "/") }}';

    let activeDetailBtn = null;
    let activeOrderId   = null;

    function applyFilter() {
        const filter = document.getElementById('filterStatus').value;
        const search = document.getElementById('searchInput').value.toLowerCase().trim();
        document.querySelectorAll('#orderTableBody tr[data-id]').forEach(row => {
            const statusMatch = filter === 'all' || row.dataset.status === filter;
            const searchMatch = !search || row.dataset.pelanggan.includes(search) || row.dataset.id.includes(search);
            row.style.display = (statusMatch && searchMatch) ? '' : 'none';
        });
    }

    async function updateStatus(sel, id) {
        const newStatus = sel.value;

        sel.classList.remove(
            'bg-[rgba(217,119,6,0.15)]', 'text-[#f59e0b]', 'border-[rgba(217,119,6,0.3)]',
            'bg-[rgba(37,99,235,0.15)]', 'text-[#60a5fa]', 'border-[rgba(37,99,235,0.3)]',
            'bg-[rgba(5,150,105,0.15)]', 'text-[#34d399]', 'border-[rgba(5,150,105,0.3)]',
            'bg-[rgba(107,114,128,0.15)]', 'text-[#9ca3af]', 'border-[rgba(107,114,128,0.3)]'
        );

        if (newStatus === 'pending')  sel.classList.add('bg-[rgba(217,119,6,0.15)]', 'text-[#f59e0b]', 'border-[rgba(217,119,6,0.3)]');
        else if (newStatus === 'dikemas') sel.classList.add('bg-[rgba(37,99,235,0.15)]', 'text-[#60a5fa]', 'border-[rgba(37,99,235,0.3)]');
        else if (newStatus === 'dikirim') sel.classList.add('bg-[rgba(5,150,105,0.15)]', 'text-[#34d399]', 'border-[rgba(5,150,105,0.3)]');
        else if (newStatus === 'selesai') sel.classList.add('bg-[rgba(107,114,128,0.15)]', 'text-[#9ca3af]', 'border-[rgba(107,114,128,0.3)]');

        sel.closest('tr').dataset.status = newStatus;
        if (activeOrderId === id) {
            document.getElementById('rincian-status').textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        }

        try {
            const res = await fetch(`${BASE}/${id}/status`, {
                method : 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body   : JSON.stringify({ status: newStatus }),
            });
            if (!res.ok) throw new Error('Gagal update');
        } catch (e) {
            console.error(e);
        }
    }

    async function showDetail(btn, id) {
        const panel = document.getElementById('detailPanel');

        if (activeDetailBtn === btn && panel.classList.contains('open')) {
            closeDetail(); return;
        }

        if (activeDetailBtn) {
            activeDetailBtn.classList.remove('active');
            activeDetailBtn.closest('tr')?.classList.remove('row-active');
        }

        activeDetailBtn = btn;
        activeOrderId   = id;
        btn.classList.add('active');
        btn.closest('tr').classList.add('row-active');
        panel.classList.add('open');
        document.getElementById('panelLoading').classList.add('show');

        try {
            const res  = await fetch(`${BASE}/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            const data = await res.json();

            document.getElementById('rincian-pelanggan').textContent = data.pelanggan       ?? '—';
            document.getElementById('rincian-email').textContent     = data.email           ?? '—';
            document.getElementById('rincian-status').textContent    = data.status_label    ?? '—';
            document.getElementById('rincian-tanggal').textContent   = data.tanggal         ?? '—';
            document.getElementById('rincian-artis').textContent     = (data.artis ?? '—') + ' >';
            document.getElementById('rincian-total').textContent     = data.total           ?? '—';
            document.getElementById('rincian-metode').textContent    = data.metode_pembayaran ?? '—';
            document.getElementById('noPesanan').textContent         = data.no_pesanan      ?? '—';

            const container = document.getElementById('merch-items-container');
            container.innerHTML = (data.items ?? []).map(item => `
                <div style="display:flex;align-items:center;gap:12px;padding:12px 14px;border-bottom:1px solid #3a3a3a;">
                    <div style="width:48px;height:48px;min-width:48px;min-height:48px;border-radius:8px;background:#111;border:1px solid #3a3a3a;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                        ${item.gambar
                            ? `<img src="${item.gambar}" alt="${item.nama}" style="width:100%;height:100%;object-fit:cover;">`
                            : `<span style="font-size:1.2rem;">📦</span>`
                        }
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:0.83rem;font-weight:600;color:#f0f0f0;margin-bottom:4px;word-break:break-word;">${item.nama}</div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:0.76rem;color:#888;">x ${item.qty}</span>
                            <span style="font-size:0.83rem;font-weight:700;color:#f0f0f0;">${item.harga}</span>
                        </div>
                    </div>
                </div>
            `).join('');

        } catch (e) {
            console.error(e);
            document.getElementById('rincian-pelanggan').textContent = 'Gagal memuat data.';
        } finally {
            document.getElementById('panelLoading').classList.remove('show');
        }
    }

    function closeDetail() {
        document.getElementById('detailPanel').classList.remove('open');
        if (activeDetailBtn) {
            activeDetailBtn.classList.remove('active');
            activeDetailBtn.closest('tr')?.classList.remove('row-active');
        }
        activeDetailBtn = null;
        activeOrderId   = null;
    }

    function salinNoPesanan(btn) {
        const no = document.getElementById('noPesanan').textContent;
        navigator.clipboard.writeText(no).then(() => {
            btn.textContent = 'Tersalin!';
            btn.classList.add('copied');
            setTimeout(() => { btn.textContent = 'Salin'; btn.classList.remove('copied'); }, 2000);
        }).catch(() => {
            btn.textContent = 'Tersalin!';
            setTimeout(() => btn.textContent = 'Salin', 2000);
        });
    }
</script>
</body>
</html>