<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Lkpd extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'lkpd';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_e_modul', 'id_mata_pelajaran', 'id_jenjang_pendidikan',
        'judul', 'alamat_tautan', 'deskripsi', 'petunjuk', 'jenis', 'berkas_pdf',
        'gambar_sampul', 'tujuan', 'aktivitas', 'pertanyaan', 'kesimpulan',
        'izin_unduh', 'status_publikasi', 'dipublikasikan_pada',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $lkpd) {
            $lkpd->uuid ??= (string) Str::uuid();
            $lkpd->alamat_tautan ??= static::buatAlamatTautanUnik($lkpd->judul);
        });
    }

    public static function buatAlamatTautanUnik(string $judul): string
    {
        $dasar = Str::slug($judul);
        $tautan = $dasar;
        $angka = 1;

        while (static::withTrashed()->where('alamat_tautan', $tautan)->exists()) {
            $tautan = "{$dasar}-{$angka}";
            $angka++;
        }

        return $tautan;
    }

    protected function casts(): array
    {
        return [
            'izin_unduh' => 'boolean',
            'status_publikasi' => StatusPublikasi::class,
            'dipublikasikan_pada' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function eModul(): BelongsTo
    {
        return $this->belongsTo(EModul::class, 'id_e_modul');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function jenjangPendidikan(): BelongsTo
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang_pendidikan');
    }

    public function favorit(): MorphMany
    {
        return $this->morphMany(Favorit::class, 'konten', 'jenis_konten', 'id_referensi');
    }

    public function ulasan(): MorphMany
    {
        return $this->morphMany(Ulasan::class, 'konten', 'jenis_konten', 'id_referensi');
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }
}
