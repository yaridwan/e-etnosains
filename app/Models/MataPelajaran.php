<?php

namespace App\Models;


class MataPelajaran extends ModelDasar
{
    protected $table = 'mata_pelajaran';

    protected $fillable = ['nama_mata_pelajaran', 'alamat_tautan', 'ikon'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
