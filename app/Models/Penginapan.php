<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penginapan extends Model
{
    protected $fillable = [
        'nama_penginapan', 'deskripsi', 'fasilitas',
        'foto1', 'foto2', 'foto3', 'foto4', 'foto5'
    ];
}
