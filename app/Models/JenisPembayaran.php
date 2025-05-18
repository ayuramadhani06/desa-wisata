<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
     use HasFactory;

    protected $table = 'jenis_pembayarans';
    
    protected $fillable = [
        'jenis_pembayaran',
        'nomor_tf',
        'foto'
    ];
}
