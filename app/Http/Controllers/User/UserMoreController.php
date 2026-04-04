<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Banner;
use App\Models\Merch;
use Illuminate\Http\Request;

class UserMoreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $artistsQuery = Artist::with(['merches' => function ($query) {
            $query->latest()->take(6);
        }])->withCount('merches');

        if ($search) {
            $artistsQuery->where('name', 'like', "%{$search}%");
        } else {
            $artistsQuery->take(3);
        }

        $artists = $artistsQuery->orderBy('name')->get();

        $allArtists = Artist::orderBy('name')->get(['id', 'name', 'slug', 'image']);

        $banners = Banner::with('artist')->where('is_active', true)->latest()->get();

        return view('user.more.index', compact('artists', 'allArtists', 'banners', 'search'));
    }

    public function show($id)
    {
        $artist = Artist::findOrFail($id);

        $allArtists = Artist::orderBy('name')->get(['id', 'name', 'slug', 'image']);

        $banners = Banner::where('artist_id', $artist->id)
            ->where('is_active', true)
            ->latest()
            ->get();

        $kategoris = Merch::where('artist_id', $artist->id)
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();

        $merches = Merch::where('artist_id', $artist->id)
            ->latest()
            ->get()
            ->groupBy('kategori');

        return view('user.more.show', compact('artist', 'allArtists', 'banners', 'kategoris', 'merches'));
    }
}