<?php

namespace App\Models;


class Tag extends ModelDasar
{
    protected $table = 'tag';

    protected $fillable = ['nama_tag', 'alamat_tautan'];

    public function getRouteKeyName(): string
    {
        return 'alamat_tautan';
    }
}
