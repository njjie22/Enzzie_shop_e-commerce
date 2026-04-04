<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Banner;
use App\Models\Artist;
use App\Models\Merch;


class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===============================
        // BANNER
        // ===============================
        if (Banner::count() === 0) {
            Banner::insert([
                ['title' => 'Promo Diskon 50%', 'image' => 'banners/dummy1.jpg', 'is_active' => true],
                ['title' => 'Flash Sale Minggu Ini', 'image' => 'banners/dummy2.jpg', 'is_active' => true],
                ['title' => 'Produk Baru Terlaris', 'image' => 'banners/dummy3.jpg', 'is_active' => true],
            ]);
        }

        // ===============================
        // ARTISTS
        // ===============================
        if (Artist::count() === 0) {
            $artists = [
                ['name' => 'SEVENTEEN', 'avatar' => 'artists/seventeen.jpg'],
                ['name' => 'ENHYPEN',   'avatar' => 'artists/enhypen.jpg'],
                ['name' => 'BTS',       'avatar' => 'artists/bts.jpg'],
                ['name' => 'TXT',       'avatar' => 'artists/txt.jpg'],
            ];
                        foreach ($artists as $artist) {
                Artist::create([
                    'name'   => $artist['name'],
                    'avatar' => $artist['avatar'],
                    'slug'   => Str::slug($artist['name']),
                ]);
            }
        }

        // ===============================
        // MERCH
        // ===============================
        if (Merch::count() === 0) {
            $artist_ids = Artist::pluck('id')->toArray();
            $merches = [
                ['artist_id' => $artist_ids[0], 'nama' => 'Album SEVENTEEN',    'harga' => 150000, 'foto' => 'merches/seventeen_album.jpg', 'status' => 'ready'],
                ['artist_id' => $artist_ids[1], 'nama' => 'Lightstick ENHYPEN', 'harga' => 250000, 'foto' => 'merches/enhypen_ls.jpg',      'status' => 'ready'],
                ['artist_id' => $artist_ids[2], 'nama' => 'BTS Hoodie',         'harga' => 350000, 'foto' => 'merches/bts_hoodie.jpg',      'status' => 'ready'],
                ['artist_id' => $artist_ids[3], 'nama' => 'TXT Poster',         'harga' => 50000,  'foto' => 'merches/txt_poster.jpg',      'status' => 'ready'],
            ];
            foreach ($merches as $merch) {
                Merch::create($merch);
            }
        }
    }
}