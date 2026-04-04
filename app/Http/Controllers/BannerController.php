<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id', // wajib ada dan harus ada di tabel artists
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->artist_id = $request->artist_id; // simpan artist_id
        $banner->is_active = $request->is_active ?? true;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return response()->json([
            'success' => true,
            'banner' => $banner
        ]);
    }
    public function index()
{
    // Ambil semua banner beserta artistnya (relasi)
    $banners = Banner::with('artist')->get();

    return view('banners.index', compact('banners'));
}
public function artist()
{
    return $this->belongsTo(Artist::class);
}
public function adminBanners()
{
    // Ambil semua banner beserta artist
    $banners = Banner::with('artist')->get();

    // Panggil view di folder admin
    return view('admin.banners.banners', compact('banners'));
}
}