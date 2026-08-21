<?php

namespace App\Models;


class InstansiPendidikan extends ModelDasar
{
    protected $table = 'instansi_pendidikan';

    protected $fillable = ['nama_instansi', 'jenis_instansi', 'alamat', 'kota', 'provinsi'];
}
