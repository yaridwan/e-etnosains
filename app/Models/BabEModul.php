<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BabEModul extends ModelDasar
{
    protected $table = 'bab_e_modul';

    protected $fillable = ['id_e_modul', 'judul_bab', 'nomor_urut', 'halaman_mulai'];

    public function eModul(): BelongsTo
    {
        return $this->belongsTo(EModul::class, 'id_e_modul');
    }
}
