<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class SimpanLkpdRequest extends FormRequest
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
            'jenis' => ['required', 'in:file,digital'],
            'deskripsi' => ['nullable', 'string'],
            'petunjuk' => ['nullable', 'string'],
            'tujuan' => ['nullable', 'string'],
            'aktivitas' => ['nullable', 'string'],
            'pertanyaan' => ['nullable', 'string'],
            'kesimpulan' => ['nullable', 'string'],
            'izin_unduh' => ['nullable', 'boolean'],
            'berkas_pdf' => ['nullable', 'mimes:pdf', 'max:20480'],
            'gambar_sampul' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
