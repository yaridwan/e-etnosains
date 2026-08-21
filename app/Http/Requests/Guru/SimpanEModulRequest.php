<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class SimpanEModulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'id_jenjang_pendidikan' => ['required', 'exists:jenjang_pendidikan,id'],
            'id_mata_pelajaran' => ['required', 'exists:mata_pelajaran,id'],
            'id_topik_etnosains' => ['nullable', 'exists:topik_etnosains,id'],
            'id_daerah_etnosains' => ['nullable', 'exists:daerah_etnosains,id'],
            'ringkasan' => ['required', 'string', 'max:500'],
            'deskripsi' => ['required', 'string'],
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
            'izin_unduh' => ['nullable', 'boolean'],
            'gambar_sampul' => ['nullable', 'image', 'max:5120'],
            'gambar_poster' => ['nullable', 'image', 'max:5120'],
            'berkas_pdf' => ['nullable', 'mimes:pdf', 'max:51200'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id_jenjang_pendidikan' => 'jenjang pendidikan',
            'id_mata_pelajaran' => 'mata pelajaran',
            'id_topik_etnosains' => 'topik etnosains',
            'id_daerah_etnosains' => 'daerah etnosains',
            'berkas_pdf' => 'berkas PDF',
        ];
    }
}
