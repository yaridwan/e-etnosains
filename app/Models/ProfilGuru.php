<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilGuru extends ModelDasar
{
    protected $table = 'profil_guru';

    protected $fillable = [
        'id_pengguna', 'id_instansi_pendidikan', 'nip_nuptk',
        'bidang_studi', 'jenis_kelamin', 'alamat', 'bio',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function instansiPendidikan(): BelongsTo
    {
        return $this->belongsTo(InstansiPendidikan::class, 'id_instansi_pendidikan');
    }
}
