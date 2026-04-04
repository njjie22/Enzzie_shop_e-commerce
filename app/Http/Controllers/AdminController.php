<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Artist;
use App\Models\Merch;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->get();
        $artists = Artist::all();
        $merches = Merch::with('artist')->get();

        return view('admin.dashboard', compact('banners','artists','merches'));
    }
}