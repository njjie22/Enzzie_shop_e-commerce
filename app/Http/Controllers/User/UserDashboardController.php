<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Merch;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
 public function index()
{
    $artists = Artist::withCount('merches')
        ->orderBy('name')
        ->get();

    $banners = Banner::with('artist')
        ->latest()
        ->take(5)
        ->get();

    $merches = Merch::with('artist')
        ->where('status', '!=', 'stok_habis')
        ->latest()
        ->get(); // ← hapus take(10)

    $notificationCount = 0;

    return view('user.dashboard', compact(
        'artists',
        'banners',
        'merches',
        'notificationCount'
    ));
}

public function filterMerch(Request $request)
{
    $artistId = $request->get('artist_id');

    $query = Merch::with('artist')
        ->where('status', '!=', 'stok_habis');

    if ($artistId && $artistId !== 'all') {
        $query->where('artist_id', $artistId);
    }

    $merches = $query->latest()->get(); // ← hapus take(10)

    return response()->json($merches);
}
}