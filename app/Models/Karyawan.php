<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['nama_karyawan', 'alamat', 'no_hp', 'jabatan', 'status', 'id_user'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
 