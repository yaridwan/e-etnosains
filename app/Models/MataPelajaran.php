<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends ModelDasar
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = ['nama_mata_pelajaran', 'alamat_tautan', 'ikon'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
