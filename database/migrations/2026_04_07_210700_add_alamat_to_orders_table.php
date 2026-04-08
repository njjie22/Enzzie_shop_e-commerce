<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('alamat_lengkap', 255)->after('email')->nullable();
            $table->string('kota', 100)->after('alamat_lengkap')->nullable();
            $table->string('kode_pos', 20)->after('kota')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['alamat_lengkap', 'kota', 'kode_pos']);
        });
    }
};
