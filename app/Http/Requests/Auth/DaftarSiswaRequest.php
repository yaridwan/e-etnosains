<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class DaftarSiswaRequest extends FormRequest
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
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'id_instansi_pendidikan' => ['required', 'exists:instansi_pendidikan,id'],
            'kelas' => ['required', 'string', 'max:20'],
            'kata_sandi' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'nama lengkap',
            'nomor_telepon' => 'nomor telepon',
            'jenis_kelamin' => 'jenis kelamin',
            'id_instansi_pendidikan' => 'sekolah',
            'kata_sandi' => 'kata sandi',
        ];
    }
}
