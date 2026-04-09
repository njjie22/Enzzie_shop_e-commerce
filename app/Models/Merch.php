<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merch extends Model
{
    use HasFactory;

    protected $table = 'merches';

    protected $fillable = [
        'artist_id',
        'kategori',
        'nama',
        'harga',
        'status',
        'foto',
        'ukuran',
        'bahan',
        'tanggal_terbit',
        'garansi',
        'no_telfon',
        'email',
        'stok',
    ];

    protected $casts = [
        'harga'          => 'integer',
        'stok'           => 'integer',
        'tanggal_terbit' => 'date',
    ];

    protected $appends = ['foto_url'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pre_order'  => 'Pre Order',
            'stok_habis' => 'Stok Habis',
            default      => 'Ready',
        };
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'album'    => 'Album',
            'weverse'  => 'Weverse',
            'photocard'=> 'Photocard',
            'lightstick'=> 'Lightstick',
            default    => 'Merch',
        };
    }
}