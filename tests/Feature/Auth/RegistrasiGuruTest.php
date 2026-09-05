<?php

namespace Tests\Feature\Auth;

use App\Enums\StatusAkun;
use App\Enums\StatusVerifikasiGuru;
use App\Models\InstansiPendidikan;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class RegistrasiGuruTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_dapat_mendaftar_dan_berstatus_menunggu_verifikasi(): void
    {
        Notification::fake();
        $this->buatPeran('guru');
        $instansi = InstansiPendidikan::factory()->create();

        $respons = $this->post(route('daftar.guru.proses'), [
            'nama_lengkap' => 'Guru Baru',
            'email' => 'guru.baru@contoh.test',
            'nomor_telepon' => '081234567890',
            'jenis_kelamin' => 'Laki-laki',
            'id_instansi_pendidikan' => $instansi->id,
            'bidang_studi' => 'Biologi',
            'alamat' => 'Jl. Contoh No. 1',
            'kata_sandi' => 'password123',
            'kata_sandi_confirmation' => 'password123',
        ]);

        $respons->assertRedirect(route('masuk'));

        $guru = Pengguna::where('email', 'guru.baru@contoh.test')->firstOrFail();
        $this->assertSame(StatusAkun::MenungguVerifikasi, $guru->status_akun);
        $this->assertTrue($guru->isGuru());
        $this->assertSame(StatusVerifikasiGuru::Menunggu, $guru->verifikasiGuru->status);
    }

    public function test_mahasiswa_dapat_mendaftar_sebagai_guru_lewat_instansi_perguruan_tinggi(): void
    {
        Notification::fake();
        $this->buatPeran('guru');
        $kampus = InstansiPendidikan::factory()->create(['jenis_instansi' => 'Perguruan Tinggi']);

        $respons = $this->post(route('daftar.guru.proses'), [
            'nama_lengkap' => 'Mahasiswa Calon Guru',
            'email' => 'mahasiswa@contoh.test',
            'nomor_telepon' => '081234567890',
            'jenis_kelamin' => 'Perempuan',
            'id_instansi_pendidikan' => $kampus->id,
            'nip_nuptk' => '1234567890',
            'bidang_studi' => 'Pendidikan Biologi',
            'alamat' => 'Jl. Kampus No. 1',
            'kata_sandi' => 'password123',
            'kata_sandi_confirmation' => 'password123',
        ]);

        $respons->assertRedirect(route('masuk'));

        $mahasiswa = Pengguna::where('email', 'mahasiswa@contoh.test')->firstOrFail();
        $this->assertTrue($mahasiswa->isGuru());
        $this->assertSame($kampus->id, $mahasiswa->profilGuru->id_instansi_pendidikan);
        $this->assertSame('1234567890', $mahasiswa->profilGuru->nip_nuptk);
    }

    public function test_registrasi_guru_gagal_jika_email_sudah_terdaftar(): void
    {
        $this->buatPeran('guru');
        $instansi = InstansiPendidikan::factory()->create();
        $this->buatGuru(['email' => 'guru.ada@contoh.test']);

        $respons = $this->post(route('daftar.guru.proses'), [
            'nama_lengkap' => 'Guru Duplikat',
            'email' => 'guru.ada@contoh.test',
            'nomor_telepon' => '081234567890',
            'jenis_kelamin' => 'Laki-laki',
            'id_instansi_pendidikan' => $instansi->id,
            'bidang_studi' => 'Biologi',
            'alamat' => 'Jl. Contoh No. 1',
            'kata_sandi' => 'password123',
            'kata_sandi_confirmation' => 'password123',
        ]);

        $respons->assertSessionHasErrors('email');
    }
}
