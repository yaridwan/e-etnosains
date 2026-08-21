<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peran extends ModelDasar
{
    protected $table = 'peran';

    protected $fillable = ['nama_peran', 'keterangan'];

    public function pengguna(): BelongsToMany
    {
        return $this->belongsToMany(Pengguna::class, 'pengguna_peran', 'id_peran', 'id_pengguna');
    }

    public function izin(): BelongsToMany
    {
        return $this->belongsToMany(Izin::class, 'peran_izin', 'id_peran', 'id_izin');
    }
}
