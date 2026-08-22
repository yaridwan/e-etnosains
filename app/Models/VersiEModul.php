<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Cuplikan (snapshot) isi E-Modul pada saat diterbitkan. Baris di tabel ini
 * bersifat abadi (immutable) — tidak pernah diubah maupun dihapus lagi setelah
 * dibuat, sehingga riwayat versi selalu dapat ditelusuri kembali.
 */
class VersiEModul extends Model
{
    const CREATED_AT = 'dibuat_pada';

    const UPDATED_AT = null;

    protected $table = 'versi_e_modul';

    protected $fillable = [
        'id_e_modul', 'nomor_versi', 'judul', 'ringkasan', 'deskripsi',
        'capaian_pembelajaran', 'tujuan_pembelajaran', 'pengetahuan_lokal',
        'konsep_sains', 'konteks_wilayah', 'aktivitas_saintifik', 'nilai_karakter',
        'gambar_sampul', 'gambar_poster', 'berkas_pdf', 'jumlah_halaman', 'id_pengguna',
    ];

    public function eModul(): BelongsTo
    {
        return $this->belongsTo(EModul::class, 'id_e_modul');
    }

    public function penerbit(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
}
