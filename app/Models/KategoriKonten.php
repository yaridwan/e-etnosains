<?php

namespace App\Models;


class KategoriKonten extends ModelDasar
{
    protected $table = 'kategori_konten';

    protected $fillable = ['nama_kategori', 'alamat_tautan'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
