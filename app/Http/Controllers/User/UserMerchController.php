<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Merch;

class UserMerchController extends Controller
{
    public function show($id)
    {
        $merch = Merch::with('artist')->findOrFail($id);

        // Merch lain dari artis yang sama (exclude yang sedang dilihat)
        $related = Merch::where('artist_id', $merch->artist_id)
            ->where('id', '!=', $merch->id)
            ->latest()
            ->take(6)
            ->get();

        // Semua artis untuk sidebar
        $allArtists = Artist::select('id', 'name', 'slug', 'image')
            ->orderBy('name')
            ->get();

        return view('user.merch.show', compact('merch', 'related', 'allArtists'));
    }
}