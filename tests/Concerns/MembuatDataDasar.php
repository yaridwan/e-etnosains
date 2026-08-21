<?php

namespace Tests\Concerns;

use App\Enums\StatusAkun;
use App\Enums\StatusVerifikasiGuru;
use App\Models\InstansiPendidikan;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use App\Models\Peran;
use App\Models\ProfilGuru;
use App\Models\ProfilSiswa;
use App\Models\VerifikasiGuru;

trait MembuatDataDasar
{
    protected function buatPeran(string $nama): Peran
    {
        return Peran::firstOrCreate(['nama_peran' => $nama]);
    }

    protected function buatAdmin(array $atribut = []): Pengguna
    {
        $admin = Pengguna::factory()->create(array_merge(['status_akun' => StatusAkun::Aktif], $atribut));
        $admin->peran()->attach($this->buatPeran('administrator'));

        return $admin;
    }

    protected function buatGuru(array $atribut = [], bool $terverifikasi = true): Pengguna
    {
        $guru = Pengguna::factory()->create(array_merge(['status_akun' => StatusAkun::Aktif], $atribut));
        $guru->peran()->attach($this->buatPeran('guru'));

        ProfilGuru::create([
            'id_pengguna' => $guru->id,
            'id_instansi_pendidikan' => InstansiPendidikan::factory()->create()->id,
            'bidang_studi' => 'IPA',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        VerifikasiGuru::create([
            'id_pengguna' => $guru->id,
            'status' => $terverifikasi ? StatusVerifikasiGuru::Disetujui : StatusVerifikasiGuru::Menunggu,
        ]);

        return $guru;
    }

    protected function buatSiswa(array $atribut = []): Pengguna
    {
        $siswa = Pengguna::factory()->create(array_merge(['status_akun' => StatusAkun::Aktif], $atribut));
        $siswa->peran()->attach($this->buatPeran('siswa'));

        ProfilSiswa::create([
            'id_pengguna' => $siswa->id,
            'id_instansi_pendidikan' => InstansiPendidikan::factory()->create()->id,
            'kelas' => 'X IPA 1',
            'jenis_kelamin' => 'Perempuan',
        ]);

        return $siswa;
    }

    protected function buatJenjangPendidikan(): JenjangPendidikan
    {
        return JenjangPendidikan::firstOrCreate(
            ['alamat_tautan' => 'sma-ma'],
            ['nama_jenjang' => 'SMA/MA', 'urutan' => 1]
        );
    }

    protected function buatMataPelajaran(): MataPelajaran
    {
        return MataPelajaran::firstOrCreate(
            ['alamat_tautan' => 'ipa'],
            ['nama_mata_pelajaran' => 'IPA']
        );
    }
}
