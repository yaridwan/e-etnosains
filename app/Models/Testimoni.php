<?php

namespace App\Models;

class Testimoni extends ModelDasar
{
    protected $table = 'testimoni';

    protected $fillable = ['nama', 'peran_testimoni', 'foto', 'isi_testimoni', 'rating', 'aktif', 'urutan'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
