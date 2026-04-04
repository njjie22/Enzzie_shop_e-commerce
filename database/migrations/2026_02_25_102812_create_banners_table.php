<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Tambahan kolom artist_id
            $table->unsignedBigInteger('artist_id')->nullable(); // nullable supaya bisa kosong dulu
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};