<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'merch_id',
        'nama_produk',
        'gambar',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Merch
     */
    public function merch()
    {
        return $this->belongsTo(Merch::class);
    }

    /**
     * Total harga item (qty * harga_satuan)
     */
    public function getTotalItemAttribute(): int
    {
        return $this->qty * $this->harga_satuan;
    }

    /**
     * Format harga satuan ke Rupiah
     */
    public function getHargaRupiahAttribute(): string
    {
        return 'Rp. ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}