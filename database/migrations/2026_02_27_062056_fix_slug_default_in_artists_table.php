<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Artist;

return new class extends Migration 
{
    public function up(): void
    {
        // Isi slug untuk data yang sudah ada tapi slug-nya kosong
        Artist::whereNull('slug')->orWhere('slug', '')->each(function ($artist) {
            $artist->slug = Str::slug($artist->name) ?: 'artist-' . $artist->id;
            $artist->saveQuietly();
        });

        // Ubah kolom slug agar punya default value kosong (fallback)
        Schema::table('artists', function (Blueprint $table) {
            $table->string('slug')->default('')->change();
        });
    }

    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }
};
