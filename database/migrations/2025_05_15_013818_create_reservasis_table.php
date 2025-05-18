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
        Schema::create('reservasis', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('id_pelanggan');
        $table->unsignedBigInteger('id_paket');
        $table->unsignedBigInteger('id_diskon')->nullable();
        $table->unsignedBigInteger('id_jenis_pembayaran')->nullable();

        $table->string('nama_pelanggan'); // simpan snapshot
        $table->string('email')->nullable();

        $table->dateTime('tgl_reservasi_wisata');
        $table->dateTime('tgl_selesai_reservasi')->nullable();

        $table->decimal('harga', 12, 2);
        $table->integer('jumlah_peserta');

        $table->decimal('persentase_diskon', 5, 2)->default(0);
        $table->decimal('nilai_diskon', 12, 2)->default(0);
        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('total_bayar', 12, 2)->default(0);

        $table->text('bukti_tf')->nullable();

        $table->enum('status_reservasi', ['Dipesan', 'Dibayar', 'Selesai', 'Dibatalkan'])->default('Dipesan');

        $table->timestamps();

        // Foreign Keys
        $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
        $table->foreign('id_paket')->references('id')->on('paket_wisatas')->onDelete('cascade');
        $table->foreign('id_diskon')->references('id')->on('diskons')->onDelete('set null');
        $table->foreign('id_jenis_pembayaran')->references('id')->on('jenis_pembayarans')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
