<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class SimpanEvaluasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:200'],
            'id_e_modul' => ['nullable', 'exists:e_modul,id'],
            'id_mata_pelajaran' => ['required', 'exists:mata_pelajaran,id'],
            'id_jenjang_pendidikan' => ['required', 'exists:jenjang_pendidikan,id'],
            'jenis_evaluasi' => ['required', 'in:formatif,sumatif,harian,akhir_semester'],
            'deskripsi' => ['nullable', 'string'],
            'petunjuk' => ['nullable', 'string'],
            'kkm' => ['nullable', 'integer', 'min:0', 'max:100'],
            'durasi_menit' => ['nullable', 'integer', 'min:1'],
            'izin_unduh' => ['nullable', 'boolean'],
            'berkas_pdf' => ['nullable', 'mimes:pdf', 'max:20480'],
            'gambar_sampul' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'id_e_modul' => 'E-Modul terkait',
            'id_mata_pelajaran' => 'mata pelajaran',
            'id_jenjang_pendidikan' => 'jenjang pendidikan',
            'jenis_evaluasi' => 'jenis evaluasi',
            'kkm' => 'KKM',
            'durasi_menit' => 'durasi',
            'berkas_pdf' => 'berkas PDF',
        ];
    }
}
