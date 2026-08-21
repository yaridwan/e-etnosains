<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KelasBelajar extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'kelas_belajar';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_mata_pelajaran', 'nama_kelas',
        'kode_kelas', 'tahun_ajaran', 'deskripsi', 'aktif',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $kelas) {
            $kelas->uuid ??= (string) Str::uuid();
            $kelas->kode_kelas ??= static::buatKodeKelasUnik();
        });
    }

    public static function buatKodeKelasUnik(): string
    {
        do {
            $kode = 'ETNO-'.Str::upper(Str::random(6));
        } while (static::where('kode_kelas', $kode)->exists());

        return $kode;
    }

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function anggota(): BelongsToMany
    {
        return $this->belongsToMany(Pengguna::class, 'anggota_kelas', 'id_kelas_belajar', 'id_pengguna')
            ->withPivot('bergabung_pada');
    }

    public function kontenKelas(): HasMany
    {
        return $this->hasMany(KontenKelas::class, 'id_kelas_belajar')->orderBy('urutan');
    }

    public function tugasKelas(): HasMany
    {
        return $this->hasMany(TugasKelas::class, 'id_kelas_belajar')->latest('dibuat_pada');
    }
}
