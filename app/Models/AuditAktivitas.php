<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditAktivitas extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'audit_aktivitas';

    protected $fillable = [
        'id_pengguna', 'aktivitas', 'modul', 'id_referensi',
        'alamat_ip', 'agen_pengguna', 'data_sebelum', 'data_sesudah',
    ];

    protected function casts(): array
    {
        return [
            'data_sebelum' => 'array',
            'data_sesudah' => 'array',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
