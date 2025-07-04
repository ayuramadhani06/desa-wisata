<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket', 'deskripsi', 'fasilitas', 'harga_per_pack', 'foto1', 'foto2', 'foto3', 'foto4', 'foto5'
    ];
}
