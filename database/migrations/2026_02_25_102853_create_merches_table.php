<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('merches')) {
            Schema::create('merches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade'); // Relasi ke artist
                $table->string('nama');
                $table->bigInteger('harga');
                $table->enum('status', ['ready', 'pre_order', 'stok_habis'])->default('ready');
                $table->string('foto')->nullable();

                // Informasi tambahan
                $table->string('ukuran')->nullable();       // S, M, L, XL
                $table->string('bahan')->nullable();        // Cotton, dll
                $table->date('tanggal_terbit')->nullable();
                $table->string('garansi')->nullable();
                $table->string('no_telfon')->nullable();
                $table->string('email')->nullable();
                $table->integer('stok')->default(0);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('merches');
    }
};