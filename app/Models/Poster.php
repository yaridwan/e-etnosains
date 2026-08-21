<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Poster extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'poster';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_e_modul', 'judul', 'alamat_tautan',
        'deskripsi', 'gambar', 'status_publikasi', 'dipublikasikan_pada',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $poster) {
            $poster->uuid ??= (string) Str::uuid();
            $poster->alamat_tautan ??= static::buatAlamatTautanUnik($poster->judul);
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

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }
}
