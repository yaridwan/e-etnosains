<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KontenTag extends Model
{
    public $timestamps = false;

    protected $table = 'konten_tag';

    protected $fillable = ['id_tag', 'jenis_konten', 'id_referensi'];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
