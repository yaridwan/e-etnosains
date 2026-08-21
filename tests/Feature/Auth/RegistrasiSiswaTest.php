<?php

namespace Tests\Feature\Auth;

use App\Enums\StatusAkun;
use App\Models\InstansiPendidikan;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class RegistrasiSiswaTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_dapat_mendaftar_dan_langsung_aktif(): void
    {
        Notification::fake();
        $this->buatPeran('siswa');
        $instansi = InstansiPendidikan::factory()->create();

        $respons = $this->post(route('daftar.siswa.proses'), [
            'nama_lengkap' => 'Siswa Baru',
            'email' => 'siswa.baru@contoh.test',
            'jenis_kelamin' => 'Perempuan',
            'id_instansi_pendidikan' => $instansi->id,
            'kelas' => 'X IPA 1',
            'kata_sandi' => 'password123',
            'kata_sandi_confirmation' => 'password123',
        ]);

        $respons->assertRedirect(route('masuk'));

        $siswa = Pengguna::where('email', 'siswa.baru@contoh.test')->firstOrFail();
        $this->assertSame(StatusAkun::Aktif, $siswa->status_akun);
        $this->assertTrue($siswa->isSiswa());
        $this->assertSame('X IPA 1', $siswa->profilSiswa->kelas);
    }
}
