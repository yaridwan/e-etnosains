<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanObservasi extends ModelDasar
{
    protected $table = 'jawaban_observasi';

    protected $fillable = [
        'id_pengumpulan_observasi', 'id_butir_observasi', 'jawaban_teks',
        'jawaban_angka', 'id_opsi_butir_observasi', 'berkas_jawaban',
    ];

    public function pengumpulan(): BelongsTo
    {
        return $this->belongsTo(PengumpulanObservasi::class, 'id_pengumpulan_observasi');
    }

    public function butirObservasi(): BelongsTo
    {
        return $this->belongsTo(ButirObservasi::class, 'id_butir_observasi');
    }

    public function opsiTerpilih(): BelongsTo
    {
        return $this->belongsTo(OpsiButirObservasi::class, 'id_opsi_butir_observasi');
    }
}
