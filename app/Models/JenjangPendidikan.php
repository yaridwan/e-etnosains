<?php

namespace App\Models;


class JenjangPendidikan extends ModelDasar
{
    protected $table = 'jenjang_pendidikan';

    protected $fillable = ['nama_jenjang', 'alamat_tautan', 'urutan'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
