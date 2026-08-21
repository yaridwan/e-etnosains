<?php

namespace Database\Seeders;

use App\Enums\StatusVerifikasiGuru;
use App\Models\InstansiPendidikan;
use App\Models\Peran;
use App\Models\Pengguna;
use App\Models\ProfilGuru;
use App\Models\ProfilSiswa;
use App\Models\VerifikasiGuru;
use Illuminate\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        $peranAdministrator = Peran::where('nama_peran', 'administrator')->firstOrFail();
        $peranGuru = Peran::where('nama_peran', 'guru')->firstOrFail();
        $peranSiswa = Peran::where('nama_peran', 'siswa')->firstOrFail();
        $instansi = InstansiPendidikan::pluck('id');

        // Administrator
        $admin = Pengguna::factory()->create([
            'nama_lengkap' => 'Administrator E-ETNOSAINS',
            'email' => 'admin@e-etnosains.test',
            'kata_sandi' => 'password',
        ]);
        $admin->peran()->attach($peranAdministrator);

        // Guru demo utama
        $namaGuru = [
            'Siti Rahayu, S.Pd.' => 'IPA',
            'Bambang Wijaya, M.Pd.' => 'Biologi',
            'Ni Made Sartini, S.Pd.' => 'Fisika',
            'Rahmat Hidayat, S.Pd.' => 'Kimia',
            'Dewi Anggraini, M.Si.' => 'Prakarya',
        ];

        $guruUtama = null;

        foreach ($namaGuru as $nama => $bidang) {
            $guru = Pengguna::factory()->create([
                'nama_lengkap' => $nama,
                'email' => $guruUtama === null ? 'guru@e-etnosains.test' : fake()->unique()->safeEmail(),
                'kata_sandi' => 'password',
            ]);
            $guru->peran()->attach($peranGuru);

            ProfilGuru::create([
                'id_pengguna' => $guru->id,
                'id_instansi_pendidikan' => $instansi->random(),
                'nip_nuptk' => fake()->numerify('##################'),
                'bidang_studi' => $bidang,
                'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                'alamat' => fake()->address(),
                'bio' => "Guru {$bidang} yang aktif mengembangkan bahan ajar berbasis etnosains dan kearifan lokal.",
            ]);

            VerifikasiGuru::create([
                'id_pengguna' => $guru->id,
                'status' => StatusVerifikasiGuru::Disetujui,
                'catatan' => 'Dokumen lengkap dan sesuai.',
                'diverifikasi_oleh' => $admin->id,
                'diverifikasi_pada' => now()->subDays(30),
            ]);

            $guruUtama ??= $guru;
        }

        // Satu guru menunggu verifikasi (contoh workflow)
        $guruBaru = Pengguna::factory()->menungguVerifikasi()->create([
            'nama_lengkap' => 'Yusuf Maulana, S.Pd.',
        ]);
        $guruBaru->peran()->attach($peranGuru);
        ProfilGuru::create([
            'id_pengguna' => $guruBaru->id,
            'id_instansi_pendidikan' => $instansi->random(),
            'nip_nuptk' => fake()->numerify('##################'),
            'bidang_studi' => 'IPS',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => fake()->address(),
        ]);
        VerifikasiGuru::create([
            'id_pengguna' => $guruBaru->id,
            'status' => StatusVerifikasiGuru::Menunggu,
        ]);

        // Siswa demo utama + tambahan
        $siswaUtama = Pengguna::factory()->create([
            'nama_lengkap' => 'Ahmad Fadli',
            'email' => 'siswa@e-etnosains.test',
            'kata_sandi' => 'password',
        ]);
        $siswaUtama->peran()->attach($peranSiswa);
        ProfilSiswa::create([
            'id_pengguna' => $siswaUtama->id,
            'id_instansi_pendidikan' => $instansi->random(),
            'kelas' => 'X IPA 1',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Pengguna::factory()->count(14)->create()->each(function (Pengguna $siswa) use ($peranSiswa, $instansi) {
            $siswa->peran()->attach($peranSiswa);
            ProfilSiswa::create([
                'id_pengguna' => $siswa->id,
                'id_instansi_pendidikan' => $instansi->random(),
                'kelas' => fake()->randomElement(['VII A', 'VIII B', 'IX A', 'X IPA 1', 'XI IPA 2', 'XII IPA 1']),
                'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            ]);
        });
    }
}
