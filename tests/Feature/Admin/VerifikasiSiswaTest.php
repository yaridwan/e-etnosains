<?php

namespace Tests\Feature\Admin;

use App\Enums\StatusAkun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class VerifikasiSiswaTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_melihat_daftar_siswa_menunggu_verifikasi(): void
    {
        $admin = $this->buatAdmin();
        $this->buatSiswa(['nama_lengkap' => 'Siswa Menunggu', 'status_akun' => StatusAkun::MenungguVerifikasi]);

        $this->actingAs($admin)
            ->get(route('admin.verifikasi-siswa.index'))
            ->assertOk()
            ->assertSee('Siswa Menunggu');
    }

    public function test_administrator_dapat_menyetujui_siswa(): void
    {
        $admin = $this->buatAdmin();
        $siswa = $this->buatSiswa(['status_akun' => StatusAkun::MenungguVerifikasi]);

        $this->actingAs($admin)
            ->post(route('admin.verifikasi-siswa.setujui', $siswa))
            ->assertRedirect();

        $this->assertSame(StatusAkun::Aktif, $siswa->fresh()->status_akun);
    }

    public function test_administrator_dapat_menolak_siswa_dengan_catatan(): void
    {
        $admin = $this->buatAdmin();
        $siswa = $this->buatSiswa(['status_akun' => StatusAkun::MenungguVerifikasi]);

        $this->actingAs($admin)
            ->post(route('admin.verifikasi-siswa.tolak', $siswa), ['catatan' => 'Data tidak lengkap.'])
            ->assertRedirect();

        $siswa->refresh();
        $this->assertSame(StatusAkun::Ditolak, $siswa->status_akun);
        $this->assertSame('Data tidak lengkap.', $siswa->catatan_verifikasi);
    }

    public function test_siswa_tidak_bisa_mengakses_halaman_verifikasi_siswa(): void
    {
        $siswa = $this->buatSiswa();

        $this->actingAs($siswa)
            ->get(route('admin.verifikasi-siswa.index'))
            ->assertForbidden();
    }

    public function test_filter_status_menampilkan_hanya_siswa_yang_cocok(): void
    {
        $admin = $this->buatAdmin();
        $this->buatSiswa(['nama_lengkap' => 'Siswa Menunggu Uji', 'status_akun' => StatusAkun::MenungguVerifikasi]);
        $this->buatSiswa(['nama_lengkap' => 'Siswa Aktif Uji', 'status_akun' => StatusAkun::Aktif]);

        $respons = $this->actingAs($admin)->get(route('admin.verifikasi-siswa.index', ['status' => 'menunggu_verifikasi']));

        $respons->assertOk()->assertSee('Siswa Menunggu Uji')->assertDontSee('Siswa Aktif Uji');
    }
}
