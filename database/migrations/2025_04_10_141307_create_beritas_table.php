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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->unique();
            $table->text('berita');
            $table->dateTime('tgl_post');
            $table->unsignedBigInteger('id_kategori_beritas');
            $table->foreign('id_kategori_beritas')->references('id')->on('kategori_beritas')->onDelete('cascade');
            $table->text('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};