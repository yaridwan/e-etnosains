<?php

namespace App\Models;


class TopikEtnosains extends ModelDasar
{
    protected $table = 'topik_etnosains';

    protected $fillable = ['nama_topik', 'alamat_tautan', 'deskripsi', 'gambar'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }

    public function eModul()
    {
        return $this->hasMany(EModul::class, 'id_topik_etnosains');
    }
}
