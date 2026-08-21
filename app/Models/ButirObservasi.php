<?php

namespace App\Models;

use App\Enums\JenisPertanyaan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ButirObservasi extends ModelDasar
{
    protected $table = 'butir_observasi';

    protected $fillable = ['id_observasi', 'pertanyaan', 'petunjuk', 'tipe_pertanyaan', 'wajib', 'urutan', 'skor_maksimal'];

    protected function casts(): array
    {
        return [
            'tipe_pertanyaan' => JenisPertanyaan::class,
            'wajib' => 'boolean',
        ];
    }

    public function observasi(): BelongsTo
    {
        return $this->belongsTo(Observasi::class, 'id_observasi');
    }

    public function opsi(): HasMany
    {
        return $this->hasMany(OpsiButirObservasi::class, 'id_butir_observasi')->orderBy('urutan');
    }
}
