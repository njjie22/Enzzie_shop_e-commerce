<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * GET /admin/banner/{id}
     */
    public function show($id)
    {
        $banner = Banner::with('artist')->findOrFail($id);

        return response()->json([
            'success' => true,
            'banner'  => [
                'id'          => $banner->id,
                'title'       => $banner->title,
                'description' => $banner->description ?? '',
                'artist_id'   => $banner->artist_id,
                'is_active'   => $banner->is_active,
                'image_url'   => $banner->image ? asset('storage/' . $banner->image) : null,
            ],
        ]);
    }

    /**
     * POST /admin/banner/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
        }

        Banner::create([
            'title'       => $request->title,
            'description' => $request->description,
            'artist_id'   => $request->artist_id,
            'image'       => $path,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Banner berhasil disimpan']);
    }

    /**
     * POST /admin/banner/{id}/update
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $banner = Banner::findOrFail($id);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'artist_id'   => $request->artist_id,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            // Hapus foto lama
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return response()->json(['success' => true, 'message' => 'Banner berhasil diupdate']);
    }

    /**
     * DELETE /admin/banner/{id}
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json(['success' => true, 'message' => 'Banner berhasil dihapus']);
    }
}