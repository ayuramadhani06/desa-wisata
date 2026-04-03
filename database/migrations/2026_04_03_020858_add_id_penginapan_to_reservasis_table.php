<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_penginapan')->nullable()->after('id_paket');
            $table->decimal('harga_penginapan', 12, 2)->default(0)->after('harga');
            $table->foreign('id_penginapan')->references('id')->on('penginapans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            //
        });
    }
};
