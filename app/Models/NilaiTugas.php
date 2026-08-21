<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiTugas extends ModelDasar
{
    protected $table = 'nilai_tugas';

    protected $fillable = ['id_pengumpulan_tugas', 'nilai', 'catatan_guru', 'dinilai_oleh', 'dinilai_pada'];

    protected function casts(): array
    {
        return ['dinilai_pada' => 'datetime'];
    }

    public function pengumpulanTugas(): BelongsTo
    {
        return $this->belongsTo(PengumpulanTugas::class, 'id_pengumpulan_tugas');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dinilai_oleh');
    }
}
