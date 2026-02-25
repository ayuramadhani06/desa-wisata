<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


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

    public function scopeAktifDanBerlaku($query)
    {
        return $query->where('aktif', 1)
                    ->whereDate('tanggal_mulai', '<=', Carbon::today())
                    ->whereDate('tanggal_berakhir', '>=', Carbon::today());
    }
}
