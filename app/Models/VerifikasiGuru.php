<?php

namespace App\Models;

use App\Enums\StatusVerifikasiGuru;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiGuru extends ModelDasar
{
    protected $table = 'verifikasi_guru';

    protected $fillable = ['id_pengguna', 'status', 'catatan', 'diverifikasi_oleh', 'diverifikasi_pada'];

    protected function casts(): array
    {
        return [
            'status' => StatusVerifikasiGuru::class,
            'diverifikasi_pada' => 'datetime',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'diverifikasi_oleh');
    }
}
