<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Admin Artis</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @layer base {
            :root {
                --accent: #c0392b;
                --accent-hover: #a93226;
            }
        }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #2e2e38; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3a3a42; }

        /* ─── SIDEBAR ─── */
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
            transition: width 0.3s ease, transform 0.3s ease;
            overflow: hidden;
        }

        /* Icon-only at 769px – 900px */
        @media (max-width: 900px) and (min-width: 769px) {
            #sidebar { width: 60px; }
            .nav-label, #sidebar-title { display: none; }
            #sidebar-hamburger { display: none; }
        }

        /* Off-canvas below 768px */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: 0; top: 0;
                width: 220px;
                transform: translateX(-100%);
                box-shadow: none;
            }
            #sidebar.open {
                transform: translateX(0);
                box-shadow: 6px 0 32px rgba(0,0,0,0.55);
            }
            #sidebar-hamburger { display: none; }
            #mobile-hamburger  { display: flex !important; }
        }

        /* ─── LAYOUT ─── */
        main { flex: 1; display: flex; flex-direction: column; overflow: hidden; min-width: 0; }

        /* ─── HEADER ─── */
        .top-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            border-bottom: 1px solid #2e2e38;
            background: #1a1a1e;
        }
        @media (max-width: 480px) {
            .top-header { padding: 10px 14px; }
            .header-title { font-size: 0.65rem !important; }
            .btn-add { font-size: 0.7rem !important; padding: 6px 10px !important; }
        }

        /* ─── CONTENT ─── */
        .content-wrap { padding: 24px; overflow-y: auto; flex: 1; }
        @media (max-width: 480px) { .content-wrap { padding: 12px; } }

        /* ─── ARTIST GRID ─── */
        .artist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }
        @media (max-width: 640px) {
            .artist-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        }
        @media (max-width: 340px) {
            .artist-grid { grid-template-columns: 1fr; }
        }

        /* ─── CARD ACTIONS ─── */
        @media (max-width: 480px) {
            .card-actions { flex-wrap: wrap; }
            .card-actions .btn-detail { flex: 1 1 100%; }
            .card-actions .btn-edit,
            .card-actions .btn-del   { flex: 1; }
        }

        /* ─── ADD PLACEHOLDER ─── */
        .add-placeholder {
            background: #18181f;
            border: 1.5px dashed #2e2e38;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 280px;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .add-placeholder:hover { border-color: #c0392b; background: rgba(192,57,43,0.05); }
        @media (max-width: 640px) { .add-placeholder { min-height: 140px; } }

        /* ─── MODAL ─── */
        #modal {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            max-width: calc(100vw - 32px);
            background: #2b2b30;
            border-radius: 14px;
            padding: 24px;
            z-index: 200;
            box-shadow: 0 24px 80px rgba(0,0,0,0.7);
        }
        @media (max-width: 480px) {
            #modal {
                top: auto; left: 12px; right: 12px; bottom: 12px;
                transform: none;
                width: auto;
                border-radius: 18px;
                padding: 20px 16px 24px;
            }
        }
    </style>
</head>
<body class="bg-[#111113] text-[#f0f0f4] font-['DM_Sans'] min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar">
        <div class="flex items-center gap-2.5 px-3.5 py-4 border-b border-[#2e2e38]">
            <div id="sidebar-hamburger" class="flex flex-col gap-1 cursor-pointer p-0.5 shrink-0" onclick="toggleSidebar()">
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
                <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
            </div>
            <h1 id="sidebar-title" class="font-['Syne'] text-[0.95rem] font-extrabold text-[#f0f0f4] truncate">Enzzie Shop</h1>
        </div>
        <nav class="flex flex-col gap-[1px] pt-1 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.dashboard') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="nav-label">Home</span>
            </a>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.order.*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                <span class="nav-label">Order</span>
            </a>
            <a href="{{ route('admin.artist.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.artist.*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/></svg>
                <span class="nav-label">Artis</span>
            </a>
            <a href="{{ route('admin.merch') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[0.88rem] font-medium text-[#cccccc] no-underline border-l-[3px] border-transparent transition-all hover:bg-[#222228] hover:text-[#f0f0f4] {{ request()->routeIs('admin.merch*') ? 'bg-[#222228] text-[#f0f0f4] border-[#c0392b]' : '' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                <span class="nav-label">Merch</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main>
        <header class="top-header">
            <button id="mobile-hamburger" class="hidden items-center justify-center w-8 h-8 shrink-0 text-[#cccccc] hover:text-[#f0f0f4]" onclick="toggleSidebar()" aria-label="Buka menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <span class="header-title flex-1 font-['Syne'] text-[0.75rem] font-bold tracking-widest uppercase text-[#7a7a8c]">Manajemen Artis</span>
            <button class="btn-add flex items-center gap-1.5 px-3 py-1.5 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.75rem] font-semibold rounded-lg transition-colors shrink-0" onclick="openModal()">
                <span>+</span> Tambah Artis
            </button>
        </header>

        <div class="content-wrap">
            <div class="artist-grid" id="artistGrid">

                @foreach($artists as $artist)
                <div class="group bg-[#18181f] border border-[#2e2e38] rounded-[14px] overflow-hidden transition-all hover:border-[#c0392b] hover:-translate-y-0.5" id="card-{{ $artist->id }}">
                    <div class="w-full aspect-square overflow-hidden bg-gradient-to-br from-[#1a0a0a] to-[#0d0d10] flex items-center justify-center relative cursor-pointer" onclick="location.href='{{ route('admin.artist.show', $artist->slug) }}'">
                        @if($artist->image)
                            <img src="{{ asset('storage/'.$artist->image) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @elseif($artist->avatar)
                            <img src="{{ asset('storage/'.$artist->avatar) }}" alt="{{ $artist->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="font-['Syne'] text-5xl font-extrabold text-white/15">{{ strtoupper(substr($artist->name, 0, 2)) }}</div>
                        @endif
                    </div>
                    <div class="p-3.5">
                        <div class="font-['Syne'] text-[0.95rem] font-bold mb-1 truncate">{{ strtoupper($artist->name) }}</div>
                        <div class="text-[0.74rem] text-[#7a7a8c] mb-3 truncate">{{ $artist->slug }}</div>
                        <div class="flex gap-1.5 card-actions">
                            <a href="{{ route('admin.artist.show', $artist->slug) }}" class="btn-detail flex-1 flex items-center justify-center py-1.5 bg-[#222228] border border-[#2e2e38] text-[#cccccc] text-[0.75rem] font-semibold rounded-lg hover:border-[#c0392b] hover:text-[#c0392b] transition-all">Detail</a>
                            <button class="btn-edit px-3 py-1.5 bg-transparent border border-[#2e2e38] text-[#7a7a8c] text-[0.75rem] font-semibold rounded-lg hover:border-[#c0392b] hover:text-[#c0392b] transition-all" onclick="editArtist({{ $artist->id }}, '{{ $artist->name }}', '{{ $artist->image ? asset('storage/'.$artist->image) : ($artist->avatar ? asset('storage/'.$artist->avatar) : '') }}')">Edit</button>
                            <button class="btn-del px-3 py-1.5 bg-transparent border border-red-500/40 text-red-500 text-[0.75rem] font-semibold rounded-lg hover:bg-red-500/10 transition-all font-['DM_Sans']" onclick="deleteArtist({{ $artist->id }})">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="add-placeholder" onclick="openModal()">
                    <div class="text-center text-[#7a7a8c]">
                        <div class="text-[2.5rem] mb-2">+</div>
                        <span class="text-[0.8rem] font-semibold">Tambah Artis</span>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- OVERLAY -->
    <div id="overlay" class="hidden fixed inset-0 bg-black/50 z-[150] backdrop-blur-[2px]" onclick="overlayClick()"></div>

    <!-- MODAL -->
    <div id="modal" class="hidden">
        <button class="absolute top-4 right-4 text-[#7a7a8c] hover:text-[#f0f0f4] text-xl leading-none" onclick="closeModal()">✕</button>
        <div class="font-['Syne'] text-base font-bold text-center mb-5 pb-3 border-b border-[#2e2e38]" id="modalTitle">Tambah Artis</div>

        <input type="hidden" id="fEditId">

        <div class="flex flex-col gap-1.5 mb-3.5">
            <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Nama Artis</label>
            <input type="text" id="fName" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] font-['DM_Sans'] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Nama artis...">
        </div>

        <div class="flex flex-col gap-1.5 mb-3.5">
            <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Foto / Avatar</label>
            <label id="imgLabel" class="flex flex-col items-center justify-center bg-[#3a3a42] border-[1.5px] border-dashed border-[#4a4a55] rounded-lg cursor-pointer text-[#7a7a8c] font-medium transition-all hover:border-[#c0392b] hover:text-[#c0392b] w-full min-h-[100px] relative overflow-hidden gap-1.5 text-[0.82rem]" onclick="document.getElementById('fImage').click()">
                <span class="text-3xl">🖼</span>
                <span id="imgPlaceholderText">+ Pilih Foto</span>
                <img id="imgPreview" src="" alt="" class="hidden w-full h-[140px] object-cover">
                <input type="file" id="fImage" accept="image/*" class="hidden" onchange="previewImg(this)">
            </label>
        </div>

        <div class="flex justify-end mt-1.5">
            <button id="btnSubmit" class="px-4 py-2 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.8rem] font-semibold rounded-lg transition-colors" onclick="submitArtist()">Simpan</button>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast" class="fixed bottom-6 right-6 bg-[#27ae60] text-white px-4 py-2.5 rounded-lg text-[0.85rem] font-semibold z-[300] opacity-0 translate-y-2.5 transition-all pointer-events-none max-w-[calc(100vw-48px)]"></div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

/* ── SIDEBAR ── */
function toggleSidebar() {
    const sb  = document.getElementById('sidebar');
    const ov  = document.getElementById('overlay');
    sb.classList.toggle('open');
    if (window.innerWidth <= 768) {
        if (sb.classList.contains('open')) {
            ov.classList.remove('hidden');
            ov.dataset.for = 'sidebar';
        } else {
            if (ov.dataset.for === 'sidebar') { ov.classList.add('hidden'); ov.dataset.for = ''; }
        }
    }
}

window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('overlay');
        sb.classList.remove('open');
        if (ov.dataset.for === 'sidebar') { ov.classList.add('hidden'); ov.dataset.for = ''; }
    }
});

function overlayClick() {
    const ov = document.getElementById('overlay');
    if (ov.dataset.for === 'sidebar') {
        document.getElementById('sidebar').classList.remove('open');
        ov.classList.add('hidden'); ov.dataset.for = '';
    } else {
        closeModal();
    }
}

/* ── MODAL ── */
function openModal(reset = true) {
    if (reset) {
        document.getElementById('modalTitle').textContent = 'Tambah Artis';
        document.getElementById('fEditId').value = '';
        document.getElementById('fName').value   = '';
        document.getElementById('fImage').value  = '';
        setImgEmpty();
    }
    const ov = document.getElementById('overlay');
    ov.classList.remove('hidden'); ov.dataset.for = 'modal';
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    const ov = document.getElementById('overlay');
    ov.classList.add('hidden'); ov.dataset.for = '';
}

function setImgEmpty() {
    document.getElementById('imgPreview').classList.add('hidden');
    document.getElementById('imgPreview').src = '';
    document.getElementById('imgLabel').style.cssText = '';
    document.getElementById('imgPlaceholderText').classList.remove('hidden');
}

function setImgFilled(src) {
    const p = document.getElementById('imgPreview');
    const l = document.getElementById('imgLabel');
    p.src = src; p.classList.remove('hidden');
    l.style.borderStyle = 'solid'; l.style.borderColor = '#27ae60'; l.style.padding = '0';
    document.getElementById('imgPlaceholderText').classList.add('hidden');
}

function editArtist(id, name, imgUrl) {
    document.getElementById('fEditId').value = id;
    document.getElementById('fName').value   = name;
    document.getElementById('modalTitle').textContent = 'Edit Artis';
    imgUrl ? setImgFilled(imgUrl) : setImgEmpty();
    openModal(false);
}

function submitArtist() {
    const editId = document.getElementById('fEditId').value;
    const name   = document.getElementById('fName').value.trim();
    if (!name) { showToast('⚠️ Nama artis wajib diisi!', '#e67e22'); return; }

    const fd = new FormData();
    fd.append('name', name); fd.append('_token', CSRF);
    const fi = document.getElementById('fImage');
    if (fi.files.length > 0) fd.append('image', fi.files[0]);

    let url = "{{ route('admin.artist.store') }}";
    if (editId) { fd.append('_method', 'PUT'); url = `/admin/artist/${editId}`; }

    const btn = document.getElementById('btnSubmit');
    btn.textContent = 'Menyimpan...'; btn.style.opacity = '0.6';

    fetch(url, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(editId ? '✓ Artis diperbarui!' : '✓ Artis ditambahkan!');
            closeModal(); setTimeout(() => location.reload(), 800);
        } else {
            const err = res.errors ? Object.values(res.errors).flat().join(', ') : (res.message || 'Gagal menyimpan.');
            showToast('⚠️ ' + err, '#e67e22');
        }
    })
    .catch(() => showToast('⚠️ Gagal menyimpan, coba lagi.', '#e67e22'))
    .finally(() => { btn.textContent = 'Simpan'; btn.style.opacity = '1'; });
}

function deleteArtist(id) {
    if (!confirm('Hapus artis ini? Semua merch terkait juga akan terhapus!')) return;
    fetch(`/admin/artist/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast('✓ Artis dihapus!');
            const card = document.getElementById(`card-${id}`);
            if (card) card.remove();
        }
    });
}

function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => setImgFilled(e.target.result);
        reader.readAsDataURL(input.files[0]);
    }
}

function showToast(msg, color = '#27ae60') {
    const t = document.getElementById('toast');
    t.textContent = msg; t.style.backgroundColor = color;
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