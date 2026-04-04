<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan')->unique();
            $table->string('pelanggan');
            $table->string('email');
            $table->string('artis')->nullable();
            $table->decimal('total', 12, 0)->default(0);
            $table->enum('status', ['pending', 'dikemas', 'dikirim', 'selesai'])->default('pending');
            $table->string('metode_pembayaran')->default('Bank');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};