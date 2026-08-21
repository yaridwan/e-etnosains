<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KemajuanBelajar extends ModelDasar
{
    protected $table = 'kemajuan_belajar';

    protected $fillable = [
        'id_pengguna', 'jenis_konten', 'id_referensi', 'halaman_terakhir',
        'persentase_baca', 'status', 'terakhir_diakses_pada',
    ];

    protected function casts(): array
    {
        return ['terakhir_diakses_pada' => 'datetime'];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
