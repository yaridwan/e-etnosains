<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpsiButirObservasi extends ModelDasar
{
    protected $table = 'opsi_butir_observasi';

    protected $fillable = ['id_butir_observasi', 'teks_opsi', 'urutan'];

    public function butirObservasi(): BelongsTo
    {
        return $this->belongsTo(ButirObservasi::class, 'id_butir_observasi');
    }
}
