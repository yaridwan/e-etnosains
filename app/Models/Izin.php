<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Izin extends ModelDasar
{
    protected $table = 'izin';

    protected $fillable = ['nama_izin', 'kelompok', 'keterangan'];

    public function peran(): BelongsToMany
    {
        return $this->belongsToMany(Peran::class, 'peran_izin', 'id_izin', 'id_peran');
    }
}
