<?php

namespace App\Services;

use App\Enums\StatusAkun;
use App\Enums\StatusVerifikasiGuru;
use App\Models\Pengguna;
use App\Models\Peran;
use App\Models\ProfilGuru;
use App\Models\ProfilSiswa;
use App\Models\VerifikasiGuru;
use Illuminate\Support\Facades\DB;

class RegistrasiService
{
    public function daftarGuru(array $data): Pengguna
    {
        return DB::transaction(function () use ($data) {
            $guru = Pengguna::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'],
                'nomor_telepon' => $data['nomor_telepon'],
                'kata_sandi' => $data['kata_sandi'],
                'status_akun' => StatusAkun::MenungguVerifikasi,
            ]);

            $guru->peran()->attach(Peran::where('nama_peran', 'guru')->firstOrFail());

            ProfilGuru::create([
                'id_pengguna' => $guru->id,
                'id_instansi_pendidikan' => $data['id_instansi_pendidikan'],
                'nip_nuptk' => $data['nip_nuptk'] ?? null,
                'bidang_studi' => $data['bidang_studi'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat' => $data['alamat'],
            ]);

            VerifikasiGuru::create([
                'id_pengguna' => $guru->id,
                'status' => StatusVerifikasiGuru::Menunggu,
            ]);

            return $guru;
        });
    }

    public function daftarSiswa(array $data): Pengguna
    {
        return DB::transaction(function () use ($data) {
            $perluPersetujuan = pengaturan_aktif('registrasi_siswa_perlu_persetujuan');

            $siswa = Pengguna::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'email' => $data['email'],
                'nomor_telepon' => $data['nomor_telepon'] ?? null,
                'kata_sandi' => $data['kata_sandi'],
                'status_akun' => $perluPersetujuan ? StatusAkun::MenungguVerifikasi : StatusAkun::Aktif,
            ]);

            $siswa->peran()->attach(Peran::where('nama_peran', 'siswa')->firstOrFail());

            ProfilSiswa::create([
                'id_pengguna' => $siswa->id,
                'id_instansi_pendidikan' => $data['id_instansi_pendidikan'],
                'kelas' => $data['kelas'],
                'jenis_kelamin' => $data['jenis_kelamin'],
            ]);

            return $siswa;
        });
    }
}
