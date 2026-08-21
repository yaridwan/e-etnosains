<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengumpulanTugas extends ModelDasar
{
    protected $table = 'pengumpulan_tugas';

    protected $fillable = ['id_tugas_kelas', 'id_pengguna', 'berkas', 'catatan_siswa', 'status', 'dikirim_pada'];

    protected function casts(): array
    {
        return ['dikirim_pada' => 'datetime'];
    }

    public function tugasKelas(): BelongsTo
    {
        return $this->belongsTo(TugasKelas::class, 'id_tugas_kelas');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function nilai(): HasOne
    {
        return $this->hasOne(NilaiTugas::class, 'id_pengumpulan_tugas');
    }
}
