<?php

namespace Tests\Feature\Publik;

use App\Enums\StatusPublikasi;
use App\Models\Lkpd;
use App\Models\Observasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class LkpdTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_lkpd_menampilkan_tautan_ke_versi_interaktif_yang_terhubung(): void
    {
        $guru = $this->buatGuru();
        $lkpd = Lkpd::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
        ]);
        $observasi = Observasi::factory()->for($guru, 'pengguna')->create([
            'id_lkpd' => $lkpd->id,
            'judul' => 'Instrumen Interaktif Fermentasi Tempe',
        ]);

        $this->get(route('lkpd.show', $lkpd))
            ->assertOk()
            ->assertSee('LKPD Interaktif')
            ->assertSee('Instrumen Interaktif Fermentasi Tempe');
    }

    public function test_siswa_melihat_tombol_kerjakan_sekarang_untuk_lkpd_interaktif(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $lkpd = Lkpd::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
        ]);
        $observasi = Observasi::factory()->for($guru, 'pengguna')->create(['id_lkpd' => $lkpd->id]);

        $this->actingAs($siswa)
            ->get(route('lkpd.show', $lkpd))
            ->assertOk()
            ->assertSee('Kerjakan Sekarang')
            ->assertSee(route('siswa.observasi.show', $observasi), false);
    }

    public function test_lkpd_tanpa_versi_interaktif_tidak_menampilkan_kartu_tersebut(): void
    {
        $guru = $this->buatGuru();
        $lkpd = Lkpd::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
        ]);

        $this->get(route('lkpd.show', $lkpd))
            ->assertOk()
            ->assertDontSee('LKPD Interaktif');
    }

    public function test_observasi_belum_terbit_tidak_ikut_ditampilkan_di_halaman_lkpd(): void
    {
        $guru = $this->buatGuru();
        $lkpd = Lkpd::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
        ]);
        Observasi::factory()->for($guru, 'pengguna')->create([
            'id_lkpd' => $lkpd->id,
            'judul' => 'Instrumen Masih Draf',
            'status_publikasi' => StatusPublikasi::Draf,
        ]);

        $this->get(route('lkpd.show', $lkpd))
            ->assertOk()
            ->assertDontSee('LKPD Interaktif')
            ->assertDontSee('Instrumen Masih Draf');
    }
}
