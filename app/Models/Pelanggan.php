<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $fillable = ['nama_lengkap', 'no_hp', 'alamat', 'id_user', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'id_pelanggan');
    }
}
