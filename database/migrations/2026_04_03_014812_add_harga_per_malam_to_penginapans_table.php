<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penginapans', function (Blueprint $table) {
            // Kita tambahkan kolom harga setelah kolom fasilitas
            $table->integer('harga_per_malam')->after('fasilitas')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('penginapans', function (Blueprint $table) {
            // Ini untuk jaga-jaga kalau mau rollback
            $table->dropColumn('harga_per_malam');
        });
    }
};