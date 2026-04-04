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
        /* Custom styles for elements difficult to handle purely with Tailwind v4 in a single file or for fine-tuning */
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
    </style>
</head>
<body class="bg-[#111113] text-[#f0f0f4] font-['DM_Sans'] min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="class="w-[240px] max-[900px]:w-[60px] h-screen sticky top-0 bg-[#1e1e1e] border-r border-[#2e2e38] flex flex-col shrink-0 z-[100] transition-all duration-300 max-[768px]:fixed max-[768px]:-left-full max-[768px]:w-[200px] [&.open]:left-0 overflow-hidden">
        <div class="flex items-center gap-2.5 px-3.5 py-4 border-b border-[#2e2e38]">
    <div class="flex flex-col gap-1 cursor-pointer p-0.5 max-[768px]:hidden shrink-0" onclick="toggleSidebar()">
        <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
        <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
        <span class="block w-4 h-0.5 bg-[#cccccc] rounded-sm"></span>
    </div>
    <h1 class="font-['Syne'] text-[0.95rem] font-extrabold text-[#f0f0f4] truncate overflow-hidden max-[900px]:hidden">Enzzie Shop</h1>
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
    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between px-6 py-3.5 border-b border-[#2e2e38] bg-[#1a1a1e]">
            <span class="font-['Syne'] text-[0.75rem] font-bold tracking-widest uppercase text-[#7a7a8c]">Manajemen Artis</span>
            <button class="flex items-center gap-1.5 px-3 py-1.5 bg-[#c0392b] hover:bg-[#a93226] text-white text-[0.75rem] font-semibold rounded-lg transition-colors" onclick="openModal()">
                <span>+</span> Tambah Artis
            </button>
        </header>

        <div class="p-6 overflow-y-auto flex-1">
            <div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4" id="artistGrid">
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
                        <div class="font-['Syne'] text-[0.95rem] font-bold mb-1">{{ strtoupper($artist->name) }}</div>
                        <div class="text-[0.74rem] text-[#7a7a8c] mb-3">{{ $artist->slug }}</div>
                        <div class="flex gap-1.5">
                            <a href="{{ route('admin.artist.show', $artist->slug) }}" class="flex-1 flex items-center justify-center py-1.5 bg-[#222228] border border-[#2e2e38] text-[#cccccc] text-[0.75rem] font-semibold rounded-lg hover:border-[#c0392b] hover:text-[#c0392b] transition-all">Detail</a>
                            <button class="px-3 py-1.5 bg-transparent border border-[#2e2e38] text-[#7a7a8c] text-[0.75rem] font-semibold rounded-lg hover:border-[#c0392b] hover:text-[#c0392b] transition-all" onclick="editArtist({{ $artist->id }}, '{{ $artist->name }}', '{{ $artist->image ? asset('storage/'.$artist->image) : ($artist->avatar ? asset('storage/'.$artist->avatar) : '') }}')">Edit</button>
                            <button class="px-3 py-1.5 bg-transparent border border-red-500/40 text-red-500 text-[0.75rem] font-semibold rounded-lg hover:bg-red-500/10 transition-all font-['DM_Sans']" onclick="deleteArtist({{ $artist->id }})">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="bg-[#18181f] border-1.5 border-dashed border-[#2e2e38] rounded-[14px] flex items-center justify-center min-h-[280px] cursor-pointer transition-all hover:border-[#c0392b] hover:bg-[#c0392b]/5" onclick="openModal()">
                    <div class="text-center text-[#7a7a8c]">
                        <div class="text-[2.5rem] mb-2">+</div>
                        <span class="text-[0.8rem] font-semibold">Tambah Artis</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL OVERLAY -->
    <div id="overlay" class="hidden fixed inset-0 bg-black/50 z-[90] backdrop-blur-[2px]" onclick="closeModal()"></div>

    <!-- MODAL -->
    <div id="modal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] max-w-[calc(100vw-32px)] bg-[#2b2b30] rounded-[14px] p-6 z-[100] shadow-[0_24px_80px_rgba(0,0,0,0.7)] animate-in fade-in zoom-in-95 duration-200">
        <button class="absolute top-4 right-4 text-[#7a7a8c] hover:text-[#f0f0f4] text-xl" onclick="closeModal()">✕</button>
        <div class="font-['Syne'] text-base font-bold text-center mb-5 pb-3 border-b border-[#2e2e38]" id="modalTitle">Tambah Artis</div>

        <input type="hidden" id="fEditId">

        <div class="flex flex-col gap-1.5 mb-3.5">
            <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Nama Artis</label>
            <input type="text" id="fName" class="bg-[#3a3a42] border border-[#4a4a55] rounded-lg px-3 py-2 text-[#f0f0f4] font-['DM_Sans'] text-[0.85rem] outline-none focus:border-[#c0392b] transition-colors" placeholder="Nama artis...">
        </div>

        <div class="flex flex-col gap-1.5 mb-3.5">
            <label class="text-[0.74rem] font-semibold text-[#7a7a8c] uppercase tracking-wider">Foto / Avatar</label>
            <label id="imgLabel" class="flex flex-col items-center justify-center bg-[#3a3a42] border-1.5 border-dashed border-[#4a4a55] rounded-lg cursor-pointer text-[#7a7a8c] font-medium transition-all hover:border-[#c0392b] hover:text-[#c0392b] w-full min-h-[100px] relative overflow-hidden gap-1.5 text-[0.82rem]" onclick="document.getElementById('fImage').click()">
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
    <div id="toast" class="fixed bottom-6 right-6 bg-[#27ae60] text-white px-4.5 py-2.5 rounded-lg text-[0.85rem] font-semibold z-[200] opacity-0 translate-y-2.5 transition-all pointer-events-none"></div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function openModal(reset = true) {
    if (reset) {
        document.getElementById('modalTitle').textContent = 'Tambah Artis';
        document.getElementById('fEditId').value = '';
        document.getElementById('fName').value = '';
        document.getElementById('fImage').value = '';
        document.getElementById('imgPreview').classList.add('hidden');
        document.getElementById('imgPreview').src = '';
        document.getElementById('imgLabel').classList.remove('border-solid', 'border-[#27ae60]', 'p-0');
        document.getElementById('imgPlaceholderText').classList.remove('hidden');
    }
    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('overlay').classList.add('hidden');
    document.getElementById('modal').classList.add('hidden');
}

function editArtist(id, name, imgUrl) {
    document.getElementById('fEditId').value = id;
    document.getElementById('fName').value = name;
    document.getElementById('modalTitle').textContent = 'Edit Artis';

    const preview = document.getElementById('imgPreview');
    const label   = document.getElementById('imgLabel');
    const text    = document.getElementById('imgPlaceholderText');

    if (imgUrl) {
        preview.src = imgUrl;
        preview.classList.remove('hidden');
        label.classList.add('border-solid', 'border-[#27ae60]', 'p-0');
        text.classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        label.classList.remove('border-solid', 'border-[#27ae60]', 'p-0');
        text.classList.remove('hidden');
    }

    openModal(false);
}

function submitArtist() {
    const editId = document.getElementById('fEditId').value;
    const name   = document.getElementById('fName').value.trim();

    if (!name) { showToast('⚠️ Nama artis wajib diisi!', '#e67e22'); return; }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('_token', CSRF);

    const fImage = document.getElementById('fImage');
    if (fImage.files.length > 0) formData.append('image', fImage.files[0]);

    let url = "{{ route('admin.artist.store') }}";
    if (editId) {
        formData.append('_method', 'PUT');
        url = `/admin/artist/${editId}`;
    }

    const btn = document.getElementById('btnSubmit');
    btn.textContent = 'Menyimpan...';
    btn.style.opacity = '0.6';

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(editId ? '✓ Artis diperbarui!' : '✓ Artis ditambahkan!');
            closeModal();
            setTimeout(() => location.reload(), 800);
        } else {
            const errors = res.errors ? Object.values(res.errors).flat().join(', ') : (res.message || 'Gagal menyimpan.');
            showToast('⚠️ ' + errors, '#e67e22');
        }
    })
    .catch(() => showToast('⚠️ Gagal menyimpan, coba lagi.', '#e67e22'))
    .finally(() => { btn.textContent = 'Simpan'; btn.style.opacity = '1'; });
}

function deleteArtist(id) {
    if (!confirm('Hapus artis ini? Semua merch terkait juga akan terhapus!')) return;

    fetch(`/admin/artist/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
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
    const preview = document.getElementById('imgPreview');
    const label   = document.getElementById('imgLabel');
    const text    = document.getElementById('imgPlaceholderText');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            label.classList.add('border-solid', 'border-[#27ae60]', 'p-0');
            text.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
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