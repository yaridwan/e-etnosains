<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TugasKelas extends ModelDasarHapusLunak
{
    
    protected $table = 'tugas_kelas';

    protected $fillable = [
        'uuid', 'id_kelas_belajar', 'id_pengguna', 'judul', 'petunjuk', 'berkas',
        'jenis_referensi', 'id_referensi_konten', 'tanggal_mulai', 'batas_waktu',
        'bobot', 'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $tugas) {
            $tugas->uuid ??= (string) Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'datetime',
            'batas_waktu' => 'datetime',
        ];
    }

    public function kelasBelajar(): BelongsTo
    {
        return $this->belongsTo(KelasBelajar::class, 'id_kelas_belajar');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function pengumpulan(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'id_tugas_kelas');
    }

    public function sudahLewatBatasWaktu(): bool
    {
        return $this->batas_waktu && $this->batas_waktu->isPast();
    }
}
