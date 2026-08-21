<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Ulasan extends ModelDasar
{
    protected $table = 'ulasan';

    protected $fillable = ['id_pengguna', 'jenis_konten', 'id_referensi', 'rating', 'komentar', 'status_moderasi'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function konten(): MorphTo
    {
        return $this->morphTo('konten', 'jenis_konten', 'id_referensi');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status_moderasi', 'disetujui');
    }
}
