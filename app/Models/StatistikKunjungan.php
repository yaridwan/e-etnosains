<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikKunjungan extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'statistik_kunjungan';

    protected $fillable = ['url', 'jenis_konten', 'id_referensi', 'alamat_ip', 'agen_pengguna'];
}
