<?php

namespace App\Models;

class Pengumuman extends ModelDasar
{
    protected $table = 'pengumuman';

    protected $fillable = ['judul', 'isi', 'target', 'tanggal_mulai', 'tanggal_selesai', 'aktif'];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'aktif' => 'boolean',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where(fn ($q) => $q->whereNull('tanggal_mulai')->orWhereDate('tanggal_mulai', '<=', now()))
            ->where(fn ($q) => $q->whereNull('tanggal_selesai')->orWhereDate('tanggal_selesai', '>=', now()));
    }

    public function scopeUntukPeran($query, string $peran)
    {
        return $query->where(fn ($q) => $q->where('target', 'umum')->orWhere('target', $peran));
    }
}
