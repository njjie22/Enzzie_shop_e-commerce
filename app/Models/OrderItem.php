<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'nama_produk',
        'gambar',
        'qty',
        'harga_satuan',
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
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
}