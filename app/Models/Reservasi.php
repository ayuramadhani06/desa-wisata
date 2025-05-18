<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_pelanggan',
        'id_paket',
        'id_diskon',
        'id_jenis_pembayaran',
        'nama_pelanggan',
        'email',
        'tgl_reservasi_wisata',
        'tgl_selesai_reservasi',
        'harga',
        'jumlah_peserta',
        'persentase_diskon',
        'nilai_diskon',
        'subtotal',
        'total_bayar',
        'bukti_tf',
        'status_reservasi',
    ];

    protected $casts = [
        'tgl_reservasi_wisata' => 'datetime',
        'tgl_selesai_reservasi' => 'datetime',
        'aktif' => 'boolean'
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke paket wisata
    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'id_paket');
    }

    // Relasi ke diskon
    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_diskon');
    }

    // Relasi ke jenis pembayaran
    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jenis_pembayaran');
    }

    
}
