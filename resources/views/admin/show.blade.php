<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artist->name }} — Enzzie Shop Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm:   ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        bg:      '#111111',
                        bg2:     '#1a1a1a',
                        bg3:     '#222222',
                        bg4:     '#2a2a2a',
                        sidebar: '#1e1e1e',
                        border1: '#333333',
                        border2: '#3a3a3a',
                        accent:  '#c0392b',
                        accentH: '#a93226',
                        text1:   '#f0f0f0',
                        text2:   '#cccccc',
                        muted:   '#888888',
                        danger:  '#e84040',
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #111; }
        h1, .font-syne { font-family: 'Syne', sans-serif; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #3a3a3a; border-radius: 10px; }

        /* Panel slide-in */
        .panel-base {
            position: fixed; top: 0; right: 0;
            width: 300px; height: 100vh;
            background: #1a1a1a;
            border-left: 1px solid #333;
            flex-direction: column;
            overflow-y: auto;
            z-index: 9999;
            box-shadow: -8px 0 32px rgba(0,0,0,0.5);
            display: none; pointer-events: none;
        }
        .panel-base.open {
            display: flex !important; pointer-events: all !important;
            animation: slideIn 0.22s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @media (max-width: 480px) { .panel-base { width: 100%; } }

        /* Banner slider */
        .banner-slider { scroll-snap-type: x mandatory; }
        .banner-slide  { scroll-snap-align: start; }

        /* Produk scroll */
        .produk-row { scrollbar-width: thin; scrollbar-color: #3a3a3a transparent; }
        .produk-row::-webkit-scrollbar { height: 3px; }

        /* Preview img */
        .preview-img { display: none; }
        .preview-img.show { display: block; }
        .upload-text.hide { display: none; }
    </style>
</head>
<body class="text-text1 min-h-screen flex">

<!-- ── SIDEBAR ── -->
<aside id="sidebar" class="class="w-[240px] max-[900px]:w-[60px] h-screen sticky top-0 bg-[#1e1e1e] border-r border-[#2e2e38] flex flex-col shrink-0 z-[100] transition-all duration-300 max-[768px]:fixed max-[768px]:-left-full max-[768px]:w-[200px] [&.open]:left-0 overflow-hidden">
    <div class="flex items-center gap-2.5 px-3.5 py-[15px] border-b border-border1">
        <h1 class="font-syne text-[0.95rem] font-extrabold tracking-wide text-text1 whitespace-nowrap">Enzzie Shop</h1>
    </div>
    <nav class="flex flex-col gap-px py-1 flex-1">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] border-transparent transition-all hover:bg-bg3 hover:text-text1 no-underline">
            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <span>Home</span>
        </a>
        <a href="{{ route('admin.order.index') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] border-transparent transition-all hover:bg-bg3 hover:text-text1 no-underline">
            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            <span>Order</span>
        </a>
        <a href="{{ route('admin.artist.index') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] border-accent bg-bg3 text-text1 no-underline">
            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/></svg>
            <span>Artis</span>
        </a>
        <a href="{{ route('admin.merch') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] border-transparent transition-all hover:bg-bg3 hover:text-text1 no-underline">
            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <span>Merch</span>
        </a>
    </nav>
</aside>

<!-- ── MAIN ── -->
<div class="flex-1 flex flex-col min-w-0 bg-[#181818]">

    <!-- TOPBAR -->
    <div class="flex items-center gap-3 px-4 py-2.5 border-b border-border1 bg-sidebar h-[52px]">
        <a href="{{ route('admin.artist.index') }}" class="text-muted hover:text-text1 transition-colors text-[0.82rem] no-underline flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            Artis
        </a>
        <span class="text-border2">/</span>
        <span class="text-text1 text-[0.82rem] font-semibold">{{ $artist->name }}</span>
        <div class="ml-auto flex items-center gap-2">
            <div class="relative w-8 h-8 rounded-full bg-bg3 border border-border1 flex items-center justify-center cursor-pointer text-text2 hover:bg-border2 transition-all">
                <svg class="w-[15px] h-[15px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="absolute top-0.5 right-0.5 min-w-[14px] h-[14px] px-px rounded-full bg-danger border-[1.5px] border-sidebar text-[0.52rem] font-bold text-white flex items-center justify-center">99+</span>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="p-4 overflow-y-auto flex-1">

        <!-- ── BANNER SECTION ── -->
        <div class="flex items-center justify-between mb-3">
            <span class="font-syne text-[0.72rem] font-bold tracking-[0.1em] uppercase text-muted">Banner</span>
        </div>

        <div class="relative rounded-[12px] overflow-hidden bg-bg2 border border-border1 h-[180px] mb-4">
            <!-- Banner slide area -->
            <div class="banner-slider flex overflow-x-auto h-full w-full" id="bannerSlider">
                @forelse($artist->banners ?? [] as $banner)
                <div class="banner-slide flex-shrink-0 w-full h-full relative">
                    @if($banner->image)
                        <img src="{{ $banner->foto_url }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 px-4 pb-3 pt-8 bg-gradient-to-t from-black/80 to-transparent">
                        <div class="font-syne font-bold text-white text-[0.95rem]">{{ $banner->title }}</div>
                        @if($banner->description)
                        <div class="text-white/70 text-[0.72rem]">{{ $banner->description }}</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="flex-shrink-0 w-full h-full flex flex-col items-center justify-center text-muted gap-2">
                    <svg class="w-8 h-8 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/></svg>
                    <span class="text-[0.75rem]">Belum ada banner</span>
                </div>
                @endforelse
            </div>

            <!-- Nav arrows (hanya jika ada banner) -->
            @if(isset($artist->banners) && $artist->banners->count() > 1)
            <button onclick="slideBanner(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-black/50 border border-white/10 flex items-center justify-center text-white hover:bg-black/70 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button onclick="slideBanner(1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-black/50 border border-white/10 flex items-center justify-center text-white hover:bg-black/70 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            </button>
            @endif

            <!-- Tambah banner btn -->
            <button onclick="openPanel('panelTambahBanner')"
                    class="absolute right-3 top-3 w-8 h-8 rounded-full bg-black/50 border border-white/10 flex items-center justify-center text-white text-lg hover:bg-accent hover:border-accent transition-all">+</button>
        </div>

        <!-- ── PRODUCT KATEGORI ── -->
        <div class="flex items-center justify-between mb-3">
            <span class="font-syne text-[0.72rem] font-bold tracking-[0.1em] uppercase text-muted">Product Kategori</span>
            <button onclick="openPanel('panelTambahKategori')"
                    class="w-7 h-7 rounded-full bg-bg3 border border-border2 flex items-center justify-center text-muted text-lg hover:border-accent hover:text-accent transition-all">+</button>
        </div>

        <!-- Kategori sections -->
        <div class="flex flex-col gap-4" id="kategoriContainer">
            @forelse($merches as $kategori => $produkList)
            <div class="bg-bg2 border border-border1 rounded-[10px] overflow-hidden" id="kategori-{{ $kategori }}">
                <!-- Kategori header -->
                <div class="flex items-center justify-between px-3.5 py-2.5 border-b border-border1">
                    <span class="font-syne text-[0.78rem] font-bold text-text1 capitalize">{{ ucfirst($kategori) }} <span class="text-muted font-normal text-[0.7rem]">&gt;</span></span>
                    <button onclick="openTambahProduk('{{ $kategori }}')"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-accent text-white text-[0.7rem] font-semibold hover:bg-accentH transition-all cursor-pointer border-none">
                        + produk
                    </button>
                </div>

                <!-- Produk scroll row -->
                <div class="produk-row flex gap-2.5 overflow-x-auto px-3 py-3" id="produk-row-{{ $kategori }}">
                    @foreach($produkList as $merch)
                    <div class="flex-shrink-0 w-[120px] bg-bg3 border border-border1 rounded-[8px] overflow-hidden cursor-pointer hover:border-accent transition-all"
                         onclick="openEditProduk({{ $merch->id }})">
                        <div class="w-full aspect-square bg-bg4 flex items-center justify-center text-2xl overflow-hidden">
                            @if($merch->foto_url)
                                <img src="{{ $merch->foto_url }}" alt="{{ $merch->nama }}" class="w-full h-full object-cover block">
                            @else
                                🛍
                            @endif
                        </div>
                        <div class="px-2 pt-1.5 pb-2">
                            <div class="text-[0.65rem] font-semibold text-text1 whitespace-nowrap overflow-hidden text-ellipsis">{{ $merch->nama }}</div>
                            <div class="flex items-center justify-between gap-1 mt-0.5">
                                <div class="text-[0.62rem] text-text2 font-bold">Rp{{ number_format($merch->harga, 0, ',', '.') }}</div>
                                <span class="px-1 py-[1px] rounded text-[0.48rem] font-bold uppercase
                                    @if($merch->status === 'ready') bg-green-500/20 text-green-400
                                    @elseif($merch->status === 'pre_order') bg-yellow-500/20 text-yellow-400
                                    @else bg-danger/20 text-danger @endif">
                                    {{ $merch->status === 'pre_order' ? 'PO' : ($merch->status === 'stok_habis' ? 'Habis' : 'Ready') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-muted text-[0.82rem]">
                Belum ada produk. Klik + untuk tambah kategori.
            </div>
            @endforelse
        </div>

    </div>
</div>

<!-- OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[9998] hidden" onclick="closeAllPanels()"></div>

<!-- ── PANEL: TAMBAH BANNER ── -->
<div id="panelTambahBanner" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Banner</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white transition-all cursor-pointer">✕</button>
    </div>
    <div class="p-4">
        <form id="bannerForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Judul</label>
                <input type="text" name="title" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full" placeholder="Judul banner..." required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Deskripsi</label>
                <textarea name="description" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full resize-y min-h-[60px]" placeholder="Deskripsi..."></textarea>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Foto Banner</label>
                <div id="bannerUploadBox" class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all"
                     onclick="this.querySelector('input').click()">
                    <img class="preview-img w-full max-h-[110px] object-cover rounded pointer-events-none" id="bannerPrevImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="bannerUploadText">
                        <span class="text-xl">🖼</span><span>+ Pilih Foto</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden" onchange="showPreview(this,'bannerPrevImg','bannerUploadText','bannerUploadBox')">
                </div>
            </div>
            <label class="flex items-center gap-2 text-[0.8rem] cursor-pointer text-text2">
                <input type="checkbox" name="is_active" checked class="accent-accent"> Aktif
            </label>
            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Simpan Banner</button>
        </form>
    </div>
</div>

<!-- ── PANEL: TAMBAH KATEGORI ── -->
<div id="panelTambahKategori" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Kategori</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white transition-all cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5">
        <p class="text-muted text-[0.78rem]">Masukkan nama kategori baru untuk artis ini.</p>
        <div class="flex flex-col gap-1">
            <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Nama Kategori</label>
            <input type="text" id="inputNamaKategori" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full" placeholder="cth: Album, Weverse, Photocard...">
        </div>
        <button onclick="tambahKategori()" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Tambah</button>

        <!-- Kategori yang sudah ada -->
        <div class="h-px bg-border1 my-1"></div>
        <div class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em] mb-1">Kategori tersedia</div>
        <div class="flex flex-col gap-1" id="kategoriListPanel">
            @forelse($merches as $kat => $list)
            <div class="flex items-center justify-between px-2.5 py-2 bg-bg3 rounded-lg border border-border1">
                <span class="text-[0.8rem] text-text2 capitalize">{{ ucfirst($kat) }}</span>
                <span class="text-[0.68rem] text-muted">{{ $list->count() }} produk</span>
            </div>
            @empty
            <div class="text-muted text-[0.75rem]">Belum ada kategori.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- ── PANEL: TAMBAH PRODUK ── -->
<div id="panelTambahProduk" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Produk</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white transition-all cursor-pointer">✕</button>
    </div>
    <div class="p-4">
        <form id="produkForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <input type="hidden" id="produkKategori" name="kategori" value="">

            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Kategori</label>
                <div id="produkKategoriLabel" class="px-2.5 py-2 bg-bg3 border border-border2 rounded-lg text-text2 text-[0.83rem] capitalize">-</div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Nama Produk</label>
                <input type="text" name="nama" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full" placeholder="Nama produk..." required>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div class="flex flex-col gap-1">
                    <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Harga (Rp)</label>
                    <input type="number" name="harga" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full" placeholder="0" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Stok</label>
                    <input type="number" name="stok" value="0" min="0" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full">
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Status</label>
                <select name="status" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent w-full" required>
                    <option value="ready">Ready</option>
                    <option value="pre_order">Pre Order</option>
                    <option value="stok_habis">Stok Habis</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Foto</label>
                <div id="produkUploadBox" class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all"
                     onclick="this.querySelector('input').click()">
                    <img class="preview-img w-full max-h-[110px] object-cover rounded pointer-events-none" id="produkPrevImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="produkUploadText">
                        <span class="text-xl">🛍</span><span>+ Pilih Foto</span>
                    </div>
                    <input type="file" name="foto" accept="image/*" class="hidden" onchange="showPreview(this,'produkPrevImg','produkUploadText','produkUploadBox')">
                </div>
            </div>

            <!-- Informasi tambahan (collapsible) -->
            <details class="bg-bg3 border border-border1 rounded-lg">
                <summary class="px-3 py-2 text-[0.72rem] font-bold text-muted uppercase tracking-[0.06em] cursor-pointer select-none">Informasi Tambahan</summary>
                <div class="px-3 pb-3 pt-1 flex flex-col gap-2">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">Ukuran</label>
                            <input type="text" name="ukuran" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full" placeholder="S, M, L...">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">Bahan</label>
                            <input type="text" name="bahan" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full" placeholder="Cotton...">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">Tanggal Terbit</label>
                            <input type="date" name="tanggal_terbit" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">Garansi</label>
                            <input type="text" name="garansi" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full" placeholder="1 tahun...">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">No. Telepon</label>
                            <input type="text" name="no_telfon" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full">
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-[0.65rem] text-muted">Email</label>
                            <input type="email" name="email" class="bg-bg4 border border-border2 rounded px-2 py-1.5 text-text1 text-[0.8rem] outline-none focus:border-accent w-full">
                        </div>
                    </div>
                </div>
            </details>

            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Kirim</button>
        </form>
    </div>
</div>

<!-- ── PANEL: EDIT PRODUK ── -->
<div id="panelEditProduk" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Edit Produk</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white transition-all cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5" id="editProdukBody">
        <div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>
    </div>
</div>

<script>
    const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
    const ARTIS_SLUG = '{{ $artist->slug }}';
    const ARTISTS_JSON = @json($kategoriList);

    // ── Image preview ──
    function showPreview(input, imgId, textId, boxId) {
        if (!input.files?.[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(imgId).src = e.target.result;
            document.getElementById(imgId).classList.add('show');
            document.getElementById(textId).classList.add('hide');
            document.getElementById(boxId).classList.add('border-green-600');
        };
        reader.readAsDataURL(input.files[0]);
    }

    // ── Panel controls ──
    function openPanel(id) {
        document.querySelectorAll('.panel-base').forEach(p => p.classList.remove('open'));
        document.getElementById(id).classList.add('open');
        document.getElementById('overlay').classList.remove('hidden');
    }
    function closeAllPanels() {
        document.querySelectorAll('.panel-base').forEach(p => p.classList.remove('open'));
        document.getElementById('overlay').classList.add('hidden');
    }

    // ── Banner slider ──
    function slideBanner(dir) {
        const slider = document.getElementById('bannerSlider');
        slider.scrollBy({ left: dir * slider.clientWidth, behavior: 'smooth' });
    }

    // ── Tambah produk (set kategori dulu) ──
    function openTambahProduk(kategori) {
        document.getElementById('produkKategori').value = kategori;
        document.getElementById('produkKategoriLabel').textContent = kategori.charAt(0).toUpperCase() + kategori.slice(1);

        // Reset form & preview
        document.getElementById('produkForm').reset();
        document.getElementById('produkPrevImg').src = '';
        document.getElementById('produkPrevImg').classList.remove('show');
        document.getElementById('produkUploadText').classList.remove('hide');
        document.getElementById('produkUploadBox').classList.remove('border-green-600');

        openPanel('panelTambahProduk');
    }

    // ── Tambah kategori baru ──
    async function tambahKategori() {
        const nama = document.getElementById('inputNamaKategori').value.trim();
        if (!nama) return alert('Masukkan nama kategori!');

        const res = await fetch(`/admin/artist/${ARTIS_SLUG}/kategori`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ nama_kategori: nama })
        });
        const result = await res.json();

        if (result.success) {
            // Tambah section kategori baru ke DOM
            const slug = result.kategori_slug;
            const label = result.kategori_label;

            // Cek apakah sudah ada
            if (document.getElementById('kategori-' + slug)) {
                alert('Kategori sudah ada!');
                return;
            }

            const container = document.getElementById('kategoriContainer');
            const emptyMsg = container.querySelector('.text-center');
            if (emptyMsg) emptyMsg.remove();

            const html = `
                <div class="bg-bg2 border border-border1 rounded-[10px] overflow-hidden" id="kategori-${slug}">
                    <div class="flex items-center justify-between px-3.5 py-2.5 border-b border-border1">
                        <span class="font-syne text-[0.78rem] font-bold text-text1">${label} <span class="text-muted font-normal text-[0.7rem]">></span></span>
                        <button onclick="openTambahProduk('${slug}')"
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-accent text-white text-[0.7rem] font-semibold hover:bg-accentH transition-all cursor-pointer border-none">
                            + produk
                        </button>
                    </div>
                    <div class="produk-row flex gap-2.5 overflow-x-auto px-3 py-3" id="produk-row-${slug}">
                        <div class="text-muted text-[0.75rem] py-2">Belum ada produk.</div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);

            // Update panel list
            document.getElementById('kategoriListPanel').insertAdjacentHTML('beforeend', `
                <div class="flex items-center justify-between px-2.5 py-2 bg-bg3 rounded-lg border border-border1">
                    <span class="text-[0.8rem] text-text2">${label}</span>
                    <span class="text-[0.68rem] text-muted">0 produk</span>
                </div>
            `);

            document.getElementById('inputNamaKategori').value = '';
            closeAllPanels();
        }
    }

    // ── Produk form submit ──
    document.getElementById('produkForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const kategori = document.getElementById('produkKategori').value;

        const res = await fetch(`/admin/artist/${ARTIS_SLUG}/produk`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData
        });
        const result = await res.json();

        if (result.success) {
            const m = result.merch;
            const fotoHtml = m.foto_url
                ? `<img src="${m.foto_url}" class="w-full h-full object-cover block" alt="${m.nama}">`
                : '🛍';

            const statusClass = m.status === 'ready'
                ? 'bg-green-500/20 text-green-400'
                : m.status === 'pre_order'
                    ? 'bg-yellow-500/20 text-yellow-400'
                    : 'bg-red-500/20 text-red-400';
            const statusLabel = m.status === 'pre_order' ? 'PO' : m.status === 'stok_habis' ? 'Habis' : 'Ready';
            const harga = 'Rp' + Number(m.harga).toLocaleString('id-ID');

            const cardHtml = `
                <div class="flex-shrink-0 w-[120px] bg-bg3 border border-border1 rounded-[8px] overflow-hidden cursor-pointer hover:border-accent transition-all"
                     onclick="openEditProduk(${m.id})">
                    <div class="w-full aspect-square bg-bg4 flex items-center justify-center text-2xl overflow-hidden">${fotoHtml}</div>
                    <div class="px-2 pt-1.5 pb-2">
                        <div class="text-[0.65rem] font-semibold text-text1 whitespace-nowrap overflow-hidden text-ellipsis">${m.nama}</div>
                        <div class="flex items-center justify-between gap-1 mt-0.5">
                            <div class="text-[0.62rem] text-text2 font-bold">${harga}</div>
                            <span class="px-1 py-[1px] rounded text-[0.48rem] font-bold uppercase ${statusClass}">${statusLabel}</span>
                        </div>
                    </div>
                </div>
            `;

            const row = document.getElementById('produk-row-' + kategori);
            const emptyMsg = row?.querySelector('.text-muted');
            if (emptyMsg) emptyMsg.remove();
            row?.insertAdjacentHTML('beforeend', cardHtml);

            alert('Produk berhasil ditambahkan!');
            closeAllPanels();
            this.reset();
        } else {
            if (result.errors) {
                alert('Validasi gagal:\n' + Object.entries(result.errors).map(([k,v]) => k + ': ' + v.join(', ')).join('\n'));
            } else {
                alert('Gagal: ' + (result.message || 'Error'));
            }
        }
    });

    // ── Edit Produk ──
    async function openEditProduk(id) {
        openPanel('panelEditProduk');
        document.getElementById('editProdukBody').innerHTML = '<div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>';

        const res = await fetch('/admin/merch/' + id, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (!data.success) {
            document.getElementById('editProdukBody').innerHTML = '<div class="text-danger text-[0.8rem]">Gagal memuat data.</div>';
            return;
        }

        const m = data.merch;
        const inputCls = "bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none w-full focus:border-accent";
        const labelCls = "text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]";

        // Build kategori options
        const kategoriOpts = Object.entries(ARTISTS_JSON).map(([val, label]) =>
            `<option value="${val}" ${m.kategori === val ? 'selected' : ''}>${label}</option>`
        ).join('');

        document.getElementById('editProdukBody').innerHTML = `
            <form id="editProdukForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
                ${m.foto_url ? `<img src="${m.foto_url}" class="w-full h-[120px] object-cover rounded-lg border border-border2" alt="">` : ''}

                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Kategori</label>
                    <select class="${inputCls}" name="kategori" required>
                        ${kategoriOpts}
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Nama Produk</label>
                    <input type="text" class="${inputCls}" name="nama" value="${m.nama || ''}" required>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col gap-1">
                        <label class="${labelCls}">Harga</label>
                        <input type="number" class="${inputCls}" name="harga" value="${m.harga || 0}" required>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="${labelCls}">Stok</label>
                        <input type="number" class="${inputCls}" name="stok" value="${m.stok || 0}" min="0">
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Status</label>
                    <select class="${inputCls}" name="status" required>
                        <option value="ready" ${m.status === 'ready' ? 'selected' : ''}>Ready</option>
                        <option value="pre_order" ${m.status === 'pre_order' ? 'selected' : ''}>Pre Order</option>
                        <option value="stok_habis" ${m.status === 'stok_habis' ? 'selected' : ''}>Stok Habis</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Ganti Foto (opsional)</label>
                    <div id="editProdukUploadBox" class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] min-h-[80px] relative hover:border-accent hover:bg-accent/[0.04] transition-all"
                         onclick="this.querySelector('input').click()">
                        <img class="preview-img w-full max-h-[100px] object-cover rounded pointer-events-none" id="editProdukPrevImg" src="" alt="">
                        <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="editProdukUploadText">
                            <span class="text-lg">🛍</span><span>+ Pilih Foto Baru</span>
                        </div>
                        <input type="file" name="foto" accept="image/*" class="hidden"
                               onchange="showPreview(this,'editProdukPrevImg','editProdukUploadText','editProdukUploadBox')">
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Simpan Perubahan</button>
            </form>
            <div class="h-px bg-border1 my-2"></div>
            <button onclick="hapusProduk(${m.id},'${(m.nama||'').replace(/'/g,"\\'")}')"
                    class="w-full py-2 bg-danger/[0.12] border border-danger/25 rounded-lg text-danger text-[0.78rem] font-semibold hover:bg-danger/[0.22] transition-all cursor-pointer">
                🗑 Hapus Produk Ini
            </button>
        `;

        document.getElementById('editProdukForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            const res = await fetch('/admin/merch/' + m.id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData
            });
            const result = await res.json();
            if (result.success) {
                alert('Produk berhasil diupdate!');
                location.reload();
            } else {
                alert('Gagal: ' + (result.message || JSON.stringify(result)));
            }
        });
    }

    // ── Hapus Produk ──
    async function hapusProduk(id, nama) {
        if (!confirm(`Yakin hapus produk "${nama}"?`)) return;
        const res = await fetch('/admin/merch/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (result.success) {
            alert('Produk berhasil dihapus!');
            location.reload();
        } else {
            alert('Gagal: ' + result.message);
        }
    }

    // ── Banner form submit ──
    document.getElementById('bannerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('artist_id', '{{ $artist->id }}');

        const res = await fetch('/admin/banner/store', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData
        });
        const result = await res.json();
        if (result.success) {
            alert('Banner berhasil disimpan!');
            location.reload();
        } else {
            alert('Gagal: ' + (result.message || 'Error'));
        }
    });
</script>
</body>
</html>