<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Notifikasi extends ModelDasar
{
    protected $table = 'notifikasi';

    protected $fillable = ['uuid', 'id_pengguna', 'tipe', 'judul', 'pesan', 'data', 'dibaca_pada'];

    protected static function booted(): void
    {
        static::creating(function (self $notifikasi) {
            $notifikasi->uuid ??= (string) Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'dibaca_pada' => 'datetime',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function sudahDibaca(): bool
    {
        return ! is_null($this->dibaca_pada);
    }
}
