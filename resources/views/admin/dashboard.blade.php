<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        bg: '#111111',
                        bg2: '#1a1a1a',
                        bg3: '#222222',
                        bg4: '#2a2a2a',
                        sidebar: '#1e1e1e',
                        border1: '#333333',
                        border2: '#3a3a3a',
                        accent: '#c0392b',
                        accentH: '#a93226',
                        text1: '#f0f0f0',
                        text2: '#cccccc',
                        muted: '#888888',
                        danger: '#e84040',
                    },
                    keyframes: {
                        slideIn: {
                            from: { transform: 'translateX(100%)', opacity: '0' },
                            to:   { transform: 'translateX(0)',    opacity: '1' },
                        }
                    },
                    animation: {
                        slideIn: 'slideIn 0.22s ease',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, .font-syne { font-family: 'Syne', sans-serif; }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #3a3a3a; border-radius: 10px; }
        .banner-slider { scrollbar-width: thin; scrollbar-color: #3a3a3a transparent; }
        .merch-grid { scrollbar-width: thin; scrollbar-color: #3a3a3a transparent; }
        .artis-row::-webkit-scrollbar { display: none; }
        .artis-row { scrollbar-width: none; }

        /* ── PANEL BASE ── */
        .panel-base {
            position: fixed;
            top: 0; right: 0;
            width: 300px;
            height: 100vh;
            background: #1a1a1a;
            border-left: 1px solid #333;
            flex-direction: column;
            overflow-y: auto;
            z-index: 9999;
            box-shadow: -8px 0 32px rgba(0,0,0,0.5);
            display: none;
            pointer-events: none;
        }
        .panel-base.open {
            display: flex !important;
            pointer-events: all !important;
            animation: slideIn 0.22s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @media (max-width: 480px) {
            .panel-base { width: 100%; }
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: 240px;
            height: 100vh;
            position: sticky;
            top: 0;
            background: #1e1e1e;
            border-right: 1px solid #2e2e38;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 100;
            transition: transform 0.3s ease, width 0.3s ease;
            overflow: hidden;
        }

        @media (max-width: 900px) and (min-width: 769px) {
            #sidebar { width: 60px; }
            .sidebar-label { display: none !important; }
            .sidebar-brand { display: none !important; }
        }

  
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: 0; top: 0;
                width: 220px;
                z-index: 200;
                transform: translateX(-100%);
                box-shadow: 4px 0 24px rgba(0,0,0,0.6);
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }

       
        .preview-img { display: none; }
        .preview-img.show { display: block; }
        .upload-text.hide { display: none; }
        .artis-chip.active .artis-avatar { border-color: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,0.25); }
        .artis-chip.active .artis-name { color: #f0f0f0; }
        .artis-chip:hover .artis-avatar { border-color: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,0.25); }
        .banner-card:hover .banner-overlay { opacity: 1 !important; }
        .filter-tab.active { background: #c0392b !important; color: #fff !important; border-color: #c0392b !important; }

        /* Topbar title: hanya mobile */
        .topbar-title { display: none; }
        @media (max-width: 768px) {
            .topbar-title { display: block; }
        }

        /* Hamburger desktop: sembunyikan di mobile (pakai topbar btn) */
        .sidebar-hamburger { display: flex; }
        @media (max-width: 768px) {
            .sidebar-hamburger { display: none; }
        }

        /* Topbar hamburger: hanya mobile */
        #topbarHamburgerBtn { display: none; }
        @media (max-width: 768px) {
            #topbarHamburgerBtn { display: flex; }
        }

        /* ── MOBILE GRID: Banner & Merch ── */
        @media (max-width: 640px) {
            .banner-slider {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                overflow: visible !important;
            }
            .banner-card {
                width: 100% !important;
                flex-shrink: unset !important;
                height: 110px !important;
            }
            #btnTambahBanner {
                width: 100% !important;
                flex-shrink: unset !important;
                height: 80px !important;
            }
            .merch-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                overflow: visible !important;
            }
            .merch-card {
                width: 100% !important;
                flex-shrink: unset !important;
            }
            /* Filter tabs: scroll horizontal, no wrap */
            #filterTabs {
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                padding-bottom: 4px;
                -webkit-overflow-scrolling: touch;
            }
            #filterTabs::-webkit-scrollbar { height: 2px; }
        }
    </style>
</head>
<body class="bg-bg text-text1 min-h-screen flex">

<!-- ── SIDEBAR OVERLAY (mobile) ── -->
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black/50 z-[190] hidden"
     onclick="closeSidebar()"></div>

<!-- ── SIDEBAR ── -->
<aside id="sidebar">
    <div class="flex items-center gap-2.5 px-3.5 py-4 border-b border-[#2e2e38] flex-shrink-0">
        <!-- Hamburger toggle (desktop/tablet only) -->
        <div class="sidebar-hamburger flex-col gap-1 cursor-pointer p-0.5 shrink-0"
             onclick="toggleSidebar()">
            <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
            <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
            <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
        </div>
        <h1 class="sidebar-brand font-syne text-[0.95rem] font-extrabold text-[#f0f0f4] truncate overflow-hidden">Enzzie Shop</h1>
    </div>
    <nav class="flex flex-col gap-px py-1 flex-1">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] transition-all duration-150 hover:bg-bg3 hover:text-text1 no-underline
                  {{ request()->routeIs('admin.dashboard') ? 'bg-bg3 text-text1 border-accent' : 'border-transparent' }}">
            <svg class="w-4 h-4 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span class="sidebar-label">Home</span>
        </a>
        <a href="{{ route('admin.order.index') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] transition-all duration-150 hover:bg-bg3 hover:text-text1 no-underline
                  {{ request()->routeIs('admin.order.*') ? 'bg-bg3 text-text1 border-accent' : 'border-transparent' }}">
            <svg class="w-4 h-4 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
            <span class="sidebar-label">Order</span>
        </a>
        <a href="{{ route('admin.artist.index') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] transition-all duration-150 hover:bg-bg3 hover:text-text1 no-underline
                  {{ request()->routeIs('admin.artist.*') ? 'bg-bg3 text-text1 border-accent' : 'border-transparent' }}">
            <svg class="w-4 h-4 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="7" r="4"/>
                <path d="M5.5 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/>
            </svg>
            <span class="sidebar-label">Artis</span>
        </a>
        <a href="{{ route('admin.merch') }}"
           class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-text2 border-l-[3px] transition-all duration-150 hover:bg-bg3 hover:text-text1 no-underline
                  {{ request()->routeIs('admin.merch.*') ? 'bg-bg3 text-text1 border-accent' : 'border-transparent' }}">
            <svg class="w-4 h-4 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2"/>
                <path d="M8 21h8M12 17v4"/>
            </svg>
            <span class="sidebar-label">Merch</span>
        </a>
        
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

<!-- ── MAIN ── -->
<div class="flex-1 flex flex-col min-w-0 bg-[#181818]">

    <!-- TOPBAR -->
    <div class="flex items-center justify-between gap-2 px-4 py-2.5 border-b border-border1 bg-sidebar h-[52px] sticky top-0 z-50">
        <!-- Hamburger (mobile only) -->
        <button id="topbarHamburgerBtn"
                class="w-8 h-8 rounded-full bg-bg3 border border-border1 items-center justify-center flex-col gap-[3px] p-[7px] cursor-pointer"
                onclick="openSidebar()">
            <span class="block w-3.5 h-0.5 bg-text2 rounded"></span>
            <span class="block w-3.5 h-0.5 bg-text2 rounded"></span>
            <span class="block w-3.5 h-0.5 bg-text2 rounded"></span>
        </button>
        <!-- Brand title (mobile only) -->
        <span class="topbar-title font-syne text-[0.9rem] font-extrabold text-text1 flex-1 text-center">Enzzie Shop</span>
        <!-- Spacer for right side (mobile balance) -->
        <div class="w-8 md:hidden"></div>
    </div>

    <!-- CONTENT -->
    <div class="p-4 overflow-y-auto flex-1">

        <!-- ── BANNER SECTION ── -->
        <div class="flex items-center justify-between mb-3">
            <span class="font-syne text-[0.72rem] font-bold tracking-[0.1em] uppercase text-muted">Banner</span>
        </div>

        <div class="banner-slider flex gap-3 overflow-x-auto pb-2 scroll-smooth" id="bannerSlider">
            @foreach($banners as $banner)
            <div class="banner-card flex-shrink-0 w-[260px] h-[150px] rounded-[10px] overflow-hidden relative border-2 cursor-pointer bg-bg3 transition-all duration-200 hover:-translate-y-0.5 z-10
                        {{ $banner->is_active ? 'border-accent' : 'border-transparent hover:border-accent' }}"
                 onclick="openEditBanner({{ $banner->id }}); event.stopPropagation();">
                @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover block">
                @endif
                <div class="absolute top-1.5 right-1.5 bg-black/55 rounded-md px-1.5 py-1 text-[0.62rem] text-white font-semibold opacity-0 transition-opacity pointer-events-none banner-overlay">✏ Edit</div>
                <div class="absolute bottom-0 left-0 right-0 pt-6 px-2.5 pb-2 bg-gradient-to-t from-black/75 to-transparent text-[0.68rem] font-semibold text-white">
                    {{ $banner->title }}@if($banner->artist) — {{ $banner->artist->name }}@endif
                </div>
            </div>
            @endforeach

            <div id="btnTambahBanner"
                 class="flex-shrink-0 w-[90px] h-[150px] rounded-[10px] border-2 border-dashed border-border2 flex flex-col items-center justify-center gap-1.5 cursor-pointer text-muted text-[0.7rem] font-semibold transition-all duration-200 hover:border-accent hover:text-accent hover:bg-accent/5">
                <span class="text-[1.3rem] font-light">+</span>
                <span>Tambah</span>
            </div>
        </div>

        <div class="h-px bg-border1 my-4"></div>

        <!-- ── ARTIS SECTION ── -->
        <div class="flex items-center justify-between mb-2.5">
            <span class="font-syne text-[0.72rem] font-bold tracking-[0.1em] uppercase text-muted">Artis</span>
            <button id="btnTambahArtis" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-accent text-white text-[0.75rem] font-semibold hover:bg-accentH transition-all duration-150 cursor-pointer border-none">+ Tambah Artis</button>
        </div>

        <div class="bg-bg2 border border-border1 rounded-[10px] px-3.5 py-3">
            <div class="artis-row flex items-center gap-3.5 overflow-x-auto pb-0.5" id="artisRow">
                <div id="btnAddArtisCircle"
                     title="Tambah Artis"
                     class="w-[50px] h-[50px] rounded-full bg-bg3 border-2 border-dashed border-border2 flex items-center justify-center cursor-pointer text-muted text-[1.3rem] font-light transition-all duration-200 hover:border-accent hover:text-accent hover:bg-accent/[0.06] flex-shrink-0 leading-none">+</div>
                @foreach($artists as $artist)
                <div class="artis-chip flex flex-col items-center gap-1.5 cursor-pointer flex-shrink-0"
                     onclick="filterMerch('{{ $artist->slug ?? strtolower(str_replace(' ','-',$artist->name)) }}', this)">
                    <div class="artis-avatar w-[50px] h-[50px] rounded-full border-2 border-border2 overflow-hidden flex items-center justify-center font-bold text-[0.62rem] text-text1 bg-bg3 transition-all duration-200">
                        @if($artist->avatar)
                            <img src="{{ asset('storage/' . $artist->avatar) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover block">
                        @else
                            {{ strtoupper(substr($artist->name, 0, 3)) }}
                        @endif
                    </div>
                    <span class="artis-name text-[0.6rem] text-muted text-center max-w-[58px] overflow-hidden text-ellipsis whitespace-nowrap">{{ $artist->name }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ARTIS TABLE -->

        <!-- ARTIS TABLE -->
        <div id="artisTableSection" class="hidden mt-3.5">
            <div class="bg-bg2 border border-border1 rounded-[9px] overflow-hidden">
                <div class="flex items-center justify-between px-3.5 py-2.5 bg-bg3 border-b border-border1">
                    <span class="font-syne text-[0.7rem] font-bold tracking-[0.08em] uppercase text-muted">Daftar Artis</span>
                    <button onclick="toggleArtisTable()"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[0.7rem] font-semibold bg-bg4 text-text2 border border-border2 hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">
                        ✕ Tutup
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-bg3/50">
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">#</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Nama Artis</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Profil</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artists as $i => $artist)
                            <tr class="hover:[&>td]:bg-white/[0.02] border-t border-border1" id="artis-row-{{ $artist->id }}">
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">{{ $i + 1 }}</td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle font-medium text-text1">{{ $artist->name }}</td>
                               <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">
                                <div class="w-[30px] h-[30px] rounded-full overflow-hidden flex items-center justify-center text-[0.6rem] font-bold bg-bg3">
                                    @if($artist->avatar || $artist->image)
                                        <img src="{{ asset('storage/' . ($artist->avatar ?? $artist->image)) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($artist->name, 0, 3)) }}
                                    @endif
                                </div>
                            </td>

                            <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">
                                <div class="flex gap-1.5">
                                    <button
                                        onclick="openEditArtis({{ $artist->id }},'{{ addslashes($artist->name) }}',{{ ($artist->avatar ?? $artist->image) ? asset('storage/' . ($artist->avatar ?? $artist->image)) : '' }})"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-[0.75rem] font-semibold bg-bg4 text-text2 border border-border2 hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">✏ Edit</button>
                                    <button
                                        onclick="hapusArtis({{ $artist->id }}, '{{ addslashes($artist->name) }}')"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-[0.75rem] font-semibold bg-danger/[0.12] text-danger border border-danger/25 hover:bg-danger/[0.22] transition-all duration-150 cursor-pointer">🗑 Hapus</button>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="h-px bg-border1 my-4"></div>

        <!-- Merch Grid -->
        <div class="merch-grid flex gap-2.5 overflow-x-auto pb-2" id="merchGrid">
            @foreach($merches as $merch)
            <div class="merch-card flex-shrink-0 w-[150px] bg-bg2 border border-border1 rounded-[10px] overflow-hidden cursor-pointer transition-all duration-200 hover:border-accent hover:-translate-y-0.5"
                 data-artis="{{ $merch->artist->slug ?? strtolower(str_replace(' ','-',$merch->artist->name ?? '')) }}"
                 onclick="openEditMerch({{ $merch->id }})">
                <div class="w-full aspect-square bg-bg3 flex items-center justify-center text-muted text-3xl overflow-hidden">
                    @if($merch->foto)
                        <img src="{{ asset('storage/' . $merch->foto) }}" alt="{{ $merch->nama }}" class="w-full h-full object-cover block">
                    @else
                        🛍
                    @endif
                </div>
                <div class="px-[9px] pt-1.5 pb-2">
                    <div class="text-[0.7rem] font-semibold mb-0.5 whitespace-nowrap overflow-hidden text-ellipsis text-text1">{{ $merch->nama }}</div>
                    <div class="text-[0.58rem] text-accent font-semibold mb-1">{{ $merch->artist->name ?? '-' }}</div>
                    <div class="flex items-center justify-between gap-1">
                        <div class="text-[0.7rem] text-text1 font-bold">Rp{{ number_format($merch->harga, 0, ',', '.') }}</div>
                        <span class="px-1.5 py-[2px] rounded text-[0.5rem] font-bold uppercase
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

        <!-- MERCH TABLE -->
        <div id="merchTableSection" class="hidden mt-4">
            <div class="bg-bg2 border border-border1 rounded-[9px] overflow-hidden">
                <div class="flex items-center justify-between px-3.5 py-2.5 bg-bg3 border-b border-border1">
                    <span class="font-syne text-[0.7rem] font-bold tracking-[0.08em] uppercase text-muted">Daftar Merch</span>
                    <button onclick="toggleMerchTable()"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[0.7rem] font-semibold bg-bg4 text-text2 border border-border2 hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">
                        ✕ Tutup
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-bg3/50">
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">#</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Nama</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Artis</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Harga</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Status</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Stok</th>
                                <th class="px-3.5 py-2.5 text-left text-[0.68rem] font-bold tracking-[0.07em] uppercase text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($merches as $i => $merch)
                            <tr class="hover:[&>td]:bg-white/[0.02] border-t border-border1" id="merch-row-{{ $merch->id }}">
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">{{ $i + 1 }}</td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text1 font-medium align-middle">{{ $merch->nama }}</td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">{{ $merch->artist->name ?? '-' }}</td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">Rp{{ number_format($merch->harga, 0, ',', '.') }}</td>
                                <td class="px-3.5 py-2.5 align-middle">
                                    <span class="px-2 py-0.5 rounded text-[0.65rem] font-bold uppercase
                                        @if($merch->status === 'ready') bg-green-500/20 text-green-400 border border-green-500/30
                                        @elseif($merch->status === 'pre_order') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                        @else bg-danger/20 text-danger border border-danger/30 @endif">
                                        {{ $merch->status === 'pre_order' ? 'Pre Order' : ($merch->status === 'stok_habis' ? 'Stok Habis' : 'Ready') }}
                                    </span>
                                </td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">{{ $merch->stok }}</td>
                                <td class="px-3.5 py-2.5 text-[0.82rem] text-text2 align-middle">
                                    <div class="flex gap-1.5">
                                        <button onclick="openEditMerch({{ $merch->id }})"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-[0.75rem] font-semibold bg-bg4 text-text2 border border-border2 hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">✏ Edit</button>
                                        <button onclick="hapusMerch({{ $merch->id }}, '{{ addslashes($merch->nama) }}')"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-[0.75rem] font-semibold bg-danger/[0.12] text-danger border border-danger/25 hover:bg-danger/[0.22] transition-all duration-150 cursor-pointer">🗑 Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<!-- ── OVERLAY ── -->
<div id="overlay"
     class="fixed inset-0 bg-black/60 backdrop-blur-[2px] z-[9998] hidden"
     onclick="closeAllPanels()"></div>

<!-- ── PANEL: TAMBAH BANNER ── -->
<div id="panelBanner" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Banner</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5">
        <form id="bannerForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Artis</label>
                <select class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" name="artist_id" required>
                    <option value="">Pilih Artis...</option>
                    @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Judul</label>
                <input type="text" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" name="title" placeholder="Judul banner..." required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Deskripsi</label>
                <textarea class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full resize-y min-h-[70px]" name="description" rows="3" placeholder="Deskripsi event..."></textarea>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Image</label>
                <div id="bannerUploadBox"
                     class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all duration-150"
                     onclick="this.querySelector('input[type=file]').click()">
                    <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="bannerPreviewImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="bannerUploadText">
                        <span class="text-xl">🖼</span>
                        <span>+ Pilih Foto</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden"
                           onchange="showPreview(this, 'bannerPreviewImg', 'bannerUploadText', 'bannerUploadBox')">
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="flex items-center gap-2 text-[0.8rem] cursor-pointer text-text2">
                    <input type="checkbox" name="is_active" checked class="accent-accent">
                    Aktif
                </label>
            </div>
            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all duration-150 text-center">Simpan Banner</button>
        </form>
    </div>
</div>

<!-- ── PANEL: EDIT BANNER ── -->
<div id="panelEditBanner" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Detail Banner</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5" id="editBannerBody">
        <div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>
    </div>
</div>

<!-- ── PANEL: TAMBAH ARTIS ── -->
<div id="panelArtis" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Artis</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5">
        <form id="artisForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Nama Artis</label>
                <input type="text" name="name" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" placeholder="Nama artis..." required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Profil</label>
                <div id="addArtisUploadBox"
                     class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all duration-150"
                     onclick="this.querySelector('input[type=file]').click()">
                    <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="addArtisPreviewImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="addArtisUploadText">
                        <span class="text-xl">🖼</span>
                        <span>+ Pilih Foto</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden"
                           onchange="showPreview(this, 'addArtisPreviewImg', 'addArtisUploadText', 'addArtisUploadBox')">
                </div>
            </div>
            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all duration-150 text-center">Kirim</button>
        </form>
        <div class="h-px bg-border1 my-2"></div>
        <button onclick="toggleArtisTable(true)" class="w-full py-2 bg-bg4 border border-border2 rounded-lg text-text2 text-[0.78rem] font-semibold hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">Lihat Tabel Artis</button>
    </div>
</div>

<!-- ── PANEL: TAMBAH MERCH ── -->
<div id="panelMerch" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Tambah Merch</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5">
        <form id="merchForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Artis</label>
                <select class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" name="artist_id" required>
                    <option value="">Pilih Artis...</option>
                    @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Nama Produk</label>
                <input type="text" name="nama" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" placeholder="Nama produk..." required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Harga (Rp)</label>
                <input type="number" name="harga" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" placeholder="0" required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Status</label>
                <select class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" name="status" required>
                    <option value="ready">Ready</option>
                    <option value="pre_order">Pre Order</option>
                    <option value="stok_habis">Stok Habis</option>
                </select>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Stok</label>
                <input type="number" name="stok" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" placeholder="0" value="0" min="0">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Foto</label>
                <div id="addMerchUploadBox"
                     class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all duration-150"
                     onclick="this.querySelector('input[type=file]').click()">
                    <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="addMerchPreviewImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="addMerchUploadText">
                        <span class="text-xl">🛍</span>
                        <span>+ Pilih Foto</span>
                    </div>
                    <input type="file" name="foto" accept="image/*" class="hidden"
                           onchange="showPreview(this, 'addMerchPreviewImg', 'addMerchUploadText', 'addMerchUploadBox')">
                </div>
            </div>
            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all duration-150 text-center">Kirim</button>
        </form>
        <div class="h-px bg-border1 my-2"></div>
        <button onclick="toggleMerchTable()" class="w-full py-2 bg-bg4 border border-border2 rounded-lg text-text2 text-[0.78rem] font-semibold hover:bg-border2 hover:text-text1 transition-all duration-150 cursor-pointer">Lihat Tabel Merch</button>
    </div>
</div>

<!-- ── PANEL: EDIT ARTIS ── -->
<div id="panelEditArtis" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Edit Artis</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5">
        <form id="editArtisForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
            <input type="hidden" id="editArtisId" name="_artis_id">
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Foto Saat Ini</label>
                <div id="editArtisCurrentImg" class="w-16 h-16 rounded-full overflow-hidden border-2 border-border2 flex items-center justify-center bg-bg3 text-[0.62rem] font-bold text-text1 mx-auto"></div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Nama Artis</label>
                <input type="text" name="name" id="editArtisName" class="bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none focus:border-accent transition-colors w-full" placeholder="Nama artis..." required>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]">Ganti Foto (opsional)</label>
                <div id="editArtisUploadBox"
                     class="border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all duration-150"
                     onclick="this.querySelector('input[type=file]').click()">
                    <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="editArtisPreviewImg" src="" alt="">
                    <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="editArtisUploadText">
                        <span class="text-xl">🖼</span>
                        <span>+ Pilih Foto Baru</span>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden"
                           onchange="showPreview(this, 'editArtisPreviewImg', 'editArtisUploadText', 'editArtisUploadBox')">
                </div>
            </div>
            <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all duration-150 text-center">Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- ── PANEL: EDIT MERCH ── -->
<div id="panelEditMerch" class="panel-base">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-border1 bg-bg3 flex-shrink-0 sticky top-0 z-10">
        <span class="font-syne text-[0.88rem] font-bold text-text1">Edit Merch</span>
        <button onclick="closeAllPanels()" class="w-6 h-6 rounded bg-bg4 border border-border2 flex items-center justify-center text-muted text-[0.78rem] hover:bg-danger hover:text-white hover:border-danger transition-all duration-150 cursor-pointer">✕</button>
    </div>
    <div class="p-4 flex flex-col gap-2.5" id="editMerchBody">
        <div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>
    </div>
</div>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    // ── Sidebar toggle ──
    function toggleSidebar() {
        // Desktop/tablet: toggle collapse
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 768) {
            const isCollapsed = sidebar.style.width === '60px';
            sidebar.style.width = isCollapsed ? '240px' : '60px';
            sidebar.querySelectorAll('.sidebar-label, .sidebar-brand').forEach(el => {
                el.style.display = isCollapsed ? '' : 'none';
            });
        } else {
            openSidebar();
        }
    }
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.remove('hidden');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.add('hidden');
    }

    // ── topbar hamburger (mobile only) ──
    document.getElementById('topbarHamburgerBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        openSidebar();
    });

    // ── Button listeners ──
    document.getElementById('btnTambahBanner').addEventListener('click', () => openPanel('panelBanner'));
    document.getElementById('btnTambahArtis').addEventListener('click', () => openPanel('panelArtis'));
    document.getElementById('btnAddArtisCircle').addEventListener('click', () => openPanel('panelArtis'));

    // ── Image preview ──
    function showPreview(input, imgId, textId, boxId) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(imgId).src = e.target.result;
            document.getElementById(imgId).classList.add('show');
            document.getElementById(textId).classList.add('hide');
            document.getElementById(boxId).classList.add('border-green-600', 'bg-green-900/10');
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

    // ── Toggle tables ──
    function toggleArtisTable(closePanel = false) {
        if (closePanel) closeAllPanels();
        const s = document.getElementById('artisTableSection');
        s.classList.toggle('hidden');
        if (!s.classList.contains('hidden')) s.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    function toggleMerchTable() {
        closeAllPanels();
        const s = document.getElementById('merchTableSection');
        s.classList.toggle('hidden');
        if (!s.classList.contains('hidden')) s.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // ── OPEN EDIT ARTIS ──
    function openEditArtis(id, name, imgUrl) {
        document.getElementById('editArtisId').value = id;
        document.getElementById('editArtisName').value = name;
        const prevImg = document.getElementById('editArtisPreviewImg');
        prevImg.src = '';
        prevImg.classList.remove('show');
        document.getElementById('editArtisUploadText').classList.remove('hide');
        document.getElementById('editArtisUploadBox').classList.remove('border-green-600', 'bg-green-900/10');
        const currentImgBox = document.getElementById('editArtisCurrentImg');
        if (imgUrl) {
            currentImgBox.innerHTML = `<img src="${imgUrl}" class="w-full h-full object-cover">`;
        } else {
            currentImgBox.innerHTML = name.substring(0, 3).toUpperCase();
        }
        openPanel('panelEditArtis');
    }

    // ── HAPUS ARTIS ──
    async function hapusArtis(id, name) {
        if (!confirm(`Yakin hapus artis "${name}"?\nSemua merch & banner terkait mungkin terpengaruh.`)) return;
        try {
            const res = await fetch('/admin/artist/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            });
            const text = await res.text();
            let result;
            try { result = JSON.parse(text); } catch { result = { success: false, message: text }; }
            if (result.success) {
                const row = document.getElementById('artis-row-' + id);
                if (row) row.remove();
                alert(result.message || 'Artis berhasil dihapus!');
                location.reload();
            } else {
                alert('Gagal hapus: ' + (result.message || 'Cek console untuk detail.'));
            }
        } catch (err) {
            alert('Error: ' + err.message);
        }
    }

    // ── EDIT ARTIS form submit ──
    document.getElementById('editArtisForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('editArtisId').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        const res = await fetch('/admin/artist/' + id, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: formData
        });
        const result = await res.json();
        if (result.success) {
            alert(result.message || 'Artis berhasil diupdate!');
            location.reload();
        } else {
            if (result.errors) {
                alert('Validasi gagal:\n' + Object.entries(result.errors).map(([k,v]) => k + ': ' + v.join(', ')).join('\n'));
            } else {
                alert('Gagal: ' + (result.message || JSON.stringify(result)));
            }
        }
    });

    // ── OPEN EDIT MERCH ──
    async function openEditMerch(id) {
        openPanel('panelEditMerch');
        document.getElementById('editMerchBody').innerHTML = '<div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>';

        const res = await fetch('/admin/merch/' + id, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (!data.success) {
            document.getElementById('editMerchBody').innerHTML = '<div class="text-danger text-[0.8rem]">Gagal memuat data.</div>';
            return;
        }

        const m = data.merch;
        const artistOptions = @json($artists).map(a =>
            `<option value="${a.id}" ${a.id == m.artist_id ? 'selected' : ''}>${a.name}</option>`
        ).join('');

        const inputCls = "bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none w-full focus:border-accent";
        const labelCls = "text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]";
        const uploadCls = "border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all";

        document.getElementById('editMerchBody').innerHTML = `
            <form id="editMerchForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Foto Saat Ini</label>
                    ${m.foto_url
                        ? `<img src="${m.foto_url}" class="w-full h-[120px] object-cover rounded-lg block border border-border2" alt="merch">`
                        : `<div class="w-full h-[80px] bg-bg3 rounded-lg flex items-center justify-center text-muted text-[0.75rem] border border-border2">Tidak ada foto</div>`
                    }
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Artis</label>
                    <select class="${inputCls}" name="artist_id" required>
                        <option value="">Pilih Artis...</option>
                        ${artistOptions}
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Nama Produk</label>
                    <input type="text" class="${inputCls}" name="nama" value="${m.nama || ''}" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Harga (Rp)</label>
                    <input type="number" class="${inputCls}" name="harga" value="${m.harga || 0}" required>
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
                    <label class="${labelCls}">Stok</label>
                    <input type="number" class="${inputCls}" name="stok" value="${m.stok || 0}" min="0">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Ganti Foto (opsional)</label>
                    <div id="editMerchUploadBox" class="${uploadCls}" onclick="this.querySelector('input[type=file]').click()">
                        <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="editMerchPreviewImg" src="" alt="">
                        <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="editMerchUploadText">
                            <span class="text-xl">🛍</span>
                            <span>+ Pilih Foto Baru</span>
                        </div>
                        <input type="file" name="foto" accept="image/*" class="hidden"
                               onchange="showPreview(this, 'editMerchPreviewImg', 'editMerchUploadText', 'editMerchUploadBox')">
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Simpan Perubahan</button>
            </form>
            <div class="h-px bg-border1 my-2"></div>
            <button class="w-full py-2 bg-danger/[0.12] border border-danger/25 rounded-lg text-danger text-[0.78rem] font-semibold hover:bg-danger/[0.22] transition-all cursor-pointer"
                onclick="hapusMerch(${m.id}, '${(m.nama || '').replace(/'/g, "\\'")}')">🗑 Hapus Merch Ini</button>
        `;

        document.getElementById('editMerchForm').addEventListener('submit', async function(e) {
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
                alert(result.message || 'Merch berhasil diupdate!');
                location.reload();
            } else {
                if (result.errors) {
                    alert('Validasi gagal:\n' + Object.entries(result.errors).map(([k,v]) => k + ': ' + v.join(', ')).join('\n'));
                } else {
                    alert('Gagal: ' + (result.message || JSON.stringify(result)));
                }
            }
        });
    }

    // ── HAPUS MERCH ──
    async function hapusMerch(id, name) {
        if (!confirm(`Yakin hapus merch "${name}"?`)) return;
        const res = await fetch('/admin/merch/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (result.success) {
            alert(result.message || 'Merch berhasil dihapus!');
            location.reload();
        } else {
            alert('Gagal: ' + (result.message || 'Error'));
        }
    }

    // ── Merch filter ──
    function filterMerch(artis, chipEl) {
        document.querySelectorAll('.artis-chip').forEach(c => c.classList.remove('active'));
        if (chipEl) chipEl.classList.add('active');
        document.querySelectorAll('.filter-tab').forEach(t => {
            t.classList.toggle('active', t.dataset.filter === artis);
        });
        document.querySelectorAll('.merch-card').forEach(card => {
            card.style.display = (artis === 'all' || card.dataset.artis === artis) ? 'block' : 'none';
        });
    }
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.merch-card').forEach(card => {
                card.style.display = (filter === 'all' || card.dataset.artis === filter) ? 'block' : 'none';
            });
            document.querySelectorAll('.artis-chip').forEach(c => {
                const slug = c.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
                c.classList.toggle('active', slug === filter);
            });
        });
    });

    // ── OPEN EDIT BANNER ──
    async function openEditBanner(id) {
        openPanel('panelEditBanner');
        document.getElementById('editBannerBody').innerHTML = '<div class="text-muted text-[0.8rem] text-center py-5">Memuat data...</div>';

        const res = await fetch('/admin/banner/' + id, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (!data.success) {
            document.getElementById('editBannerBody').innerHTML = '<div class="text-danger text-[0.8rem]">Gagal memuat data.</div>';
            return;
        }

        const b = data.banner;
        const artistOptions = @json($artists).map(a =>
            `<option value="${a.id}" ${a.id == b.artist_id ? 'selected' : ''}>${a.name}</option>`
        ).join('');

        const inputCls = "bg-bg3 border border-border2 rounded-lg px-2.5 py-2 text-text1 text-[0.83rem] outline-none w-full focus:border-accent";
        const uploadCls = "border-[1.5px] border-dashed border-border2 rounded-lg p-3.5 flex flex-col items-center justify-center gap-1 cursor-pointer text-muted text-[0.75rem] font-medium min-h-[90px] relative hover:border-accent hover:bg-accent/[0.04] transition-all";
        const labelCls = "text-[0.68rem] font-bold text-muted uppercase tracking-[0.06em]";

        document.getElementById('editBannerBody').innerHTML = `
            <form id="editBannerForm" enctype="multipart/form-data" class="flex flex-col gap-2.5">
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Foto Saat Ini</label>
                    ${b.image_url
                        ? `<img src="${b.image_url}" class="w-full h-[100px] object-cover rounded-lg block border border-border2" alt="banner">`
                        : `<div class="w-full h-[100px] bg-bg3 rounded-lg flex items-center justify-center text-muted text-[0.75rem] border border-border2">Tidak ada foto</div>`
                    }
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Artis</label>
                    <select class="${inputCls}" name="artist_id" required>
                        <option value="">Pilih Artis...</option>
                        ${artistOptions}
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Judul</label>
                    <input type="text" class="${inputCls}" name="title" value="${b.title || ''}" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Deskripsi</label>
                    <textarea class="${inputCls} resize-y min-h-[70px]" name="description" rows="3">${b.description || ''}</textarea>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="${labelCls}">Ganti Foto (opsional)</label>
                    <div id="editBannerUploadBox" class="${uploadCls}" onclick="this.querySelector('input[type=file]').click()">
                        <img class="preview-img w-full max-h-[120px] object-cover rounded pointer-events-none" id="editBannerPreviewImg" src="" alt="">
                        <div class="upload-text flex flex-col items-center gap-1 pointer-events-none" id="editBannerUploadText">
                            <span class="text-xl">🖼</span>
                            <span>+ Pilih Foto Baru</span>
                        </div>
                        <input type="file" name="image" accept="image/*" class="hidden"
                               onchange="showPreview(this, 'editBannerPreviewImg', 'editBannerUploadText', 'editBannerUploadBox')">
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="flex items-center gap-2 text-[0.8rem] cursor-pointer text-text2">
                        <input type="checkbox" name="is_active" ${b.is_active ? 'checked' : ''} class="accent-accent">
                        Aktif
                    </label>
                </div>
                <button type="submit" class="w-full py-2.5 bg-accent border-none rounded-lg text-white text-[0.84rem] font-semibold cursor-pointer hover:bg-accentH transition-all">Simpan Perubahan</button>
            </form>
            <div class="h-px bg-border1 my-2"></div>
            <button class="w-full py-2 bg-danger/[0.12] border border-danger/25 rounded-lg text-danger text-[0.78rem] font-semibold hover:bg-danger/[0.22] transition-all cursor-pointer"
                onclick="deleteBanner(${b.id})">🗑 Hapus Banner Ini</button>
        `;

        document.getElementById('editBannerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const res = await fetch('/admin/banner/' + b.id + '/update', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: formData
            });
            const result = await res.json();
            if (result.success) {
                alert(result.message);
                location.reload();
            } else {
                if (result.errors) {
                    alert('Validasi gagal:\n' + Object.entries(result.errors).map(([k,v]) => k + ': ' + v.join(', ')).join('\n'));
                } else {
                    alert('Gagal: ' + (result.message || JSON.stringify(result)));
                }
            }
        });
    }

    // ── DELETE BANNER ──
    async function deleteBanner(id) {
        if (!confirm('Yakin hapus banner ini?')) return;
        const res = await fetch('/admin/banner/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Gagal: ' + (result.message || 'Error'));
        }
    }

    // ── Banner form submit ──
    document.getElementById('bannerForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const response = await fetch('/admin/banner/store', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: new FormData(this)
        });
        const result = await response.json();
        if (result.success) {
            alert('Banner berhasil disimpan!');
            location.reload();
        } else {
            if (result.errors) {
                alert('Validasi gagal:\n' + Object.entries(result.errors).map(([k,v]) => k + ': ' + v.join(', ')).join('\n'));
            } else {
                alert('Gagal: ' + (result.message || JSON.stringify(result)));
            }
        }
    });

    // ── Artis form submit ──
    document.getElementById('artisForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const response = await fetch('/admin/artist', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: new FormData(this)
        });
        const result = await response.json();
        if (result.success) { alert('Artis berhasil disimpan!'); location.reload(); }
        else { alert('Gagal: ' + (result.message || 'Error')); }
    });

    // ── Merch form submit ──
    document.getElementById('merchForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const response = await fetch('/admin/merch', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: new FormData(this)
        });
        const result = await response.json();
        if (result.success) { alert('Merch berhasil disimpan!'); location.reload(); }
        else { alert('Gagal: ' + (result.message || 'Error')); }
    });
</script>
</body>
</html>