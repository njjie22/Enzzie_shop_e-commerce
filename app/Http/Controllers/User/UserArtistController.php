<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Merch;
use App\Models\Banner;

class UserArtistController extends Controller
{
    
    public function index()
    {
        $artists = Artist::withCount('merches')
            ->orderBy('name')
            ->get();

        return view('user.artist.index', compact('artists'));
    }

    public function show($slug)
    {
        $artist = Artist::where('slug', $slug)->firstOrFail();

        // Banner milik artis ini
        $banners = Banner::where('artist_id', $artist->id)
            ->where('is_active', true)
            ->latest()
            ->get();

        // Semua kategori merch artis ini
        $kategoris = Merch::where('artist_id', $artist->id)
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();

        // Merch dikelompokkan per kategori
        $merches = Merch::where('artist_id', $artist->id)
            ->latest()
            ->get()
            ->groupBy('kategori');

        return view('user.artist.show', compact('artist', 'banners', 'kategoris', 'merches'));
    }
}