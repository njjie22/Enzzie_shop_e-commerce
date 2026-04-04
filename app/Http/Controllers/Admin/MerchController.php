<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Merch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MerchController extends Controller
{
    public function index()
    {
        $merches = Merch::with('artist')->latest()->get();
        $artists = Artist::latest()->get();
        $kategoris = Merch::whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('admin.merch', compact('merches', 'artists', 'kategoris')); // ← DAN INI
    }

    public function store(Request $request)
    {
        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'nama'      => 'required|string|max:200',
            'harga'     => 'required|integer|min:0',
            'status'    => 'required|in:ready,pre_order,stok_habis',
            'stok'      => 'nullable|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'ukuran'    => 'nullable|string|max:100',
            'bahan'     => 'nullable|string|max:100',
            'tanggal_terbit' => 'nullable|date',
            'garansi'   => 'nullable|string|max:100',
            'no_telfon' => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
        ]);

        $data = $request->only([
            'artist_id', 'kategori', 'nama', 'harga', 'status',
            'ukuran', 'bahan', 'tanggal_terbit',
            'garansi', 'no_telfon', 'email',
        ]);

        $data['stok'] = $request->stok ?? 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('merches', 'public');
        }

        $merch = Merch::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Merch berhasil ditambahkan.',
                'merch'   => $merch->load('artist'),
            ]);
        }

        return redirect()->route('admin.merch')->with('success', 'Merch berhasil ditambahkan.');
    }

    public function show($id)
    {
        $merch = Merch::with('artist')->findOrFail($id);

        return response()->json([
            'success' => true,
            'merch'   => array_merge($merch->toArray(), [
                'foto_url' => $merch->foto_url,
            ]),
        ]);
    }

    public function update(Request $request, $id)
    {
        $merch = Merch::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:200',
            'harga'     => 'required|integer|min:0',
            'status'    => 'required|in:ready,pre_order,stok_habis',
            'kategori'  => 'nullable|string|max:50',
            'stok'      => 'nullable|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'ukuran'    => 'nullable|string|max:100',
            'bahan'     => 'nullable|string|max:100',
            'tanggal_terbit' => 'nullable|date',
            'garansi'   => 'nullable|string|max:100',
            'no_telfon' => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
        ]);

        $data = $request->only([
            'kategori', 'nama', 'harga', 'status',
            'ukuran', 'bahan', 'tanggal_terbit',
            'garansi', 'no_telfon', 'email',
        ]);

        // Pertahankan artist_id dari data lama jika tidak dikirim
        if ($request->filled('artist_id')) {
            $data['artist_id'] = $request->artist_id;
        }

        $data['stok'] = $request->stok ?? $merch->stok;

        if ($request->hasFile('foto')) {
            if ($merch->foto) {
                Storage::disk('public')->delete($merch->foto);
            }
            $data['foto'] = $request->file('foto')->store('merches', 'public');
        }

        $merch->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Merch berhasil diupdate.',
                'merch'   => $merch->fresh()->load('artist'),
            ]);
        }

        return redirect()->route('admin.merch')->with('success', 'Merch berhasil diupdate.');
    }

    public function destroy($id)
    {
        $merch = Merch::findOrFail($id);

        if ($merch->foto) {
            Storage::disk('public')->delete($merch->foto);
        }

        $merch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Merch berhasil dihapus!',
        ]);
    }
}