<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';
    
    protected $fillable = [
        'kode_diskon',
        'nama_diskon',
        'persentase_diskon',
        'tanggal_mulai',
        'tanggal_berakhir',
        'deskripsi',
        'foto',
        'aktif'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'aktif' => 'boolean'
    ];
}
