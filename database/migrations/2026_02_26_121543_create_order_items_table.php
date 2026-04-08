<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom ke tabel orders yang sudah ada
        Schema::table('orders', function (Blueprint $table) {
            // Kolom alamat (semua varchar)
            if (!Schema::hasColumn('orders', 'alamat_lengkap')) {
                $table->string('alamat_lengkap', 255)->after('email')->nullable();
            }
            
            if (!Schema::hasColumn('orders', 'kota')) {
                $table->string('kota', 100)->after('alamat_lengkap')->nullable();
            }
            
            if (!Schema::hasColumn('orders', 'kode_pos')) {
                $table->string('kode_pos', 20)->after('kota')->nullable();
            }
            
            // Kolom subtotal (opsional, untuk ringkasan)
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 0)->after('total')->default(0);
            }
        });

        // 2. Buat tabel order_items (tetap sama)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('gambar')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('harga_satuan', 12, 0);
            $table->decimal('subtotal', 12, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_lengkap',
                'kota',
                'kode_pos',
                'subtotal'
            ]);
        });
    }
};