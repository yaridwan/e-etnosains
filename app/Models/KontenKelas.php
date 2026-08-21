<?php

namespace App\Models;

use App\Enums\JenisKonten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontenKelas extends ModelDasar
{
    protected $table = 'konten_kelas';

    protected $fillable = ['id_kelas_belajar', 'jenis_konten', 'id_referensi', 'urutan'];

    public function kelasBelajar(): BelongsTo
    {
        return $this->belongsTo(KelasBelajar::class, 'id_kelas_belajar');
    }

    public function konten(): ?Model
    {
        $jenis = JenisKonten::tryFrom($this->jenis_konten);

        return $jenis?->modelClass()::find($this->id_referensi);
    }
}
