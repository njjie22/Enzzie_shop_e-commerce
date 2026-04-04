<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Admin Merch</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #2e2e38; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3a3a42; }
    </style>
</head>
<body class="bg-[#111113] text-[#f0f0f4] font-['DM_Sans'] min-h-screen flex">

    <!-- SIDEBAR -->
  <aside id="sidebar" class="class="w-[240px] max-[900px]:w-[60px] h-screen sticky top-0 bg-[#1e1e1e] border-r border-[#2e2e38] flex flex-col shrink-0 z-[100] transition-all duration-300 max-[768px]:fixed max-[768px]:-left-full max-[768px]:w-[200px] [&.open]:left-0 overflow-hidden">
        <div class="flex items-center gap-2.5 px-3.5 py-4 border-b border-[#2e2e38]">
            <div class="flex flex-col gap-1 cursor-pointer p-0.5 max-[768px]:hidden" onclick="toggleSidebar()">
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
            </div>
            <h1 class="font-['Syne'] text-[0.95rem] font-extrabold text-[#f0f0f4] truncate max-[900px]:hidden overflow-hidden">Enzzie Shop</h1>
        </div>
        <nav class="flex flex-col gap-[1px] pt-1 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.dashboard') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="max-[900px]:hidden">Home</span>
            </a>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.order.*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                <span class="max-[900px]:hidden">Order</span>
            </a>
            <a href="{{ route('admin.artist.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.artist.*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/></svg>
                <span class="max-[900px]:hidden">Artis</span>
            </a>
            <a href="{{ route('admin.merch') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.merch*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                <span class="max-[900px]:hidden">Merch</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col overflow-hidden relative">
        <!-- TOPBAR -->
        <header class="flex items-center justify-between gap-2.5 px-6 py-3 border-b border-[#2e2e38] bg-[#1a1a1e] flex-wrap">
            <div class="flex items-center gap-2 flex-1 flex-wrap">
                <div class="relative">
                    <select id="filterArtis" class="appearance-none bg-[#222228] border border-[#2e2e38] rounded-lg pl-3 pr-8 py-1.5 text-[#f0f0f4] font-['DM_Sans'] text-[0.83rem] font-medium cursor-pointer outline-none focus:border-[#c0392b] transition-colors min-w-[130px]" onchange="filterProducts()">
                        <option value="">Semua Artis</option>
                        @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ request('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ strtoupper($artist->name) }}
                        </option>
                        @endforeach
                    </select>
                    <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-[#7a7a8c] pointer-events-none">▾</span>
                </div>
                <div class="relative">
                    <select id="filterKategori" class="appearance-none bg-[#222228] border border-[#2e2e38] rounded-lg pl-3 pr-8 py-1.5 text-[#f0f0f4] font-['DM_Sans'] text-[0.83rem] font-medium cursor-pointer outline-none focus:border-[#c0392b] transition-colors min-w-[130px]" onchange="filterProducts()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-[#7a7a8c] pointer-events-none">▾</span>
                </div>
            </div>
           
        </header>

        <!-- CONTENT -->
        <div class="p-5 md:px-6 overflow-y-auto flex-1 relative">
            <div class="flex items-center justify-between mb-4">
                <span class="font-['Syne'] text-[0.75rem] font-bold tracking-widest uppercase text-[#7a7a8c]">Produk Merch</span>
                <button class="flex items-center gap-1.5 px-3 py-1.5 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.76rem] font-semibold rounded-lg transition-all hover:-translate-y-0.5" id="btnTambahProduk">+ Tambah Produk</button>
            </div>

            <div class="grid grid-cols-[repeat(auto-fill,minmax(190px,1fr))] gap-3.5 max-[420px]:grid-cols-1" id="productGrid">
                @foreach($merches as $merch)
                <div class="group bg-[#18181f] border border-[#2e2e38] rounded-xl overflow-hidden transition-all hover:border-[#c0392b] hover:-translate-y-0.5"
                     data-id="{{ $merch->id }}"
                     data-artist="{{ $merch->artist_id }}"
                     data-kategori="{{ $merch->kategori }}">
                    <div class="w-full aspect-square relative overflow-hidden bg-[#0d0d10]">
                        @if($merch->foto_url)
                            <img src="{{ $merch->foto_url }}" alt="{{ $merch->nama }}"
                                 class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105"
                                 onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center w-full h-full bg-gradient-to-br from-[#1a0a0a] to-[#0d0d10] text-[3.5rem]\'>👕</div>'">
                        @else
                            <div class="flex items-center justify-center w-full h-full bg-gradient-to-br from-[#1a0a0a] to-[#0d0d10] text-[3.5rem]">👕</div>
                        @endif
                    </div>
                    <div class="p-3">
                        <div class="text-[0.86rem] font-semibold mb-0.5">{{ $merch->nama }}</div>
                        <div class="text-[0.74rem] text-[#7a7a8c] mb-0.5">
                            {{ $merch->artist->name ?? '-' }} · {{ ucfirst($merch->kategori) }}
                        </div>
                        <div class="text-[0.8rem] text-[#7a7a8c] mb-2">Rp <strong class="text-[#f0f0f4]">{{ number_format($merch->harga, 0, ',', '.') }}</strong></div>
                        <div class="flex items-center justify-between gap-1.5">
                            @if($merch->status === 'stok_habis')
                                <span class="px-2 py-1 rounded-full text-[0.68rem] font-bold uppercase tracking-wider bg-white/10 text-[#888]">Stok Habis</span>
                            @elseif($merch->status === 'pre_order')
                                <span class="px-2 py-1 rounded-full text-[0.68rem] font-bold uppercase tracking-wider bg-[#c0392b]/20 text-[#c0392b] border border-[#c0392b]/40">Pre-Order</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-[0.68rem] font-bold uppercase tracking-wider bg-[#27ae60]/20 text-[#27ae60] border border-[#27ae60]/40">Ready</span>
                            @endif
                            <div class="flex gap-1">
                                <button class="px-2.5 py-1 bg-transparent border border-[#2e2e38] text-[#7a7a8c] text-[0.76rem] font-semibold rounded-lg hover:border-[#c0392b] hover:text-[#c0392b] transition-all" onclick="editProduct({{ $merch->id }})">Edit</button>
                                <button class="px-2 py-1 bg-transparent border border-red-500/40 text-red-500 text-[0.72rem] font-semibold rounded-lg hover:bg-red-500/10 transition-all" onclick="deleteProduct({{ $merch->id }})">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="bg-[#18181f] border-2 border-dashed border-[#2e2e38] rounded-xl flex items-center justify-center min-h-[260px] cursor-pointer transition-all hover:border-[#c0392b] hover:bg-[#c0392b]/5" onclick="openModal()">
                    <div class="text-center text-[#7a7a8c]">
                        <div class="text-[2.2rem] mb-1.5 leading-none">+</div>
                        <span class="text-[0.78rem] font-semibold">Tambah Produk</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- OVERLAY -->
    <div id="overlay" class="hidden fixed inset-0 bg-black/50 z-[90] backdrop-blur-[2px]" onclick="closeModal()"></div>

    <!-- MODAL -->
    <div id="tambahPanel" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] max-w-[calc(100vw-32px)] max-h-[90vh] overflow-y-auto bg-[#2b2b30] rounded-[14px] p-6 z-[100] shadow-[0_24px_80px_rgba(0,0,0,0.7)]">
        <button class="absolute top-4 right-4 text-[#7a7a8c] hover:text-[#f0f0f4] text-xl leading-none" onclick="closeModal()">✕</button>
        <div class="font-['Syne'] text-base font-bold text-center mb-4 pb-3 border-b border-[#2e2e38]" id="modalTitle">Tambah Produk</div>

        <input type="hidden" id="fEditId">

        <div class="grid grid-cols-2 gap-3 max-[420px]:grid-cols-1">
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Nama</label>
                <input type="text" id="fNama" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Nama produk...">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Harga</label>
                <input type="number" id="fHarga" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Rp 0">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Status</label>
                <select id="fStatus" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors">
                    <option value="">Pilih status...</option>
                    <option value="ready">Ready</option>
                    <option value="pre_order">Pre-Order</option>
                    <option value="stok_habis">Stok Habis</option>
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Foto</label>
                <label id="fotoLabel" class="flex items-center justify-center bg-[#3a3a42] border-2 border-dashed border-[#4a4a55] rounded-lg cursor-pointer text-[#7a7a8c] font-medium transition-all hover:border-[#c0392b] hover:text-[#c0392b] w-full min-h-[90px] relative overflow-hidden p-3.5" onclick="document.getElementById('fFoto').click()">
                    <div id="fotoPlaceholderBox" class="flex flex-col items-center justify-center gap-1 text-[0.82rem]">
                        <span class="text-[1.4rem]">🖼</span>
                        <span>+ Pilih Foto</span>
                    </div>
                    <img id="imgPreview" src="" alt="" class="hidden w-full h-[160px] object-cover rounded-md">
                    <input type="file" id="fFoto" accept="image/*" class="hidden" onchange="previewImage(this)">
                </label>
            </div>

            <div class="col-span-full h-px bg-[#2e2e38] my-1"></div>
            <div class="col-span-full font-['Syne'] text-[0.88rem] font-bold text-[#f0f0f4] mb-[-4px]">Informasi</div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Ukuran</label>
                <input type="text" id="fUkuran" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="S, M, L, XL...">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Bahan</label>
                <input type="text" id="fBahan" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Cotton, Polyester...">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Tanggal Terbit</label>
                <input type="date" id="fTanggal" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Garansi</label>
                <input type="text" id="fGaransi" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Garansi produk...">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">No. Telpon</label>
                <input type="tel" id="fTelp" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="+62...">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Email</label>
                <input type="email" id="fEmail" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="email@...">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Stok</label>
                <input type="number" id="fStok" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="0">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Artis</label>
                <select id="fArtis" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors">
                    <option value="">Pilih artis...</option>
                    @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ strtoupper($artist->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1.5 col-span-full">
                <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Kategori</label>
                <div class="flex gap-2">
                    <select id="fKategori" class="flex-1 bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors">
                        <option value="">Pilih kategori...</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
                        @endforeach
                    </select>
                    <!-- Input kategori baru -->
                    <input type="text" id="fKategoriCustom" class="w-32 bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Baru...">
                    <button type="button" onclick="addKategori()" class="px-3 py-2 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.78rem] font-semibold rounded-lg transition-all whitespace-nowrap">+ Add</button>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button id="btnSubmit" class="px-7 py-2.5 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.85rem] font-semibold rounded-lg transition-all" onclick="submitProduct()">Kirim</button>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" class="fixed bottom-6 right-6 bg-[#27ae60] text-white px-4 py-2.5 rounded-lg text-[0.85rem] font-semibold z-[200] opacity-0 translate-y-2.5 transition-all pointer-events-none"></div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const STORE_URL  = "{{ route('admin.merch.store') }}";
const UPDATE_URL = (id) => `/admin/merch/${id}`;
const DELETE_URL = (id) => `/admin/merch/${id}`;

function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

function filterProducts() {
    const artistId = document.getElementById('filterArtis').value;
    const kategori = document.getElementById('filterKategori').value;
    document.querySelectorAll('[data-id]').forEach(card => {
        const matchArtist = !artistId || card.dataset.artist == artistId;
        const matchKat    = !kategori || card.dataset.kategori == kategori;
        card.style.display = (matchArtist && matchKat) ? '' : 'none';
    });
}

function openModal(reset = true) {
    if (reset) {
        document.getElementById('modalTitle').textContent = 'Tambah Produk';
        document.getElementById('fEditId').value = '';
        clearForm();
    }
    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('tambahPanel').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('overlay').classList.add('hidden');
    document.getElementById('tambahPanel').classList.add('hidden');
}

document.getElementById('btnTambahProduk').addEventListener('click', () => openModal(true));

// Tambah kategori baru ke dropdown
function addKategori() {
    const input = document.getElementById('fKategoriCustom');
    const val   = input.value.trim().toLowerCase();
    if (!val) return;

    const select = document.getElementById('fKategori');
    // Cek apakah sudah ada
    const exists = Array.from(select.options).some(o => o.value === val);
    if (!exists) {
        const opt = new Option(val.charAt(0).toUpperCase() + val.slice(1), val);
        select.add(opt);
        // Juga tambahkan ke filter dropdown
        const filterSelect = document.getElementById('filterKategori');
        const existsFilter = Array.from(filterSelect.options).some(o => o.value === val);
        if (!existsFilter) {
            filterSelect.add(new Option(val.charAt(0).toUpperCase() + val.slice(1), val));
        }
    }
    select.value = val;
    input.value  = '';
}

function editProduct(id) {
    fetch(`/admin/merch/${id}`)
        .then(r => r.json())
        .then(res => {
            if (!res.success) return;
            const p = res.merch;

            document.getElementById('fEditId').value     = p.id;
            document.getElementById('fNama').value       = p.nama || '';
            document.getElementById('fHarga').value      = p.harga || '';
            document.getElementById('fStatus').value     = p.status || '';
            document.getElementById('fUkuran').value     = p.ukuran || '';
            document.getElementById('fBahan').value      = p.bahan || '';
            document.getElementById('fGaransi').value    = p.garansi || '';
            document.getElementById('fTelp').value       = p.no_telfon || '';
            document.getElementById('fEmail').value      = p.email || '';
            document.getElementById('fStok').value       = p.stok || 0;
            document.getElementById('fArtis').value      = p.artist_id || '';
            document.getElementById('fTanggal').value    = p.tanggal_terbit || '';

            // Set kategori — tambahkan ke dropdown kalau belum ada
            const select = document.getElementById('fKategori');
            const exists = Array.from(select.options).some(o => o.value === p.kategori);
            if (!exists && p.kategori) {
                select.add(new Option(p.kategori.charAt(0).toUpperCase() + p.kategori.slice(1), p.kategori));
            }
            select.value = p.kategori || '';

            const preview     = document.getElementById('imgPreview');
            const placeholder = document.getElementById('fotoPlaceholderBox');
            const label       = document.getElementById('fotoLabel');
            if (p.foto_url) {
                preview.src = p.foto_url;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                label.classList.add('border-solid', 'border-[#27ae60]', 'p-0');
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
                label.classList.remove('border-solid', 'border-[#27ae60]', 'p-0');
            }

            document.getElementById('modalTitle').textContent = 'Edit Produk';
            openModal(false);
        });
}

function submitProduct() {
    const editId = document.getElementById('fEditId').value;
    const nama   = document.getElementById('fNama').value.trim();
    const status = document.getElementById('fStatus').value;

    if (!nama || !status) {
        showToast('⚠️ Nama & Status wajib diisi!', '#e67e22');
        return;
    }

    const formData = new FormData();
    formData.append('nama',           nama);
    formData.append('harga',          document.getElementById('fHarga').value || 0);
    formData.append('status',         status);
    formData.append('ukuran',         document.getElementById('fUkuran').value);
    formData.append('bahan',          document.getElementById('fBahan').value);
    formData.append('garansi',        document.getElementById('fGaransi').value);
    formData.append('no_telfon',      document.getElementById('fTelp').value);
    formData.append('email',          document.getElementById('fEmail').value);
    formData.append('stok',           document.getElementById('fStok').value || 0);
    formData.append('artist_id',      document.getElementById('fArtis').value);
    formData.append('kategori',       document.getElementById('fKategori').value);
    formData.append('tanggal_terbit', document.getElementById('fTanggal').value);
    formData.append('_token',         CSRF);

    const fFoto = document.getElementById('fFoto');
    if (fFoto.files.length > 0) formData.append('foto', fFoto.files[0]);

    const url = editId ? UPDATE_URL(editId) : STORE_URL;
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.style.opacity = '0.6';
    btn.textContent = 'Menyimpan...';

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(editId ? '✓ Produk diperbarui!' : '✓ Produk ditambahkan!');
            closeModal();
            setTimeout(() => location.reload(), 800);
        } else {
            const errors = res.errors ? Object.values(res.errors).flat().join(', ') : (res.message || 'Terjadi kesalahan.');
            showToast('⚠️ ' + errors, '#e67e22');
        }
    })
    .catch(() => showToast('⚠️ Gagal menyimpan, coba lagi.', '#e67e22'))
    .finally(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.textContent = 'Kirim';
    });
}

function deleteProduct(id) {
    if (!confirm('Hapus produk ini?')) return;
    fetch(DELETE_URL(id), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast('✓ Produk dihapus!');
            document.querySelector(`[data-id="${id}"]`)?.remove();
        }
    });
}

function clearForm() {
    ['fNama','fHarga','fStatus','fUkuran','fBahan','fGaransi','fTelp','fEmail','fStok','fArtis','fKategori','fTanggal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    document.getElementById('fKategoriCustom').value = '';
    document.getElementById('fFoto').value = '';
    document.getElementById('imgPreview').classList.add('hidden');
    document.getElementById('imgPreview').src = '';
    document.getElementById('fotoPlaceholderBox').classList.remove('hidden');
    document.getElementById('fotoLabel').classList.remove('border-solid', 'border-[#27ae60]', 'p-0');
}

function previewImage(input) {
    const preview     = document.getElementById('imgPreview');
    const placeholder = document.getElementById('fotoPlaceholderBox');
    const label       = document.getElementById('fotoLabel');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            label.classList.add('border-solid', 'border-[#27ae60]', 'p-0');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
        preview.src = '';
        placeholder.classList.remove('hidden');
        label.classList.remove('border-solid', 'border-[#27ae60]', 'p-0');
    }
}

function showToast(msg, color = '#27ae60') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.backgroundColor = color;
    t.classList.remove('opacity-0', 'translate-y-2.5');
    t.classList.add('opacity-100', 'translate-y-0');
    setTimeout(() => {
        t.classList.add('opacity-0', 'translate-y-2.5');
        t.classList.remove('opacity-100', 'translate-y-0');
    }, 2800);
}
</script>
</body>
</html>