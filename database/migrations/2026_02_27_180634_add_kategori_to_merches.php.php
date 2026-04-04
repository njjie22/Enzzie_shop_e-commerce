<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merches', function (Blueprint $table) {
            $table->string('kategori')->default('merch')->after('artist_id');
        });
    }

    public function down(): void
    {
        Schema::table('merches', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};