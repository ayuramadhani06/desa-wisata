<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWisata extends Model
{
    protected $fillable = ['kategori_wisata'];

    public function obyekWisatas()
    {
        return $this->hasMany(ObyekWisata::class, 'id_kategori_wisatas');
    }
}
