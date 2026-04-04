<div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 class="panel-title" style="font-family: 'Syne', sans-serif; font-weight: 700; color: var(--text);">Daftar Banner</h2>
    <button class="btn-tambah" onclick="openPanel('panelBanner')">+ Tambah Banner</button>
</div>

<div class="banner-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
    @foreach($banners as $banner)
    <div class="banner-card" style="background: var(--bg2); border: 1px solid var(--border); border-radius: 15px; overflow: hidden; position: relative;">
        <div class="banner-img-wrapper" style="aspect-ratio: 16/9; background: #222;">
            @if($banner->image)
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--muted);">Tidak ada gambar</div>
            @endif
        </div>
        
        <div class="banner-info" style="padding: 15px;">
            <h3 style="font-size: 1rem; margin-bottom: 5px;">{{ $banner->title }}</h3>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.8rem; color: var(--muted);">Artis: {{ $banner->artist->name ?? '-' }}</span>
                <span class="status-badge" style="font-size: 0.7rem; padding: 2px 8px; border-radius: 10px; background: {{ $banner->is_active ? 'rgba(0, 255, 0, 0.1)' : 'rgba(255, 0, 0, 0.1)' }}; color: {{ $banner->is_active ? '#00ff00' : '#ff4d4d' }};">
                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="panel" id="panelBanner">
    <div class="panel-header">
        <span class="panel-title">Tambah Banner</span>
        <button class="panel-close" onclick="closeAllPanels()">✕</button>
    </div>

    <form id="bannerForm" enctype="multipart/form-data">
        @csrf
        <div class="panel-body" style="padding: 20px; display: flex; flex-direction: column; gap: 15px;">
            <div class="form-group">
                <label class="form-label">Judul Banner</label>
                <input type="text" name="title" required class="form-control" placeholder="Masukkan judul..." />
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Artist</label>
                <select id="artist_id" name="artist_id" required class="form-control">
                    <option value="">-- Pilih Artist --</option>
                    </select>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Banner</label>
                <div class="image-upload" onclick="document.getElementById('fileInput').click()">
                    <span class="upload-icon">🖼</span>
                    <span id="fileName">Click to upload image</span>
                    <input type="file" id="fileInput" name="image" accept="image/*" style="display:none" onchange="updateFileName(this)">
                </div>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" id="is_active" name="is_active" checked style="width: 18px; height: 18px;" />
                <label for="is_active" style="font-size: 0.9rem; color: var(--text);">Status Aktif</label>
            </div>
        </div>

        <div class="panel-footer" style="padding: 20px; border-top: 1px solid var(--border);">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">Simpan Banner</button>
        </div>
    </form>
</div>