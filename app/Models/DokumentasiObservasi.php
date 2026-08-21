<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiObservasi extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'dokumentasi_observasi';

    protected $fillable = ['id_pengumpulan_observasi', 'berkas', 'keterangan'];

    public function pengumpulan(): BelongsTo
    {
        return $this->belongsTo(PengumpulanObservasi::class, 'id_pengumpulan_observasi');
    }
}
