<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Aturan untuk simpan draf otomatis (autosave). Sengaja jauh lebih longgar
 * daripada SimpanEModulRequest: saat mengetik, guru mungkin belum mengisi
 * seluruh kolom wajib, dan autosave tidak boleh menampilkan galat validasi
 * yang mengganggu — cukup diamkan kolom yang belum valid, jangan disimpan.
 * Berkas (gambar/PDF) sengaja tidak disertakan; autosave hanya untuk teks.
 */
class SimpanOtomatisEModulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['nullable', 'string', 'max:200'],
            'id_jenjang_pendidikan' => ['nullable', 'exists:jenjang_pendidikan,id'],
            'id_mata_pelajaran' => ['nullable', 'exists:mata_pelajaran,id'],
            'id_topik_etnosains' => ['nullable', 'exists:topik_etnosains,id'],
            'id_daerah_etnosains' => ['nullable', 'exists:daerah_etnosains,id'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string'],
            'capaian_pembelajaran' => ['nullable', 'string'],
            'tujuan_pembelajaran' => ['nullable', 'string'],
            'kelas' => ['nullable', 'string', 'max:20'],
            'fase' => ['nullable', 'string', 'max:10'],
            'tahun' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'kata_kunci' => ['nullable', 'string', 'max:255'],
            'pengetahuan_lokal' => ['nullable', 'string'],
            'konsep_sains' => ['nullable', 'string'],
            'konteks_wilayah' => ['nullable', 'string', 'max:150'],
            'aktivitas_saintifik' => ['nullable', 'string'],
            'nilai_karakter' => ['nullable', 'string'],
        ];
    }
}
