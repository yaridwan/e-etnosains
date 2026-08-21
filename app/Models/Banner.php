<?php

namespace App\Models;


class Banner extends ModelDasar
{
    protected $table = 'banner';

    protected $fillable = ['judul', 'subjudul', 'gambar', 'teks_tombol', 'tautan_tombol', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
