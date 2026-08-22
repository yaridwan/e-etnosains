<?php

namespace App\Models;

use App\Enums\StatusPublikasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class EModul extends ModelDasarHapusLunak
{
    use HasFactory;

    protected $table = 'e_modul';

    protected $fillable = [
        'uuid', 'id_pengguna', 'id_jenjang_pendidikan', 'id_mata_pelajaran',
        'id_topik_etnosains', 'id_daerah_etnosains', 'judul', 'alamat_tautan',
        'ringkasan', 'deskripsi', 'capaian_pembelajaran', 'tujuan_pembelajaran',
        'kelas', 'fase', 'tahun', 'kata_kunci', 'gambar_sampul', 'gambar_poster',
        'berkas_pdf', 'jumlah_halaman', 'izin_unduh', 'pengetahuan_lokal',
        'konsep_sains', 'konteks_wilayah', 'aktivitas_saintifik', 'nilai_karakter',
        'status_publikasi', 'unggulan', 'catatan_reviewer', 'dipublikasikan_pada', 'dijadwalkan_pada',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $eModul) {
            $eModul->uuid ??= (string) Str::uuid();
            $eModul->alamat_tautan ??= static::buatAlamatTautanUnik($eModul->judul);
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
            'unggulan' => 'boolean',
            'status_publikasi' => StatusPublikasi::class,
            'dipublikasikan_pada' => 'datetime',
            'dijadwalkan_pada' => 'datetime',
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

    public function jenjangPendidikan(): BelongsTo
    {
        return $this->belongsTo(JenjangPendidikan::class, 'id_jenjang_pendidikan');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mata_pelajaran');
    }

    public function topikEtnosains(): BelongsTo
    {
        return $this->belongsTo(TopikEtnosains::class, 'id_topik_etnosains');
    }

    public function daerahEtnosains(): BelongsTo
    {
        return $this->belongsTo(DaerahEtnosains::class, 'id_daerah_etnosains');
    }

    public function babEModul(): HasMany
    {
        return $this->hasMany(BabEModul::class, 'id_e_modul')->orderBy('nomor_urut');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusEModul::class, 'id_e_modul')->latest('dibuat_pada');
    }

    public function catatanPeninjauan(): HasMany
    {
        return $this->hasMany(CatatanPeninjauanEModul::class, 'id_e_modul')->latest('dibuat_pada');
    }

    public function versi(): HasMany
    {
        return $this->hasMany(VersiEModul::class, 'id_e_modul')->orderByDesc('nomor_versi');
    }

    public function lkpd(): HasMany
    {
        return $this->hasMany(Lkpd::class, 'id_e_modul');
    }

    public function video(): HasMany
    {
        return $this->hasMany(VideoPembelajaran::class, 'id_e_modul');
    }

    public function poster(): HasMany
    {
        return $this->hasMany(Poster::class, 'id_e_modul');
    }

    public function observasi(): HasMany
    {
        return $this->hasMany(Observasi::class, 'id_e_modul');
    }

    public function favorit(): MorphMany
    {
        return $this->morphMany(Favorit::class, 'konten', 'jenis_konten', 'id_referensi');
    }

    public function ulasan(): MorphMany
    {
        return $this->morphMany(Ulasan::class, 'konten', 'jenis_konten', 'id_referensi');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'konten_tag', 'id_referensi', 'id_tag')
            ->wherePivot('jenis_konten', 'e_modul')
            ->withPivotValue('jenis_konten', 'e_modul');
    }

    public function scopeDipublikasikan($query)
    {
        return $query->where('status_publikasi', StatusPublikasi::Dipublikasikan);
    }

    public function ratingRataRata(): float
    {
        return round($this->ulasan()->where('status_moderasi', 'disetujui')->avg('rating') ?? 0, 1);
    }
}
