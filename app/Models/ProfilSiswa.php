<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilSiswa extends ModelDasar
{
    protected $table = 'profil_siswa';

    protected $fillable = ['id_pengguna', 'id_instansi_pendidikan', 'kelas', 'jenis_kelamin'];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function instansiPendidikan(): BelongsTo
    {
        return $this->belongsTo(InstansiPendidikan::class, 'id_instansi_pendidikan');
    }
}
