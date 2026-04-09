<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'is_active',
        'artist_id', // ditambahkan
    ];

    // Relasi ke Artist
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
    
}