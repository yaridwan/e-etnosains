<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenjangPendidikan extends ModelDasar
{
    use HasFactory;

    protected $table = 'jenjang_pendidikan';

    protected $fillable = ['nama_jenjang', 'alamat_tautan', 'urutan'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
