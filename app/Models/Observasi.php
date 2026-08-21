<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Observasi extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'observasi';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_e_modul', 'id_lkpd', 'judul', 'alamat_tautan',
        'deskripsi', 'tujuan', 'petunjuk', 'lokasi_observasi', 'durasi',
        'alat_dan_bahan', 'prosedur', 'aspek_keselamatan', 'batas_pengumpulan',
        'status_publikasi',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $observasi) {
            $observasi->uuid ??= (string) Str::uuid();
            $observasi->alamat_tautan ??= static::buatAlamatTautanUnik($observasi->judul);
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
            'status_publikasi' => StatusPublikasi::class,
            'batas_pengumpulan' => 'datetime',
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

    public function lkpd(): BelongsTo
    {
        return $this->belongsTo(Lkpd::class, 'id_lkpd');
    }

    public function butirObservasi(): HasMany
    {
        return $this->hasMany(ButirObservasi::class, 'id_observasi')->orderBy('urutan');
    }

    public function pengumpulan(): HasMany
    {
        return $this->hasMany(PengumpulanObservasi::class, 'id_observasi');
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }
}
