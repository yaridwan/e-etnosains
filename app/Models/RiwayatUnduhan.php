<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatUnduhan extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'riwayat_unduhan';

    protected $fillable = ['id_pengguna', 'jenis_konten', 'id_referensi', 'alamat_ip'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
