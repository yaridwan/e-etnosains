<?php

namespace Tests\Feature\Admin;

use App\Enums\StatusAkun;
use App\Enums\StatusVerifikasiGuru;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class VerifikasiGuruTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_melihat_daftar_verifikasi_guru(): void
    {
        $admin = $this->buatAdmin();
        $this->buatGuru(['nama_lengkap' => 'Guru Menunggu'], terverifikasi: false);

        $this->actingAs($admin)
            ->get(route('admin.verifikasi-guru.index'))
            ->assertOk()
            ->assertSee('Guru Menunggu');
    }

    public function test_administrator_dapat_menyetujui_guru(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru(terverifikasi: false);

        $this->actingAs($admin)
            ->post(route('admin.verifikasi-guru.setujui', $guru->verifikasiGuru))
            ->assertRedirect();

        $guru->refresh();
        $this->assertSame(StatusAkun::Aktif, $guru->status_akun);
        $this->assertSame(StatusVerifikasiGuru::Disetujui, $guru->verifikasiGuru->fresh()->status);
    }

    public function test_administrator_dapat_menolak_guru_dengan_catatan(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru(terverifikasi: false);

        $this->actingAs($admin)
            ->post(route('admin.verifikasi-guru.tolak', $guru->verifikasiGuru), [
                'catatan' => 'Data tidak lengkap.',
            ])
            ->assertRedirect();

        $this->assertSame(StatusVerifikasiGuru::Ditolak, $guru->verifikasiGuru->fresh()->status);
    }

    public function test_guru_tidak_bisa_mengakses_halaman_verifikasi_guru(): void
    {
        $guru = $this->buatGuru();

        $this->actingAs($guru)
            ->get(route('admin.verifikasi-guru.index'))
            ->assertForbidden();
    }
}
