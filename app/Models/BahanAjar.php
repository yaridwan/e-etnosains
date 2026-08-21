<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class BahanAjar extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'bahan_ajar';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_mata_pelajaran', 'id_jenjang_pendidikan', 'id_topik_etnosains',
        'judul', 'alamat_tautan', 'deskripsi', 'jenis_berkas', 'berkas', 'gambar_sampul',
        'tautan_eksternal', 'status_publikasi', 'dipublikasikan_pada',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $bahanAjar) {
            $bahanAjar->uuid ??= (string) Str::uuid();
            $bahanAjar->alamat_tautan ??= static::buatAlamatTautanUnik($bahanAjar->judul);
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

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function jenjangPendidikan(): BelongsTo
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang_pendidikan');
    }

    public function topikEtnosains(): BelongsTo
    {
        return $this->belongsTo(TopikEtnosains::class, 'id_topik_etnosains');
    }

    public function favorit(): MorphMany
    {
        return $this->morphMany(Favorit::class, 'konten', 'jenis_konten', 'id_referensi');
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }
}
