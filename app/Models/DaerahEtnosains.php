<?php

namespace App\Models;


class DaerahEtnosains extends ModelDasar
{
    protected $table = 'daerah_etnosains';

    protected $fillable = ['provinsi', 'kabupaten_kota', 'kecamatan', 'desa_kelurahan', 'nama_kearifan_lokal'];

    public function namaLengkap(): string
    {
        return collect([$this->nama_kearifan_lokal, $this->kabupaten_kota, $this->provinsi])
            ->filter()
            ->implode(', ');
    }
}
