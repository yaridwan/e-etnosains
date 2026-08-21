<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstansiPendidikan extends ModelDasar
{
    use HasFactory;

    protected $table = 'instansi_pendidikan';

    protected $fillable = ['nama_instansi', 'jenis_instansi', 'alamat', 'kota', 'provinsi'];
}
