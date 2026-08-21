<?php

namespace App\Models;

class Faq extends ModelDasar
{
    protected $table = 'faq';

    protected $fillable = ['pertanyaan', 'jawaban', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
