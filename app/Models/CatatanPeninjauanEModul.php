<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanPeninjauanEModul extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'catatan_peninjauan_e_modul';

    protected $fillable = ['id_e_modul', 'id_pengguna', 'catatan', 'keputusan'];

    public function eModul(): BelongsTo
    {
        return $this->belongsTo(EModul::class, 'id_e_modul');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
