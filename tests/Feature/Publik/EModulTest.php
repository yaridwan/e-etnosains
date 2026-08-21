<?php

namespace Tests\Feature\Publik;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EModulTest extends TestCase
{
    use RefreshDatabase;

    private function buatEModulTerbit(array $atribut = []): EModul
    {
        return EModul::factory()->create(array_merge([
            'id_pengguna' => Pengguna::factory(),
            'id_jenjang_pendidikan' => JenjangPendidikan::factory(),
            'id_mata_pelajaran' => MataPelajaran::factory(),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ], $atribut));
    }

    public function test_e_modul_dipublikasikan_dapat_dilihat_publik(): void
    {
        $eModul = $this->buatEModulTerbit(['judul' => 'Sains dalam Gula Aren']);

        $this->get(route('e-modul.show', $eModul))
            ->assertOk()
            ->assertSee('Sains dalam Gula Aren');
    }

    public function test_e_modul_draf_tidak_dapat_diakses_publik(): void
    {
        $eModul = $this->buatEModulTerbit(['status_publikasi' => StatusPublikasi::Draf]);

        $this->get(route('e-modul.show', $eModul))->assertNotFound();
    }

    public function test_url_e_modul_menggunakan_alamat_tautan_bukan_id(): void
    {
        $eModul = $this->buatEModulTerbit(['judul' => 'Fotosintesis dalam Kearifan Lokal']);

        $this->assertStringContainsString('fotosintesis-dalam-kearifan-lokal', route('e-modul.show', $eModul));
    }

    public function test_halaman_baca_flipbook_menampilkan_pesan_jika_belum_ada_pdf(): void
    {
        $eModul = $this->buatEModulTerbit(['berkas_pdf' => null]);

        $this->get(route('e-modul.baca', $eModul))->assertNotFound();
    }

    public function test_unduhan_ditolak_jika_izin_unduh_nonaktif(): void
    {
        $eModul = $this->buatEModulTerbit(['izin_unduh' => false]);

        $this->get(route('e-modul.unduh', $eModul))->assertForbidden();
    }
}
