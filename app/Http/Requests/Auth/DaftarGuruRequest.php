<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class DaftarGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:pengguna,email'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'id_instansi_pendidikan' => ['required', 'exists:instansi_pendidikan,id'],
            'nip_nuptk' => ['nullable', 'string', 'max:30'],
            'bidang_studi' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string', 'max:500'],
            'kata_sandi' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'nama lengkap',
            'nomor_telepon' => 'nomor telepon',
            'jenis_kelamin' => 'jenis kelamin',
            'id_instansi_pendidikan' => 'instansi/sekolah/kampus',
            'nip_nuptk' => 'NIP/NUPTK/NIM',
            'bidang_studi' => 'bidang/mata pelajaran',
            'kata_sandi' => 'kata sandi',
        ];
    }
}
