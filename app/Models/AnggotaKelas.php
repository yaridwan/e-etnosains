<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKelas extends ModelDasar
{
    protected $table = 'anggota_kelas';

    protected $fillable = ['id_kelas_belajar', 'id_pengguna', 'bergabung_pada'];

    protected function casts(): array
    {
        return ['bergabung_pada' => 'datetime'];
    }

    public function kelasBelajar(): BelongsTo
    {
        return $this->belongsTo(KelasBelajar::class, 'id_kelas_belajar');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
