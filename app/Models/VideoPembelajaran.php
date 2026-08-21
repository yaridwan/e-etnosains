<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class VideoPembelajaran extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'video_pembelajaran';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_e_modul', 'id_mata_pelajaran', 'id_topik_etnosains',
        'judul', 'alamat_tautan', 'deskripsi', 'url_video', 'id_youtube', 'gambar_sampul',
        'status_publikasi', 'dipublikasikan_pada',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $video) {
            $video->uuid ??= (string) Str::uuid();
            $video->alamat_tautan ??= static::buatAlamatTautanUnik($video->judul);
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

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function topikEtnosains(): BelongsTo
    {
        return $this->belongsTo(TopikEtnosains::class, 'id_topik_etnosains');
    }

    public function tautanEmbed(): string
    {
        return "https://www.youtube-nocookie.com/embed/{$this->id_youtube}";
    }

    public function tautanThumbnail(): string
    {
        return "https://img.youtube.com/vi/{$this->id_youtube}/hqdefault.jpg";
    }

    public static function ekstrakIdYoutube(string $url): ?string
    {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $cocok)) {
            return $cocok[1];
        }

        return null;
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }
}
