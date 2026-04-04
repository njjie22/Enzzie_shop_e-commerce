<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pesanan',
        'pelanggan',
        'email',
        'artis',
        'total',
        'status',
        'metode_pembayaran',
    ];

    /**
     * Relasi ke item-item dalam pesanan
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Format total ke Rupiah
     */
    public function getTotalRupiahAttribute(): string
    {
        return 'Rp. ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Label status dengan huruf kapital
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}