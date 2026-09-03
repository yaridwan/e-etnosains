<?php

namespace Tests\Feature\Publik;

use App\Enums\StatusPublikasi;
use App\Models\Evaluasi;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluasiTest extends TestCase
{
    use RefreshDatabase;

    private function buatEvaluasiTerbit(array $atribut = []): Evaluasi
    {
        return Evaluasi::factory()->create(array_merge([
            'id_pengguna' => Pengguna::factory(),
            'id_jenjang_pendidikan' => JenjangPendidikan::factory(),
            'id_mata_pelajaran' => MataPelajaran::factory(),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ], $atribut));
    }

    public function test_evaluasi_dipublikasikan_dapat_dilihat_publik(): void
    {
        $evaluasi = $this->buatEvaluasiTerbit(['judul' => 'Ulangan Harian Fotosintesis']);

        $this->get(route('evaluasi.show', $evaluasi))
            ->assertOk()
            ->assertSee('Ulangan Harian Fotosintesis');
    }

    public function test_evaluasi_draf_tidak_dapat_diakses_publik(): void
    {
        $evaluasi = $this->buatEvaluasiTerbit(['status_publikasi' => StatusPublikasi::Draf]);

        $this->get(route('evaluasi.show', $evaluasi))->assertNotFound();
    }

    public function test_url_evaluasi_menggunakan_alamat_tautan_bukan_id(): void
    {
        $evaluasi = $this->buatEvaluasiTerbit(['judul' => 'Ulangan Semester Kearifan Lokal']);

        $this->assertStringContainsString('ulangan-semester-kearifan-lokal', route('evaluasi.show', $evaluasi));
    }

    public function test_unduhan_ditolak_jika_izin_unduh_nonaktif(): void
    {
        $evaluasi = $this->buatEvaluasiTerbit(['izin_unduh' => false]);

        $this->get(route('evaluasi.unduh', $evaluasi))->assertForbidden();
    }

    public function test_daftar_evaluasi_hanya_menampilkan_yang_dipublikasikan(): void
    {
        $this->buatEvaluasiTerbit(['judul' => 'Evaluasi Terbit']);
        $this->buatEvaluasiTerbit(['judul' => 'Evaluasi Draf', 'status_publikasi' => StatusPublikasi::Draf]);

        $this->get(route('evaluasi.index'))
            ->assertOk()
            ->assertSee('Evaluasi Terbit')
            ->assertDontSee('Evaluasi Draf');
    }
}
