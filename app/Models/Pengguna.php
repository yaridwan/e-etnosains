<?php

namespace App\Models;

use App\Enums\StatusAkun;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Pengguna extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = 'diperbarui_pada';

    const DELETED_AT = 'dihapus_pada';

    protected $table = 'pengguna';

    protected $fillable = [
        'uuid', 'nama_lengkap', 'email', 'nomor_telepon', 'kata_sandi',
        'foto', 'status_akun', 'terakhir_masuk_pada', 'alamat_ip_terakhir',
    ];

    protected $hidden = [
        'kata_sandi', 'ingat_saya',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $pengguna) {
            $pengguna->uuid ??= (string) Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'email_terverifikasi_pada' => 'datetime',
            'terakhir_masuk_pada' => 'datetime',
            'status_akun' => StatusAkun::class,
            'kata_sandi' => 'hashed',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    public function getRememberTokenName(): string
    {
        return 'ingat_saya';
    }

    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_terverifikasi_pada);
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_terverifikasi_pada' => $this->freshTimestamp(),
        ])->save();
    }

    public function peran(): BelongsToMany
    {
        return $this->belongsToMany(Peran::class, 'pengguna_peran', 'id_pengguna', 'id_peran');
    }

    public function memilikiPeran(string ...$namaPeran): bool
    {
        return $this->peran->pluck('nama_peran')->intersect($namaPeran)->isNotEmpty();
    }

    public function profilGuru(): HasOne
    {
        return $this->hasOne(ProfilGuru::class, 'id_pengguna');
    }

    public function profilSiswa(): HasOne
    {
        return $this->hasOne(ProfilSiswa::class, 'id_pengguna');
    }

    public function verifikasiGuru(): HasOne
    {
        return $this->hasOne(VerifikasiGuru::class, 'id_pengguna');
    }

    public function eModul(): HasMany
    {
        return $this->hasMany(EModul::class, 'id_pengguna');
    }

    public function lkpd(): HasMany
    {
        return $this->hasMany(Lkpd::class, 'id_pengguna');
    }

    public function bahanAjar(): HasMany
    {
        return $this->hasMany(BahanAjar::class, 'id_pengguna');
    }

    public function videoPembelajaran(): HasMany
    {
        return $this->hasMany(VideoPembelajaran::class, 'id_pengguna');
    }

    public function poster(): HasMany
    {
        return $this->hasMany(Poster::class, 'id_pengguna');
    }

    public function observasi(): HasMany
    {
        return $this->hasMany(Observasi::class, 'id_pengguna');
    }

    public function kelasBelajar(): HasMany
    {
        return $this->hasMany(KelasBelajar::class, 'id_pengguna');
    }

    public function kelasDiikuti(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(KelasBelajar::class, 'anggota_kelas', 'id_pengguna', 'id_kelas_belajar')
            ->withPivot('bergabung_pada');
    }

    public function kemajuanBelajar(): HasMany
    {
        return $this->hasMany(KemajuanBelajar::class, 'id_pengguna');
    }

    public function pengumpulanObservasi(): HasMany
    {
        return $this->hasMany(PengumpulanObservasi::class, 'id_pengguna');
    }

    public function pengumpulanTugas(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'id_pengguna');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_pengguna');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_pengguna')->latest('dibuat_pada');
    }

    public function favorit(): HasMany
    {
        return $this->hasMany(Favorit::class, 'id_pengguna');
    }

    public function isAdministrator(): bool
    {
        return $this->memilikiPeran('administrator');
    }

    public function isGuru(): bool
    {
        return $this->memilikiPeran('guru');
    }

    public function isSiswa(): bool
    {
        return $this->memilikiPeran('siswa');
    }
}
