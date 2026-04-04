<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Artist;
use App\Models\Merch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = Banner::with('artist')->orderBy('created_at', 'desc')->get();
        $artists = Artist::all();
        $merches = Merch::with('artist')->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('banners', 'artists', 'merches'));
    }

    // ── STORE BANNER ──
    public function storeBanner(Request $request)
    {
        $request->validate([
            'artist_id'   => 'required|exists:artists,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|max:2048',
            'is_active'   => 'nullable',
        ]);

        $data = [
            'artist_id'   => $request->artist_id,
            'title'       => $request->title,
            'description' => $request->description,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);

        return response()->json(['success' => true, 'message' => 'Banner berhasil disimpan!']);
    }

    // ── SHOW BANNER (untuk panel edit) ──
    public function showBanner($id)
    {
        $banner = Banner::with('artist')->findOrFail($id);

        return response()->json([
            'success' => true,
            'banner'  => [
                'id'          => $banner->id,
                'title'       => $banner->title,
                'description' => $banner->description,
                'artist_id'   => $banner->artist_id,
                'is_active'   => $banner->is_active,
                'image_url'   => $banner->image ? asset('storage/' . $banner->image) : null,
            ]
        ]);
    }

    // ── UPDATE BANNER ──
    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'artist_id'   => 'required|exists:artists,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'nullable',
        ]);

        $data = [
            'artist_id'   => $request->artist_id,
            'title'       => $request->title,
            'description' => $request->description,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return response()->json(['success' => true, 'message' => 'Banner berhasil diupdate!']);
    }

    // ── DELETE BANNER ──
    public function destroyBanner($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json(['success' => true, 'message' => 'Banner berhasil dihapus!']);
    }

    // ── STORE ARTIST ──
    public function storeArtist(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = ['name' => $request->name];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('artists', 'public');
        }

        Artist::create($data);

        return response()->json(['success' => true, 'message' => 'Artis berhasil disimpan!']);
    }

    // ── STORE MERCH ──
    // Kolom tabel: nama, harga, status, foto, stok
    public function storeMerch(Request $request)
    {
        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'nama'      => 'required|string|max:200',
            'harga'     => 'required|integer|min:0',
            'status'    => 'required|in:ready,pre_order,stok_habis',
            'stok'      => 'nullable|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = [
            'artist_id' => $request->artist_id,
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'status'    => $request->status,
            'stok'      => $request->stok ?? 0,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('merches', 'public');
        }

        Merch::create($data);

        return response()->json(['success' => true, 'message' => 'Merch berhasil disimpan!']);
    }
}