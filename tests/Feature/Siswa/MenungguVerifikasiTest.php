<?php

namespace Tests\Feature\Siswa;

use App\Enums\StatusAkun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class MenungguVerifikasiTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_menunggu_verifikasi_diarahkan_ke_halaman_menunggu(): void
    {
        $siswa = $this->buatSiswa(['status_akun' => StatusAkun::MenungguVerifikasi]);

        $this->actingAs($siswa)
            ->get(route('siswa.dashboard'))
            ->assertRedirect(route('siswa.menunggu-verifikasi'));
    }

    public function test_siswa_ditolak_diarahkan_ke_halaman_menunggu(): void
    {
        $siswa = $this->buatSiswa(['status_akun' => StatusAkun::Ditolak, 'catatan_verifikasi' => 'Data tidak sesuai.']);

        $this->actingAs($siswa)
            ->get(route('siswa.menunggu-verifikasi'))
            ->assertOk()
            ->assertSee('Data tidak sesuai.');
    }

    public function test_siswa_aktif_dapat_mengakses_dashboard(): void
    {
        $siswa = $this->buatSiswa();

        $this->actingAs($siswa)
            ->get(route('siswa.dashboard'))
            ->assertOk();
    }
}
