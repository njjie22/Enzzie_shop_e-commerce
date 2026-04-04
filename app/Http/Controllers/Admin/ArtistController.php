<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Merch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    /**
     * Daftar semua artis
     * GET /admin/artist
     */
    public function index()
    {
        $artists = Artist::latest()->get();
        return view('admin.artist', compact('artists'));
    }

    /**
     * Halaman detail artis — berisi banner & produk per kategori
     * GET /admin/artist/{slug}
     */
    public function show($slug)
    {
        $artist = Artist::where('slug', $slug)->firstOrFail();

        $merches = Merch::where('artist_id', $artist->id)
            ->latest()
            ->get()
            ->groupBy('kategori');

        $kategoriList = [
            'merch'      => 'Merch',
            'album'      => 'Album',
            'weverse'    => 'Weverse',
            'photocard'  => 'Photocard',
            'lightstick' => 'Lightstick',
        ];

        return view('admin.show', compact('artist', 'merches', 'kategoriList'));
    }

    /**
     * Simpan artis baru
     * POST /admin/artist
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist = Artist::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Artis berhasil ditambahkan.',
            'artist'  => $artist,
        ]);
    }

    /**
     * Update artis
     * POST /admin/artist/{id} (dengan _method=PUT)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $artist = Artist::findOrFail($id);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('image')) {
            if ($artist->image) Storage::disk('public')->delete($artist->image);
            $data['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Artis berhasil diupdate.',
            'artist'  => $artist,
        ]);
    }

    /**
     * Hapus artis
     * DELETE /admin/artist/{id}
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        if ($artist->image) Storage::disk('public')->delete($artist->image);
        $artist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artis berhasil dihapus!',
        ]);
    }

    /**
     * Tambah produk ke artis tertentu (dari halaman show)
     * POST /admin/artist/{slug}/produk
     */
    public function storeProduk(Request $request, $slug)
    {
        $artist = Artist::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama'     => 'required|string|max:200',
            'harga'    => 'required|integer|min:0',
            'status'   => 'required|in:ready,pre_order,stok_habis',
            'kategori' => 'required|string|max:50',
            'stok'     => 'nullable|integer|min:0',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'ukuran'   => 'nullable|string|max:100',
            'bahan'    => 'nullable|string|max:100',
            'tanggal_terbit' => 'nullable|date',
            'garansi'  => 'nullable|string|max:100',
            'no_telfon'=> 'nullable|string|max:20',
            'email'    => 'nullable|email|max:100',
        ]);

        $data = $request->only([
            'nama', 'harga', 'status', 'kategori',
            'ukuran', 'bahan', 'tanggal_terbit',
            'garansi', 'no_telfon', 'email',
        ]);

        $data['artist_id'] = $artist->id;
        $data['stok']      = $request->stok ?? 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('merches', 'public');
        }

        $merch = Merch::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'merch'   => $merch,
        ]);
    }

    /**
     * Tambah kategori baru untuk artis (nama kategori custom)
     * POST /admin/artist/{slug}/kategori
     */
    public function storeKategori(Request $request, $slug)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50',
        ]);

        $kategoriSlug = Str::slug($request->nama_kategori);

        return response()->json([
            'success'       => true,
            'kategori_slug' => $kategoriSlug,
            'kategori_label'=> $request->nama_kategori,
        ]);
    }
}
