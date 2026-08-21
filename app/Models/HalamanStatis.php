<?php

namespace App\Models;


class HalamanStatis extends ModelDasar
{
    protected $table = 'halaman_statis';

    protected $fillable = ['judul', 'alamat_tautan', 'konten', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
