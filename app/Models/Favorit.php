<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorit extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'favorit';

    protected $fillable = ['id_pengguna', 'jenis_konten', 'id_referensi'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function konten(): MorphTo
    {
        return $this->morphTo('konten', 'jenis_konten', 'id_referensi');
    }
}
