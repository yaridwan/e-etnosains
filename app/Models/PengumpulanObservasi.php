<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengumpulanObservasi extends ModelDasar
{
    protected $table = 'pengumpulan_observasi';

    protected $fillable = [
        'id_observasi', 'id_pengguna', 'status', 'dikirim_pada',
        'dinilai_pada', 'dinilai_oleh', 'skor', 'catatan_guru',
    ];

    protected function casts(): array
    {
        return [
            'dikirim_pada' => 'datetime',
            'dinilai_pada' => 'datetime',
        ];
    }

    public function observasi(): BelongsTo
    {
        return $this->belongsTo(Observasi::class, 'id_observasi');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dinilai_oleh');
    }

    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanObservasi::class, 'id_pengumpulan_observasi');
    }

    public function dokumentasi(): HasMany
    {
        return $this->hasMany(DokumentasiObservasi::class, 'id_pengumpulan_observasi');
    }
}
