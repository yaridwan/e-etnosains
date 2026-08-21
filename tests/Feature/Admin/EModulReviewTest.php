<?php

namespace Tests\Feature\Admin;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class EModulReviewTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_menyetujui_e_modul_yang_diajukan(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.setujui', $eModul), ['catatan' => 'Sudah baik.'])
            ->assertRedirect(route('admin.tinjau-e-modul.index'));

        $eModul->refresh();
        $this->assertSame(StatusPublikasi::Dipublikasikan, $eModul->status_publikasi);
        $this->assertNotNull($eModul->dipublikasikan_pada);
        $this->assertDatabaseHas('riwayat_status_e_modul', [
            'id_e_modul' => $eModul->id,
            'status_sesudah' => 'dipublikasikan',
        ]);
    }

    public function test_administrator_dapat_meminta_perbaikan_e_modul(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.minta-perbaikan', $eModul), ['catatan' => 'Lengkapi bagian evaluasi.'])
            ->assertRedirect();

        $this->assertSame(StatusPublikasi::PerluPerbaikan, $eModul->fresh()->status_publikasi);
    }

    public function test_e_modul_draf_tidak_muncul_di_halaman_publik(): void
    {
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
        ]);

        $this->get(route('e-modul.show', $eModul))->assertNotFound();
    }
}
